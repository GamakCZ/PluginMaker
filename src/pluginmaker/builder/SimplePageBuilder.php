<?php

declare(strict_types=1);

namespace pluginmaker\builder;

/**
 * Class SimplePageBuilder
 * @package pluginmaker
 */
class SimplePageBuilder {

    /** @var SimpleTag $headTag */
    public $headTag;
    /** @var SimpleTag $bodyTag */
    public $bodyTag;

    public function __construct() {
        $this->headTag = new SimpleTag("head");
        $this->bodyTag = new SimpleTag("body");
    }

    /**
     * @return SimpleTag
     */
    public function getBody(): SimpleTag {
        return $this->bodyTag;
    }

    /**
     * @return SimpleTag
     */
    public function getHead(): SimpleTag{
        return $this->headTag;
    }

    public function displayFinalHTML() {
        echo $this->getHead()->toHTML();
        echo $this->getBody()->toHTML();
    }
}