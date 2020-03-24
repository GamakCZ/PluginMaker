<?php

declare(strict_types=1);

namespace pluginmaker\builder;

/**
 * Class SimpleTagData
 * @package pluginmaker\builder
 */
class SimpleTagData {

    /** @var string $key */
    public $key;
    /** @var string|null $value */
    public $value;

    /**
     * SimpleTagData constructor.
     * @param string $key
     * @param string|null $value
     */
    public function __construct(string $key, ?string $value = null) {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString() {
        if(is_null($this->value)) {
            return $this->key;
        }

        return $this->key . '="' . $this->value . '"';
    }
}