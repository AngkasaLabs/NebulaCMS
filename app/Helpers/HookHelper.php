<?php

use App\Services\HookService;

if (!function_exists('add_action')) {
    /**
     * Registering action hook
     *
     * @param string $hook Hook name
     * @param callable $callback Function to be executed
     * @param int $priority Execution priority (the smaller the number, the higher the priority)
     * @return void
     */
    function add_action(string $hook, callable $callback, int $priority = 10): void
    {
        HookService::addAction($hook, $callback, $priority);
    }
}

if (!function_exists('add_filter')) {
    /**
     * Registering filter hook
     *
     * @param string $hook Hook name
     * @param callable $callback Function to be executed
     * @param int $priority Execution priority (the smaller the number, the higher the priority)
     * @return void
     */
    function add_filter(string $hook, callable $callback, int $priority = 10): void
    {
        HookService::addFilter($hook, $callback, $priority);
    }
}

if (!function_exists('do_action')) {
    /**
     * Running action hook
     *
     * @param string $hook Hook name
     * @param mixed ...$args Arguments to be passed to callback
     * @return void
     */
    function do_action(string $hook, ...$args): void
    {
        HookService::doAction($hook, ...$args);
    }
}

if (!function_exists('apply_filters')) {
    /**
     * Running filter hook
     *
     * @param string $hook Hook name
     * @param mixed $value Value to be filtered
     * @param mixed ...$args Additional arguments to be passed to callback
     * @return mixed Filtered value
     */
    function apply_filters(string $hook, $value, ...$args): mixed
    {
        return HookService::applyFilter($hook, $value, ...$args);
    }
}

if (!function_exists('remove_action')) {
    /**
     * Removing action hook
     *
     * @param string $hook Hook name
     * @param callable|null $callback Function to be removed, null to remove all
     * @param int|null $priority Priority to be removed, null to remove all
     * @return void
     */
    function remove_action(string $hook, ?callable $callback = null, ?int $priority = null): void
    {
        HookService::removeAction($hook, $callback, $priority);
    }
}

if (!function_exists('remove_filter')) {
    /**
     * Removing filter hook
     *
     * @param string $hook Hook name
     * @param callable|null $callback Function to be removed, null to remove all
     * @param int|null $priority Priority to be removed, null to remove all
     * @return void
     */
    function remove_filter(string $hook, ?callable $callback = null, ?int $priority = null): void
    {
        HookService::removeFilter($hook, $callback, $priority);
    }
}

if (!function_exists('has_action')) {
    /**
     * Checking if action hook has registered callback
     *
     * @param string $hook Hook name
     * @return bool
     */
    function has_action(string $hook): bool
    {
        return HookService::hasHook($hook, 'action');
    }
}

if (!function_exists('has_filter')) {
    /**
     * Checking if filter hook has registered callback
     *
     * @param string $hook Hook name
     * @return bool
     */
    function has_filter(string $hook): bool
    {
        return HookService::hasHook($hook, 'filter');
    }
}
