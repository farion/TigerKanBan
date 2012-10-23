<?php

/**
 * tkTaskTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class tkTaskTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object tkTaskTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('tkTask');
    }

    public function findRootByArea(tkArea $area)
    {
        $root = Doctrine_Query::create()
            ->from('tkTask')
            ->where("level = ? AND area_id = ?", array(0, $area->getId()))
            ->fetchOne();

        if (!$root) {

            $root = new tkTask();
            $root->area_id = $area->getId();
            $root->save();

            $this->getTree()->createRoot($root);
        }

        return $root;
    }
}