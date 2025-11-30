<?php

class ExpenseController
{
    public function index($request)
    {
        $expenses = Expense::all([
            'status' => $request->get('status'),
            'category' => $request->get('category')
        ]);

        $categories = Expense::getCategories();

        return view('expenses/index', [
            'title' => 'Expenses',
            'expenses' => $expenses,
            'categories' => $categories
        ]);
    }

    public function create($request)
    {
        $categories = Expense::getCategories();
        $paymentMethods = Expense::getPaymentMethods();

        return view('expenses/create', [
            'title' => 'Create Expense',
            'categories' => $categories,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function store($request)
    {
        $rules = [
            'category' => 'required',
            'amount' => 'required|numeric',
            'expense_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            Expense::create([
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'amount' => (float) $request->post('amount'),
                'expense_date' => $request->post('expense_date'),
                'payment_method' => $request->post('payment_method'),
                'vendor' => $request->post('vendor'),
                'invoice_number' => $request->post('invoice_number'),
                'status' => $request->post('status') ?? 'pending'
            ]);

            flash('success', 'Expense created successfully');
            return redirect('/expenses');
        } catch (Exception $e) {
            flash('error', 'Failed to create expense: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            flash('error', 'Expense not found');
            return redirect('/expenses');
        }

        return view('expenses/show', [
            'title' => 'View Expense',
            'expense' => $expense
        ]);
    }

    public function edit($request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            flash('error', 'Expense not found');
            return redirect('/expenses');
        }

        $categories = Expense::getCategories();
        $paymentMethods = Expense::getPaymentMethods();

        return view('expenses/edit', [
            'title' => 'Edit Expense',
            'expense' => $expense,
            'categories' => $categories,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'category' => 'required',
            'amount' => 'required|numeric',
            'expense_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            Expense::update($id, [
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'amount' => (float) $request->post('amount'),
                'expense_date' => $request->post('expense_date'),
                'payment_method' => $request->post('payment_method'),
                'vendor' => $request->post('vendor'),
                'invoice_number' => $request->post('invoice_number'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Expense updated successfully');
            return redirect('/expenses/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update expense: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Expense::delete($id);
            flash('success', 'Expense deleted successfully');
            return redirect('/expenses');
        } catch (Exception $e) {
            flash('error', 'Failed to delete expense: ' . $e->getMessage());
            return back();
        }
    }
}