<?php

declare(strict_types=1);

namespace pluginmaker\design;

use pluginmaker\builder\base\DivTag;
use pluginmaker\builder\base\TextTag;
use pluginmaker\builder\SimpleTag;
use pluginmaker\PluginMaker;
use pluginmaker\VersionConstants;

/**
 * Class NavBar
 * @package pluginmaker\navbar
 */
class NavBar {

    /**
     * NavBar constructor.
     * @param PluginMaker $page
     */
    public function __construct(PluginMaker $page) {
        $divTag = new DivTag();
        $divTag->addTag(new TextTag("Running PocketMine PluginMaker v" . VersionConstants::PLUGINMAKER_VERSION ));
        $divTag->addTag(new SimpleTag("hr"));
        $page->getPageBuilder()->getBody()->addTag(clone $divTag);
    }

}