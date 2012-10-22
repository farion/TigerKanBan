<?php

class tmGuardShowUsersTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'show-users';
    $this->briefDescription = 'Shows all users';

    $this->detailedDescription = <<<EOF
The [guard:show-users|INFO] task to show all users:

  [./symfony guard:show-users |INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $users = array();
    
    foreach(Doctrine::getTable('sfGuardUser')->findAll() AS $user)
    {
	    $users[] = $user->username; 
    }    
    
    $this->logSection('guard-users', implode($users,','));

  }
}
