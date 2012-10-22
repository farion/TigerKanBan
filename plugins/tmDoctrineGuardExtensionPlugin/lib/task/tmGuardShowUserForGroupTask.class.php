<?php

class tmGuardShowUserForGroupTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('group', sfCommandArgument::REQUIRED, 'The group name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'show-user-for-group';
    $this->briefDescription = 'Shows the users of a group';

    $this->detailedDescription = <<<EOF
The [guard:show-user-for-group|INFO] task to shows the user of a group:

  [./symfony guard:show-user-for-group blog|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $group = Doctrine::getTable('sfGuardGroup')->findOneByName($arguments['group']);


    if(!$group)
    {
      $this->logSection('guard',sprintf('Group "%s" does not exist.',$arguments['group']),null,'ERROR');
      exit();
    }      

    $users = array();

    foreach($group->users AS $user)
	  {
	    $users[] = $user->username; 
    }    
    
    $this->logSection('guard-users',implode($users,','));

  }
}
