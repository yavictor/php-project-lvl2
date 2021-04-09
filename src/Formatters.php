<?php

namespace Differ\Formatters;

use Exception;

use function Differ\Formatters\Json\render as renderJson;
use function Differ\Formatters\Stylish\render as renderStylish;
use function Differ\Formatters\Plain\render as renderPlain;

function format(array $data, string $format): string
{
    switch ($format) {
        case 'json':
            return renderJson($data);
        case 'stylish':
            return renderStylish($data);
        case 'plain':
            return renderPlain($data);
        default:
            throw new Exception("Unsupported format: $format");
    }
}
