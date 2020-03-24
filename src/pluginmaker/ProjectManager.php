<?php

declare(strict_types=1);

namespace pluginmaker;

/**
 * Class ProjectManager
 * @package pluginmaker
 */
class ProjectManager {

    protected const COOKIE_PREFIX = "pluginmaker_";

    /** @var PluginMaker $page */
    private $page;
    /** @var Project $project */
    private $project;

    /**
     * ProjectManager constructor.
     * @param PluginMaker $page
     */
    public function __construct(PluginMaker $page) {
        $this->page = $page;
    }

    /**
     * @return string|null
     */
    public function getCurrentProjectId(): ?string {
        return $_COOKIE[self::COOKIE_PREFIX . "projectId"] ?? null;
    }

    /**
     * @return bool
     */
    public function projectExists(): bool {
        return !is_null($this->getCurrentProjectId());
    }

    public function loadProject() {
        if($this->projectExists()) {
            $dirPath = $this->getPage()->getDataPath() . $this->getCurrentProjectId() . DIRECTORY_SEPARATOR;
            if(!is_dir($dirPath)) {
                $this->createProject();
                return;
            }

            $this->project = new Project($dirPath);
            return;
        }

        $this->createProject();
    }

    /**
     * @return string $id
     */
    public function createProject() {
        $id = $this->generateRandomId();
        $dirPath = $this->getPage()->getDataPath() . $id . DIRECTORY_SEPARATOR;

        setcookie(self::COOKIE_PREFIX . "projectId", $id, time() + (60 * 60 * 24 * 365));

        @mkdir($dirPath);
        $this->project = new Project($dirPath);

        return $id;
    }


    /**
     * @return string
     */
    private function generateRandomId() {
        return (string)time() . "-" . mt_rand(10000, 99999); // TODO - make better uuid
    }

    public function disableActiveProject() {
        $this->project = null;
        unset($_COOKIE[self::COOKIE_PREFIX . "projectId"]);
        setcookie(self::COOKIE_PREFIX . "projectId", "", -1);

        header("Refresh:0");
        exit();
    }


    /**
     * @return PluginMaker
     */
    public function getPage(): PluginMaker {
        return $this->page;
    }

    /**
     * @return Project|null
     */
    public function getProject(): ?Project {
        return $this->project;
    }
}