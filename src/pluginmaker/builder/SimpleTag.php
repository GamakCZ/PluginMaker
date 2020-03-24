<?php

declare(strict_types=1);

namespace pluginmaker\builder;

/**
 * Class SimpleTag
 * @package pluginmaker\builder
 */
class SimpleTag implements Tag {

    /** @var string $tagName */
    public $tagName = "";
    /** @var SimpleTagData[] $tagData */
    private $tagData = [];

    /** @var SimpleTag[] $tags */
    public $tags = []; // inside content
    /** @var string|null $content */
    public $content = null;

    /** @var bool $closeTag */
    public $closeTag = true;


    /**
     * SimpleTag constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        $this->tagName = $name;
    }

    /**
     * @param SimpleTagData $simpleTagData
     */
    public function addTagData(SimpleTagData $simpleTagData) {
        $this->tagData[$simpleTagData->key] = $simpleTagData;
    }

    /**
     * @param string $key
     * @return SimpleTagData
     */
    public function getTagData(string $key) {
        return $this->tagData[$key];
    }

    /**
     * @param SimpleTag $simpleTag
     */
    public function addTag(SimpleTag $simpleTag) {
        $this->tags[] = $simpleTag;
    }

    /**
     * @param string $name
     */
    public function setCSSClassName(string $name) {
        $this->addTagData(new SimpleTagData("class", $name));
    }

    /**
     * @param string $id
     */
    public function setCSSClassId(string $id) {
        $this->addTagData(new SimpleTagData("id", $id));
    }

    /**
     * @return string
     */
    public function toHTML(): string {
        $getTagData = function (SimpleTagData $tagData) : string  {
            return $tagData->__toString();
        };

        $html = "<" . $this->tagName . (empty($this->tagData) ? ">"  : (" " . implode(" ", array_map($getTagData, array_values( $this->tagData)))) . ">");

        if(empty($this->tags) && is_null($this->content)) {
            return $html . ($this->closeTag ? "</" . $this->tagName . ">"  : "");
        }

        if(!is_null($this->content)) {
            return $html . $this->content . "</" . $this->tagName . ">";
        }

        $getTagHTML = function (Tag $tag): string {
            return $tag->toHTML();
        };

        return $html . implode("", array_map($getTagHTML, array_values($this->tags))) . "</" . $this->tagName . ">";
    }
}