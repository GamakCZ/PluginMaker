<?php

declare(strict_types=1);

namespace pluginmaker;

/**
 * Class Project
 * @package pluginmaker
 */
class Project {

    /** @var string $dataPath */
    private $dataPath;
    /** @var string $namespace */
    private $namespace;
    /** @var array $description */
    private $description;

    /**
     * Project constructor.
     * @param string $dataPath
     */
    public function __construct(string $dataPath) {
        $this->dataPath = $dataPath;
        if(is_file($dataPath . "description.yml")) {
            $this->description = yaml_parse_file($dataPath . "description.yml");
            $this->namespace = $this->description["main"] ?? null;
        }
    }

    /**
     * @return bool
     */
    public function hasValidDescription(): bool {
        return file_exists($this->getDataPath() . "description.yml") && !empty(yaml_parse_file($this->getDataPath() . "description.yml"));
    }

    /**
     * @param array $description
     */
    public function saveDescription(array $description) {
        if(isset($description["submit"])) {
            unset($description["submit"]);
        }

        $description["main"] = $this->namespace = strtolower($description["author"] . "\\" . $description["name"]);

        yaml_emit_file($this->getDataPath() . "description.yml", $description);
    }

    public function export() {
        $resourcePath = PluginMaker::getInstance()->getResourcePath();

        $mainFile = file_get_contents($resourcePath . "skeleton.skeleton");

        $toReplace = [
            "namespace" => $this->namespace,
            "pluginName" => $this->description["name"]
        ];

        foreach ($toReplace as $key => $value) {
            $mainFile = str_replace("{%$key}", $value, $mainFile);
        }

        @mkdir($exportDir = $this->getDataPath() . "export");
        @mkdir($authorDir = $exportDir . DIRECTORY_SEPARATOR . strtolower($this->description["author"]));
        @mkdir($nameDir = $authorDir . DIRECTORY_SEPARATOR . strtolower($this->description["name"]));
        @yaml_emit_file($this->getDataPath() . "export" . DIRECTORY_SEPARATOR . "plugin.yml", $this->description);
        @file_put_contents($nameDir . DIRECTORY_SEPARATOR . $this->description["name"] . ".php", $mainFile);

        $phar = new \Phar($pharPath = $this->getDataPath() . $this->description["name"] . ".phar");
        $phar->buildFromDirectory($this->getDataPath() . "export");

        header("Content-disposition: attachment;filename=SimpleSpawn.phar");
        readfile($pharPath);
    }

    /**
     * @return string
     */
    public function getDataPath(): string {
        return $this->dataPath;
    }
}