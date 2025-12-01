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
        return view('settings/backup', ['title' => 'Backup & Restore']);
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
