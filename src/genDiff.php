<?php

namespace Differ\genDiff;

use Symfony\Component\Yaml\Yaml;

use function Differ\parsers\parseFormatters;

function getData($path)
{
    if (!is_readable($path)) {
        throw new \Exception("'{$path}' is not readble");
    }

    $extension = pathinfo($path, PATHINFO_EXTENSION);

    if ($extension === 'json') {
        return json_decode(file_get_contents("$path"), true);
    } elseif ($extension === 'yaml') {
        return Yaml::parse(file_get_contents("$path"));
    } else {
        throw new \Exception("'{$extension}' - this extension is not supported");
    }
}

function genDiff($path1, $path2, $format)
{
    try {
        $before = getData($path1);
    } catch (\Exception $e) {
        echo $e;
    }
    try {
        $after = getData($path2);
    } catch (\Exception $e) {
        echo $e;
    }
    try {
        return parseFormatters($before, $after, $format);
    } catch (\Exception $e) {
        echo $e;
    }
}
