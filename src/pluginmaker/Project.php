<?php

declare(strict_types=1);

namespace pluginmaker;

use pluginmaker\action\ActionManager;
use pluginmaker\builder\SimpleTag;

/**
 * Class Project
 * @package pluginmaker
 */
class Project {

    /** @var ActionManager $actionManager */
    private $actionManager;

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
            $this->namespace = (implode("\\", array_slice(explode("\\", $this->description["main"]), 0, 2))) ?? null;
        }

        $this->actionManager = new ActionManager($this);
    }

    /**
     * @param SimpleTag $tag
     */
    public function loadManagementForms(SimpleTag $tag) {
        $this->getActionManager()->addActionForm($tag);
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

        $description["main"] = strtolower($description["author"] . "\\" . $description["name"]) . "\\" . $description["name"];
        $this->namespace = implode("\\", array_slice(explode("\\", $description["main"]), 0, 2));

        yaml_emit_file($this->getDataPath() . "description.yml", $description);
    }

    public function export() {
        $resourcePath = PluginMaker::getInstance()->getResourcePath();

        $mainFile = file_get_contents($resourcePath . "skeleton.skeleton");

        $toReplace = [
            "namespace" => $this->namespace,
            "pluginName" => $this->description["name"],
            "customCode" => $this->getActionManager()->exportActions()
        ];

        foreach ($toReplace as $key => $value) {
            $mainFile = str_replace("{%$key}", $value, $mainFile);
        }

        @mkdir($targetDir = $this->getDataPath() . "export" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . strtolower($this->description["author"]) . DIRECTORY_SEPARATOR . strtolower($this->description["name"]),0777, true);
        @yaml_emit_file($this->getDataPath() . "export" . DIRECTORY_SEPARATOR . "plugin.yml", $this->description);
        @file_put_contents($targetDir . DIRECTORY_SEPARATOR . $this->description["name"] . ".php", $mainFile);

        $phar = new \Phar($pharPath = $this->getDataPath() . $this->description["name"] . ".phar.plugin");
        $phar->buildFromDirectory($this->getDataPath() . "export");

        // Header doesn't allow to download phar without broken signature ._.
        $script = new SimpleTag("script");
        $script->content = "const a = document.createElement('a');a.href = '/download.php';a.setAttribute('download', '" . $this->description["name"] . ".phar');a.click();";

        PluginMaker::getInstance()->getPageBuilder()->getHead()->addTag($script);
    }

    /**
     * @return string
     */
    public function getDataPath(): string {
        return $this->dataPath;
    }

    /**
     * @return ActionManager
     */
    public function getActionManager(): ActionManager {
        return $this->actionManager;
    }
}