<?php
namespace CakePG\CakeSlide\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Datasource\ConnectionManager;

/**
 * Modified 2017.11.24
 */
class SortPriorityBehavior extends Behavior
{
    /**
     * ソート処理
     */
    public function sortPriority($orders)
    {
        $dataSource = ConnectionManager::get('default');
        try {
            $dataSource->begin();
            for ($i=1; $i < count($orders) + 1; $i++) {
              $articleCategory = $this->getTable()->get($orders[$i - 1]);
              $articleCategory['priority'] = $i;
              $this->getTable()->save($articleCategory);
            }
            $dataSource->commit();
            return true;
        } catch(Exception $e) {
            $dataSource->rollback();
            return false;
        }
    }
}
