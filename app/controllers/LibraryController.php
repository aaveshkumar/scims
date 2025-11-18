<?php

class LibraryController
{
    /**
     * Show all books
     */
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category' => $request->get('category'),
            'status' => $request->get('status')
        ];
        
        $books = Book::getAll($filters);
        $categories = Book::getCategories();
        $stats = Book::getStatistics();
        
        return view('library/index', [
            'title' => 'Library Management - Books',
            'books' => $books,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    /**
     * Show create book form
     */
    public function create($request)
    {
        return view('library/create', [
            'title' => 'Add New Book'
        ]);
    }

    /**
     * Store new book
     */
    public function store($request)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'total_copies' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'isbn' => $request->post('isbn'),
                'title' => $request->post('title'),
                'author' => $request->post('author'),
                'publisher' => $request->post('publisher'),
                'publication_year' => $request->post('publication_year'),
                'category' => $request->post('category'),
                'total_copies' => $request->post('total_copies'),
                'available_copies' => $request->post('total_copies'), // Initially all copies are available
                'location' => $request->post('location'),
                'price' => $request->post('price'),
                'description' => $request->post('description'),
                'status' => $request->post('status') ?? 'active'
            ];

            Book::create($data);
            flash('success', 'Book added successfully');
            return redirect('/library/books');
        } catch (Exception $e) {
            flash('error', 'Failed to add book: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show book details
     */
    public function show($request, $id)
    {
        $book = Book::find($id);
        
        if (!$book) {
            flash('error', 'Book not found');
            return redirect('/library/books');
        }
        
        // Get book issue history
        $issues = BookIssue::getAll(['book_id' => $id]);
        
        return view('library/show', [
            'title' => 'Book Details',
            'book' => $book,
            'issues' => $issues
        ]);
    }

    /**
     * Show edit book form
     */
    public function edit($request, $id)
    {
        $book = Book::find($id);
        
        if (!$book) {
            flash('error', 'Book not found');
            return redirect('/library/books');
        }
        
        return view('library/edit', [
            'title' => 'Edit Book',
            'book' => $book
        ]);
    }

    /**
     * Update book
     */
    public function update($request, $id)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'total_copies' => 'required|numeric',
            'available_copies' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'isbn' => $request->post('isbn'),
                'title' => $request->post('title'),
                'author' => $request->post('author'),
                'publisher' => $request->post('publisher'),
                'publication_year' => $request->post('publication_year'),
                'category' => $request->post('category'),
                'total_copies' => $request->post('total_copies'),
                'available_copies' => $request->post('available_copies'),
                'location' => $request->post('location'),
                'price' => $request->post('price'),
                'description' => $request->post('description'),
                'status' => $request->post('status')
            ];

            Book::update($id, $data);
            flash('success', 'Book updated successfully');
            return redirect('/library/books');
        } catch (Exception $e) {
            flash('error', 'Failed to update book: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Delete book
     */
    public function destroy($request, $id)
    {
        try {
            Book::delete($id);
            flash('success', 'Book deleted successfully');
            return redirect('/library/books');
        } catch (Exception $e) {
            flash('error', 'Failed to delete book: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show issue/return page
     */
    public function issue($request)
    {
        $filters = [
            'status' => $request->get('status'),
            'search' => $request->get('search')
        ];
        
        $issues = BookIssue::getAll($filters);
        $overdueIssues = BookIssue::getOverdue();
        $stats = BookIssue::getStatistics();
        
        // Get available books
        $availableBooks = db()->fetchAll(
            "SELECT id, title, author, isbn, available_copies 
             FROM books 
             WHERE status = 'active' AND available_copies > 0 
             ORDER BY title"
        );
        
        // Get library members
        $members = LibraryMember::getAll(['status' => 'active']);
        
        return view('library/issue', [
            'title' => 'Issue/Return Books',
            'issues' => $issues,
            'overdueIssues' => $overdueIssues,
            'stats' => $stats,
            'availableBooks' => $availableBooks,
            'members' => $members,
            'filters' => $filters
        ]);
    }
    
    /**
     * Process book issue
     */
    public function processIssue($request)
    {
        $rules = [
            'user_id' => 'required',
            'book_id' => 'required',
            'issue_date' => 'required',
            'due_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $userId = $request->post('user_id');
            $bookId = $request->post('book_id');
            
            // Check if book is available
            if (!Book::isAvailable($bookId)) {
                flash('error', 'Book is not available for issue');
                return back();
            }
            
            // Check if user can issue more books
            if (!BookIssue::canUserIssueBook($userId)) {
                flash('error', 'User has reached maximum book limit');
                return back();
            }
            
            $data = [
                'book_id' => $bookId,
                'user_id' => $userId,
                'issue_date' => $request->post('issue_date'),
                'due_date' => $request->post('due_date'),
                'remarks' => $request->post('remarks'),
                'issued_by' => auth()->id()
            ];
            
            // Create issue record
            BookIssue::create($data);
            
            // Decrease available copies
            Book::decreaseAvailableCopies($bookId);
            
            flash('success', 'Book issued successfully');
            return redirect('/library/issue');
        } catch (Exception $e) {
            flash('error', 'Failed to issue book: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Process book return
     */
    public function processReturn($request)
    {
        $rules = [
            'issue_id' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please select a book to return');
            return back();
        }

        try {
            $issueId = $request->post('issue_id');
            $issue = BookIssue::find($issueId);
            
            if (!$issue || $issue['status'] !== 'issued') {
                flash('error', 'Invalid issue record or book already returned');
                return back();
            }
            
            // Return the book
            BookIssue::returnBook($issueId, auth()->id());
            
            // Increase available copies
            Book::increaseAvailableCopies($issue['book_id']);
            
            flash('success', 'Book returned successfully. Fine: Rs. ' . ($issue['fine_amount'] ?? 0));
            return redirect('/library/issue');
        } catch (Exception $e) {
            flash('error', 'Failed to return book: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Pay fine
     */
    public function payFine($request)
    {
        $issueId = $request->post('issue_id');
        
        try {
            BookIssue::payFine($issueId);
            flash('success', 'Fine paid successfully');
            return back();
        } catch (Exception $e) {
            flash('error', 'Failed to pay fine: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show library members
     */
    public function members($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'membership_type' => $request->get('membership_type')
        ];
        
        $members = LibraryMember::getAll($filters);
        $stats = LibraryMember::getStatistics();
        $expiringSoon = LibraryMember::getExpiringSoon();
        
        return view('library/members', [
            'title' => 'Library Members',
            'members' => $members,
            'stats' => $stats,
            'expiringSoon' => $expiringSoon,
            'filters' => $filters
        ]);
    }
    
    /**
     * Show add member form
     */
    public function createMember($request)
    {
        // Get all users who are not already library members
        $users = db()->fetchAll(
            "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name, u.email, 
                    COALESCE(r.display_name, 'No Role') as role_name 
             FROM users u 
             LEFT JOIN library_members lm ON u.id = lm.user_id 
             LEFT JOIN user_roles ur ON u.id = ur.user_id
             LEFT JOIN roles r ON ur.role_id = r.id
             WHERE lm.id IS NULL 
             ORDER BY u.first_name, u.last_name"
        );
        
        return view('library/create_member', [
            'title' => 'Add Library Member',
            'users' => $users
        ]);
    }
    
    /**
     * Store new member
     */
    public function storeMember($request)
    {
        $rules = [
            'user_id' => 'required',
            'join_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'user_id' => $request->post('user_id'),
                'membership_type' => $request->post('membership_type') ?? 'standard',
                'join_date' => $request->post('join_date'),
                'expiry_date' => $request->post('expiry_date'),
                'max_books' => $request->post('max_books') ?? 3,
                'status' => 'active'
            ];

            LibraryMember::create($data);
            flash('success', 'Library member added successfully');
            return redirect('/library/members');
        } catch (Exception $e) {
            flash('error', 'Failed to add member: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Edit member
     */
    public function editMember($request, $id)
    {
        $member = LibraryMember::find($id);
        
        if (!$member) {
            flash('error', 'Member not found');
            return redirect('/library/members');
        }
        
        return view('library/edit_member', [
            'title' => 'Edit Library Member',
            'member' => $member
        ]);
    }
    
    /**
     * Update member
     */
    public function updateMember($request, $id)
    {
        $rules = [
            'membership_type' => 'required',
            'max_books' => 'required|numeric',
            'status' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'membership_type' => $request->post('membership_type'),
                'expiry_date' => $request->post('expiry_date'),
                'max_books' => $request->post('max_books'),
                'status' => $request->post('status')
            ];

            LibraryMember::update($id, $data);
            flash('success', 'Member updated successfully');
            return redirect('/library/members');
        } catch (Exception $e) {
            flash('error', 'Failed to update member: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Renew membership
     */
    public function renewMembership($request, $id)
    {
        try {
            $months = $request->post('months') ?? 12;
            LibraryMember::renewMembership($id, $months);
            flash('success', 'Membership renewed successfully');
            return back();
        } catch (Exception $e) {
            flash('error', 'Failed to renew membership: ' . $e->getMessage());
            return back();
        }
    }
}
