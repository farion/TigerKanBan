<?php

class tmGuardCreateGroupTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('groupname', sfCommandArgument::REQUIRED, 'The group name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'create-group';
    $this->briefDescription = 'Creates a group';

    $this->detailedDescription = <<<EOF
The [guard:create-group|INFO] task creates a group:

  [./symfony guard:create-group staff|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $group = new sfGuardGroup();
    $group->setName($arguments['groupname']);
    $group->save();

    $this->logSection('guard', sprintf('Create group "%s"', $arguments['groupname']));
  }
}
