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
        
        // Fetch from fees_structures table
        $sql = "SELECT fs.*, c.name as class_name
                FROM fees_structures fs
                LEFT JOIN classes c ON fs.class_id = c.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['class_id'])) {
            $sql .= " AND fs.class_id = ?";
            $params[] = $filters['class_id'];
        }
        
        if (!empty($filters['academic_year'])) {
            $sql .= " AND fs.academic_year = ?";
            $params[] = $filters['academic_year'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND fs.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY fs.academic_year DESC, c.name";
        
        $feeTemplates = db()->fetchAll($sql, $params);
        
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        // Get statistics from fees_structures
        $totalCount = db()->fetchOne("SELECT COUNT(*) as count FROM fees_structures")['count'];
        $activeCount = db()->fetchOne("SELECT COUNT(*) as count FROM fees_structures WHERE status = 'active'")['count'];
        $totalAmount = db()->fetchOne("SELECT COALESCE(SUM(amount), 0) as total FROM fees_structures WHERE status = 'active'")['total'];
        
        $stats = [
            'total_templates' => $totalCount,
            'active_templates' => $activeCount,
            'total_amount' => $totalAmount
        ];
        
        $academicYears = db()->fetchAll(
            "SELECT DISTINCT academic_year FROM fees_structures ORDER BY academic_year DESC"
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
        $sql = "SELECT fs.*, c.name as class_name
                FROM fees_structures fs
                LEFT JOIN classes c ON fs.class_id = c.id
                WHERE fs.id = ?";
        
        $feeStructure = db()->fetchOne($sql, [$id]);
        
        if (!$feeStructure) {
            flash('error', 'Fee structure not found');
            return redirect('/fee-structure');
        }
        
        return view('fee_structure/show', [
            'title' => 'Fee Structure Details',
            'feeStructure' => $feeStructure
        ]);
    }

    public function edit($request, $id)
    {
        $sql = "SELECT fs.*, c.name as class_name
                FROM fees_structures fs
                LEFT JOIN classes c ON fs.class_id = c.id
                WHERE fs.id = ?";
        
        $feeStructure = db()->fetchOne($sql, [$id]);
        
        if (!$feeStructure) {
            flash('error', 'Fee structure not found');
            return redirect('/fee-structure');
        }
        
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('fee_structure/edit', [
            'title' => 'Edit Fee Structure',
            'feeStructure' => $feeStructure,
            'classes' => $classes
        ]);
    }

    public function update($request, $id)
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
            $sql = "UPDATE fees_structures SET 
                    name = ?, 
                    class_id = ?, 
                    fee_type = ?,
                    academic_year = ?, 
                    semester = ?,
                    amount = ?, 
                    due_date = ?, 
                    status = ?
                    WHERE id = ?";

            db()->execute($sql, [
                $request->post('name'),
                $request->post('class_id') ?: null,
                $request->post('fee_type'),
                $request->post('academic_year'),
                $request->post('semester') ?: null,
                (float) $request->post('amount'),
                $request->post('due_date') ?: null,
                $request->post('status'),
                $id
            ]);

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
            db()->execute("DELETE FROM fees_structures WHERE id = ?", [$id]);
            flash('success', 'Fee structure deleted successfully');
            return redirect('/fee-structure');
        } catch (Exception $e) {
            flash('error', 'Failed to delete fee structure: ' . $e->getMessage());
            return back();
        }
    }
}