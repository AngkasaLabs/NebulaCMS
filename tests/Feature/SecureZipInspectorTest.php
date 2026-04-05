<?php

use App\Services\SecureZipInspector;
use Tests\Support\ZipTestHelper;

it('menolak entri zip dengan path traversal', function () {
    $zipPath = ZipTestHelper::createZipFile([
        '../evil.txt' => 'x',
    ]);

    try {
        $inspector = new SecureZipInspector;
        expect(fn () => $inspector->assertSafeArchive($zipPath))
            ->toThrow(InvalidArgumentException::class);
    } finally {
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }
});
