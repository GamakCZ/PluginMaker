<?php

declare(strict_types=1);

namespace pluginmaker\design;

use pluginmaker\builder\base\BreakTag;
use pluginmaker\builder\base\DivTag;
use pluginmaker\builder\base\HrTag;
use pluginmaker\builder\base\TextTag;
use pluginmaker\builder\SimpleTag;
use pluginmaker\PluginMaker;

/**
 * Class Footer
 * @package pluginmaker\design
 */
class Footer {

    /**
     * Footer constructor.
     * @param SimpleTag $tag
     */
    public function __construct(SimpleTag $tag) {
        $tag->addTag($this->getFooter());
    }

    /**
     * @return SimpleTag
     */
    private function getFooter(): SimpleTag {
        $divTag = new DivTag();
        $divTag->setCSSClassName("footer-basic");

        $footerTag = new SimpleTag("footer");
        $footerTag->addTag(new HrTag());
        $footerTag->addTag(new BreakTag());

        $paragraph = new SimpleTag("p");
        $paragraph->content = "VixikHD © 2019-2020";
        $paragraph->setCSSClassName("copyright");

        $footerTag->addTag($this->getStatisticsTag());
        $footerTag->addTag($paragraph);

        $divTag->addTag($footerTag);
        return $divTag;
    }

    /**
     * @return SimpleTag
     */
    private function getStatisticsTag(): SimpleTag {
        $listTag = new SimpleTag("ul");
        $listTag->setCSSClassName("list-inline");

        $itemTag = new SimpleTag("li");

        $itemTag->setCSSClassName("list-inline-item");
        $itemTag->addTag(new TextTag("Projects created: " . (string)count(glob(PluginMaker::getInstance()->getDataPath() . "*"))));
        $listTag->addTag(clone $itemTag);

        $itemTag->tags = [];
        $itemTag->addTag(new TextTag("Total space used: " . (string)$this->getDataSize()));
        $listTag->addTag($itemTag);

        return $listTag;
    }

    private function getDataSize(): string {
        $size = $this->getSize(PluginMaker::getInstance()->getDataPath());

        $kbSize = $size / 1000;
        $mbSize = $kbSize / 1000;
        $mBSize = $mbSize / 16;

        return (string) round($mBSize, 3) . " MB";
    }

    private function getSize($directory) {
        $size = 0;
        $files = glob($directory . '/*');
        foreach($files as $path){
            is_file($path) && $size += filesize($path);

            if (is_dir($path)) {
                $size += $this->getSize($path);
            }
        }
        return $size;
    }
}