<?php

class InvoiceController
{
    private $invoiceModel;
    private $studentModel;
    private $feeStructureModel;

    public function __construct()
    {
        $this->invoiceModel = new Invoice();
        $this->studentModel = new Student();
        $this->feeStructureModel = new FeeStructure();
    }

    public function index($request)
    {
        $status = $request->get('status', 'all');
        
        $query = "SELECT i.*, s.admission_number, u.first_name, u.last_name
                  FROM invoices i
                  INNER JOIN students s ON i.student_id = s.id
                  INNER JOIN users u ON s.user_id = u.id";
        
        $params = [];
        if ($status !== 'all') {
            $query .= " WHERE i.payment_status = ?";
            $params[] = $status;
        }
        
        $query .= " ORDER BY i.created_at DESC";
        
        $invoices = db()->fetchAll($query, $params);

        return view('invoices.index', ['invoices' => $invoices, 'status' => $status]);
    }

    public function create($request)
    {
        $students = db()->fetchAll(
            "SELECT s.id, s.admission_number, u.first_name, u.last_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.status = 'active'"
        );

        $feeStructures = $this->feeStructureModel->where('status', 'active')->get();

        return view('invoices.create', ['students' => $students, 'feeStructures' => $feeStructures]);
    }

    public function store($request)
    {
        $rules = [
            'student_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'due_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $amount = $request->post('amount');
            $discount = $request->post('discount', 0);
            $tax = $request->post('tax', 0);
            $totalAmount = $amount - $discount + $tax;

            $this->invoiceModel->create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'student_id' => $request->post('student_id'),
                'fee_structure_id' => $request->post('fee_structure_id'),
                'amount' => $amount,
                'discount' => $discount,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'amount_paid' => 0,
                'balance' => $totalAmount,
                'due_date' => $request->post('due_date'),
                'payment_status' => 'unpaid',
                'created_by' => auth()['id']
            ]);

            flash('success', 'Invoice created successfully');
            return redirect('/invoices');
        } catch (Exception $e) {
            flash('error', 'Failed to create invoice: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $invoice = db()->fetchOne(
            "SELECT i.*, s.admission_number, u.first_name, u.last_name, u.email
             FROM invoices i
             INNER JOIN students s ON i.student_id = s.id
             INNER JOIN users u ON s.user_id = u.id
             WHERE i.id = ?",
            [$id]
        );

        if (!$invoice) {
            flash('error', 'Invoice not found');
            return redirect('/invoices');
        }

        return view('invoices.show', ['invoice' => $invoice]);
    }

    public function recordPayment($request, $id)
    {
        $invoice = $this->invoiceModel->find($id);
        if (!$invoice) {
            return responseJSON(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        $rules = [
            'amount' => 'required|numeric',
            'payment_method' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return responseJSON(['success' => false, 'message' => 'Validation failed'], 400);
        }

        try {
            $invoiceObj = new Invoice();
            foreach ($invoice as $key => $value) {
                $invoiceObj->$key = $value;
            }

            $invoiceObj->recordPayment(
                $request->post('amount'),
                $request->post('payment_method'),
                $request->post('transaction_id')
            );

            return responseJSON(['success' => true, 'message' => 'Payment recorded successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function defaulters($request)
    {
        $defaulters = $this->invoiceModel->getDefaulters(date('Y-m-d'));

        return view('invoices.defaulters', ['defaulters' => $defaulters]);
    }
}
