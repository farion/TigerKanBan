<?php

class myUser extends sfGuardSecurityUser
{
    public function getFirstTeam(){
        return Doctrine_Query::create()
            ->from('sfGuardGroup g')
            ->leftJoin("g.users u")
            ->where("u.id = ?",$this->getGuardUser()->getId())
            ->fetchOne();
    }
}
