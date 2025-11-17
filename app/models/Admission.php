<?php

class Admission extends Model
{
    protected $table = 'admissions';
    protected $fillable = [
        'application_number', 'first_name', 'last_name', 'email', 'phone',
        'date_of_birth', 'gender', 'address', 'course_id', 'class_id',
        'previous_school', 'previous_grade', 'guardian_name', 'guardian_phone',
        'guardian_email', 'documents', 'status', 'remarks', 'applied_at',
        'reviewed_at', 'reviewed_by'
    ];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function course()
    {
        return $this->db->fetchOne(
            "SELECT * FROM courses WHERE id = ?",
            [$this->getAttribute('course_id')]
        );
    }

    public function class()
    {
        return $this->db->fetchOne(
            "SELECT * FROM classes WHERE id = ?",
            [$this->getAttribute('class_id')]
        );
    }

    public function reviewer()
    {
        $reviewerId = $this->getAttribute('reviewed_by');
        if (!$reviewerId) {
            return null;
        }
        
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?",
            [$reviewerId]
        );
    }

    public function approve($userId, $remarks = null)
    {
        $data = [
            'status' => 'approved',
            'reviewed_by' => $userId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ];
        
        return $this->update($this->getAttribute('id'), $data);
    }

    public function reject($userId, $remarks = null)
    {
        $data = [
            'status' => 'rejected',
            'reviewed_by' => $userId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ];
        
        return $this->update($this->getAttribute('id'), $data);
    }

    public function waitlist($userId, $remarks = null)
    {
        $data = [
            'status' => 'waitlisted',
            'reviewed_by' => $userId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ];
        
        return $this->update($this->getAttribute('id'), $data);
    }

    public function convertToStudent()
    {
        if ($this->getAttribute('status') !== 'approved') {
            return false;
        }

        $studentData = [
            'first_name' => $this->getAttribute('first_name'),
            'last_name' => $this->getAttribute('last_name'),
            'email' => $this->getAttribute('email'),
            'phone' => $this->getAttribute('phone'),
            'date_of_birth' => $this->getAttribute('date_of_birth'),
            'gender' => $this->getAttribute('gender'),
            'address' => $this->getAttribute('address'),
            'guardian_name' => $this->getAttribute('guardian_name'),
            'guardian_phone' => $this->getAttribute('guardian_phone'),
            'course_id' => $this->getAttribute('course_id'),
            'class_id' => $this->getAttribute('class_id'),
            'admission_date' => date('Y-m-d'),
            'status' => 'active'
        ];

        $studentModel = new Student();
        return $studentModel->create($studentData);
    }

    public static function generateApplicationNumber()
    {
        $year = date('Y');
        $prefix = 'ADM' . $year;
        
        $db = Database::getInstance();
        $lastApplication = $db->fetchOne(
            "SELECT application_number FROM admissions 
             WHERE application_number LIKE ? 
             ORDER BY id DESC LIMIT 1",
            [$prefix . '%']
        );

        if ($lastApplication) {
            $lastNumber = (int) substr($lastApplication['application_number'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getTimeline()
    {
        $timeline = [];
        
        $timeline[] = [
            'action' => 'Application Submitted',
            'date' => $this->getAttribute('applied_at') ?? $this->getAttribute('created_at'),
            'user' => $this->getAttribute('first_name') . ' ' . $this->getAttribute('last_name'),
            'icon' => 'file-earmark-text',
            'color' => 'primary'
        ];

        if ($this->getAttribute('reviewed_at')) {
            $reviewer = $this->reviewer();
            $reviewerName = $reviewer ? $reviewer['first_name'] . ' ' . $reviewer['last_name'] : 'Admin';
            
            $statusColors = [
                'approved' => 'success',
                'rejected' => 'danger',
                'waitlisted' => 'warning'
            ];
            
            $timeline[] = [
                'action' => ucfirst($this->getAttribute('status')),
                'date' => $this->getAttribute('reviewed_at'),
                'user' => $reviewerName,
                'icon' => $this->getAttribute('status') === 'approved' ? 'check-circle' : 
                         ($this->getAttribute('status') === 'rejected' ? 'x-circle' : 'hourglass'),
                'color' => $statusColors[$this->getAttribute('status')] ?? 'secondary'
            ];
        }

        return $timeline;
    }

    public static function getStatistics()
    {
        $db = Database::getInstance();
        
        return [
            'total' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions")['count'],
            'pending' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'pending'")['count'],
            'approved' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'approved'")['count'],
            'rejected' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'rejected'")['count'],
            'waitlisted' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'waitlisted'")['count'],
        ];
    }

    private function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }
}
