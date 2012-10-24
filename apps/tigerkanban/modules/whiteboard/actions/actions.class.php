<?php

require_once(dirname(__FILE__) . '/../../../../../lib/vendor/markdown/markdown.php');

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
        if (!Doctrine_Query::create()
            ->from('sfGuardGroup g')
            ->leftJoin("g.users u")
            ->where("u.id = ?", sfContext::getInstance()->getUser()->getGuardUser()->getId())
            ->count()
        ) {
            return "NoGroup";
        }

        $this->taskform = new tkTaskForm();

    }

    public function executeGetAreasJson(sfWebRequest $request)
    {
        $team_id = $request->getParameter("team_id",null);
        $this->forward404Unless(is_numeric($team_id));


        $areas = Doctrine::getTable('tkArea')
            ->createQuery()
            ->where("sf_guard_group_id = ?", $request->getParameter("team_id"))
            ->orderBy('pos ASC')
            ->fetchArray();

        $lanes = Doctrine::getTable('tkLane')
            ->createQuery()
            ->where("sf_guard_group_id = ?", $request->getParameter("team_id"))
            ->orderBy('pos ASC')
            ->fetchArray();


        foreach($areas AS &$area){
            $q = Doctrine_Manager::getInstance()->getCurrentConnection();
            $result = $q->execute("SELECT COUNT(*) AS cload
                                    FROM tk_task t
                                    LEFT JOIN (
                                        SELECT root_id
                                        FROM tk_task t
                                        LEFT JOIN tk_area a
                                        ON a.id = t.area_id
                                        WHERE t.area_id = ".$area['id']." AND t.level = 0 AND sf_guard_group_id = ".$team_id."
                                    ) r
                                    ON t.root_id = r.root_id
                                    WHERE t.level = 1  AND r.root_id IS NOT NULL AND (t.archived IS NULL OR t.archived = 0)"
            );

            $row = $result->fetch();
            $area['load'] = $row['cload'];
        }

        foreach($lanes AS &$lane){
            $q = Doctrine_Manager::getInstance()->getCurrentConnection();
            $result = $q->execute("SELECT COUNT(*) AS cload
                                    FROM tk_task t
                                    LEFT JOIN (
                                        SELECT root_id
                                        FROM tk_task t
                                        LEFT JOIN tk_lane l
                                        ON l.id = t.lane_id
                                        LEFT JOIN tk_area a
                                        ON a.id = t.area_id
                                        WHERE t.lane_id = ".$lane['id']." AND t.level = 0 AND
                                        l.sf_guard_group_id = ".$team_id." AND a.sf_guard_group_id = ".$team_id." AND a.wip IS NOT NULL
                                    ) r
                                    ON t.root_id = r.root_id
                                    WHERE t.level = 1  AND r.root_id IS NOT NULL AND (t.archived IS NULL OR t.archived = 0)"
            );


            $row = $result->fetch();
            $lane['load'] = $row['cload'];
        }


        $this->getResponse()->setContentType('text/json');
        return $this->renderText(json_encode(array('areas' => $areas, 'lanes' => $lanes)));
    }

    public function executeUpdateTaskJson(sfWebRequest $request)
    {
        $values = $request->getParameter("task");

        $task = Doctrine::getTable("tkTask")->find($values['id']);

        $taskform = new tkTaskForm($task);
        $taskform->bind($values);

        if ($taskform->isValid()) {

            $taskform->save();

            if (!$task) {
                $task = $taskform->getObject();
                $root = Doctrine::getTable('tkTask')->findRootByTeamId($request->getParameter('team_id'));
                $task->getNode()->insertAsLastChildOf($root);
                $task->creator_id = $this->getUser()->getGuardUser()->getId();
                $task->save();
            }

            $this->getResponse()->setContentType('text/json');
            return $this->renderText('[]');
        }

        throw new sfException("Invalid Form");
    }

    public function executeGetTasksJson(sfWebRequest $request)
    {
        $q = Doctrine_Query::create()
            ->select("t.title, t.effort, t.link, c.username AS creatorname, u.username AS username, r.area_id AS area_id, r.lane_id AS lane_id, DATE(t.created_at) AS created_at, DATE(t.readydate) AS readydate, t.comment, blocked")
            ->from("tkTask t")
            ->leftJoin("t.root r")
            ->where("t.level = 1 AND (t.archived != 1 OR t.archived IS NULL)")
            ->leftJoin("t.user u")
            ->leftJoin("t.creator c");

        if ($request->getParameter("filter", "all") == "me") {
            $q->andWhere("u.id = ?", $this->getUser()->getGuardUser()->getId());
        }

        $tasks = $q->orderBy("t.lft ASC")
            ->fetchArray();

        foreach ($tasks AS &$task) {
            $task['comment_formatted'] = Markdown($task['comment']);
        }


        $this->getResponse()->setContentType('text/json');
        return $this->renderText(json_encode($tasks));
    }

    public function executeMoveTaskJson(sfWebRequest $request)
    {
        $this->forward404Unless($area = Doctrine::getTable('tkArea')->find($request->getParameter('area_id')));
        $this->forward404Unless($lane = Doctrine::getTable('tkLane')->find($request->getParameter('lane_id')));
        $this->forward404Unless($root = Doctrine::getTable('tkTask')->findRootByAreaAndLane($area, $lane));
        $this->forward404Unless($task = Doctrine::getTable('tkTask')->find($request->getParameter('task_id')));

        $pos = $request->getParameter("task_pos") - 1;

        if ($pos <= 0) {
            $task->getNode()->moveAsFirstChildOf($root);
        } else {
            $children = $root->getNode()->getChildren();
            $this->forward404Unless($prevsib = $children[$pos]);

            if($prevsib->getId() != $task->getId())
                $task->getNode()->moveAsNextSiblingOf($prevsib);
        }

        $this->getResponse()->setContentType('text/json');
        return $this->renderText('[]');
    }

    public function executeArchiveTaskJson(sfWebRequest $request)
    {
        $this->forward404Unless($task = Doctrine::getTable('tkTask')->find($request->getParameter('task_id')));

        $task->archived = true;
        $task->save();

        $this->getResponse()->setContentType('text/json');
        return $this->renderText('[]');
    }
}
