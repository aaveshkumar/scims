<?php

class Admission extends Model
{
    protected $table = 'admissions';
    protected $fillable = [
        'application_number', 'first_name', 'last_name', 'email', 'phone',
        'date_of_birth', 'gender', 'address', 'course_id', 'class_id',
        'guardian_name', 'guardian_phone', 'guardian_email',
        'previous_school', 'documents', 'status', 'remarks'
    ];

    public function course()
    {
        if (!$this->course_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM courses WHERE id = ?",
            [$this->course_id]
        );
    }

    public function class()
    {
        if (!$this->class_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM classes WHERE id = ?",
            [$this->class_id]
        );
    }

    public function approve($reviewerId)
    {
        return $this->update($this->id, [
            'status' => 'approved',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function reject($reviewerId, $remarks)
    {
        return $this->update($this->id, [
            'status' => 'rejected',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ]);
    }

    public function convertToStudent()
    {
        $this->beginTransaction();

        try {
            $userModel = new User();
            $userId = $userModel->create([
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => User::hashPassword('password123'),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'address' => $this->address,
                'status' => 'active'
            ]);

            $roleModel = new Role();
            $studentRole = $roleModel->findByName('student');
            
            $this->db->execute(
                "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                [$userId, $studentRole['id']]
            );

            $studentModel = new Student();
            $studentId = $studentModel->create([
                'user_id' => $userId,
                'admission_number' => $this->application_number,
                'class_id' => $this->class_id,
                'admission_date' => date('Y-m-d'),
                'guardian_name' => $this->guardian_name,
                'guardian_phone' => $this->guardian_phone,
                'guardian_email' => $this->guardian_email,
                'previous_school' => $this->previous_school,
                'documents' => $this->documents,
                'status' => 'active'
            ]);

            $this->update($this->id, ['status' => 'completed']);

            $this->commit();

            return $studentId;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public static function generateApplicationNumber()
    {
        return 'ADM' . date('Y') . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}
