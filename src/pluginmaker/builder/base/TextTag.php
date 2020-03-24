<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;

/**
 * Class TextTag
 * @package pluginmaker\builder\base
 */
class TextTag extends SimpleTag {

    /**
     * TextTag constructor.
     * @param string $text
     */
    public function __construct(string $text) {
        $this->content = $text;
        parent::__construct("a");
    }
}