<?php

class LibraryController
{
    public function index($request)
    {
        return view('library/index', ['title' => 'Library Management']);
    }

    public function create($request)
    {
        return view('library/create', ['title' => 'Create - Library Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/library');
    }

    public function show($request, $id)
    {
        return view('library/show', ['title' => 'View - Library Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('library/edit', ['title' => 'Edit - Library Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/library');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/library');
    }

    public function issue($request)
    {
        return view('library/issue', ['title' => 'Issue/Return Books']);
    }

    public function members($request)
    {
        return view('library/members', ['title' => 'Library Members']);
    }
    
    public function processIssue($request)
    {
        $rules = [
            'student_id' => 'required',
            'book_id' => 'required',
            'issue_date' => 'required',
            'due_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            // Check if book is available
            $book = db()->fetchOne("SELECT available_quantity FROM books WHERE id = ?", [$request->post('book_id')]);
            
            if (!$book || $book['available_quantity'] < 1) {
                flash('error', 'Book is not available for issue');
                return back();
            }

            // Create issue record (assuming a library_issues table exists)
            db()->execute(
                "INSERT INTO library_issues (student_id, book_id, issue_date, due_date, notes, status, created_at) VALUES (?, ?, ?, ?, ?, 'issued', NOW())",
                [
                    $request->post('student_id'),
                    $request->post('book_id'),
                    $request->post('issue_date'),
                    $request->post('due_date'),
                    $request->post('notes')
                ]
            );

            // Update book available quantity
            db()->execute(
                "UPDATE books SET available_quantity = available_quantity - 1 WHERE id = ?",
                [$request->post('book_id')]
            );

            flash('success', 'Book issued successfully');
            return redirect('/library/issue');
        } catch (Exception $e) {
            flash('error', 'Failed to issue book: ' . $e->getMessage());
            return back();
        }
    }
    
    public function processReturn($request)
    {
        $rules = [
            'issue_id' => 'required',
            'return_date' => 'required',
            'condition' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            // Get issue record
            $issue = db()->fetchOne("SELECT * FROM library_issues WHERE id = ? AND status = 'issued'", [$request->post('issue_id')]);
            
            if (!$issue) {
                flash('error', 'Invalid issue record or book already returned');
                return back();
            }

            // Update issue record
            db()->execute(
                "UPDATE library_issues SET status = 'returned', return_date = ?, book_condition = ?, fine_amount = ?, notes = ? WHERE id = ?",
                [
                    $request->post('return_date'),
                    $request->post('condition'),
                    $request->post('fine_amount') ?: 0,
                    $request->post('notes'),
                    $request->post('issue_id')
                ]
            );

            // Update book available quantity
            db()->execute(
                "UPDATE books SET available_quantity = available_quantity + 1 WHERE id = ?",
                [$issue['book_id']]
            );

            flash('success', 'Book returned successfully');
            return redirect('/library/issue');
        } catch (Exception $e) {
            flash('error', 'Failed to return book: ' . $e->getMessage());
            return back();
        }
    }
}
