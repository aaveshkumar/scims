<?php

class PayrollController
{
    public function index($request)
    {
        $filters = [
            'staff_id' => $request->get('staff_id'),
            'month' => $request->get('month'),
            'year' => $request->get('year'),
            'status' => $request->get('status')
        ];
        
        $payrollRecords = Payroll::getAll($filters);
        $staff = db()->fetchAll("SELECT s.id, u.first_name, u.last_name, s.employee_id FROM staff s JOIN users u ON s.user_id = u.id ORDER BY u.first_name");
        $stats = Payroll::getStatistics();
        
        return view('payroll/index', [
            'title' => 'Payroll Management',
            'payrollRecords' => $payrollRecords,
            'staff' => $staff,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $staff = db()->fetchAll("SELECT s.id, u.first_name, u.last_name, s.employee_id, s.salary FROM staff s JOIN users u ON s.user_id = u.id ORDER BY u.first_name");
        
        return view('payroll/create', [
            'title' => 'Generate Payroll',
            'staff' => $staff
        ]);
    }

    public function store($request)
    {
        $rules = [
            'staff_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'basic_salary' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $authUser = auth();
            $userId = isset($authUser['id']) ? $authUser['id'] : 1;
            
            $data = [
                'staff_id' => $request->post('staff_id'),
                'month' => $request->post('month'),
                'year' => $request->post('year'),
                'basic_salary' => $request->post('basic_salary'),
                'allowances' => $request->post('allowances') ?? 0,
                'deductions' => $request->post('deductions') ?? 0,
                'payment_date' => $request->post('payment_date'),
                'payment_method' => $request->post('payment_method'),
                'status' => 'pending',
                'remarks' => $request->post('remarks'),
                'created_by' => $userId
            ];

            Payroll::create($data);
            flash('success', 'Payroll generated successfully');
            return redirect('/payroll');
        } catch (Exception $e) {
            flash('error', 'Failed to generate payroll: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $payroll = Payroll::find($id);
        
        if (!$payroll) {
            flash('error', 'Payroll record not found');
            return redirect('/payroll');
        }
        
        return view('payroll/show', [
            'title' => 'Payroll Details',
            'payroll' => $payroll
        ]);
    }

    public function edit($request, $id)
    {
        $payroll = Payroll::find($id);
        
        if (!$payroll) {
            flash('error', 'Payroll record not found');
            return redirect('/payroll');
        }
        
        return view('payroll/edit', [
            'title' => 'Edit Payroll',
            'payroll' => $payroll
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'basic_salary' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'basic_salary' => $request->post('basic_salary'),
                'allowances' => $request->post('allowances') ?? 0,
                'deductions' => $request->post('deductions') ?? 0,
                'payment_date' => $request->post('payment_date'),
                'payment_method' => $request->post('payment_method'),
                'status' => $request->post('status'),
                'remarks' => $request->post('remarks')
            ];

            Payroll::update($id, $data);
            flash('success', 'Payroll updated successfully');
            return redirect('/payroll');
        } catch (Exception $e) {
            flash('error', 'Failed to update payroll: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Payroll::delete($id);
            flash('success', 'Payroll record deleted successfully');
            return redirect('/payroll');
        } catch (Exception $e) {
            flash('error', 'Failed to delete payroll: ' . $e->getMessage());
            return back();
        }
    }
}