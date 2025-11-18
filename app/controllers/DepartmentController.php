<?php

class DepartmentController
{
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status')
        ];
        
        $sql = "SELECT d.*, CONCAT(u.first_name, ' ', u.last_name) as head_name 
                FROM departments d 
                LEFT JOIN users u ON d.head_id = u.id 
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (d.name LIKE ? OR d.code LIKE ? OR d.description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND d.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY d.created_at DESC";
        
        $departments = db()->fetchAll($sql, $params);
        
        return view('departments/index', [
            'title' => 'Departments',
            'departments' => $departments,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $staff = db()->fetchAll(
            "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM staff s 
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.status = 'active' 
             ORDER BY u.first_name, u.last_name"
        );
        
        return view('departments/create', [
            'title' => 'Create Department',
            'staff' => $staff
        ]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $sql = "INSERT INTO departments (name, code, description, head_id, status, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                $request->post('name'),
                strtoupper($request->post('code')),
                $request->post('description'),
                $request->post('head_id') ?: null,
                $request->post('status') ?? 'active'
            ]);
            
            flash('success', 'Department created successfully');
            return redirect('/departments');
        } catch (Exception $e) {
            flash('error', 'Failed to create department: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $department = db()->fetchOne(
            "SELECT d.*, CONCAT(u.first_name, ' ', u.last_name) as head_name, u.email as head_email 
             FROM departments d 
             LEFT JOIN users u ON d.head_id = u.id 
             WHERE d.id = ?",
            [$id]
        );
        
        if (!$department) {
            flash('error', 'Department not found');
            return redirect('/departments');
        }
        
        $staff = db()->fetchAll(
            "SELECT s.*, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM staff s 
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.department_id = ? 
             ORDER BY u.first_name, u.last_name",
            [$id]
        );
        
        return view('departments/show', [
            'title' => 'View Department',
            'department' => $department,
            'staff' => $staff
        ]);
    }

    public function edit($request, $id)
    {
        $department = db()->fetchOne("SELECT * FROM departments WHERE id = ?", [$id]);
        
        if (!$department) {
            flash('error', 'Department not found');
            return redirect('/departments');
        }
        
        $staff = db()->fetchAll(
            "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM staff s 
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.status = 'active' 
             ORDER BY u.first_name, u.last_name"
        );
        
        return view('departments/edit', [
            'title' => 'Edit Department',
            'department' => $department,
            'staff' => $staff
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $sql = "UPDATE departments SET name = ?, code = ?, description = ?, head_id = ?, status = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('name'),
                strtoupper($request->post('code')),
                $request->post('description'),
                $request->post('head_id') ?: null,
                $request->post('status') ?? 'active',
                $id
            ]);
            
            flash('success', 'Department updated successfully');
            return redirect('/departments');
        } catch (Exception $e) {
            flash('error', 'Failed to update department: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            // Check if any staff are in this department
            $count = db()->fetchOne("SELECT COUNT(*) as count FROM staff WHERE department_id = ?", [$id]);
            
            if ($count['count'] > 0) {
                flash('error', 'Cannot delete department. Staff members are assigned to it.');
                return redirect('/departments');
            }
            
            db()->execute("DELETE FROM departments WHERE id = ?", [$id]);
            flash('success', 'Department deleted successfully');
        } catch (Exception $e) {
            flash('error', 'Failed to delete department: ' . $e->getMessage());
        }
        
        return redirect('/departments');
    }
}
