<?php

class tmGuardRemovePermissionTask extends sfBaseTask
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
    $this->name = 'remove-permission';
    $this->briefDescription = 'Removes a permission';

    $this->detailedDescription = <<<EOF
The [guard:remove-permission|INFO] task removes a permission:

  [./symfony guard:remove-permission dialogs|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $permission = Doctrine::getTable('sfGuardPermission')->findOneByName($arguments['permission']);
   
    if(!$permission){
      $this->logSection('guard',sprintf('Permission "%s" does not exist.',$arguments['permission']),null,'ERROR');
      exit();
    }      
      
    $permission->delete();

    $this->logSection('guard', sprintf('Remove permission "%s"', $arguments['permission']));
  }
}
