<?php

declare(strict_types=1);

namespace pluginmaker\design;

use pluginmaker\builder\base\DivTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Class Environment
 * @package pluginmaker\design
 */
class Environment extends DivTag {

    public function __construct() {
        parent::__construct(null);

        $this->addTagData(new SimpleTagData("style", "margin: 20px"));
    }
}