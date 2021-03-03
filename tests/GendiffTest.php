<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    public function testGenerateDifference(): void
    {
        $configFiles = [
          __DIR__ . '/fixtures/file1.json',
          __DIR__ . '/fixtures/file2.json'
        ];
        $result = genDiff($configFiles);
        $expected = file_get_contents(__DIR__ . '/fixtures/plainResult.txt');
        $this->assertEquals($result, $expected);
    }
}
