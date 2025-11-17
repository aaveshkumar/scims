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

    /**
     * Approve an admission application
     * @param int $admissionId
     * @param int $userId - Reviewer user ID
     * @param string|null $remarks
     * @return bool
     */
    public static function approveApplication($admissionId, $userId, $remarks = null)
    {
        $db = Database::getInstance();
        
        return $db->execute(
            "UPDATE admissions SET 
                status = 'approved',
                reviewed_by = ?,
                reviewed_at = NOW(),
                remarks = ?
             WHERE id = ?",
            [$userId, $remarks, $admissionId]
        );
    }

    /**
     * Reject an admission application
     */
    public static function rejectApplication($admissionId, $userId, $remarks = null)
    {
        $db = Database::getInstance();
        
        return $db->execute(
            "UPDATE admissions SET 
                status = 'rejected',
                reviewed_by = ?,
                reviewed_at = NOW(),
                remarks = ?
             WHERE id = ?",
            [$userId, $remarks, $admissionId]
        );
    }

    /**
     * Move application to waitlist
     */
    public static function waitlistApplication($admissionId, $userId, $remarks = null)
    {
        $db = Database::getInstance();
        
        return $db->execute(
            "UPDATE admissions SET 
                status = 'waitlisted',
                reviewed_by = ?,
                reviewed_at = NOW(),
                remarks = ?
             WHERE id = ?",
            [$userId, $remarks, $admissionId]
        );
    }

    /**
     * Convert approved admission to student with full user account
     * @param int $admissionId
     * @return array - ['success' => bool, 'student_id' => int, 'user_id' => int, 'message' => string]
     */
    public static function convertToStudent($admissionId)
    {
        $db = Database::getInstance();
        
        // Get admission details
        $admission = $db->fetchOne("SELECT * FROM admissions WHERE id = ?", [$admissionId]);
        
        if (!$admission) {
            return ['success' => false, 'message' => 'Admission not found'];
        }
        
        if ($admission['status'] !== 'approved') {
            return ['success' => false, 'message' => 'Only approved applications can be converted'];
        }

        // Check if already converted
        $existingStudent = $db->fetchOne(
            "SELECT id FROM students WHERE admission_number = ?",
            [$admission['application_number']]
        );
        
        if ($existingStudent) {
            return ['success' => false, 'message' => 'Application already converted to student'];
        }

        // Start transaction
        $db->beginTransaction();
        
        try {
            // 1. Create user account
            $password = password_hash('student@' . date('Y'), PASSWORD_DEFAULT);
            
            $db->execute(
                "INSERT INTO users (first_name, last_name, email, phone, password, 
                 gender, date_of_birth, address, status, created_at, updated_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())",
                [
                    $admission['first_name'],
                    $admission['last_name'],
                    $admission['email'],
                    $admission['phone'],
                    $password,
                    $admission['gender'],
                    $admission['date_of_birth'],
                    $admission['address']
                ]
            );
            
            $userId = $db->lastInsertId();

            // 2. Assign student role
            $studentRole = $db->fetchOne("SELECT id FROM roles WHERE name = 'student' LIMIT 1");
            if ($studentRole) {
                $db->execute(
                    "INSERT INTO user_roles (user_id, role_id, created_at) VALUES (?, ?, NOW())",
                    [$userId, $studentRole['id']]
                );
            }

            // 3. Create student record
            $admissionNumber = $admission['application_number'];
            
            $db->execute(
                "INSERT INTO students (user_id, admission_number, class_id, admission_date,
                 guardian_name, guardian_phone, guardian_email, previous_school,
                 documents, status, created_at, updated_at)
                 VALUES (?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, 'active', NOW(), NOW())",
                [
                    $userId,
                    $admissionNumber,
                    $admission['class_id'],
                    $admission['guardian_name'],
                    $admission['guardian_phone'],
                    $admission['guardian_email'] ?? null,
                    $admission['previous_school'] ?? null,
                    $admission['documents'] ?? null
                ]
            );
            
            $studentId = $db->lastInsertId();

            // 4. Mark admission as completed
            $db->execute(
                "UPDATE admissions SET status = 'completed' WHERE id = ?",
                [$admissionId]
            );

            // Commit transaction
            $db->commit();

            return [
                'success' => true,
                'student_id' => $studentId,
                'user_id' => $userId,
                'message' => 'Student account created successfully',
                'default_password' => 'student@' . date('Y')
            ];
            
        } catch (Exception $e) {
            $db->rollback();
            return ['success' => false, 'message' => 'Failed to convert: ' . $e->getMessage()];
        }
    }

    /**
     * Get application timeline/history
     */
    public static function getTimeline($admissionId)
    {
        $db = Database::getInstance();
        
        $admission = $db->fetchOne(
            "SELECT a.*, u.first_name as reviewer_first_name, u.last_name as reviewer_last_name
             FROM admissions a
             LEFT JOIN users u ON a.reviewed_by = u.id
             WHERE a.id = ?",
            [$admissionId]
        );

        if (!$admission) {
            return [];
        }

        $timeline = [];
        
        // Application submitted
        $timeline[] = [
            'action' => 'Application Submitted',
            'date' => $admission['created_at'],
            'user' => $admission['first_name'] . ' ' . $admission['last_name'],
            'icon' => 'file-earmark-text',
            'color' => 'primary'
        ];

        // Application reviewed
        if ($admission['reviewed_at']) {
            $reviewerName = $admission['reviewer_first_name'] 
                ? $admission['reviewer_first_name'] . ' ' . $admission['reviewer_last_name']
                : 'Admin';
            
            $statusIcons = [
                'approved' => 'check-circle',
                'rejected' => 'x-circle',
                'waitlisted' => 'hourglass',
                'completed' => 'person-check'
            ];
            
            $statusColors = [
                'approved' => 'success',
                'rejected' => 'danger',
                'waitlisted' => 'warning',
                'completed' => 'info'
            ];
            
            $timeline[] = [
                'action' => ucfirst($admission['status']),
                'date' => $admission['reviewed_at'],
                'user' => $reviewerName,
                'icon' => $statusIcons[$admission['status']] ?? 'info-circle',
                'color' => $statusColors[$admission['status']] ?? 'secondary'
            ];
        }

        return $timeline;
    }

    /**
     * Get admission statistics
     */
    public static function getStatistics()
    {
        $db = Database::getInstance();
        
        return [
            'total' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions")['count'],
            'pending' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'pending'")['count'],
            'approved' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'approved'")['count'],
            'rejected' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'rejected'")['count'],
            'waitlisted' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'waitlisted'")['count'],
            'completed' => $db->fetchOne("SELECT COUNT(*) as count FROM admissions WHERE status = 'completed'")['count'],
        ];
    }

    /**
     * Generate unique application number
     */
    public static function generateApplicationNumber()
    {
        $db = Database::getInstance();
        $year = date('Y');
        $prefix = 'ADM' . $year;
        
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

    /**
     * Track application by application number (for public/applicants)
     */
    public static function trackApplication($applicationNumber)
    {
        $db = Database::getInstance();
        
        return $db->fetchOne(
            "SELECT a.*, c.name as course_name, cl.name as class_name
             FROM admissions a
             LEFT JOIN courses c ON a.course_id = c.id
             LEFT JOIN classes cl ON a.class_id = cl.id
             WHERE a.application_number = ?",
            [$applicationNumber]
        );
    }
}
