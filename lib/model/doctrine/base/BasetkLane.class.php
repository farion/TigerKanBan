<?php

/**
 * BasetkLane
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $pos
 * @property integer $sf_guard_group_id
 * @property integer $wip
 * @property sfGuardGroup $team
 * @property Doctrine_Collection $tkTask
 * 
 * @method string              getName()              Returns the current record's "name" value
 * @method integer             getPos()               Returns the current record's "pos" value
 * @method integer             getSfGuardGroupId()    Returns the current record's "sf_guard_group_id" value
 * @method integer             getWip()               Returns the current record's "wip" value
 * @method sfGuardGroup        getTeam()              Returns the current record's "team" value
 * @method Doctrine_Collection getTkTask()            Returns the current record's "tkTask" collection
 * @method tkLane              setName()              Sets the current record's "name" value
 * @method tkLane              setPos()               Sets the current record's "pos" value
 * @method tkLane              setSfGuardGroupId()    Sets the current record's "sf_guard_group_id" value
 * @method tkLane              setWip()               Sets the current record's "wip" value
 * @method tkLane              setTeam()              Sets the current record's "team" value
 * @method tkLane              setTkTask()            Sets the current record's "tkTask" collection
 * 
 * @package    tigerkanban
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasetkLane extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tk_lane');
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardGroup as team', array(
             'local' => 'sf_guard_group_id',
             'foreign' => 'id'));

        $this->hasMany('tkTask', array(
             'local' => 'id',
             'foreign' => 'lane_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}