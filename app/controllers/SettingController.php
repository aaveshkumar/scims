<?php

class SettingController
{
    public function index($request)
    {
        // Fetch all settings grouped by category
        $settings = db()->fetchAll("SELECT * FROM system_settings ORDER BY category, setting_key");
        
        // Group settings by category
        $groupedSettings = [];
        foreach ($settings as $setting) {
            $category = $setting['category'] ?: 'General';
            if (!isset($groupedSettings[$category])) {
                $groupedSettings[$category] = [];
            }
            $groupedSettings[$category][] = $setting;
        }
        
        return view('settings/index', [
            'title' => 'System Settings',
            'settings' => $settings,
            'groupedSettings' => $groupedSettings
        ]);
    }

    public function create($request)
    {
        return view('settings/create', ['title' => 'Create - System Settings']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/settings');
    }

    public function show($request, $id)
    {
        return view('settings/show', ['title' => 'View - System Settings', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('settings/edit', ['title' => 'Edit - System Settings', 'id' => $id]);
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/settings');
    }

    public function backup($request)
    {
        $backupsDir = __DIR__ . '/../../public/backups';
        $backups = [];
        
        if (is_dir($backupsDir)) {
            $files = scandir($backupsDir, SCANDIR_SORT_DESCENDING);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filePath = $backupsDir . '/' . $file;
                    $backups[] = [
                        'name' => $file,
                        'size' => filesize($filePath),
                        'date' => date('Y-m-d H:i:s', filemtime($filePath)),
                        'path' => $filePath
                    ];
                }
            }
        }
        
        return view('settings/backup', [
            'title' => 'Backup & Restore',
            'backups' => $backups
        ]);
    }

    public function createBackup($request)
    {
        try {
            $backupsDir = __DIR__ . '/../../public/backups';
            if (!is_dir($backupsDir)) {
                mkdir($backupsDir, 0755, true);
            }

            // Create backup filename
            $backupName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = $backupsDir . '/' . $backupName;

            // Create SQL dump
            $dbname = getenv('PGDATABASE') ?: 'postgres';
            $dbuser = getenv('PGUSER') ?: 'postgres';
            $dbpass = getenv('PGPASSWORD') ?: '';
            $dbhost = getenv('PGHOST') ?: 'localhost';
            $dbport = getenv('PGPORT') ?: '5432';

            // Set environment variables for pg_dump
            putenv("PGPASSWORD={$dbpass}");
            
            // Run pg_dump command
            $command = sprintf(
                'pg_dump -h %s -p %s -U %s -d %s > %s 2>&1',
                escapeshellarg($dbhost),
                escapeshellarg($dbport),
                escapeshellarg($dbuser),
                escapeshellarg($dbname),
                escapeshellarg($backupPath)
            );

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new Exception('Failed to create database backup');
            }

            flash('success', 'Backup created successfully: ' . $backupName);
            return redirect('/settings/backup');
        } catch (Exception $e) {
            flash('error', 'Failed to create backup: ' . $e->getMessage());
            return redirect('/settings/backup');
        }
    }

    public function downloadBackup($request, $filename)
    {
        try {
            $backupsDir = __DIR__ . '/../../public/backups';
            $backupPath = $backupsDir . '/' . basename($filename);

            // Security check: ensure file is in backups directory
            if (!file_exists($backupPath) || !is_file($backupPath)) {
                flash('error', 'Backup file not found');
                return redirect('/settings/backup');
            }

            // Download the file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Content-Length: ' . filesize($backupPath));
            readfile($backupPath);
            exit;
        } catch (Exception $e) {
            flash('error', 'Failed to download backup: ' . $e->getMessage());
            return redirect('/settings/backup');
        }
    }

    public function restoreBackup($request)
    {
        try {
            if (!isset($_FILES['backup_file']) || $_FILES['backup_file']['error'] !== UPLOAD_ERR_OK) {
                flash('error', 'Please select a valid backup file');
                return back();
            }

            $uploadedFile = $_FILES['backup_file'];
            $tempPath = $uploadedFile['tmp_name'];

            // Validate file extension
            $ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
            if ($ext !== 'sql') {
                flash('error', 'Invalid file type. Only SQL files are allowed');
                return back();
            }

            // Store backup in backups directory
            $backupsDir = __DIR__ . '/../../public/backups';
            if (!is_dir($backupsDir)) {
                mkdir($backupsDir, 0755, true);
            }

            $backupName = 'restored_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = $backupsDir . '/' . $backupName;
            move_uploaded_file($tempPath, $backupPath);

            // Database credentials
            $dbname = getenv('PGDATABASE') ?: 'postgres';
            $dbuser = getenv('PGUSER') ?: 'postgres';
            $dbpass = getenv('PGPASSWORD') ?: '';
            $dbhost = getenv('PGHOST') ?: 'localhost';
            $dbport = getenv('PGPORT') ?: '5432';

            // Set environment variable for psql
            putenv("PGPASSWORD={$dbpass}");

            // Restore backup
            $command = sprintf(
                'psql -h %s -p %s -U %s -d %s < %s 2>&1',
                escapeshellarg($dbhost),
                escapeshellarg($dbport),
                escapeshellarg($dbuser),
                escapeshellarg($dbname),
                escapeshellarg($backupPath)
            );

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new Exception('Failed to restore database from backup');
            }

            flash('success', 'Database restored successfully from: ' . $uploadedFile['name']);
            return redirect('/settings/backup');
        } catch (Exception $e) {
            flash('error', 'Failed to restore backup: ' . $e->getMessage());
            return back();
        }
    }

    public function deleteBackup($request, $filename)
    {
        try {
            $backupsDir = __DIR__ . '/../../public/backups';
            $backupPath = $backupsDir . '/' . basename($filename);

            if (!file_exists($backupPath)) {
                flash('error', 'Backup file not found');
                return redirect('/settings/backup');
            }

            unlink($backupPath);
            flash('success', 'Backup deleted successfully');
            return redirect('/settings/backup');
        } catch (Exception $e) {
            flash('error', 'Failed to delete backup: ' . $e->getMessage());
            return redirect('/settings/backup');
        }
    }

    public function auditLogs($request)
    {
        return view('settings/audit_logs', ['title' => 'Audit Logs']);
    }

    public function update($request)
    {
        try {
            // Get all POST data
            $data = $request->post();
            
            // Process each setting
            foreach ($data as $key => $value) {
                if ($key === '_token' || $key === '_method') {
                    continue;
                }
                
                // Check if setting exists
                $existing = db()->fetchOne("SELECT id FROM system_settings WHERE setting_key = ?", [$key]);
                
                if ($existing) {
                    // Update existing setting
                    db()->execute(
                        "UPDATE system_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?",
                        [$value, $key]
                    );
                } else {
                    // Insert new setting
                    db()->execute(
                        "INSERT INTO system_settings (setting_key, setting_value, setting_type, is_editable, created_at, updated_at) 
                         VALUES (?, ?, 'string', true, NOW(), NOW())",
                        [$key, $value]
                    );
                }
            }
            
            flash('success', 'Settings updated successfully');
            return redirect('/settings');
        } catch (Exception $e) {
            flash('error', 'Failed to update settings: ' . $e->getMessage());
            return back();
        }
    }
}
