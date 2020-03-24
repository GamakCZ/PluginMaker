<?php

declare(strict_types=1);

namespace pluginmaker\builder\base;

use pluginmaker\builder\base\form\InputTag;
use pluginmaker\builder\SimpleTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Class FormTag
 * @package pluginmaker\builder\base
 */
class FormTag extends SimpleTag {

    public const METHOD_GET = "get";
    public const METHOD_POST = "post";

    /**
     * FormTag constructor.
     */
    public function __construct(string $method = FormTag::METHOD_POST) {
        $this->addTagData(new SimpleTagData("method", $method));

        parent::__construct("form");
    }

    /**
     * @param string $text
     * @param int $size
     */
    public function addHeading(string $text, int $size = 3) {
        $this->addTag(new HeadingTag($text, $size));
    }

    /**
     * @param string $text
     */
    public function addText(string $text) {
        $this->addTag(new TextTag($text));
    }

    /**
     * @param int $multiplier
     */
    public function addBreak(int $multiplier = 1) {
        for($i = 0; $i < $multiplier; $i++) {
            $this->addTag(new BreakTag());
        }
    }

    /**
     * @param string $name
     * @param array $options
     */
    public function addDropdown(string $name, array $options) {
        $dropdown = new SimpleTag("select");
        $dropdown->addTagData(new SimpleTagData("name", $name));
        $dropdown->setCSSClassName("form-control");

        foreach ($options as $option) {
            $optionTag = new SimpleTag("option");
            $optionTag->closeTag = false;

            $optionTag->addTagData(new SimpleTagData("value", $option));


            $dropdown->addTag($optionTag);
            $dropdown->addTag(new TextTag($option));
            $dropdown->addTag(new BreakTag());
        }

        $this->addTag($dropdown);
    }

    /**
     * @param InputTag $input
     */
    public function addInput(InputTag $input) {
        $this->addTag($input);
    }

    /**
     * @param string $text
     */
    public function addSubmit(string $text = "Submit") {
        $this->addInput(new InputTag("submit", InputTag::TYPE_SUBMIT, null, $text));
    }
}