<?php

class tmGuardShowPermissionsTask extends sfBaseTask
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
    $this->name = 'show-permissions';
    $this->briefDescription = 'Shows all permissions';

    $this->detailedDescription = <<<EOF
The [guard:show-permissions|INFO] task to show all permissions:

  [./symfony guard:show-permissions |INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $groups = array();
    
    foreach(Doctrine::getTable('sfGuardPermission')->findAll() AS $group)
    {
	    $groups[] = $group->name; 
    }    
    
    $this->logSection('guard-permissions', implode($groups,','));

  }
}
