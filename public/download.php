<?php

declare(strict_types=1);

/**
 * @return string
 */
function getDataPath(): string {
    return substr(getcwd(), 0, -strlen("public")) . "data" . DIRECTORY_SEPARATOR;
}

$targetProject = $_COOKIE["pluginmaker_projectId"] ?? null;

if(is_null($targetProject)) {
    echo "Invalid project";
    return;
}

$targetPath = getDataPath() . $targetProject . DIRECTORY_SEPARATOR;
$description = yaml_parse_file($targetPath . "description.yml");
$pluginName = $description["name"];

$pharPath = $targetPath . $pluginName . ".phar.plugin";

echo file_get_contents($pharPath);