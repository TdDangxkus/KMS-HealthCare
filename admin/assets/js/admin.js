// Admin JavaScript - QickMed
document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const footer = document.querySelector('.footer');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
            if (footer) {
                footer.classList.toggle('expanded');
            }
            
            // Save sidebar state to localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Restore sidebar state from localStorage
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
        if (sidebarCollapsed === 'true') {
            sidebar.classList.add('collapsed');
            if (mainContent) {
                mainContent.classList.add('expanded');
            }
            if (footer) {
                footer.classList.add('expanded');
            }
        }
    }
    
    // Mobile Sidebar Toggle
    function handleMobileSidebar() {
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            sidebar?.classList.add('collapsed');
            mainContent?.classList.add('expanded');
            footer?.classList.add('expanded');
        } else {
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
            if (sidebarCollapsed !== 'true') {
                sidebar?.classList.remove('collapsed');
                mainContent?.classList.remove('expanded');
                footer?.classList.remove('expanded');
            }
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', handleMobileSidebar);
    handleMobileSidebar(); // Initial check
    
    // Auto-hide mobile sidebar when clicking on content
    if (window.innerWidth <= 768) {
        mainContent?.addEventListener('click', function() {
            if (!sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                footer?.classList.add('expanded');
            }
        });
    }
    
    // Dropdown Toggle Animation
    const dropdownToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('href'));
            const icon = this.querySelector('.fa-chevron-down');
            
            if (target && icon) {
                if (target.classList.contains('show')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
            }
        });
    });
    
    // Search Functionality
    const searchInput = document.querySelector('input[placeholder="Tìm kiếm..."]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    // Implement search functionality here
                    console.log('Searching for:', searchTerm);
                    // You can redirect to search page or perform AJAX search
                    // window.location.href = `search.php?q=${encodeURIComponent(searchTerm)}`;
                }
            }
        });
    }
    
    // Toast Notifications
    function showToast(message, type = 'success', duration = 5000) {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.toast');
        existingToasts.forEach(toast => toast.remove());
        
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Initialize and show toast
        const bsToast = new bootstrap.Toast(toast, {
            delay: duration
        });
        bsToast.show();
        
        // Remove toast element after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    }
    
    // Form Validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                showToast('Vui lòng kiểm tra lại thông tin!', 'danger');
            }
            form.classList.add('was-validated');
        });
    });
    
    // Loading States
    function showLoading(button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="loading me-2"></span>Đang xử lý...';
        button.disabled = true;
        button.dataset.originalText = originalText;
    }
    
    function hideLoading(button) {
        const originalText = button.dataset.originalText;
        if (originalText) {
            button.innerHTML = originalText;
            button.disabled = false;
            delete button.dataset.originalText;
        }
    }
    
    // AJAX Form Submission
    const ajaxForms = document.querySelectorAll('.ajax-form');
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);
            
            showLoading(submitBtn);
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoading(submitBtn);
                
                if (data.success) {
                    showToast(data.message || 'Thao tác thành công!', 'success');
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'danger');
                }
            })
            .catch(error => {
                hideLoading(submitBtn);
                showToast('Có lỗi xảy ra! Vui lòng thử lại.', 'danger');
                console.error('Error:', error);
            });
        });
    });
    
    // Delete Confirmation
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const message = this.dataset.message || 'Bạn có chắc chắn muốn xóa?';
            const url = this.href || this.dataset.url;
            
            if (confirm(message)) {
                if (url) {
                    window.location.href = url;
                }
            }
        });
    });
    
    // Data Tables Enhancement
    const tables = document.querySelectorAll('.data-table');
    tables.forEach(table => {
        // Add sorting functionality
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                const sortBy = this.dataset.sort;
                // Implement sorting logic here
                console.log('Sort by:', sortBy);
            });
        });
    });
    
    // Auto-refresh for real-time data
    function autoRefresh() {
        const refreshElements = document.querySelectorAll('[data-auto-refresh]');
        refreshElements.forEach(element => {
            const interval = parseInt(element.dataset.autoRefresh) * 1000;
            const url = element.dataset.refreshUrl;
            
            if (url && interval) {
                setInterval(() => {
                    fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        element.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Auto-refresh error:', error);
                    });
                }, interval);
            }
        });
    }
    
    // Initialize auto-refresh
    autoRefresh();
    
    // Theme Toggle (if needed)
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            localStorage.setItem('darkTheme', document.body.classList.contains('dark-theme'));
        });
        
        // Restore theme
        const darkTheme = localStorage.getItem('darkTheme');
        if (darkTheme === 'true') {
            document.body.classList.add('dark-theme');
        }
    }
    
    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + / to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === '/') {
            e.preventDefault();
            searchInput?.focus();
        }
        
        // Escape to close modals/dropdowns
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            });
            
            const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
    
    // Tooltips initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Popovers initialization
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Page Loading Animation
    window.addEventListener('beforeunload', function() {
        document.body.style.opacity = '0.7';
    });
    
    // Smooth Scrolling
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animation on Scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    // Observe cards and other elements
    const animatedElements = document.querySelectorAll('.card, .stats-card');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Expose utility functions globally
    window.AdminUtils = {
        showToast,
        showLoading,
        hideLoading
    };
});

// Global utility functions
function confirmDelete(message, url) {
    if (confirm(message || 'Bạn có chắc chắn muốn xóa?')) {
        window.location.href = url;
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        window.AdminUtils?.showToast('Đã sao chép vào clipboard!', 'success', 2000);
    }).catch(function() {
        window.AdminUtils?.showToast('Không thể sao chép!', 'danger', 2000);
    });
} 