<?php

/**
 * tkTask filter form base class.
 *
 * @package    tigerkanban
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetkTaskFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'            => new sfWidgetFormFilterInput(),
      'link'             => new sfWidgetFormFilterInput(),
      'area_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('area'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('user'), 'add_empty' => true)),
      'effort'           => new sfWidgetFormFilterInput(),
      'root_id'          => new sfWidgetFormFilterInput(),
      'lft'              => new sfWidgetFormFilterInput(),
      'rgt'              => new sfWidgetFormFilterInput(),
      'level'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorPass(array('required' => false)),
      'link'             => new sfValidatorPass(array('required' => false)),
      'area_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('area'), 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('user'), 'column' => 'id')),
      'effort'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'root_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('tk_task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tkTask';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'title'            => 'Text',
      'link'             => 'Text',
      'area_id'          => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
      'effort'           => 'Number',
      'root_id'          => 'Number',
      'lft'              => 'Number',
      'rgt'              => 'Number',
      'level'            => 'Number',
    );
  }
}
