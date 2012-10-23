<?php

class indexComponents extends sfComponents {

    public function executeHeader(){
        if($this->getUser()->isAuthenticated()){
            $this->teamform = new tkTeamForm();
            $team = $this->getUser()->getFirstTeam();
            if($team){
              $this->teamform->setDefault("team_id",$team->getId());
            }

        }
    }

}