<?php

/**
 * tkArea filter form base class.
 *
 * @package    tigerkanban
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetkAreaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'              => new sfWidgetFormFilterInput(),
      'pos'               => new sfWidgetFormFilterInput(),
      'sf_guard_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('team'), 'add_empty' => true)),
      'wip'               => new sfWidgetFormFilterInput(),
      'area_type'         => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'              => new sfValidatorPass(array('required' => false)),
      'pos'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sf_guard_group_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('team'), 'column' => 'id')),
      'wip'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'area_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tk_area_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tkArea';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'name'              => 'Text',
      'pos'               => 'Number',
      'sf_guard_group_id' => 'ForeignKey',
      'wip'               => 'Number',
      'area_type'         => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
