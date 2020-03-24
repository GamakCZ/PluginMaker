<?php

declare(strict_types=1);

namespace pluginmaker\builder;

use pluginmaker\builder\base\Link;

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

        $this->getHead()->addTag(new Link("stylesheet", "assets/css/bootstrap.css"));
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
        $doc = new \DOMDocument();
        $doc->loadHTML($this->getHead()->toHTML() . $this->getBody()->toHTML());
        $doc->formatOutput = true;


        echo $doc->saveXML();
    }
}