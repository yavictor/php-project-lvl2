<?php

namespace Differ\Formatters\Json;

function render(array $data): string
{
    return json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
}
