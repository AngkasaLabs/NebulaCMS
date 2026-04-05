<?php

namespace App\Services;

class HookService
{
    /**
     * Array to store all registered hooks
     */
    protected static $actions = [];
    protected static $filters = [];

    /**
     * Registering action hook
     *
     * @param string $hook Hook name
     * @param callable $callback Function to be executed
     * @param int $priority Execution priority (lower number means higher priority)
     * @return void
     */
    public static function addAction(string $hook, callable $callback, int $priority = 10): void
    {
        self::$actions[$hook][$priority][] = $callback;
        ksort(self::$actions[$hook]); // Sort by priority
    }

    /**
     * Registering filter hook
     *
     * @param string $hook Hook name
     * @param callable $callback Function to be executed
     * @param int $priority Execution priority (lower number means higher priority)
     * @return void
     */
    public static function addFilter(string $hook, callable $callback, int $priority = 10): void
    {
        self::$filters[$hook][$priority][] = $callback;
        ksort(self::$filters[$hook]); // Sort by priority
    }

    /**
     * Running action hook
     *
     * @param string $hook Hook name
     * @param mixed ...$args Arguments to be passed to callback
     * @return void
     */
    public static function doAction(string $hook, ...$args): void
    {
        if (!isset(self::$actions[$hook])) {
            return;
        }

        foreach (self::$actions[$hook] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                call_user_func_array($callback, $args);
            }
        }
    }

    /**
     * Running filter hook
     *
     * @param string $hook Hook name
     * @param mixed $value Value to be filtered
     * @param mixed ...$args Additional arguments to be passed to callback
     * @return mixed Filtered value
     */
    public static function applyFilter(string $hook, $value, ...$args): mixed
    {
        if (!isset(self::$filters[$hook])) {
            return $value;
        }

        $args = array_merge([$value], $args);

        foreach (self::$filters[$hook] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                $value = call_user_func_array($callback, $args);
                $args[0] = $value; // Update value for next callback
            }
        }

        return $value;
    }

    /**
     * Removing action hook
     *
     * @param string $hook Hook name
     * @param callable|null $callback Function to be removed, null to remove all
     * @param int|null $priority Priority to be removed, null to remove all priorities
     * @return void
     */
    public static function removeAction(string $hook, ?callable $callback = null, ?int $priority = null): void
    {
        self::removeHook('actions', $hook, $callback, $priority);
    }

    /**
     * Removing filter hook
     *
     * @param string $hook Hook name
     * @param callable|null $callback Function to be removed, null to remove all
     * @param int|null $priority Priority to be removed, null to remove all priorities
     * @return void
     */
    public static function removeFilter(string $hook, ?callable $callback = null, ?int $priority = null): void
    {
        self::removeHook('filters', $hook, $callback, $priority);
    }

    /**
     * Helper for removing hook (action or filter)
     *
     * @param string $type Hook type ('actions' or 'filters')
     * @param string $hook Hook name
     * @param callable|null $callback Function to be removed
     * @param int|null $priority Priority to be removed
     * @return void
     */
    protected static function removeHook(string $type, string $hook, ?callable $callback = null, ?int $priority = null): void
    {
        $storage = $type === 'actions' ? 'actions' : 'filters';

        // If hook is not set, do nothing
        if (!isset(self::${$storage}[$hook])) {
            return;
        }

        // If callback and priority is null, remove all hook
        if ($callback === null && $priority === null) {
            unset(self::${$storage}[$hook]);
            return;
        }

        // If only priority is given, remove all callback on that priority
        if ($callback === null && $priority !== null) {
            if (isset(self::${$storage}[$hook][$priority])) {
                unset(self::${$storage}[$hook][$priority]);
            }
            return;
        }

        // If only callback is given, search in all priority
        if ($callback !== null && $priority === null) {
            foreach (self::${$storage}[$hook] as $p => $callbacks) {
                foreach ($callbacks as $i => $cb) {
                    if ($cb === $callback) {
                        unset(self::${$storage}[$hook][$p][$i]);
                    }
                }
                // Remove priority if there is no callback left
                if (empty(self::${$storage}[$hook][$p])) {
                    unset(self::${$storage}[$hook][$p]);
                }
            }
            return;
        }

        // If callback and priority is given
        if (isset(self::${$storage}[$hook][$priority])) {
            foreach (self::${$storage}[$hook][$priority] as $i => $cb) {
                if ($cb === $callback) {
                    unset(self::${$storage}[$hook][$priority][$i]);
                }
            }
            // Remove priority if there is no callback left
            if (empty(self::${$storage}[$hook][$priority])) {
                unset(self::${$storage}[$hook][$priority]);
            }
        }

        // Remove hook if there is no priority left
        if (empty(self::${$storage}[$hook])) {
            unset(self::${$storage}[$hook]);
        }
    }

    /**
     * Checking if hook has registered callback
     *
     * @param string $hook Hook name
     * @param string $type Hook type ('action' or 'filter')
     * @return bool
     */
    public static function hasHook(string $hook, string $type = 'action'): bool
    {
        $storage = $type === 'action' ? 'actions' : 'filters';
        return isset(self::${$storage}[$hook]) && !empty(self::${$storage}[$hook]);
    }
}
