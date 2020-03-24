<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Class Link
 * @package pluginmaker\builder\base
 */
class Link extends SimpleTag {

    /** @var bool $closeTag */
    public $closeTag = false;

    /**
     * Link constructor.
     *
     * @param string $rel
     * @param string $type
     * @param string $target
     */
    public function __construct(string $rel, string $target) {
        parent::__construct("link");

        $this->addTagData(new SimpleTagData("rel", $rel));
        $this->addTagData(new SimpleTagData("href", $target));
    }
}