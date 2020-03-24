<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\SimpleTag;

/**
 * Class BreakTag
 * @package pluginmaker\builder\base
 */
class BreakTag extends SimpleTag {

    /** @var bool $closeTag */
    public $closeTag = false;

    /**
     * BreakTag constructor.
     */
    public function __construct() {
        parent::__construct("br");
    }
}