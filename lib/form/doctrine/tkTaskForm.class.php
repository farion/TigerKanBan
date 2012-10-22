<?php

/**
 * tkTask form.
 *
 * @package    tigerkanban
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
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

      $this->useFields(array("title","link","effort","sf_guard_user_id"));
  }
}
