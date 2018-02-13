<?php
namespace CakePG\CakeSlide\Controller\Component;

use Cake\Controller\Component;

class TopImageListComponent extends Component
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controler = $this->_registry->getController();
    }

    public function getTopImages($limit = null)
    {
        $this->controler->loadModel('CakePG/CakeSlide.TopImages');
        return $this->controler->TopImages->find('all' , [
            'order' => ['priority' => 'asc'],
            'limit' => $limit
        ]);
    }
}
