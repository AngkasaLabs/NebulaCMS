// Import required libraries
import hljs from 'highlight.js';
import bootstrap from 'bootstrap';

// Handle mobile menu
document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('[data-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});

// Handle smooth scroll
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
            });
        }
    });
});

// Handle image loading
document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach((img) => imageObserver.observe(img));
});

// Handle code highlighting
document.addEventListener('DOMContentLoaded', function () {
    const codeBlocks = document.querySelectorAll('pre code');
    if (window.hljs) {
        codeBlocks.forEach((block) => {
            hljs.highlightElement(block);
        });
    }
});

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        }
    });
});

// Add active class to current nav item
const currentPath = window.location.pathname;
document.querySelectorAll('.navbar-nav .nav-link').forEach((link) => {
    if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
    }
});

// Back to top button
window.addEventListener('scroll', function () {
    var backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        if (window.pageYOffset > 100) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    }
});

// Image lazy loading
document.addEventListener('DOMContentLoaded', function () {
    var lazyImages = [].slice.call(document.querySelectorAll('img[data-src]'));

    if ('IntersectionObserver' in window) {
        let lazyImageObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.removeAttribute('data-src');
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
});
