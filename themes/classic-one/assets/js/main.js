/**
 * Classic One Theme JavaScript
 * Main JavaScript file for the Classic One theme
 */

(function() {
    'use strict';

    // Document ready function
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        setupMobileMenu();
        
        // Dropdown menu functionality
        setupDropdownMenus();
        
        // Back to top button
        setupBackToTop();
    });

    /**
     * Setup mobile menu toggle functionality
     */
    function setupMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mainNavigation = document.querySelector('.main-navigation ul');
        
        if (menuToggle && mainNavigation) {
            menuToggle.addEventListener('click', function() {
                mainNavigation.classList.toggle('show');
                menuToggle.classList.toggle('active');
            });
        }
    }

    /**
     * Setup dropdown menu functionality
     */
    function setupDropdownMenus() {
        // For touch devices, first tap on parent item opens submenu
        const hasChildrenItems = document.querySelectorAll('.menu-item-has-children > a');
        
        if (hasChildrenItems.length) {
            hasChildrenItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    const parent = this.parentNode;
                    
                    // If submenu is not open, prevent default and open it
                    if (!parent.classList.contains('submenu-open')) {
                        e.preventDefault();
                        parent.classList.add('submenu-open');
                    }
                });
            });
            
            // Close submenus when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.menu-item-has-children')) {
                    document.querySelectorAll('.submenu-open').forEach(function(item) {
                        item.classList.remove('submenu-open');
                    });
                }
            });
        }
    }

    /**
     * Setup back to top button functionality
     */
    function setupBackToTop() {
        const backToTopButton = document.querySelector('.back-to-top');
        
        if (backToTopButton) {
            // Show/hide button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });
            
            // Smooth scroll to top when clicked
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }

})();