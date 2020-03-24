<?php

declare(strict_types=1);

namespace pluginmaker\action;

use pluginmaker\PluginMaker;
use pluginmaker\Project;

/**
 * Class ActionManager
 * @package pluginmaker\action
 */
class ActionManager {
    use ActionForms;

    public const PLAYER_JOIN = "playerjoinevent.skeleton";
    public const PLAYER_QUIT = "playerquitevent.skeleton";
    public const PLAYER_TELEPORT = "entitylevelchangeevent.skeleton";

    public const ACTION_BROADCAST_MESSAGE = "broadcastmessage.skeleton";
    public const ACTION_SEND_MESSAGE = "sendmessage.skeleton";

    /** @var Project $project */
    private $project;

    /** @var Action[] $actions */
    private $actions = [];

    /**
     * ActionManager constructor.
     * @param Project $project
     */
    public function __construct(Project $project) {
        $this->project = $project;

        $this->loadActions();
    }

    public function loadActions() {
        @mkdir($this->getActionPath());
        foreach (glob($this->getActionPath() . "*.action") as $action) {
            $this->registerAction($action);
        }
    }

    /**
     * @param string $file
     */
    private function registerAction(string $file) {
        $action = new Action($file);
        $action->load();

        $this->actions[] = $action;
    }

    /**
     * @return string
     */
    public function exportActions(): string {
        /** @var Action[][] $data */
        $data = [];

        foreach ($this->actions as $action) {
            $data[$action->event][] = $action;
        }

        $code = [];


        foreach ($data as $event => $actions) {
            $actionCode = [];

            foreach ($actions as $action) {
                $actionCode[] = str_replace("{%message}", str_replace("{%player}", '{$player->getName()}', $action->message), file_get_contents(PluginMaker::getInstance()->getResourcePath() . "action" . DIRECTORY_SEPARATOR . $action->action));
            }

            $code[] = str_replace("{%actionCode}", implode("\n", $actionCode), file_get_contents(PluginMaker::getInstance()->getResourcePath() . "event" . DIRECTORY_SEPARATOR . $event));
        }

        return implode("\n\n", $code);
    }

    public function handleActionForm() {
        $getEventFile = function (string $formName) {
            switch ($formName) {
                case "Player join":
                    return ActionManager::PLAYER_JOIN;
                case "Player quit":
                    return ActionManager::PLAYER_QUIT;
                default:
                    return ActionManager::PLAYER_TELEPORT;
            }
        };

        $data = [
            "event" => $getEventFile($_POST["event"]),
            "action" => $_POST["target-action"] === "Send message to player" ? self::ACTION_SEND_MESSAGE : self::ACTION_BROADCAST_MESSAGE,
            "message" => $_POST["message"]
        ];

        file_put_contents($file = $this->getActionPath() . (string)time() . "-" . (string)mt_rand(1000, 9999) . ".action", json_encode($data, JSON_PRETTY_PRINT));
        $this->registerAction($file);
    }

    /**
     * @return string
     */
    public function getActionPath(): string {
        return $this->getProject()->getDataPath() . "actions" . DIRECTORY_SEPARATOR;
    }

    /**
     * @return Project
     */
    public function getProject(): Project {
        return $this->project;
    }
}