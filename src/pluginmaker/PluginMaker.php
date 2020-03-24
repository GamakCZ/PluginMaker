<?php

declare(strict_types=1);

namespace pluginmaker;

use pluginmaker\builder\SimplePageBuilder;
use pluginmaker\design\NavBar;
use pluginmaker\forms\FormData;

/**
 * Class PluginMaker
 * @package pluginmaker
 */
class PluginMaker {
    use FormData;

    /** @var PluginMaker $instance */
    private static $instance;

    /** @var SimplePageBuilder $pageBuilder */
    private $pageBuilder;
    /** @var ProjectManager $projectManager */
    private $projectManager;

    public function __construct() {
        self::$instance = $this;
        $this->pageBuilder = new SimplePageBuilder();
        $this->initBase();
        $this->run();
        $this->displayGenerated();
    }

    private function initBase() {
        new NavBar($this);
        $this->projectManager = new ProjectManager($this);
    }

    private function run() {
        $this->getProjectManager()->loadProject();

        $project = $this->getProjectManager()->getProject();
        if(!$project->hasValidDescription()) {
            if(empty($_POST)) {
                $this->addDescriptionForm($this->getPageBuilder()->getBody());
                return;
            }

            $project->saveDescription($_POST);
        }

        if(isset($_POST["action"])) {
            switch ($_POST["action"]) {
                case "export":
                    $project->export();
                    break;
                case "new":
                    $this->getProjectManager()->disableActiveProject();
            }
        }

        $this->addExportButton($this->getPageBuilder()->getBody());
        $this->addNewButton($this->getPageBuilder()->getBody());
    }

    public function displayGenerated() {
        $this->getPageBuilder()->displayFinalHTML();
    }

    /**
     * @return string
     */
    public function getResourcePath(): string {
        return substr(getcwd(), 0, -strlen("public")) . "resources" . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getDataPath(): string {
        return substr(getcwd(), 0, -strlen("public")) . "data" . DIRECTORY_SEPARATOR;
    }

    /**
     * @return SimplePageBuilder
     */
    public function getPageBuilder(): SimplePageBuilder {
        return $this->pageBuilder;
    }

    /**
     * @return ProjectManager
     */
    public function getProjectManager(): ProjectManager {
        return $this->projectManager;
    }

    /**
     * @return PluginMaker
     */
    public static function getInstance(): PluginMaker {
        return self::$instance;
    }
}