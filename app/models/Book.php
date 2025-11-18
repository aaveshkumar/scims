<?php

class Book
{
    protected static $table = 'books';
    
    /**
     * Get all books with optional filters
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (title LIKE ? OR author LIKE ? OR isbn LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['category'])) {
            $sql .= " AND category = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY title ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get book by ID
     */
    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM books WHERE id = ?", [$id]);
    }
    
    /**
     * Create new book
     */
    public static function create($data)
    {
        $sql = "INSERT INTO books (isbn, title, author, publisher, publication_year, 
                category, total_copies, available_copies, location, price, description, 
                cover_image, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['isbn'] ?? null,
            $data['title'],
            $data['author'],
            $data['publisher'] ?? null,
            $data['publication_year'] ?? null,
            $data['category'] ?? null,
            $data['total_copies'] ?? 1,
            $data['available_copies'] ?? 1,
            $data['location'] ?? null,
            $data['price'] ?? null,
            $data['description'] ?? null,
            $data['cover_image'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Update book
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE books SET isbn = ?, title = ?, author = ?, publisher = ?, 
                publication_year = ?, category = ?, total_copies = ?, available_copies = ?, 
                location = ?, price = ?, description = ?, cover_image = ?, status = ?, 
                updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['isbn'] ?? null,
            $data['title'],
            $data['author'],
            $data['publisher'] ?? null,
            $data['publication_year'] ?? null,
            $data['category'] ?? null,
            $data['total_copies'],
            $data['available_copies'],
            $data['location'] ?? null,
            $data['price'] ?? null,
            $data['description'] ?? null,
            $data['cover_image'] ?? null,
            $data['status'] ?? 'active',
            $id
        ]);
    }
    
    /**
     * Delete book
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM books WHERE id = ?", [$id]);
    }
    
    /**
     * Get all categories
     */
    public static function getCategories()
    {
        return db()->fetchAll("SELECT DISTINCT category FROM books WHERE category IS NOT NULL ORDER BY category");
    }
    
    /**
     * Check if book is available
     */
    public static function isAvailable($id)
    {
        $book = self::find($id);
        return $book && $book['available_copies'] > 0;
    }
    
    /**
     * Decrease available copies when book is issued
     */
    public static function decreaseAvailableCopies($id)
    {
        return db()->execute("UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0", [$id]);
    }
    
    /**
     * Increase available copies when book is returned
     */
    public static function increaseAvailableCopies($id)
    {
        return db()->execute("UPDATE books SET available_copies = available_copies + 1 WHERE id = ? AND available_copies < total_copies", [$id]);
    }
    
    /**
     * Get book statistics
     */
    public static function getStatistics()
    {
        return [
            'total_books' => db()->fetchOne("SELECT COUNT(*) as count FROM books")['count'],
            'total_copies' => db()->fetchOne("SELECT SUM(total_copies) as total FROM books")['total'] ?? 0,
            'available_copies' => db()->fetchOne("SELECT SUM(available_copies) as total FROM books")['total'] ?? 0,
            'issued_books' => db()->fetchOne("SELECT COUNT(*) as count FROM book_issues WHERE status = 'issued'")['count']
        ];
    }
}
