<?php

use App\Models\Theme;

it('memuat PluginServiceProvider sebelum ThemeServiceProvider', function () {
    $providers = require base_path('bootstrap/providers.php');

    $pluginIdx = array_search(\App\Providers\PluginServiceProvider::class, $providers, true);
    $themeIdx = array_search(\App\Providers\ThemeServiceProvider::class, $providers, true);

    expect($pluginIdx)->not->toBeFalse();
    expect($themeIdx)->not->toBeFalse();
    expect($pluginIdx)->toBeLessThan($themeIdx);
});

it('mendefinisikan urutan dispatch: plugins.loaded lalu theme.loaded (kontrak hook)', function () {
    $order = [];
    $theme = new Theme([
        'folder_name' => 'default',
        'name' => 'Kontrak',
    ]);

    add_action('plugins.loaded', function () use (&$order) {
        $order[] = 'plugins.loaded';
    });
    add_action('theme.loaded', function () use (&$order) {
        $order[] = 'theme.loaded';
    });

    do_action('plugins.loaded', collect());
    do_action('theme.loaded', $theme);

    expect($order)->toBe(['plugins.loaded', 'theme.loaded']);
});
