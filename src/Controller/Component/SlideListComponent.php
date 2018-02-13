<?php
namespace CakePG\CakeSlide\Controller\Component;

use Cake\Controller\Component;

class SlideListComponent extends Component
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controler = $this->_registry->getController();
    }

    public function getSlides($limit = null)
    {
        $this->controler->loadModel('CakePG/CakeSlide.Slides');
        return $this->controler->Slides->find('all' , [
            'order' => ['priority' => 'asc'],
            'limit' => $limit
        ]);
    }
}
