<?php

declare(strict_types=1);

namespace pluginmaker;

use pluginmaker\builder\SimplePageBuilder;
use pluginmaker\design\Environment;
use pluginmaker\design\Footer;
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
    /** @var Environment $environment */
    private $environment;

    public function __construct() {
        self::$instance = $this;
        $this->pageBuilder = new SimplePageBuilder();

        $this->initBase();
        $this->run();

        new Footer($this->getEnvironment());

        $this->displayGenerated();
    }

    private function initBase() {
        new NavBar($this);
        $this->environment = new Environment();
        $this->projectManager = new ProjectManager($this);
    }

    private function run() {
        $this->getProjectManager()->loadProject();
        $this->getPageBuilder()->getBody()->addTag($this->getEnvironment());

        $project = $this->getProjectManager()->getProject();
        if(!$project->hasValidDescription()) {
            if(empty($_POST)) {
                $this->addDescriptionForm($this->getEnvironment());
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
                    break;
                case "action":
                    $this->getProjectManager()->getProject()->getActionManager()->handleActionForm();
                    break;
            }
        }

        $this->getProjectManager()->getProject()->loadManagementForms($this->getEnvironment());

        $this->addExportButton($this->getEnvironment());
        $this->addNewButton($this->getEnvironment());
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
     * @return Environment
     */
    public function getEnvironment(): Environment {
        return $this->environment;
    }

    /**
     * @return PluginMaker
     */
    public static function getInstance(): PluginMaker {
        return self::$instance;
    }
}