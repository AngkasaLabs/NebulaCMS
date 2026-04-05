<?php

use App\Services\HookService;

describe('HookService', function () {
    it('menjalankan action callback sesuai prioritas (angka lebih kecil dulu)', function () {
        $hook = 'unit_hook_priority_'.uniqid();
        $order = [];

        HookService::addAction($hook, function () use (&$order) {
            $order[] = 'b';
        }, 20);
        HookService::addAction($hook, function () use (&$order) {
            $order[] = 'a';
        }, 5);

        HookService::doAction($hook);

        expect($order)->toBe(['a', 'b']);
    });

    it('menerapkan filter secara berurutan dan meneruskan nilai', function () {
        $hook = 'unit_filter_chain_'.uniqid();

        HookService::addFilter($hook, fn ($v) => $v.'1', 10);
        HookService::addFilter($hook, fn ($v) => $v.'2', 10);

        expect(HookService::applyFilter($hook, 'x'))->toBe('x12');
    });

    it('mengembalikan nilai awal jika tidak ada filter', function () {
        $hook = 'unit_filter_missing_'.uniqid();
        expect(HookService::applyFilter($hook, 'original'))->toBe('original');
    });

    it('hasHook mengembalikan true setelah addAction', function () {
        $hook = 'unit_has_action_'.uniqid();
        expect(HookService::hasHook($hook, 'action'))->toBeFalse();

        HookService::addAction($hook, fn () => null);

        expect(HookService::hasHook($hook, 'action'))->toBeTrue();
    });

    it('removeAction menghapus callback', function () {
        $hook = 'unit_remove_action_'.uniqid();
        $called = false;
        $cb = function () use (&$called) {
            $called = true;
        };

        HookService::addAction($hook, $cb, 10);
        HookService::removeAction($hook, $cb, 10);
        HookService::doAction($hook);

        expect($called)->toBeFalse();
    });
});
