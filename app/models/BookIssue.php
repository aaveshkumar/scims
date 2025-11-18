<?php

class BookIssue
{
    protected static $table = 'book_issues';
    
    /**
     * Get all book issues with book and user details
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT bi.*, b.title as book_title, b.isbn, b.author,
                u.name as user_name, u.email as user_email,
                ib.name as issued_by_name
                FROM book_issues bi
                JOIN books b ON bi.book_id = b.id
                JOIN users u ON bi.user_id = u.id
                LEFT JOIN users ib ON bi.issued_by = ib.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND bi.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['user_id'])) {
            $sql .= " AND bi.user_id = ?";
            $params[] = $filters['user_id'];
        }
        
        if (!empty($filters['book_id'])) {
            $sql .= " AND bi.book_id = ?";
            $params[] = $filters['book_id'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (b.title LIKE ? OR b.isbn LIKE ? OR u.name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY bi.issue_date DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get issue by ID
     */
    public static function find($id)
    {
        $sql = "SELECT bi.*, b.title as book_title, b.isbn, b.author,
                u.name as user_name, u.email as user_email
                FROM book_issues bi
                JOIN books b ON bi.book_id = b.id
                JOIN users u ON bi.user_id = u.id
                WHERE bi.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    /**
     * Issue a book
     */
    public static function create($data)
    {
        $sql = "INSERT INTO book_issues (book_id, user_id, issue_date, due_date, 
                status, remarks, issued_by, created_at, updated_at) 
                VALUES (?, ?, ?, ?, 'issued', ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['book_id'],
            $data['user_id'],
            $data['issue_date'],
            $data['due_date'],
            $data['remarks'] ?? null,
            $data['issued_by']
        ]);
    }
    
    /**
     * Return a book
     */
    public static function returnBook($id, $returnedBy)
    {
        $issue = self::find($id);
        if (!$issue) return false;
        
        $returnDate = date('Y-m-d');
        $dueDate = $issue['due_date'];
        $fine = 0;
        
        // Calculate fine if overdue (Rs. 5 per day)
        if ($returnDate > $dueDate) {
            $days = (strtotime($returnDate) - strtotime($dueDate)) / (60 * 60 * 24);
            $fine = $days * 5; // Rs. 5 per day
        }
        
        $sql = "UPDATE book_issues SET status = 'returned', return_date = ?, 
                fine_amount = ?, returned_to = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [$returnDate, $fine, $returnedBy, $id]);
    }
    
    /**
     * Pay fine
     */
    public static function payFine($id)
    {
        return db()->execute("UPDATE book_issues SET fine_paid = TRUE, updated_at = NOW() WHERE id = ?", [$id]);
    }
    
    /**
     * Get overdue issues
     */
    public static function getOverdue()
    {
        $sql = "SELECT bi.*, b.title as book_title, u.name as user_name, u.email
                FROM book_issues bi
                JOIN books b ON bi.book_id = b.id
                JOIN users u ON bi.user_id = u.id
                WHERE bi.status = 'issued' AND bi.due_date < CURDATE()
                ORDER BY bi.due_date ASC";
        
        return db()->fetchAll($sql);
    }
    
    /**
     * Get active issues for a user
     */
    public static function getUserActiveIssues($userId)
    {
        $sql = "SELECT bi.*, b.title as book_title, b.author
                FROM book_issues bi
                JOIN books b ON bi.book_id = b.id
                WHERE bi.user_id = ? AND bi.status = 'issued'
                ORDER BY bi.due_date ASC";
        
        return db()->fetchAll($sql, [$userId]);
    }
    
    /**
     * Check if user can issue more books
     */
    public static function canUserIssueBook($userId)
    {
        $member = LibraryMember::getByUserId($userId);
        if (!$member) return false;
        
        $activeIssues = count(self::getUserActiveIssues($userId));
        return $activeIssues < $member['max_books'];
    }
    
    /**
     * Get issue statistics
     */
    public static function getStatistics()
    {
        return [
            'total_issued' => db()->fetchOne("SELECT COUNT(*) as count FROM book_issues WHERE status = 'issued'")['count'],
            'total_returned' => db()->fetchOne("SELECT COUNT(*) as count FROM book_issues WHERE status = 'returned'")['count'],
            'overdue_count' => db()->fetchOne("SELECT COUNT(*) as count FROM book_issues WHERE status = 'issued' AND due_date < CURDATE()")['count'],
            'total_fines' => db()->fetchOne("SELECT SUM(fine_amount) as total FROM book_issues WHERE fine_paid = FALSE")['total'] ?? 0
        ];
    }
}
