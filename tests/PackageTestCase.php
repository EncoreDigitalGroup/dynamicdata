<?php

namespace Tests;

use EncoreDigitalGroup\DynamicData\ServiceProvider;
use Orchestra\Testbench\TestCase;

class PackageTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
