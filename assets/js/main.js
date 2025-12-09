/**
 * SIEGA Modern Website - Main JavaScript
 * Universitas Katolik Soegijapranata
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all components
    initNavbar();
    initMobileMenu();
    initSmoothScroll();
    initLazyLoading();
    initTooltips();
    initModals();
    initForms();
    initSearch();
    initFilters();
    
    console.log('SIEGA Modern Website initialized! 🚀');
});

/**
 * Navbar Scroll Effect
 */
function initNavbar() {
    const navbar = document.querySelector('nav');
    
    if (!navbar) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.remove('navbar-transparent');
            navbar.classList.add('navbar-solid');
        } else {
            navbar.classList.add('navbar-transparent');
            navbar.classList.remove('navbar-solid');
        }
    });
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (!menuButton || !mobileMenu) return;
    
    menuButton.addEventListener('click', function() {
        const isOpen = mobileMenu.classList.contains('hidden');
        
        if (isOpen) {
            mobileMenu.classList.remove('hidden');
            menuIcon?.classList.add('hidden');
            closeIcon?.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
            menuIcon?.classList.remove('hidden');
            closeIcon?.classList.add('hidden');
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!menuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.add('hidden');
            menuIcon?.classList.remove('hidden');
            closeIcon?.classList.add('hidden');
        }
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            e.preventDefault();
            
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL without jumping
                history.pushState(null, null, href);
            }
        });
    });
}

/**
 * Lazy Loading for Images
 */
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

/**
 * Initialize Tooltips
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const text = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            
            tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-slate-900 rounded-lg shadow-lg -top-12 left-1/2 transform -translate-x-1/2 whitespace-nowrap';
            tooltip.textContent = text;
            tooltip.id = 'tooltip-' + Date.now();
            
            this.style.position = 'relative';
            this.appendChild(tooltip);
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('[id^="tooltip-"]');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

/**
 * Modal Functions
 */
function initModals() {
    // Close modal when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    if (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    } else {
        // Close all modals
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.classList.add('hidden');
        });
    }
    document.body.style.overflow = 'auto';
}

/**
 * Form Validation and Submission
 */
function initForms() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            this.querySelectorAll('.error-message').forEach(el => el.remove());
            this.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            let isValid = true;
            
            // Validate required fields
            this.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    showFieldError(field, 'Field ini wajib diisi');
                    isValid = false;
                }
            });
            
            // Validate email fields
            this.querySelectorAll('input[type="email"]').forEach(field => {
                if (field.value && !isValidEmail(field.value)) {
                    showFieldError(field, 'Format email tidak valid');
                    isValid = false;
                }
            });
            
            // Validate phone fields
            this.querySelectorAll('input[type="tel"]').forEach(field => {
                if (field.value && !isValidPhone(field.value)) {
                    showFieldError(field, 'Format nomor telepon tidak valid');
                    isValid = false;
                }
            });
            
            if (isValid) {
                // Submit form via AJAX or normal submit
                if (this.dataset.ajax === 'true') {
                    submitFormAjax(this);
                } else {
                    this.submit();
                }
            }
        });
    });
}

function showFieldError(field, message) {
    field.classList.add('border-red-500');
    
    const error = document.createElement('div');
    error.className = 'error-message text-red-400 text-sm mt-1';
    error.textContent = message;
    
    field.parentNode.appendChild(error);
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function isValidPhone(phone) {
    const re = /^[\d\s\-\+\(\)]+$/;
    return re.test(phone) && phone.replace(/\D/g, '').length >= 10;
}

function submitFormAjax(form) {
    const formData = new FormData(form);
    const action = form.action;
    
    // Show loading state
    const submitButton = form.querySelector('[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner"></span> Loading...';
    
    fetch(action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Data berhasil disimpan!');
            form.reset();
            
            // Close modal if inside one
            const modal = form.closest('.modal-overlay');
            if (modal) {
                closeModal(modal.id);
            }
            
            // Reload data if callback exists
            if (typeof window.reloadData === 'function') {
                window.reloadData();
            }
        } else {
            showAlert('error', data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan koneksi!');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
}

/**
 * Show Alert/Notification
 */
function showAlert(type, message, duration = 5000) {
    const alertClasses = {
        success: 'alert-success',
        error: 'alert-error',
        warning: 'alert-warning',
        info: 'alert-info'
    };
    
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };
    
    const alert = document.createElement('div');
    alert.className = `alert ${alertClasses[type]} fixed top-4 right-4 z-50 min-w-[300px] animate-fade-in-down`;
    alert.innerHTML = `
        <span class="text-2xl">${icons[type]}</span>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    `;
    
    document.body.appendChild(alert);
    
    // Auto remove after duration
    setTimeout(() => {
        alert.remove();
    }, duration);
}

/**
 * Confirm Dialog
 */
function confirmDialog(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * Initialize Search
 */
function initSearch() {
    const searchInputs = document.querySelectorAll('[data-search]');
    
    searchInputs.forEach(input => {
        const target = input.dataset.search;
        
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll(`[data-searchable="${target}"]`);
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Initialize Filters
 */
function initFilters() {
    const filters = document.querySelectorAll('[data-filter]');
    
    filters.forEach(filter => {
        filter.addEventListener('change', function() {
            const filterType = this.dataset.filter;
            const filterValue = this.value;
            const items = document.querySelectorAll(`[data-filter-${filterType}]`);
            
            items.forEach(item => {
                const itemValue = item.dataset[`filter${filterType.charAt(0).toUpperCase() + filterType.slice(1)}`];
                
                if (filterValue === '' || itemValue === filterValue) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Copy to Clipboard
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('success', 'Berhasil disalin ke clipboard!');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showAlert('error', 'Gagal menyalin!');
    });
}

/**
 * Format Number with Separator
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Debounce Function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Scroll to Top
 */
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show scroll to top button when scrolled down
window.addEventListener('scroll', function() {
    const scrollTopBtn = document.getElementById('scroll-top-btn');
    
    if (scrollTopBtn) {
        if (window.scrollY > 500) {
            scrollTopBtn.classList.remove('hidden');
        } else {
            scrollTopBtn.classList.add('hidden');
        }
    }
});

// Export functions to window object for global access
window.openModal = openModal;
window.closeModal = closeModal;
window.showAlert = showAlert;
window.confirmDialog = confirmDialog;
window.copyToClipboard = copyToClipboard;
window.formatNumber = formatNumber;
window.scrollToTop = scrollToTop;