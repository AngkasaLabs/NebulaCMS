<?php

/**
 * Uninstall script for Default Theme
 * 
 * This script is executed when the theme is deleted via the admin panel.
 * The environment variable NEBULA_THEME_UNINSTALL=1 is set when this script runs.
 * 
 * Use this to clean up any theme-specific data, files, or configurations.
 */

if (getenv('NEBULA_THEME_UNINSTALL') !== '1') {
    exit;
}

// Example: Clean up theme-specific options from database
// You can add your custom cleanup logic here

// Example: Log uninstall action
if (function_exists('info')) {
    info('Default Theme uninstalled successfully');
}

// Example: Remove theme-specific cache entries
// if (function_exists('cache')) {
//     cache()->forget('default_theme_options');
// }

// The script will automatically:
// 1. Remove the theme folder from /themes/{folder_name}
// 2. Remove published assets from /public/themes/{folder_name}
// 3. Remove the theme record from the database

// No return value needed - success is assumed if no exception is thrown
