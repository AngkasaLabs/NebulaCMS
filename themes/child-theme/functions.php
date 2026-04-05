<?php

/**
 * File functions.php for child theme
 *
 * This file is used to register hooks, filters, and other functions needed by the child theme.
 * This file will be loaded automatically by the theme system after the parent theme's functions.php is loaded.
 */

// Hook that runs after theme is loaded
add_action('theme.loaded', function($theme) {
    // Do something after theme is loaded
    // This will run after the same hook in the parent theme (if any)
});

// Filter to modify home page data
// This will replace the same filter in the parent theme because we use higher priority (5)
add_filter('home_page_data', function($data) {
    // We can access the data that has been modified by the parent theme

    // Add new data
    $data['child_theme_data'] = 'Data from child theme';

    return $data;
}, 5); // Higher priority (lower number) than default (10)

// Filter to modify number of posts per page on blog page
// This will replace the value set by the parent theme
add_filter('blog_posts_per_page', function($perPage) {
    // Change number of posts per page
    return 9; // Show 9 posts per page
});

// Filter to modify template hierarchy
// This will run after the same filter in the parent theme
add_filter('template_hierarchy', function($templates, $theme) {
    // Add custom template to hierarchy
    if (is_array($templates) && count($templates) > 0) {
        array_unshift($templates, 'theme::templates.child-custom');
    }

    return $templates;
}, 5); // Higher priority (lower number) than default (10)

/**
 * Function to register child theme menus
 * This will replace the same function in the parent theme (if any)
 */
function register_theme_menus() {
    // Implement custom menu for child theme
}

/**
 * Function to register child theme sidebars
 * This will replace the same function in the parent theme (if any)
 */
function register_theme_sidebars() {
    // Implement custom sidebar for child theme
}

/**
 * Function to register child theme assets (CSS, JavaScript)
 * This will replace the same function in the parent theme (if any)
 */
function enqueue_theme_assets() {
    // Implement custom assets for child theme

    // If you want to load parent theme assets first, call parent_theme_enqueue_assets() (if any)
}
