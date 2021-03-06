<?php

/**
 * BasetkArea
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $pos
 * @property integer $sf_guard_group_id
 * @property integer $wip
 * @property integer $area_type
 * @property sfGuardGroup $team
 * @property Doctrine_Collection $tkTask
 * 
 * @method string              getName()              Returns the current record's "name" value
 * @method integer             getPos()               Returns the current record's "pos" value
 * @method integer             getSfGuardGroupId()    Returns the current record's "sf_guard_group_id" value
 * @method integer             getWip()               Returns the current record's "wip" value
 * @method integer             getAreaType()          Returns the current record's "area_type" value
 * @method sfGuardGroup        getTeam()              Returns the current record's "team" value
 * @method Doctrine_Collection getTkTask()            Returns the current record's "tkTask" collection
 * @method tkArea              setName()              Sets the current record's "name" value
 * @method tkArea              setPos()               Sets the current record's "pos" value
 * @method tkArea              setSfGuardGroupId()    Sets the current record's "sf_guard_group_id" value
 * @method tkArea              setWip()               Sets the current record's "wip" value
 * @method tkArea              setAreaType()          Sets the current record's "area_type" value
 * @method tkArea              setTeam()              Sets the current record's "team" value
 * @method tkArea              setTkTask()            Sets the current record's "tkTask" collection
 * 
 * @package    tigerkanban
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasetkArea extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tk_area');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('pos', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('sf_guard_group_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('wip', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('area_type', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardGroup as team', array(
             'local' => 'sf_guard_group_id',
             'foreign' => 'id'));

        $this->hasMany('tkTask', array(
             'local' => 'id',
             'foreign' => 'area_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}