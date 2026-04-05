<?php

namespace Tests\Support;

use ZipArchive;

class ZipTestHelper
{
    /**
     * @param  array<string, string>  $pathToContents  path dalam ZIP => isi file
     */
    public static function createZipFile(array $pathToContents): string
    {
        $path = storage_path('app/zip-test-'.uniqid('', true).'.zip');
        $zip = new ZipArchive;
        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Cannot create zip: '.$path);
        }
        foreach ($pathToContents as $name => $content) {
            $zip->addFromString($name, $content);
        }
        $zip->close();

        return $path;
    }
}
