<?php

class tmGuardRemovePermissionFromGroupTask extends sfBaseTask
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
        $this->name = 'remove-permission-from-group';
        $this->briefDescription = 'Removes a permission from a group';

        $this->detailedDescription = <<<EOF
The [guard:create-permission|INFO] task removes a permission from a group:

  [./symfony guard:remove-permission-from-group blog|INFO]
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

        if (!$perm)
            $this->logSection('guard', sprintf('Permission "%s" does not exist.', $arguments['permission']), null, 'ERROR');

        if (!$group)
            $this->logSection('guard', sprintf('Group "%s" does not exist.', $arguments['group']), null, 'ERROR');

        if (!$group || !$perm)
            exit();


        Doctrine_Query::create()
            ->delete('sfGuardGroupPermission')
            ->where('group_id = ? AND permission_id = ?', array($group->getId(), $perm->getId()))
            ->execute();

        $this->logSection('guard', sprintf('Remove permission "%s" from group "%s".', $arguments['permission'], $arguments['group']));
    }
}
