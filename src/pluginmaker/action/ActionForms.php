<?php

declare(strict_types=1);

namespace pluginmaker\action;

use pluginmaker\builder\base\DivTag;
use pluginmaker\builder\base\form\InputTag;
use pluginmaker\builder\base\FormTag;
use pluginmaker\builder\base\HrTag;
use pluginmaker\builder\SimpleTag;
use pluginmaker\builder\SimpleTagData;

/**
 * Trait ActionForms
 * @package pluginmaker\action
 */
trait ActionForms {

    public function addActionForm(SimpleTag $tag) {
        $form = new FormTag();

        $input = new InputTag("action", InputTag::TYPE_TEXT, "", "action");
        $input->addTagData(new SimpleTagData("hidden"));
        $form->addInput($input);

        $form->addHeading("Add action to your plugin:");
        $form->addTag(new HrTag());

        $form->addText("Target event:");
        $form->addBreak();
        $form->addDropdown("event", ["Player join", "Player quit", "Player teleport (between levels)"]);
        $form->addBreak(2);

        $form->addText("Target action:");
        $form->addBreak();
        $form->addDropdown("target-action", ["Send message to player", "Broadcast message"]);
        $form->addBreak(2);

        $form->addText("Your message:");
        $form->addBreak();
        $form->addInput(new InputTag("message", InputTag::TYPE_TEXT, "You can use {%player} to get player's name."));
        $form->addBreak(2);

        $form->addSubmit("Add the action");

        $tag->addTag(new DivTag($form));
    }
}