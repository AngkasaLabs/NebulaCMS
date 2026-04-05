<?php

return [
    App\Providers\AppServiceProvider::class,
    // Plugin harus sebelum Theme agar add_action('theme.loaded') di plugins/*/index.php
    // terdaftar sebelum do_action('theme.loaded') di ThemeServiceProvider::boot().
    App\Providers\PluginServiceProvider::class,
    App\Providers\ThemeServiceProvider::class,
    App\Providers\ViewServiceProvider::class,
    App\Providers\HookServiceProvider::class,
];
