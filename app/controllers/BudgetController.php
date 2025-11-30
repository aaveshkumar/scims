<?php

class BudgetController
{
    public function index($request)
    {
        $budgets = Budget::all([
            'category' => $request->get('category'),
            'status' => $request->get('status'),
            'academic_year' => $request->get('academic_year')
        ]);

        $categories = Budget::getCategories();
        $stats = Budget::getStatistics();

        return view('budget/index', [
            'title' => 'Budget Planning',
            'budgets' => $budgets,
            'categories' => $categories,
            'stats' => $stats,
            'request' => $request
        ]);
    }

    public function create($request)
    {
        $categories = Budget::getCategories();

        return view('budget/create', [
            'title' => 'Create Budget',
            'categories' => $categories
        ]);
    }

    public function store($request)
    {
        $rules = [
            'category' => 'required',
            'allocated_amount' => 'required|numeric',
            'academic_year' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $authUser = auth();
            $userId = isset($authUser['id']) ? $authUser['id'] : 1;

            Budget::create([
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'allocated_amount' => (float) $request->post('allocated_amount'),
                'spent_amount' => (float) ($request->post('spent_amount') ?? 0),
                'academic_year' => $request->post('academic_year'),
                'period' => $request->post('period'),
                'status' => $request->post('status') ?? 'active',
                'created_by' => $userId
            ]);

            flash('success', 'Budget created successfully');
            return redirect('/budget');
        } catch (Exception $e) {
            flash('error', 'Failed to create budget: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            flash('error', 'Budget not found');
            return redirect('/budget');
        }

        return view('budget/show', [
            'title' => 'Budget Details',
            'budget' => $budget
        ]);
    }

    public function edit($request, $id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            flash('error', 'Budget not found');
            return redirect('/budget');
        }

        $categories = Budget::getCategories();

        return view('budget/edit', [
            'title' => 'Edit Budget',
            'budget' => $budget,
            'categories' => $categories
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'category' => 'required',
            'allocated_amount' => 'required|numeric',
            'academic_year' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            Budget::update($id, [
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'allocated_amount' => (float) $request->post('allocated_amount'),
                'spent_amount' => (float) ($request->post('spent_amount') ?? 0),
                'academic_year' => $request->post('academic_year'),
                'period' => $request->post('period'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Budget updated successfully');
            return redirect('/budget/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update budget: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Budget::delete($id);
            flash('success', 'Budget deleted successfully');
            return redirect('/budget');
        } catch (Exception $e) {
            flash('error', 'Failed to delete budget: ' . $e->getMessage());
            return back();
        }
    }
}