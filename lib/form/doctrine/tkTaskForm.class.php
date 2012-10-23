<?php

class tkTaskForm extends BasetkTaskForm
{
    public function configure()
    {
        $this->widgetSchema->setLabels(array(
            "title" => "Title",
            "link" => "Link",
            "effort" => "Effort in hours",
            "sf_guard_user_id" => "Assigned to"
        ));

        $this->disableCSRFProtection();

        $this->useFields(array("title", "link", "effort", "sf_guard_user_id"));
    }
}
