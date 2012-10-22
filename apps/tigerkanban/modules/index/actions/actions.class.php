<?php

/**
 * index actions.
 *
 * @package    tigerkanban
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class indexActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
      $this->taskform = new tkTaskForm();
    }

    public function executeGetAreasJson(sfWebRequest $request)
    {
        $this->areas = Doctrine::getTable('tkArea')->createQuery()->orderBy('pos ASC')->fetchArray();

        $this->getResponse()->setContentType('text/json');
        return $this->renderText(json_encode($this->areas));
    }

    public function executeAddTaskJson(sfWebRequest $request){

        $taskform = new tkTaskForm();

        $taskform->bind($request->getParameter("task"));

        if($taskform->isValid()){
            $taskform->save();
            $this->getResponse()->setContentType('text/json');
            return $this->renderText('[]');
        }

        echo $$taskform->renderGlobalErrors();

        throw new sfException("Invalid Form");
    }
}
