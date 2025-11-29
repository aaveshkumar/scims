            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle Functionality - Enhanced
        (function() {
            const htmlElement = document.documentElement;
            
            // Initialize theme on page load
            function initTheme() {
                const savedTheme = localStorage.getItem('theme') || 'light';
                setTheme(savedTheme);
            }
            
            function setTheme(theme) {
                // Set data attribute for CSS
                htmlElement.setAttribute('data-bs-theme', theme);
                
                // Update icon if it exists
                const themeIcon = document.getElementById('themeIcon');
                if (themeIcon) {
                    if (theme === 'dark') {
                        themeIcon.classList.remove('bi-moon-stars-fill');
                        themeIcon.classList.add('bi-sun-fill');
                    } else {
                        themeIcon.classList.remove('bi-sun-fill');
                        themeIcon.classList.add('bi-moon-stars-fill');
                    }
                }
                
                // Save to localStorage
                localStorage.setItem('theme', theme);
            }
            
            // Initialize theme immediately
            initTheme();
            
            // Set up theme toggle button if it exists
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentTheme = htmlElement.getAttribute('data-bs-theme') || 'light';
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                });
            }
            
            // Listen for storage changes in other tabs
            window.addEventListener('storage', function(e) {
                if (e.key === 'theme' && e.newValue) {
                    setTheme(e.newValue);
                }
            });
        })();
        
        // Page Loader Functionality
        (function() {
            const loader = document.getElementById('page-loader');
            
            // Only initialize if loader element exists
            if (!loader) return;
            
            // Show loader on all link clicks (except # links and logout)
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a');
                if (target && target.getAttribute('href') && 
                    !target.getAttribute('href').startsWith('#') && 
                    !target.getAttribute('href').startsWith('javascript:') &&
                    !target.classList.contains('no-loader') &&
                    target.getAttribute('target') !== '_blank') {
                    loader.classList.add('active');
                }
            });
            
            // Hide loader when page loads
            window.addEventListener('load', function() {
                loader.classList.remove('active');
            });
            
            // Hide loader if user navigates back
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    loader.classList.remove('active');
                }
            });
        })();
        
        // Delete Confirmation Function
        function confirmDelete(url, message = 'Are you sure you want to delete this?') {
            if (confirm(message)) {
                // Get CSRF token from meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                if (!csrfToken) {
                    alert('CSRF token not found. Please refresh the page.');
                    return;
                }
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ _token: csrfToken })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    alert('An error occurred. Please refresh the page and try again.');
                    console.error('Delete error:', error);
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
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                return;
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ _token: csrfToken })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Status toggle failed');
                }
            })
            .catch(error => {
                alert('An error occurred while toggling status. Please refresh the page and try again.');
                console.error('Toggle status error:', error);
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
