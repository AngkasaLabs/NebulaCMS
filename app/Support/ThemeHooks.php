<?php

namespace App\Support;

/**
 * Hook constants for Theme lifecycle.
 */
final class ThemeHooks
{
    public const THEME_BEFORE_ACTIVATE = 'theme.before_activate';

    public const THEME_AFTER_ACTIVATE = 'theme.after_activate';

    public const THEME_BEFORE_DEACTIVATE = 'theme.before_deactivate';

    public const THEME_AFTER_DEACTIVATE = 'theme.after_deactivate';

    public const THEME_BEFORE_DELETE = 'theme.before_delete';

    public const THEME_AFTER_DELETE = 'theme.after_delete';
}
