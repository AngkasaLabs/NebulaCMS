<?php

use Illuminate\Support\Facades\URL;

if (!function_exists('theme_asset')) {
    /**
     * Generate an asset path for the theme.
     *
     * @param  string  $path
     * @return string
     */
    function theme_asset($path)
    {
        $theme = app('theme');
        return URL::asset("themes/{$theme->folder_name}/assets/{$path}");
    }
}