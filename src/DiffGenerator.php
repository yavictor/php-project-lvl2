<?php

namespace Differ\Differ;

use Exception;

use function Functional\sort;
use function Differ\Parsers\parseConfig;
use function Differ\Formatters\format;

function read(string $filePath): string|false
{
    if (!file_exists($filePath)) {
        throw new Exception("The file $filePath does not exists.");
    }

    return file_get_contents(realpath($filePath));
}

function genDiff(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string
{
    $firstData = read($firstFilePath);
    $secondData = read($secondFilePath);

    $parsedFirstData = parseConfig($firstData, pathinfo($firstFilePath, PATHINFO_EXTENSION));
    $parsedSecondData = parseConfig($secondData, pathinfo($secondFilePath, PATHINFO_EXTENSION));

    $tree = generateTree($parsedFirstData, $parsedSecondData);

    return format($tree, $format);
}

function generateTree(object $firstData, object $secondData): array
{
    $firstConfigKeys = array_keys(get_object_vars($firstData));
    $secondConfigKeys = array_keys(get_object_vars($secondData));
    $unionKeys = array_unique(array_merge($firstConfigKeys, $secondConfigKeys));
    $sortedKeys = sort($unionKeys, fn($left, $right): int => $left <=> $right);

    return array_map(function ($key) use ($firstData, $secondData): array {
        if (!property_exists($firstData, $key)) {
            return createNode($key, 'added', null, $secondData->$key);
        }
        if (!property_exists($secondData, $key)) {
            return createNode($key, 'removed', $firstData->$key, null);
        }
        if (is_object($firstData->$key) && is_object($secondData->$key)) {
            return createNode($key, 'complex', null, null, generateTree($firstData->$key, $secondData->$key));
        }
        if ($firstData->$key === $secondData->$key) {
            return createNode($key, 'unchanged', $firstData->$key, $secondData->$key);
        }
        return createNode($key, 'updated', $firstData->$key, $secondData->$key);
    }, $sortedKeys);
}

function createNode(string $key, string $type, $oldValue, $newValue, $children = null): array
{
    return [
        'key' => $key,
        'type' => $type,
        'oldValue' => $oldValue,
        'newValue' => $newValue,
        'children' => $children
    ];
}
