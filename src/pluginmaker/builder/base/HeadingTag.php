<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;

/**
 * Class HeadingTag
 * @package pluginmaker\builder\base
 */
class HeadingTag extends SimpleTag {

    /**
     * HeadingTag constructor.
     * @param string $text
     * @param int $size
     */
    public function __construct(string $text, int $size) {
        parent::__construct("h$size");

        $this->content = $text;
    }
}