<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Generate New Payroll</h1>
        <p class="text-muted mb-0">Create payroll for an employee</p>
    </div>
    <a href="/payroll" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/payroll" class="needs-validation" id="payrollForm">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Employee Selection -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-person-check me-2"></i>Select Employee
                </h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Employee *</label>
                        <select name="staff_id" id="staffSelect" class="form-select" required onchange="updateStaffSalary()">
                            <option value="">-- Select an Employee --</option>
                            <?php if (!empty($staff)): ?>
                                <?php foreach ($staff as $member): ?>
                                    <option value="<?= $member['id'] ?>" data-salary="<?= $member['salary'] ?? 0 ?>">
                                        <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?> (<?= htmlspecialchars($member['employee_id']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">Choose the employee for this payroll</small>
                    </div>
                </div>
            </div>

            <!-- Period Selection -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar-event me-2"></i>Payroll Period
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Month *</label>
                        <select name="month" class="form-select" required>
                            <option value="">-- Select Month --</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November" selected>November</option>
                            <option value="December">December</option>
                        </select>
                        <small class="text-muted">Payroll month</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Year *</label>
                        <select name="year" class="form-select" required>
                            <option value="">-- Select Year --</option>
                            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                        <small class="text-muted">Payroll year</small>
                    </div>
                </div>
            </div>

            <!-- Salary Components -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-currency-rupee me-2"></i>Salary Components
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Basic Salary *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="basic_salary" id="basicSalary" class="form-control" step="0.01" min="0" required onchange="calculateGross()">
                        </div>
                        <small class="text-muted">Monthly basic salary</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Allowances</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="allowances" id="allowances" class="form-control" step="0.01" min="0" value="0" onchange="calculateGross()">
                        </div>
                        <small class="text-muted">e.g., HRA, DA, conveyance</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deductions</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="deductions" id="deductions" class="form-control" step="0.01" min="0" value="0" onchange="calculateGross()">
                        </div>
                        <small class="text-muted">e.g., taxes, insurance, loan</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Gross Salary</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="text" id="grossSalary" class="form-control" disabled>
                        </div>
                        <small class="text-muted">Auto-calculated (Basic + Allowances)</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            <strong>Net Salary:</strong> ₹<span id="netSalary">0.00</span> (Gross - Deductions)
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-credit-card me-2"></i>Payment Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>">
                        <small class="text-muted">When will the payment be made?</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="">-- Select Method --</option>
                            <option value="Cash">Cash</option>
                            <option value="Check">Check</option>
                            <option value="Bank Transfer" selected>Bank Transfer</option>
                            <option value="Digital Payment">Digital Payment</option>
                        </select>
                        <small class="text-muted">How will the payment be made?</small>
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-text me-2"></i>Additional Notes
                </h6>
                <textarea name="remarks" class="form-control" rows="3" placeholder="Add any additional notes or remarks for this payroll..."></textarea>
                <small class="text-muted">Optional remarks about this payroll</small>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Generate Payroll
                </button>
                <a href="/payroll" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updateStaffSalary() {
    const select = document.getElementById('staffSelect');
    const selectedOption = select.options[select.selectedIndex];
    const salary = selectedOption.getAttribute('data-salary') || 0;
    document.getElementById('basicSalary').value = salary;
    calculateGross();
}

function calculateGross() {
    const basic = parseFloat(document.getElementById('basicSalary').value) || 0;
    const allowances = parseFloat(document.getElementById('allowances').value) || 0;
    const deductions = parseFloat(document.getElementById('deductions').value) || 0;
    
    const gross = basic + allowances;
    const net = gross - deductions;
    
    document.getElementById('grossSalary').value = gross.toFixed(2);
    document.getElementById('netSalary').innerText = net.toFixed(2);
}

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    calculateGross();
});
</script>

<style>
[data-bs-theme="dark"] .text-muted {
    color: #a8b1bd !important;
}

[data-bs-theme="dark"] .form-label {
    color: #e9ecef;
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #495057;
}

[data-bs-theme="dark"] .form-control:focus,
[data-bs-theme="dark"] .form-select:focus {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #5a8dee;
    box-shadow: 0 0 0 0.25rem rgba(90, 141, 238, 0.25);
}

[data-bs-theme="dark"] .input-group-text {
    background-color: #3a3f47;
    color: #e9ecef;
    border-color: #495057;
}

[data-bs-theme="dark"] .alert-info {
    background-color: #3a4a5a;
    color: #d4e3ff;
    border-color: #5a7a9a;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>