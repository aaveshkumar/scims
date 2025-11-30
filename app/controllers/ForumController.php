<?php

class ForumController
{
    public function index($request)
    {
        $forums = db()->fetchAll("SELECT f.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name, s.name as subject_name, c.name as class_name FROM forums f LEFT JOIN users u ON f.created_by = u.id LEFT JOIN subjects s ON f.subject_id = s.id LEFT JOIN classes c ON f.class_id = c.id ORDER BY f.created_at DESC");
        
        return view('forums/index', [
            'title' => 'Discussion Forums',
            'forums' => $forums
        ]);
    }

    public function create($request)
    {
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('forums/create', [
            'title' => 'Create - Discussion Forums',
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function store($request)
    {
        $authUser = auth();
        $sql = "INSERT INTO forums (title, subject_id, class_id, description, created_by, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        db()->execute($sql, [
            $request->post('title'),
            $request->post('subject_id') ?: null,
            $request->post('class_id') ?: null,
            $request->post('description'),
            isset($authUser['id']) ? $authUser['id'] : 1,
            $request->post('status') ?? 'active'
        ]);
        
        flash('success', 'Forum created successfully');
        return redirect('/forums');
    }

    public function show($request, $id)
    {
        $forum = db()->fetchOne("SELECT f.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name, s.name as subject_name, c.name as class_name FROM forums f LEFT JOIN users u ON f.created_by = u.id LEFT JOIN subjects s ON f.subject_id = s.id LEFT JOIN classes c ON f.class_id = c.id WHERE f.id = ?", [$id]);
        
        if (!$forum) {
            flash('error', 'Forum not found');
            return redirect('/forums');
        }
        
        return view('forums/show', [
            'title' => 'View - Discussion Forums',
            'forum' => $forum
        ]);
    }

    public function edit($request, $id)
    {
        $forum = db()->fetchOne("SELECT * FROM forums WHERE id = ?", [$id]);
        
        if (!$forum) {
            flash('error', 'Forum not found');
            return redirect('/forums');
        }
        
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('forums/edit', [
            'title' => 'Edit - Discussion Forums',
            'forum' => $forum,
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function update($request, $id)
    {
        $sql = "UPDATE forums SET title = ?, subject_id = ?, class_id = ?, description = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        db()->execute($sql, [
            $request->post('title'),
            $request->post('subject_id') ?: null,
            $request->post('class_id') ?: null,
            $request->post('description'),
            $request->post('status'),
            $id
        ]);
        
        flash('success', 'Forum updated successfully');
        return redirect('/forums');
    }

    public function destroy($request, $id)
    {
        db()->execute("DELETE FROM forums WHERE id = ?", [$id]);
        flash('success', 'Forum deleted successfully');
        return redirect('/forums');
    }
}