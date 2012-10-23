<?php

class tkTeamForm extends sfForm {

    public function configure(){

        $q = Doctrine_Query::create()
                ->from('sfGuardGroup g')
                ->leftJoin("g.users u")
                ->where("u.id = ?",sfContext::getInstance()->getUser()->getGuardUser()->getId());


        $this->setWidgets(array(
           'team_id' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardGroup','query' =>  $q))
        ));

        $this->setValidators(array(
           'team_id' => new sfValidatorDoctrineChoice(array('model' => 'sfGuardGroup','query' =>  $q))
        ));
    }

}