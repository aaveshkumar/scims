            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle Functionality
        (function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;
            
            if (themeToggle) {
                // Load saved theme from localStorage
                const savedTheme = localStorage.getItem('theme') || 'light';
                setTheme(savedTheme);
                
                // Theme toggle click handler
                themeToggle.addEventListener('click', function() {
                    const currentTheme = htmlElement.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            }
            
            function setTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);
                
                if (theme === 'dark') {
                    if (themeIcon) {
                        themeIcon.classList.remove('bi-moon-stars-fill');
                        themeIcon.classList.add('bi-sun-fill');
                    }
                    document.body.style.backgroundColor = '#1a1d20';
                    document.body.style.color = '#e9ecef';
                } else {
                    if (themeIcon) {
                        themeIcon.classList.remove('bi-sun-fill');
                        themeIcon.classList.add('bi-moon-stars-fill');
                    }
                    document.body.style.backgroundColor = '#f8f9fc';
                    document.body.style.color = '#212529';
                }
            }
        })();
        
        // Delete Confirmation Function
        function confirmDelete(url, message = 'Are you sure you want to delete this?') {
            if (confirm(message)) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    alert('An error occurred');
                    console.error(error);
                });
            }
        }
        
        // Toggle Status Function
        function toggleStatus(type, id) {
            const urls = {
                'student': `/students/${id}/toggle-status`,
                'staff': `/staff/${id}/toggle-status`,
                'library-member': `/library/members/${id}/toggle-status`
            };
            
            const url = urls[type];
            if (!url) {
                alert('Invalid type');
                return;
            }
            
            // Get CSRF token from meta tag or form
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                            document.querySelector('input[name="_token"]')?.value;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ _token: csrfToken })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Status toggle failed');
                }
            })
            .catch(error => {
                alert('An error occurred while toggling status');
                console.error(error);
            });
        }
        
        // Global Form Handler with Loading States
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                // Track which submit button was clicked (for browsers without event.submitter)
                let lastClickedSubmit = null;
                
                // Listen for clicks on ALL submit controls to track which was clicked
                document.addEventListener('click', function(e) {
                    const target = e.target;
                    if (target.matches('button[type="submit"], input[type="submit"], button:not([type])')) {
                        lastClickedSubmit = target;
                    }
                }, true); // Use capture phase to ensure we catch it first
                
                // Handle all form submissions
                const forms = document.querySelectorAll('form:not([data-no-loader])');
                
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        // Get the actual button/input that was clicked to submit the form
                        // event.submitter gives us the exact element (works in modern browsers)
                        let submitBtn = e.submitter;
                        
                        // Fallback for older browsers or if submitter is null
                        if (!submitBtn) {
                            // Use the last clicked submit button if available
                            if (lastClickedSubmit && form.contains(lastClickedSubmit)) {
                                submitBtn = lastClickedSubmit;
                            } else {
                                // Last resort: try document.activeElement or first submit button
                                submitBtn = document.activeElement;
                                if (!submitBtn || !submitBtn.matches('button[type="submit"], input[type="submit"], button:not([type])')) {
                                    submitBtn = form.querySelector('button[type="submit"]') || 
                                               form.querySelector('input[type="submit"]') ||
                                               form.querySelector('button:not([type])');
                                }
                            }
                        }
                        
                        // Clear the tracked button after use
                        lastClickedSubmit = null;
                        
                        if (submitBtn) {
                            // Prevent double submission
                            if (submitBtn.disabled || submitBtn.hasAttribute('data-submitting')) {
                                e.preventDefault();
                                return false;
                            }
                            
                            // Mark as submitting
                            submitBtn.setAttribute('data-submitting', 'true');
                            
                            // Save original button content
                            const originalContent = submitBtn.innerHTML || submitBtn.value;
                            const isInputElement = submitBtn.tagName === 'INPUT';
                            
                            // Disable the control
                            submitBtn.disabled = true;
                            
                            // Show loader (different handling for input vs button)
                            if (isInputElement) {
                                submitBtn.value = 'Processing...';
                            } else {
                                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
                            }
                            
                            // Safety timeout: Re-enable after 30 seconds if still disabled
                            setTimeout(() => {
                                if (submitBtn.disabled) {
                                    submitBtn.disabled = false;
                                    submitBtn.removeAttribute('data-submitting');
                                    
                                    if (isInputElement) {
                                        submitBtn.value = originalContent;
                                    } else {
                                        submitBtn.innerHTML = originalContent;
                                    }
                                }
                            }, 30000);
                        }
                    });
                });
                
                // Handle all buttons with data-loading attribute
                const loadingButtons = document.querySelectorAll('[data-loading]');
                loadingButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (this.disabled || this.hasAttribute('data-submitting')) return;
                        
                        this.setAttribute('data-submitting', 'true');
                        const originalText = this.innerHTML;
                        const loadingText = this.getAttribute('data-loading') || 'Processing...';
                        
                        this.disabled = true;
                        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + loadingText;
                        
                        setTimeout(() => {
                            if (this.disabled) {
                                this.disabled = false;
                                this.removeAttribute('data-submitting');
                                this.innerHTML = originalText;
                            }
                        }, 30000);
                    });
                });
            });
        })();
    </script>
</body>
</html>
