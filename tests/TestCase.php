<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CheckInstallation middleware redirects all traffic to /install when this file is missing.
        // It is gitignored (fresh clones / CI), so tests must mark the app as installed.
        touch(storage_path('installed.lock'));
    }
}
