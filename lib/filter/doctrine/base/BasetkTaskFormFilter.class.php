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
      'lane_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('lane'), 'add_empty' => true)),
      'creator_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('creator'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('user'), 'add_empty' => true)),
      'effort'           => new sfWidgetFormFilterInput(),
      'finished'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'readyDate'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'archived'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'blocked'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'comment'          => new sfWidgetFormFilterInput(),
      'root_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('root'), 'add_empty' => true)),
      'lft'              => new sfWidgetFormFilterInput(),
      'rgt'              => new sfWidgetFormFilterInput(),
      'level'            => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorPass(array('required' => false)),
      'link'             => new sfValidatorPass(array('required' => false)),
      'area_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('area'), 'column' => 'id')),
      'lane_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('lane'), 'column' => 'id')),
      'creator_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('creator'), 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('user'), 'column' => 'id')),
      'effort'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'finished'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'readyDate'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'archived'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'blocked'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'comment'          => new sfValidatorPass(array('required' => false)),
      'root_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('root'), 'column' => 'id')),
      'lft'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'lane_id'          => 'ForeignKey',
      'creator_id'       => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
      'effort'           => 'Number',
      'finished'         => 'Boolean',
      'readyDate'        => 'Date',
      'archived'         => 'Boolean',
      'blocked'          => 'Boolean',
      'comment'          => 'Text',
      'root_id'          => 'ForeignKey',
      'lft'              => 'Number',
      'rgt'              => 'Number',
      'level'            => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
