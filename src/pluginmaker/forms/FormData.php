<?php

declare(strict_types=1);

namespace pluginmaker\forms;

use pluginmaker\builder\base\BreakTag;
use pluginmaker\builder\base\DivTag;
use pluginmaker\builder\base\form\InputTag;
use pluginmaker\builder\base\FormTag;
use pluginmaker\builder\base\HrTag;
use pluginmaker\builder\SimpleTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Trait FormData
 * @package pluginmaker\forms
 */
trait FormData  {

    /**
     * @param SimpleTag $tag
     */
    public function addExportButton(SimpleTag $tag) {
        $input = new InputTag("action", InputTag::TYPE_TEXT, null, "export");
        $input->addTagData(new SimpleTagData("hidden"));

        $form = new FormTag();
        $form->addInput($input);
        $form->addSubmit("Export plugin");

        $div = new DivTag();
        $div->addTag(new BreakTag());
        $div->addTag(new HrTag());
        $div->addTag($form);

        $tag->addTag($div);
    }

    /**
     * @param SimpleTag $tag
     */
    public function addNewButton(SimpleTag $tag) {
        $input = new InputTag("action", InputTag::TYPE_TEXT, null, "new");
        $input->addTagData(new SimpleTagData("hidden"));

        $form = new FormTag();
        $form->addInput($input);
        $form->addSubmit("Create new plugin");

        $tag->addTag(new DivTag($form));
    }

    /**
     * @param SimpleTag $tag
     */
    public function addDescriptionForm(SimpleTag $tag) {
        $pluginDescriptionForm = new FormTag();
        $pluginDescriptionForm->addText("Plugin name:");
        $pluginDescriptionForm->addBreak();
        $pluginDescriptionForm->addInput(new InputTag("name"));
        $pluginDescriptionForm->addBreak(2);

        $pluginDescriptionForm->addText("Plugin description:");
        $pluginDescriptionForm->addBreak();
        $pluginDescriptionForm->addInput(new InputTag("description"));
        $pluginDescriptionForm->addBreak(2);

        $pluginDescriptionForm->addText("Plugin api:");
        $pluginDescriptionForm->addBreak();
        $apiInput = new InputTag("api", InputTag::TYPE_TEXT, "3.0.0", "3.0.0");
        //$apiInput->addTagData(new SimpleTagData("disabled"));
        $pluginDescriptionForm->addInput($apiInput);
        $pluginDescriptionForm->addBreak(2);

        $pluginDescriptionForm->addText("Plugin author:");
        $pluginDescriptionForm->addBreak();
        $pluginDescriptionForm->addInput(new InputTag("author"));
        $pluginDescriptionForm->addBreak(2);

        $pluginDescriptionForm->addText("Plugin version:");
        $pluginDescriptionForm->addBreak();
        $pluginDescriptionForm->addInput(new InputTag("version"));
        $pluginDescriptionForm->addBreak(2);

        $pluginDescriptionForm->addSubmit();

        $tag->addTag(new DivTag($pluginDescriptionForm));
    }
}