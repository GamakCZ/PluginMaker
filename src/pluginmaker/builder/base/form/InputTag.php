<?php

declare(strict_types=1);

namespace pluginmaker\builder\base\form;

use pluginmaker\builder\SimpleTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Class Input
 * @package pluginmaker\builder\base\form
 */
class InputTag extends SimpleTag {

    public const TYPE_TEXT = "text";
    public const TYPE_SUBMIT = "submit";
    public const TYPE_PASSWORD = "password";

    /** @var bool $closeTag */
    public $closeTag = false;

    /**
     * InputTag constructor.
     * @param string $name
     * @param string $type
     * @param string|null $placeHolder
     * @param string|null $defaultValue
     */
    public function __construct(string $name, string $type = self::TYPE_TEXT, string $placeHolder = null, ?string $defaultValue = null) {
        parent::__construct("input");

        $this->addTagData(new SimpleTagData("name", $name));
        $this->addTagData(new SimpleTagData("type", $type));

        if(!is_null($placeHolder)) {
            $this->addTagData(new SimpleTagData("placeholder", $placeHolder));
        }

        if(!is_null($defaultValue)) {
            $this->addTagData(new SimpleTagData("value", $defaultValue));
        }

        $this->addTagData(new SimpleTagData("autocomplete", "off"));
        $this->setCSSClassName("form-control");
    }
}