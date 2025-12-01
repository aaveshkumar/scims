<?php

class ErrorHandler
{
    /**
     * Convert database exception to user-friendly error message
     */
    public static function getDatabaseErrorMessage($exception, $context = 'Operation')
    {
        $message = $exception->getMessage();
        
        // Duplicate key violation
        if (strpos($message, '23505') !== false || strpos($message, 'duplicate key') !== false) {
            if (strpos($message, 'asset_code_key') !== false) {
                return 'This asset code already exists. Please use a unique code.';
            }
            if (strpos($message, 'item_code_key') !== false) {
                return 'This item code already exists. Please use a unique code.';
            }
            if (strpos($message, 'supplier_code_key') !== false) {
                return 'This supplier code already exists. Please use a unique code.';
            }
            if (strpos($message, 'po_number_key') !== false) {
                return 'This purchase order number already exists.';
            }
            return 'This record already exists. Please use different values.';
        }
        
        // Foreign key violation
        if (strpos($message, '23503') !== false || strpos($message, 'foreign key') !== false) {
            if (strpos($message, 'assigned_to_fkey') !== false) {
                return 'The selected user does not exist. Please select a valid user.';
            }
            if (strpos($message, 'supplier_id_fkey') !== false) {
                return 'The selected supplier does not exist. Please select a valid supplier.';
            }
            return 'The selected reference record does not exist. Please check your input.';
        }
        
        // Numeric value out of range
        if (strpos($message, '22003') !== false || strpos($message, 'numeric field overflow') !== false) {
            return 'One or more numeric values are too large. Please check your input amounts.';
        }
        
        // Not null violation
        if (strpos($message, '23502') !== false || strpos($message, 'null value') !== false) {
            return 'Some required fields are missing. Please fill all required fields.';
        }
        
        // Generic database error
        if (strpos($message, 'SQLSTATE') !== false) {
            return $context . ' failed due to a database error. Please check your input and try again.';
        }
        
        // Fallback
        return $context . ' failed. Please try again or contact support if the problem persists.';
    }
}
