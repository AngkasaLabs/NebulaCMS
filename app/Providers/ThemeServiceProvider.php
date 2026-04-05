<?php

namespace App\Providers;

use App\Models\Theme;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('theme', function ($app) {
            try {
                if (! Schema::hasTable('themes')) {
                    return new Theme([
                        'name' => 'Default Theme',
                        'folder_name' => 'default',
                        'is_active' => true,
                    ]);
                }

                return Theme::getActive() ?? new Theme([
                    'name' => 'Default Theme',
                    'folder_name' => 'default',
                    'is_active' => true,
                ]);
            } catch (\Exception $e) {
                // if database not found, return default theme
                return new Theme([
                    'name' => 'Default Theme',
                    'folder_name' => 'default',
                    'is_active' => true,
                ]);
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            if (! Schema::hasTable('themes')) {
                // Register default theme namespace even when database is not available
                $this->registerDefaultThemeNamespace();

                return;
            }
        } catch (\Exception $e) {
            // Jika database tidak tersedia, register default theme namespace
            $this->registerDefaultThemeNamespace();

            return;
        }

        // Share active theme to all views
        View::composer('*', function ($view) {
            $view->with('theme', app('theme'));
        });

        // Add theme path to view finder
        $theme = app('theme');

        // Loading functions.php from parent theme (if any) and active theme
        $this->loadThemeFunctions($theme);

        $this->registerThemeLangPaths($theme);

        // Using hook to modify theme view path
        $themePath = apply_filters('theme.view_path_base', base_path("themes/{$theme->folder_name}/views"), $theme);

        // Check if theme has parent
        $parentTheme = $this->getParentTheme($theme);

        // If theme has parent, add parent path first
        if ($parentTheme) {
            $parentThemePath = apply_filters('theme.parent_view_path_base', base_path("themes/{$parentTheme->folder_name}/views"), $parentTheme);

            if (file_exists($parentThemePath)) {
                $this->loadViewsFrom($parentThemePath, 'parent_theme');
            }
        }

        // Then add active theme path (child theme if using parent)
        if (file_exists($themePath)) {
            $this->loadViewsFrom($themePath, 'theme');
        } else {
            // Fallback: register default theme path for testing
            $defaultThemePath = base_path('themes/default/views');
            if (file_exists($defaultThemePath)) {
                $this->loadViewsFrom($defaultThemePath, 'theme');
            }
        }

        // Register theme assets path with hook
        $assetsPath = apply_filters('theme.assets_path_base', base_path("themes/{$theme->folder_name}/assets"), $theme);
        $publicPath = apply_filters('theme.public_assets_path', public_path("themes/{$theme->folder_name}/assets"), $theme);

        $this->publishes([
            $assetsPath => $publicPath,
        ], 'theme-assets');

        // Run hook after theme is loaded
        do_action('theme.loaded', $theme);
    }

    /**
     * Getting parent theme if current theme is a child theme
     */
    protected function getParentTheme(Theme $theme): ?Theme
    {
        // Check if theme has parent settings
        $settings = $theme->settings ?? [];

        if (isset($settings['parent']) && ! empty($settings['parent'])) {
            $parentSlug = $settings['parent'];

            return Theme::where('folder_name', $parentSlug)->first();
        }

        return null;
    }

    /**
     * Loading functions.php from theme
     * Loading functions.php from parent theme first (if any)
     * then loading functions.php from active theme
     */
    protected function loadThemeFunctions(Theme $theme): void
    {
        // Check if theme has parent
        $parentTheme = $this->getParentTheme($theme);

        // If theme has parent, load functions.php from parent first
        if ($parentTheme) {
            $parentFunctionsPath = base_path("themes/{$parentTheme->folder_name}/functions.php");

            if (file_exists($parentFunctionsPath)) {
                require_once $parentFunctionsPath;
            }
        }

        // Then load functions.php from active theme
        $functionsPath = base_path("themes/{$theme->folder_name}/functions.php");

        if (file_exists($functionsPath)) {
            require_once $functionsPath;
        }
    }

    /**
     * Register default theme namespace for fallback
     */
    protected function registerDefaultThemeNamespace(): void
    {
        $defaultThemePath = base_path('themes/default/views');
        if (file_exists($defaultThemePath)) {
            $this->loadViewsFrom($defaultThemePath, 'theme');
        }

        $this->registerThemeLangPaths(app('theme'));
    }

    /**
     * Register translation paths under themes/{folder}/lang so groups like
     * documentation.php live in the theme (merged after app lang/, theme wins on duplicate keys).
     */
    protected function registerThemeLangPaths(Theme $theme): void
    {
        $translator = $this->app->make('translator');

        $parentTheme = $this->getParentTheme($theme);
        if ($parentTheme) {
            $parentLang = base_path("themes/{$parentTheme->folder_name}/lang");
            if (is_dir($parentLang)) {
                $translator->addPath($parentLang);
            }
        }

        $path = base_path("themes/{$theme->folder_name}/lang");
        if (is_dir($path)) {
            $translator->addPath($path);
        }
    }
}
