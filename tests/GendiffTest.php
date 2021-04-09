<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    private function makeFilepaths(string $fileName): string
    {
        $parts = [__DIR__, 'fixtures', $fileName];
        return implode(DIRECTORY_SEPARATOR, $parts);
    }

     /**
     * @dataProvider defaultOutputProviders
     */
    public function testDefaultFormatOutput(string $fileName1, string $fileName2, string $expectedFileName): void
    {
        //$outputFilePath = $this->makeFilepaths($expectedFileName);
        $expectedOutput = file_get_contents($this->makeFilepaths($expectedFileName));
        $inputFilePath1 = $this->makeFilepaths($fileName1);
        $inputFilePath2 = $this->makeFilepaths($fileName2);
        $diffResult = genDiff($inputFilePath1, $inputFilePath2);
        $this->assertSame($expectedOutput, $diffResult);
    }

    /**
     * @dataProvider differentFormatsProviders
     */
    public function testDifferentFormatOutputs(
        string $fileName1,
        string $fileName2,
        string $format,
        string $expectedFileName
    ): void {
        //$outputFilePath = $this->makeFilepaths($expectedFileName);
        $expectedOutput = file_get_contents($this->makeFilepaths($expectedFileName));
        $inputFilePath1 = $this->makeFilepaths($fileName1);
        $inputFilePath2 = $this->makeFilepaths($fileName2);
        $diffResult = genDiff($inputFilePath1, $inputFilePath2, $format);
        $this->assertSame($expectedOutput, $diffResult);
    }

    public function defaultOutputProviders(): array
    {
        return [
          'default output for yaml files' => [
              'file1.yaml',
              'file2.yaml',
              'diff.stylish'
          ]
        ];
    }

    public function differentFormatsProviders(): array
    {
        return [
            'output for stylish' => [
              'file1.yaml',
              'file2.yaml',
              'stylish',
              'diff.stylish'
            ],
            'output for plain' => [
              'file1.json',
              'file2.json',
              'plain',
              'diff.plain'
            ],
            'output for json' => [
              'file1.json',
              'file2.json',
              'json',
              'jsonResult.txt'
            ]
        ];
    }
}
