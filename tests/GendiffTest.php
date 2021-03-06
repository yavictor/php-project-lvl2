<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    public function testGenerateDifference(): void
    {
        $jsonFiles = [
          __DIR__ . '/fixtures/file1.json',
          __DIR__ . '/fixtures/file2.json'
        ];
        $ymlFiles = [
          __DIR__ . '/fixtures/filepath1.yml',
          __DIR__ . '/fixtures/filepath2.yml'
        ];
        $resultJson = genDiff($jsonFiles);
        $resultYml = genDiff($ymlFiles);
        $expected = file_get_contents(__DIR__ . '/fixtures/plainResult.txt');
        $this->assertEquals($resultJson, $expected);
        $this->assertEquals($resultYml, $expected);
    }
}
