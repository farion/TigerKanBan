<?php

class tmGuardAddPermissionToGroupTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('permission', sfCommandArgument::REQUIRED, 'The permission name'),
      new sfCommandArgument('group', sfCommandArgument::REQUIRED, 'The group name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'add-permission-to-group';
    $this->briefDescription = 'Adds a permission to a group';

    $this->detailedDescription = <<<EOF
The [guard:create-permission|INFO] task adds a permission to a group:

  [./symfony guard:add-permission-to-group blog|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $perm = Doctrine::getTable('sfGuardPermission')->findOneByName($arguments['permission']);
    $group = Doctrine::getTable('sfGuardGroup')->findOneByName($arguments['group']);
    
    if(!$perm) 
      $this->logSection('guard',sprintf('Permission "%s" does not exist.',$arguments['permission']),null,'ERROR');

    if(!$group)
      $this->logSection('guard',sprintf('Group "%s" does not exist.',$arguments['group']),null,'ERROR');      
      
    if(!$group || !$perm)
      exit();  
      
    $group->permissions[] = $perm;
    $group->save();  
      
    $this->logSection('guard', sprintf('Add permission "%s" to group "%s".',$arguments['permission'],$arguments['group']));
  }
}
