<?php

class tmGuardShowPermissionsForUserTask extends sfBaseTask
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
    $this->name = 'show-permissions-for-user';
    $this->briefDescription = 'Shows the permissions of an user';

    $this->detailedDescription = <<<EOF
The [guard:show-permissions-for-user|INFO] task to show the permission of an user:

  [./symfony guard:show-permissions-for-user blog|INFO]
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

    $permissions = array();
    
    foreach($user->permissions AS $permission)
    {
    	$permissions[] = $permission->name;	
    } 
    
    foreach($user->groups AS $group)
    {
      foreach($group->permissions AS $permission)
	    {
	      $permissions[] = $permission->name; 
	    }
    }    
    
    $this->logSection('guard-permissions',implode($permissions,','));

  }
}
