<?php

/**
 * tkTask form base class.
 *
 * @method tkTask getObject() Returns the current form's model object
 *
 * @package    tigerkanban
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetkTaskForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInputText(),
      'link'             => new sfWidgetFormInputText(),
      'area_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('area'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('user'), 'add_empty' => true)),
      'effort'           => new sfWidgetFormInputText(),
      'progress'         => new sfWidgetFormInputText(),
      'archived'         => new sfWidgetFormInputCheckbox(),
      'root_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('root'), 'add_empty' => true)),
      'lft'              => new sfWidgetFormInputText(),
      'rgt'              => new sfWidgetFormInputText(),
      'level'            => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('area'), 'required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('user'), 'required' => false)),
      'effort'           => new sfValidatorNumber(array('required' => false)),
      'progress'         => new sfValidatorInteger(array('required' => false)),
      'archived'         => new sfValidatorBoolean(array('required' => false)),
      'root_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('root'), 'required' => false)),
      'lft'              => new sfValidatorInteger(array('required' => false)),
      'rgt'              => new sfValidatorInteger(array('required' => false)),
      'level'            => new sfValidatorInteger(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tk_task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tkTask';
  }

}
