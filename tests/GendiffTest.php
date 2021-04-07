<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
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
        $outputFilePath = $this->makeFilepaths($expectedFileName);
        $expectedOutput = file_get_contents($outputFilePath);

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
        $outputFilePath = $this->makeFilepaths($expectedFileName);
        $expectedOutput = trim(file_get_contents($outputFilePath));

        $inputFilePath1 = $this->makeFilepaths($fileName1);
        $inputFilePath2 = $this->makeFilepaths($fileName2);

        $diffResult = genDiff($inputFilePath1, $inputFilePath2, $format);

        $this->assertSame($expectedOutput, $diffResult);
    }

    public function defaultOutputProviders(): array
    {
        return [
          'default output for json files' => [
              'nested1.json',
              'nested2.json',
              'nestedResult.txt'
          ],
          'default output for yaml files' => [
              'nested1.yaml',
              'nested2.yaml',
              'nestedResult.txt'
          ]
        ];
    }

    public function differentFormatsProviders(): array
    {
        return [
            'output stylish' => ['nested1.yaml', 'nested2.yaml', 'stylish', 'nestedResult.txt'],
            'output plain' => ['nested1.json', 'nested2.json', 'plain', 'plainResult.txt'],
            'output json' => ['nested1.json', 'nested2.json', 'json', 'jsonResult.txt']
        ];
    }
}
