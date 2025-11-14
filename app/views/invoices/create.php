<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create Invoice</h1>
    <a href="/invoices" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Invoice Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/invoices">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Student *</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">Choose a student</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>">
                                <?= htmlspecialchars($student['admission_number']) ?> - <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fee Structure</label>
                    <select name="fee_structure_id" class="form-select">
                        <option value="">Select Fee Structure (Optional)</option>
                        <?php foreach ($feeStructures as $structure): ?>
                            <option value="<?= $structure['id'] ?>">
                                <?= htmlspecialchars($structure['name']) ?> - $<?= number_format($structure['amount'], 2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Amount *</label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" placeholder="0.00" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Discount</label>
                    <input type="number" name="discount" class="form-control" step="0.01" min="0" value="0" placeholder="0.00">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tax</label>
                    <input type="number" name="tax" class="form-control" step="0.01" min="0" value="0" placeholder="0.00">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Due Date *</label>
                    <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control" id="totalAmount" readonly placeholder="Will be calculated">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Invoice
                </button>
                <a href="/invoices" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.querySelector('input[name="amount"]');
    const discountInput = document.querySelector('input[name="discount"]');
    const taxInput = document.querySelector('input[name="tax"]');
    const totalInput = document.getElementById('totalAmount');

    function calculateTotal() {
        const amount = parseFloat(amountInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;
        const tax = parseFloat(taxInput.value) || 0;
        const total = amount - discount + tax;
        totalInput.value = '$' + total.toFixed(2);
    }

    amountInput.addEventListener('input', calculateTotal);
    discountInput.addEventListener('input', calculateTotal);
    taxInput.addEventListener('input', calculateTotal);
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
