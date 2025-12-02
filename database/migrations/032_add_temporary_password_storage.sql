-- Migration: Add temporary_password_plaintext column
-- Description: Store temporary passwords for viewing in credentials modal

ALTER TABLE users ADD COLUMN IF NOT EXISTS temporary_password_plaintext VARCHAR(255) NULL AFTER password_expires_at;

-- Create index for quick lookup
CREATE INDEX IF NOT EXISTS idx_temporary_password_plaintext ON users(temporary_password_plaintext);
