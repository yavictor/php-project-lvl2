<?php

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($config)
{
  $parseMethods = [
    'json' => fn($config) => json_decode($config, $associative = true),
    'yml' => fn($config) => Yaml::parse($config)
  ];
  $configInfo = [pathinfo($config[0]), pathinfo($config[1])];
  $extensions = [$configInfo[0]['extension'], $configInfo[1]['extension']];
  $firstConfig = $parseMethods[$extensions[0]](file_get_contents($config[0], true));
  $secondConfig = $parseMethods[$extensions[1]](file_get_contents($config[1], true));
  return [$firstConfig, $secondConfig];
}
