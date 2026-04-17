<?php

/**
 * Uninstall script for Hello World Plugin
 *
 * This script is executed when the plugin is deleted via the admin panel.
 * The environment variable NEBULA_PLUGIN_UNINSTALL=1 is set when this script runs.
 *
 * Use this to clean up any plugin-specific data, files, or configurations.
 */

if (getenv('NEBULA_PLUGIN_UNINSTALL') !== '1') {
    exit;
}

// Example: Clean up plugin-specific options from database
// You can add your custom cleanup logic here

// Example: Log uninstall action
if (function_exists('info')) {
    info('Hello World Plugin uninstalled successfully');
}

// Example: Remove plugin-specific cache entries
// if (function_exists('cache')) {
//     cache()->forget('hello_world_options');
// }

// The script will automatically:
// 1. Remove the plugin folder from /plugins/{folder_name}
// 2. Remove the plugin record from the database

// No return value needed - success is assumed if no exception is thrown
