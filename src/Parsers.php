<?php

namespace Differ\Parsers;

use Exception;
use Symfony\Component\Yaml\Yaml;

function parseConfig(string $data, string $type): object
{
    switch ($type) {
        case 'json':
            return json_decode($data, false, 512, JSON_THROW_ON_ERROR);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("Unsupported parser type: $type");
    }
}
