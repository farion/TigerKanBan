<?php

class tmGuardCreatePermissionTask extends sfBaseTask
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
    $this->name = 'create-permission';
    $this->briefDescription = 'Creates a permission';

    $this->detailedDescription = <<<EOF
The [guard:create-permission|INFO] task creates a permission:

  [./symfony guard:create-permission blog|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $perm = new sfGuardPermission();
    $perm->setName($arguments['permission']);
    $perm->save();

    $this->logSection('guard', sprintf('Create permission "%s"', $arguments['permission']));
  }
}
