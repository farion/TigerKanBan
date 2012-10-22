<?php

class tmGuardShowGroupsForUserTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('user', sfCommandArgument::REQUIRED, 'The user name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'show-groups-for-user';
    $this->briefDescription = 'Shows the groups of an user';

    $this->detailedDescription = <<<EOF
The [guard:show-groups-for-user|INFO] task to show the groups of an user:

  [./symfony guard:show-groups-for-user blog|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($arguments['user']);


    if(!$user)
    {
      $this->logSection('guard',sprintf('User "%s" does not exist.',$arguments['user']),null,'ERROR');
      exit();
    }      

    $groups = array();
    
    foreach($user->groups AS $group)
    {
	    $groups[] = $group->name; 
    }    
    
    $this->logSection('guard-groups', implode($groups,','));

  }
}
