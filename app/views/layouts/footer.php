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
        
        // Global Form Handler with Loading States
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                // Handle all form submissions
                const forms = document.querySelectorAll('form:not([data-no-loader])');
                
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        
                        if (submitBtn) {
                            // Prevent double submission
                            if (submitBtn.disabled) {
                                e.preventDefault();
                                return false;
                            }
                            
                            // Save original button text
                            const originalText = submitBtn.innerHTML;
                            
                            // Disable button and show loader
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
                            
                            // Re-enable on error or after timeout (safety net)
                            setTimeout(() => {
                                if (submitBtn.disabled) {
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = originalText;
                                }
                            }, 30000); // 30 seconds timeout
                        }
                    });
                });
                
                // Handle all buttons with data-loading attribute
                const loadingButtons = document.querySelectorAll('[data-loading]');
                loadingButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (this.disabled) return;
                        
                        const originalText = this.innerHTML;
                        const loadingText = this.getAttribute('data-loading') || 'Processing...';
                        
                        this.disabled = true;
                        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + loadingText;
                        
                        setTimeout(() => {
                            if (this.disabled) {
                                this.disabled = false;
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
