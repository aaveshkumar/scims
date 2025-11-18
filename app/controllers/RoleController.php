<?php

class RoleController
{
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status')
        ];
        
        $sql = "SELECT * FROM roles WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR display_name LIKE ? OR description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $roles = db()->fetchAll($sql, $params);
        
        return view('roles/index', [
            'title' => 'Roles & Permissions',
            'roles' => $roles,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        return view('roles/create', [
            'title' => 'Create Role'
        ]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'display_name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $sql = "INSERT INTO roles (name, display_name, description, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                strtolower(str_replace(' ', '_', $request->post('name'))),
                $request->post('display_name'),
                $request->post('description')
            ]);
            
            flash('success', 'Role created successfully');
            return redirect('/roles');
        } catch (Exception $e) {
            flash('error', 'Failed to create role: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $role = db()->fetchOne("SELECT * FROM roles WHERE id = ?", [$id]);
        
        if (!$role) {
            flash('error', 'Role not found');
            return redirect('/roles');
        }
        
        $users = db()->fetchAll(
            "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name, u.email 
             FROM users u 
             INNER JOIN user_roles ur ON u.id = ur.user_id 
             WHERE ur.role_id = ?",
            [$id]
        );
        
        return view('roles/show', [
            'title' => 'View Role',
            'role' => $role,
            'users' => $users
        ]);
    }

    public function edit($request, $id)
    {
        $role = db()->fetchOne("SELECT * FROM roles WHERE id = ?", [$id]);
        
        if (!$role) {
            flash('error', 'Role not found');
            return redirect('/roles');
        }
        
        return view('roles/edit', [
            'title' => 'Edit Role',
            'role' => $role
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'display_name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $sql = "UPDATE roles SET name = ?, display_name = ?, description = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                strtolower(str_replace(' ', '_', $request->post('name'))),
                $request->post('display_name'),
                $request->post('description'),
                $id
            ]);
            
            flash('success', 'Role updated successfully');
            return redirect('/roles');
        } catch (Exception $e) {
            flash('error', 'Failed to update role: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            // Check if any users are assigned to this role
            $count = db()->fetchOne("SELECT COUNT(*) as count FROM user_roles WHERE role_id = ?", [$id]);
            
            if ($count['count'] > 0) {
                flash('error', 'Cannot delete role. Users are assigned to this role.');
                return redirect('/roles');
            }
            
            db()->execute("DELETE FROM roles WHERE id = ?", [$id]);
            flash('success', 'Role deleted successfully');
        } catch (Exception $e) {
            flash('error', 'Failed to delete role: ' . $e->getMessage());
        }
        
        return redirect('/roles');
    }
}
