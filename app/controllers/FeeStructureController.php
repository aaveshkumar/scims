<?php

class FeeStructureController
{
    public function index($request)
    {
        $filters = [
            'class_id' => $request->get('class_id'),
            'academic_year' => $request->get('academic_year'),
            'status' => $request->get('status')
        ];
        
        $feeTemplates = FeeTemplate::getAll($filters);
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        $stats = FeeTemplate::getStatistics();
        
        $academicYears = db()->fetchAll(
            "SELECT DISTINCT academic_year FROM fee_structure_templates ORDER BY academic_year DESC"
        );
        
        return view('fee_structure/index', [
            'title' => 'Fee Structure Management',
            'feeTemplates' => $feeTemplates,
            'classes' => $classes,
            'academicYears' => $academicYears,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('fee_structure/create', [
            'title' => 'Create Fee Structure',
            'classes' => $classes
        ]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'fee_type' => 'required',
            'academic_year' => 'required',
            'amount' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'name' => $request->post('name'),
                'class_id' => $request->post('class_id') ?: null,
                'course_id' => null,
                'academic_year' => $request->post('academic_year'),
                'semester' => $request->post('semester') ?: null,
                'fee_type' => $request->post('fee_type'),
                'amount' => (float) $request->post('amount'),
                'due_date' => $request->post('due_date') ?: null,
                'status' => $request->post('status') ? 'active' : 'inactive'
            ];

            $feeStructure = new FeeStructure();
            $feeStructure->create($data);
            
            flash('success', 'Fee structure created successfully');
            return redirect('/fee-structure');
        } catch (Exception $e) {
            flash('error', 'Failed to create fee structure: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $feeTemplate = FeeTemplate::find($id);
        
        if (!$feeTemplate) {
            flash('error', 'Fee structure not found');
            return redirect('/fee-structure');
        }
        
        return view('fee_structure/show', [
            'title' => 'Fee Structure Details',
            'feeTemplate' => $feeTemplate
        ]);
    }

    public function edit($request, $id)
    {
        $feeTemplate = FeeTemplate::find($id);
        
        if (!$feeTemplate) {
            flash('error', 'Fee structure not found');
            return redirect('/fee-structure');
        }
        
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('fee_structure/edit', [
            'title' => 'Edit Fee Structure',
            'feeTemplate' => $feeTemplate,
            'classes' => $classes
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'academic_year' => 'required',
            'amount' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'name' => $request->post('name'),
                'class_id' => $request->post('class_id'),
                'academic_year' => $request->post('academic_year'),
                'amount' => $request->post('amount'),
                'due_date' => $request->post('due_date'),
                'fine_per_day' => $request->post('fine_per_day') ?? 0,
                'description' => $request->post('description'),
                'status' => $request->post('status')
            ];

            FeeTemplate::update($id, $data);
            flash('success', 'Fee structure updated successfully');
            return redirect('/fee-structure');
        } catch (Exception $e) {
            flash('error', 'Failed to update fee structure: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            FeeTemplate::delete($id);
            flash('success', 'Fee structure deleted successfully');
            return redirect('/fee-structure');
        } catch (Exception $e) {
            flash('error', 'Failed to delete fee structure: ' . $e->getMessage());
            return back();
        }
    }
}