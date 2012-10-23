<?php

/**
 * whiteboard actions.
 *
 * @package    tigerkanban
 * @subpackage whiteboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class whiteboardActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {


        if(!Doctrine_Query::create()
            ->from('sfGuardGroup g')
            ->leftJoin("g.users u")
            ->where("u.id = ?",sfContext::getInstance()->getUser()->getGuardUser()->getId())
            ->count()){
            return "NoGroup";
        }

        $this->taskform = new tkTaskForm();

    }

    public function executeGetAreasJson(sfWebRequest $request)
    {
        $this->areas = Doctrine::getTable('tkArea')
            ->createQuery()
            ->where("sf_guard_group_id = ?",$request->getParameter("team_id"))
            ->orderBy('pos ASC')
            ->fetchArray();

        $this->getResponse()->setContentType('text/json');
        return $this->renderText(json_encode($this->areas));
    }

    public function executeUpdateTaskJson(sfWebRequest $request)
    {
        $values = $request->getParameter("task");

        $task = Doctrine::getTable("tkTask")->find($values['id']);

        $taskform = new tkTaskForm($task);
        $taskform->bind($values);

        if ($taskform->isValid()) {

            $taskform->save();

            if(!$task){
                $root = Doctrine::getTable('tkTask')->findRootByTeamId($request->getParameter('team_id'));
                $taskform->getObject()->getNode()->insertAsLastChildOf($root);
            }

            $this->getResponse()->setContentType('text/json');
            return $this->renderText('[]');
        }

        throw new sfException("Invalid Form");
    }

    public function executeGetTasksJson(sfWebRequest $request)
    {
        $q = Doctrine_Query::create()
            ->select("t.title, t.effort, t.link, u.username AS username, r.area_id AS area_id, t.progress")
            ->from("tkTask t")
            ->leftJoin("t.root r")
            ->where("t.level = 1 AND (t.archived != 1 OR t.archived IS NULL)")
            ->leftJoin("t.user u");

        if($request->getParameter("filter","all") == "me"){
            $q->andWhere("u.id = ?",$this->getUser()->getGuardUser()->getId());
        }

        $tasks = $q->orderBy("t.lft ASC")
        ->fetchArray();

        $this->getResponse()->setContentType('text/json');
        return $this->renderText(json_encode($tasks));
    }

    public function executeMoveTaskJson(sfWebRequest $request)
    {
        $this->forward404Unless($area = Doctrine::getTable('tkArea')->find($request->getParameter('area_id')));
        $this->forward404Unless($root = Doctrine::getTable('tkTask')->findRootByArea($area));
        $this->forward404Unless($task = Doctrine::getTable('tkTask')->find($request->getParameter('task_id')));

        $pos = $request->getParameter("task_pos") - 1;

        if ($pos <= 0) {
            $task->getNode()->moveAsFirstChildOf($root);
        } else {
            $children = $root->getNode()->getChildren();
            $this->forward404Unless($prevsib = $children[$pos]);
            $task->getNode()->moveAsNextSiblingOf($prevsib);
        }

        $this->getResponse()->setContentType('text/json');
        return $this->renderText('[]');
    }

    public function executeArchiveTaskJson(sfWebRequest $request){
        $this->forward404Unless($task = Doctrine::getTable('tkTask')->find($request->getParameter('task_id')));

        $task->archived = true;
        $task->save();

        $this->getResponse()->setContentType('text/json');
        return $this->renderText('[]');
    }
}