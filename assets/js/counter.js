/**
 * SIEGA Modern Website - Counter Animation
 * Animated number counter for statistics
 */

document.addEventListener('DOMContentLoaded', function() {
    initCounters();
});

/**
 * Initialize all counters on page
 */
function initCounters() {
    const counters = document.querySelectorAll('.counter');
    
    if (counters.length === 0) return;
    
    // Options for Intersection Observer
    const options = {
        threshold: 0.5, // Trigger when 50% visible
        rootMargin: '0px'
    };
    
    // Create observer
    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Start counter animation
                animateCounter(entry.target);
                
                // Stop observing this counter
                observer.unobserve(entry.target);
            }
        });
    }, options);
    
    // Observe all counters
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

/**
 * Animate counter from 0 to target value
 * @param {HTMLElement} element - Counter element
 */
function animateCounter(element) {
    const target = parseInt(element.dataset.target);
    const duration = parseInt(element.dataset.duration) || 2000; // Default 2 seconds
    const increment = target / (duration / 16); // 60 FPS
    
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        
        if (current >= target) {
            element.textContent = formatCounterValue(target);
            clearInterval(timer);
        } else {
            element.textContent = formatCounterValue(Math.floor(current));
        }
    }, 16);
}

/**
 * Format counter value with separators
 * @param {number} value - Number to format
 * @returns {string} Formatted number
 */
function formatCounterValue(value) {
    // Add thousand separators
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Easing function for smoother animation
 * @param {number} t - Time
 * @param {number} b - Beginning value
 * @param {number} c - Change in value
 * @param {number} d - Duration
 * @returns {number} Eased value
 */
function easeOutCubic(t, b, c, d) {
    return c * ((t = t / d - 1) * t * t + 1) + b;
}

/**
 * Advanced counter with easing
 * @param {HTMLElement} element - Counter element
 */
function animateCounterWithEasing(element) {
    const target = parseInt(element.dataset.target);
    const duration = parseInt(element.dataset.duration) || 2000;
    const startTime = Date.now();
    
    function update() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = Math.floor(easeOutCubic(progress, 0, target, 1));
        element.textContent = formatCounterValue(current);
        
        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            element.textContent = formatCounterValue(target);
        }
    }
    
    requestAnimationFrame(update);
}

/**
 * Counter with prefix/suffix support
 * Example: data-prefix="Rp " data-suffix="jt"
 * @param {HTMLElement} element - Counter element
 */
function animateCounterWithAffix(element) {
    const target = parseInt(element.dataset.target);
    const duration = parseInt(element.dataset.duration) || 2000;
    const prefix = element.dataset.prefix || '';
    const suffix = element.dataset.suffix || '';
    const decimals = parseInt(element.dataset.decimals) || 0;
    
    const increment = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        
        if (current >= target) {
            element.textContent = prefix + formatCounterValue(target.toFixed(decimals)) + suffix;
            clearInterval(timer);
        } else {
            element.textContent = prefix + formatCounterValue(Math.floor(current).toFixed(decimals)) + suffix;
        }
    }, 16);
}

/**
 * Percentage counter (0-100)
 * @param {HTMLElement} element - Counter element
 */
function animatePercentage(element) {
    const target = parseInt(element.dataset.target);
    const duration = parseInt(element.dataset.duration) || 2000;
    
    const increment = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        
        if (current >= target) {
            element.textContent = target + '%';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current) + '%';
        }
    }, 16);
}

/**
 * Decimal counter (with decimal points)
 * Example: 98.5, 3.14, etc.
 * @param {HTMLElement} element - Counter element
 */
function animateDecimalCounter(element) {
    const target = parseFloat(element.dataset.target);
    const duration = parseInt(element.dataset.duration) || 2000;
    const decimals = parseInt(element.dataset.decimals) || 1;
    
    const increment = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        
        if (current >= target) {
            element.textContent = target.toFixed(decimals);
            clearInterval(timer);
        } else {
            element.textContent = current.toFixed(decimals);
        }
    }, 16);
}

/**
 * Reset counter to 0
 * @param {HTMLElement} element - Counter element
 */
function resetCounter(element) {
    element.textContent = '0';
}

/**
 * Reset all counters on page
 */
function resetAllCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => resetCounter(counter));
}

/**
 * Manually trigger counter animation
 * @param {string} elementId - ID of counter element
 */
function triggerCounter(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        animateCounter(element);
    }
}

// Export functions for global access
window.animateCounter = animateCounter;
window.animateCounterWithEasing = animateCounterWithEasing;
window.animateCounterWithAffix = animateCounterWithAffix;
window.animatePercentage = animatePercentage;
window.animateDecimalCounter = animateDecimalCounter;
window.resetCounter = resetCounter;
window.resetAllCounters = resetAllCounters;
window.triggerCounter = triggerCounter;