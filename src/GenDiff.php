<?php

namespace Differ\Differ;

function generateConfigData($paths)
{
    $firstConfig = json_decode(file_get_contents($paths[0]), true);
    $secondConfig = json_decode(file_get_contents($paths[1]), true);
    $mergedKeys = array_keys(array_merge($firstConfig, $secondConfig));
    $mergedKeys = array_map(function ($key) use ($firstConfig, $secondConfig) {
        if (array_key_exists($key, $firstConfig) && !array_key_exists($key, $secondConfig)) {
            $value = $firstConfig[$key];
            $state = 'removed';
            return ['key' => $key, 'value' => $value, 'state' => $state];
        } if (!array_key_exists($key, $firstConfig) && array_key_exists($key, $secondConfig)) {
            $value = $secondConfig[$key];
            $state = 'added';
            return ['key' => $key, 'value' => $value, 'state' => $state];
        } if (array_key_exists($key, $firstConfig) && array_key_exists($key, $secondConfig)) {
            if ($firstConfig[$key] !== $secondConfig[$key]) {
                $value = [$firstConfig[$key], $secondConfig[$key]];
                $state = 'changed';
                return ['key' => $key, 'value' => $value, 'state' => $state];
            } else {
                $value = $secondConfig[$key];
                $state = 'unchanged';
                return ['key' => $key, 'value' => $value, 'state' => $state];
            }
        }
    }, $mergedKeys);
    return $mergedKeys;
}

function renderConfig($el)
{
  //print_r($el);
    if (is_bool($el['value'])) {
        $el['value'] = $el['value'] === true ? 'true' : 'false';
    }
    if ($el['state'] === 'removed') {
        return "  - {$el['key']}: {$el['value']}";
    } if ($el['state'] === 'added') {
        return "  + {$el['key']}: {$el['value']}";
    } if ($el['state'] === 'unchanged') {
        return "    {$el['key']}: {$el['value']}";
    } if ($el['state'] === 'changed') {
        return "  - {$el['key']}: {$el['value'][0]}\n  + {$el['key']}: {$el['value'][1]}";
    }
}

function genDiff($args)
{
    $data = generateConfigData($args);
    sort($data);
    $result = "{\n";
    foreach ($data as $el) {
        $result .= renderConfig($el) . "\n";
    };
    $result .= "}";

    return $result;
}
