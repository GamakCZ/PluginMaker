<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;

/**
 * Class DivTag
 * @package pluginmaker\builder\base
 */
class DivTag extends SimpleTag {

    public function __construct(SimpleTag $children = null) {
        parent::__construct("div");

        if(!is_null($children)) {
            $this->addTag($children);
        }
    }
}