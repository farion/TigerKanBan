<?php

class tmGuardShowUserForPermissionTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('permission', sfCommandArgument::REQUIRED, 'The permission name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'show-user-for-permission';
    $this->briefDescription = 'Shows the users of a permission';

    $this->detailedDescription = <<<EOF
The [guard:show-user-for-permission|INFO] task to shows the user of a permission:

  [./symfony guard:show-user-for-permission blog|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $permission = Doctrine::getTable('sfGuardPermission')->findOneByName($arguments['permission']);


    if(!$permission)
    {
      $this->logSection('guard',sprintf('Permission "%s" does not exist.',$arguments['permission']),null,'ERROR');
      exit();
    }      

    $users = array();
    
    foreach($permission->Users AS $user)
    {
    	$users[] = $user->username;	
    } 
    
    foreach($permission->Groups AS $group)
    {
      foreach($group->users AS $user)
	    {
	      $users[] = $user->username; 
	    }
    }    
    
    $this->logSection('guard-users',implode($users,','));

  }
}
