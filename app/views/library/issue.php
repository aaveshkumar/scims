<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Issue/Return Books</h1>
    <a href="/library/books" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left me-2"></i>Back to Library
    </a>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-box-arrow-right me-2"></i>Issue Book</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/library/issue">
                    <input type="hidden" name="_token" value="<?= csrf() ?>">
                    
                    <div class="mb-3">
                        <label for="student_id_issue" class="form-label">Student</label>
                        <select class="form-select" id="student_id_issue" name="student_id" required>
                            <option value="">Select Student</option>
                            <option value="1">John Doe (STU001)</option>
                            <option value="2">Jane Smith (STU002)</option>
                            <option value="3">Mike Johnson (STU003)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="book_id_issue" class="form-label">Book</label>
                        <select class="form-select" id="book_id_issue" name="book_id" required>
                            <option value="">Select Book</option>
                            <option value="1">Mathematics Grade 10 (ISBN: 978-1-234-56789-0)</option>
                            <option value="2">Physics for Beginners (ISBN: 978-1-234-56789-1)</option>
                            <option value="3">World History (ISBN: 978-1-234-56789-2)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="issue_date" class="form-label">Issue Date</label>
                        <input type="date" class="form-control" id="issue_date" name="issue_date" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?= date('Y-m-d', strtotime('+14 days')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any special notes..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Issue Book
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-box-arrow-in-left me-2"></i>Return Book</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/library/return">
                    <input type="hidden" name="_token" value="<?= csrf() ?>">
                    
                    <div class="mb-3">
                        <label for="issue_record" class="form-label">Issued Record</label>
                        <select class="form-select" id="issue_record" name="issue_id" required>
                            <option value="">Select Issued Record</option>
                            <option value="1">John Doe - Mathematics Grade 10 (Issued: 2024-11-03)</option>
                            <option value="2">Jane Smith - Physics for Beginners (Issued: 2024-11-05)</option>
                            <option value="3">Mike Johnson - World History (Issued: 2024-11-10)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="return_date" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="return_date" name="return_date" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">Book Condition</label>
                        <select class="form-select" id="condition" name="condition" required>
                            <option value="good">Good</option>
                            <option value="fair">Fair</option>
                            <option value="damaged">Damaged</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fine_amount" class="form-label">Fine Amount (if late)</label>
                        <input type="number" class="form-control" id="fine_amount" name="fine_amount" value="0" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="return_notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="return_notes" name="notes" rows="2" placeholder="Any return notes..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-2"></i>Return Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Currently Issued Books</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe (STU001)</td>
                        <td>Mathematics Grade 10</td>
                        <td>2024-11-03</td>
                        <td>2024-11-17</td>
                        <td><span class="badge bg-warning">Due Today</span></td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="showReturnModal(1)">
                                <i class="bi bi-box-arrow-in-left"></i> Return
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith (STU002)</td>
                        <td>Physics for Beginners</td>
                        <td>2024-11-05</td>
                        <td>2024-11-19</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="showReturnModal(2)">
                                <i class="bi bi-box-arrow-in-left"></i> Return
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Mike Johnson (STU003)</td>
                        <td>World History</td>
                        <td>2024-11-10</td>
                        <td>2024-11-24</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="showReturnModal(3)">
                                <i class="bi bi-box-arrow-in-left"></i> Return
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showReturnModal(id) {
    document.getElementById('issue_record').value = id;
    window.scrollTo(0, 0);
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
