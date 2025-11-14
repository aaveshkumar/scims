<?php

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'invoice_number', 'student_id', 'fee_structure_id', 'amount',
        'discount', 'tax', 'total_amount', 'amount_paid', 'balance',
        'due_date', 'payment_status', 'payment_method', 'transaction_id',
        'payment_date', 'remarks', 'created_by'
    ];

    public function student()
    {
        return $this->db->fetchOne(
            "SELECT s.*, u.first_name, u.last_name, u.email
             FROM students s 
             INNER JOIN users u ON s.user_id = u.id 
             WHERE s.id = ?",
            [$this->student_id]
        );
    }

    public function feeStructure()
    {
        if (!$this->fee_structure_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM fees_structures WHERE id = ?",
            [$this->fee_structure_id]
        );
    }

    public function recordPayment($amount, $paymentMethod, $transactionId = null)
    {
        $newAmountPaid = $this->amount_paid + $amount;
        $newBalance = $this->total_amount - $newAmountPaid;

        $paymentStatus = 'paid';
        if ($newBalance > 0) {
            $paymentStatus = 'partial';
        }

        return $this->update($this->id, [
            'amount_paid' => $newAmountPaid,
            'balance' => $newBalance,
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'payment_date' => date('Y-m-d')
        ]);
    }

    public function getDefaulters($dueDate = null)
    {
        $sql = "SELECT i.*, s.admission_number, u.first_name, u.last_name, u.phone, u.email
                FROM invoices i
                INNER JOIN students s ON i.student_id = s.id
                INNER JOIN users u ON s.user_id = u.id
                WHERE i.balance > 0";
        
        $params = [];

        if ($dueDate) {
            $sql .= " AND i.due_date < ?";
            $params[] = $dueDate;
        }

        $sql .= " ORDER BY i.due_date ASC";

        return $this->db->fetchAll($sql, $params);
    }

    public static function generateInvoiceNumber()
    {
        return 'INV' . date('Y') . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}
