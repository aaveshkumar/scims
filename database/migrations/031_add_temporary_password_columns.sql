-- Migration: Add temporary password management columns
-- Description: Add password_temporary and password_expires_at to track temporary passwords

ALTER TABLE users ADD COLUMN IF NOT EXISTS password_temporary BOOLEAN DEFAULT true AFTER status;
ALTER TABLE users ADD COLUMN IF NOT EXISTS password_expires_at TIMESTAMP NULL AFTER password_temporary;

-- Create index for efficient expiration checks
CREATE INDEX IF NOT EXISTS idx_password_expires_at ON users(password_expires_at);
CREATE INDEX IF NOT EXISTS idx_password_temporary ON users(password_temporary);
