<?php

class tmGuardRemoveUserTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('user', sfCommandArgument::REQUIRED, 'The user name')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'guard';
    $this->name = 'remove-user';
    $this->briefDescription = 'Removes an user';

    $this->detailedDescription = <<<EOF
The [guard:remove-user|INFO] task removes an user:

  [./symfony guard:remove-user marieber|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($arguments['user']);
   
    if(!$user){
      $this->logSection('guard',sprintf('User "%s" does not exist.',$arguments['user']),null,'ERROR');
      exit();
    }      
      
    $user->delete();

    $this->logSection('guard', sprintf('Remove user "%s"', $arguments['user']));
  }
}
