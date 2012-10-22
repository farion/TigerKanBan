<?php

class tmGuardRemoveGroupTask extends sfBaseTask
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
    $this->name = 'remove-group';
    $this->briefDescription = 'Removes a group';

    $this->detailedDescription = <<<EOF
The [guard:remove-group|INFO] task removes a group:

  [./symfony guard:remove-group staff|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $group = Doctrine::getTable('sfGuardGroup')->findOneByName($arguments['group']);
   
    if(!$group){
      $this->logSection('guard',sprintf('Group "%s" does not exist.',$arguments['group']),null,'ERROR');
      exit();
    }      
      
    $group->delete();

    $this->logSection('guard', sprintf('Remove group "%s"', $arguments['group']));
  }
}
