<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registering HookService as a singleton
        $this->app->singleton('hook', function ($app) {
            return new \App\Services\HookService();
        });

        // Loading helper functions
        require_once app_path('Helpers/HookHelper.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registering theme hooks
        $this->registerThemeHooks();
    }

    /**
     * Registering theme hooks
     */
    protected function registerThemeHooks(): void
    {
        // Hook for modifying theme view path
        add_filter('theme.view_path', function ($viewPath, $theme, $view) {
            // Default implementation
            return "themes.{$theme->folder_name}.views.{$view}";
        }, 10);

        // Hook for modifying theme asset path
        add_filter('theme.asset_path', function ($assetPath, $theme, $path) {
            // Default implementation
            return url("themes/{$theme->folder_name}/assets/{$path}");
        }, 10);

        // Hook for modifying theme content before rendering
        add_filter('theme.content', function ($content) {
            // Default implementation: do nothing
            return $content;
        }, 10);

        // Hook for running before theme is activated
        add_action('theme.before_activate', function ($theme) {
            // Default implementation: do nothing
        }, 10);

        // Hook for running after theme is activated
        add_action('theme.after_activate', function ($theme) {
            // Default implementation: do nothing
        }, 10);

        // Hook for running before theme is deleted
        add_action('theme.before_delete', function ($theme) {
            // Default implementation: do nothing
        }, 10);

        // Hook for running after theme is deleted
        add_action('theme.after_delete', function ($theme) {
            // Default implementation: do nothing
        }, 10);
    }
}
