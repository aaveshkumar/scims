<?php

class ReportController
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO(
            'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS
        );
    }

    public function index($request)
    {
        return view('reports/index', ['title' => 'Reports & Analytics']);
    }

    public function create($request)
    {
        return view('reports/create', ['title' => 'Create - Reports & Analytics']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/reports');
    }

    public function show($request, $id)
    {
        return view('reports/show', ['title' => 'View - Reports & Analytics', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('reports/edit', ['title' => 'Edit - Reports & Analytics', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/reports');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/reports');
    }

    public function attendance($request)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, u.first_name, u.last_name, c.name as class_name
            FROM attendance a
            LEFT JOIN users u ON a.student_id = u.id
            LEFT JOIN classes c ON a.class_id = c.id
            ORDER BY a.date DESC LIMIT 100
        ");
        $stmt->execute();
        $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total, 
                   SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                   SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                   SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
            FROM attendance
        ");
        $stmt->execute();
        $summary = $stmt->fetch(\PDO::FETCH_ASSOC);

        return view('reports/attendance', [
            'title' => 'Attendance Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function academic($request)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, u.first_name, u.last_name, s.name as subject_name, e.exam_name
            FROM marks m
            LEFT JOIN users u ON m.student_id = u.id
            LEFT JOIN subjects s ON m.subject_id = s.id
            LEFT JOIN exams e ON m.exam_id = e.id
            ORDER BY m.marks_obtained DESC LIMIT 100
        ");
        $stmt->execute();
        $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total,
                   AVG(marks_obtained) as avg_marks,
                   MAX(marks_obtained) as highest,
                   MIN(marks_obtained) as lowest
            FROM marks
        ");
        $stmt->execute();
        $summary = $stmt->fetch(\PDO::FETCH_ASSOC);

        return view('reports/academic', [
            'title' => 'Academic Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function financial($request)
    {
        $stmt = $this->db->prepare("
            SELECT i.*, u.first_name, u.last_name
            FROM invoices i
            LEFT JOIN users u ON i.student_id = u.id
            ORDER BY i.issue_date DESC LIMIT 100
        ");
        $stmt->execute();
        $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total,
                   SUM(amount) as total_amount,
                   SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as paid,
                   SUM(CASE WHEN status != 'paid' THEN amount ELSE 0 END) as pending
            FROM invoices
        ");
        $stmt->execute();
        $summary = $stmt->fetch(\PDO::FETCH_ASSOC);

        return view('reports/financial', [
            'title' => 'Financial Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function custom($request)
    {
        return view('reports/custom', ['title' => 'Custom Reports']);
    }
}
