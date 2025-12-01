<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-gear me-2"></i>System Settings</h2>
    <p class="text-muted">Manage all site configuration and institutional settings</p>
</div>

<form method="POST" action="/settings" class="row">
    <?= csrf() ?>
    
    <!-- General Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>General Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Name <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" class="form-control" placeholder="e.g., School Management System" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site URL</label>
                        <input type="url" name="site_url" class="form-control" placeholder="https://example.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Description</label>
                        <textarea name="site_description" class="form-control" rows="2" placeholder="Brief description of your institution"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Timezone</label>
                        <select name="timezone" class="form-select">
                            <option value="UTC">UTC</option>
                            <option value="Asia/Kolkata">Asia/Kolkata (IST)</option>
                            <option value="Asia/Karachi">Asia/Karachi (PKT)</option>
                            <option value="America/New_York">America/New_York (EST)</option>
                            <option value="Europe/London">Europe/London (GMT)</option>
                            <option value="Asia/Dubai">Asia/Dubai (GST)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Institution Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-building me-2"></i>Institution Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                        <input type="text" name="institution_name" class="form-control" placeholder="Official institution name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Institution Code</label>
                        <input type="text" name="institution_code" class="form-control" placeholder="e.g., INST001">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Institution Address</label>
                        <textarea name="institution_address" class="form-control" rows="2" placeholder="Complete address"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Affiliation/Board</label>
                        <input type="text" name="affiliation" class="form-control" placeholder="e.g., CBSE, State Board">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Establishment Year</label>
                        <input type="number" name="established_year" class="form-control" placeholder="YYYY" min="1800" max="9999">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>Contact Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Primary Email <span class="text-danger">*</span></label>
                        <input type="email" name="primary_email" class="form-control" placeholder="admin@school.com" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Primary Phone</label>
                        <input type="tel" name="primary_phone" class="form-control" placeholder="+1234567890">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Secondary Email</label>
                        <input type="email" name="secondary_email" class="form-control" placeholder="info@school.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Secondary Phone</label>
                        <input type="tel" name="secondary_phone" class="form-control" placeholder="+0987654321">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Email Configuration</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="smtp_host" class="form-control" placeholder="smtp.gmail.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="smtp_port" class="form-control" placeholder="587" value="587">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Username</label>
                        <input type="email" name="smtp_username" class="form-control" placeholder="your-email@gmail.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" name="smtp_password" class="form-control" placeholder="••••••••••">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Encryption</label>
                        <select name="smtp_encryption" class="form-select">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">From Email</label>
                        <input type="email" name="from_email" class="form-control" placeholder="noreply@school.com">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-book me-2"></i>Academic Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Current Academic Year</label>
                        <input type="text" name="academic_year" class="form-control" placeholder="2024-2025">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Session Start Date</label>
                        <input type="date" name="session_start_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Session End Date</label>
                        <input type="date" name="session_end_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Default Working Days/Week</label>
                        <input type="number" name="working_days" class="form-control" placeholder="6" min="1" max="7">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>System & Security</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Session Timeout (minutes)</label>
                        <input type="number" name="session_timeout" class="form-control" placeholder="30" value="30">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Max Login Attempts</label>
                        <input type="number" name="max_login_attempts" class="form-control" placeholder="5" value="5">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password Min Length</label>
                        <input type="number" name="password_min_length" class="form-control" placeholder="8" value="8" min="6">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Enable Two-Factor Auth</label>
                        <select name="enable_2fa" class="form-select">
                            <option value="0">Disabled</option>
                            <option value="1">Enabled</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">
                            <input type="checkbox" name="require_password_change" value="1"> Require password change on first login
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- File Upload Settings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>File Upload Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Max File Upload Size (MB)</label>
                        <input type="number" name="max_upload_size" class="form-control" placeholder="50" value="50">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allowed File Types</label>
                        <input type="text" name="allowed_file_types" class="form-control" placeholder="pdf,doc,docx,jpg,png">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Document Retention (days)</label>
                        <input type="number" name="document_retention" class="form-control" placeholder="365">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social & Links -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-share me-2"></i>Social Media & Links</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="col-12">
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Save Settings
            </button>
            <a href="/dashboard" class="btn btn-secondary">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
        </div>
    </div>
</form>

<style>
    .card-header {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .card-header h5 {
        font-weight: 600;
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
