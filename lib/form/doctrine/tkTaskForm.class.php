<?php

class tkTaskForm extends BasetkTaskForm
{
    public function configure()
    {
        $this->setWidget("comment",new sfWidgetFormTextarea());

        $this->setWidget("blocked", new sfWidgetFormChoice(array('choices' => array(0 => 'No, task is actionable', 1 => 'Yes, task is currently blocked'))));

        $this->disableCSRFProtection();

        $this->widgetSchema->setLabels(array(
            "title" => "Title",
            "link" => "Link",
            "effort" => "Effort in hours",
            "sf_guard_user_id" => "Assigned to",
            "comment" => "Note",
            "blocked" => "Is blocked?"
        ));

        $this->useFields(array("title", "comment", "link", "effort", "sf_guard_user_id","blocked"));
    }
}
