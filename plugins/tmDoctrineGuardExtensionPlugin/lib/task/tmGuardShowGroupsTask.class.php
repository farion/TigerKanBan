<?php

class tmGuardShowGroupsTask extends sfBaseTask
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
    $this->name = 'show-groups';
    $this->briefDescription = 'Shows all groups';

    $this->detailedDescription = <<<EOF
The [guard:show-groups|INFO] task to show all groups:

  [./symfony guard:show-groups |INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $groups = array();
    
    foreach(Doctrine::getTable('sfGuardGroup')->findAll() AS $group)
    {
	    $groups[] = $group->name; 
    }    
    
    $this->logSection('guard-groups', implode($groups,','));

  }
}
