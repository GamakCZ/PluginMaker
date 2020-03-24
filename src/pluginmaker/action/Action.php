<?php

declare(strict_types=1);

namespace pluginmaker\action;

/**
 * Class Action
 * @package pluginmaker\action
 */
class Action {

    /** @var string $file */
    private $file;

    /** @var string $event */
    public $event;
    /** @var string $action */
    public $action;
    /** @var string $message */
    public $message;

    public function __construct(string $targetFile) {
        $this->file = $targetFile;
    }

    public function load() {
        $data = json_decode(file_get_contents($this->getFile()), true);

        $this->event = $data["event"];
        $this->action = $data["action"];
        $this->message = $data["message"];
    }


    /**
     * @return string
     */
    public function getFile(): string {
        return $this->file;
    }
}