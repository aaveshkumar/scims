<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-pencil-square me-2"></i>Send Message to Admin</h2>
            <a href="/support" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/support">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" class="form-control" required 
                               placeholder="Brief description of your concern" 
                               value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
                        <?php if (isset($errors['subject'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['subject'][0] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="8" required 
                                  placeholder="Please describe your query or concern in detail..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['message'][0] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Send Message
                        </button>
                        <a href="/support" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Note:</strong> Admin will review your message and respond within 24 hours.
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
