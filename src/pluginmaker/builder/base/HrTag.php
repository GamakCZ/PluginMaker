<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;

/**
 * Class HrTag
 * @package pluginmaker\builder\base
 */
class HrTag extends SimpleTag {

    public $closeTag = false;

    public function __construct() {
        parent::__construct("hr");
    }
}