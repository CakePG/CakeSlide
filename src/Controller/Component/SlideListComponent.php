<?php
namespace CakePG\CakeSlide\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;

class SlideListComponent extends Component
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controler = $this->_registry->getController();
    }

    public function getSlides()
    {
        $this->controler->loadModel('CakePG/CakeSlide.Slides');
        $display = Configure::read('CakeSlide.display');
        return $this->controler->Slides->find('all' , [
            'order' => ['priority' => 'asc'],
            'limit' => $display
        ]);
    }
}
