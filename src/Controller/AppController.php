<?php
namespace CakePG\CakeSlide\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->set('dashboardPath', Configure::read('CakeSlide.dashboard_path'));
        $this->set('display', Configure::read('CakeSlide.display'));
    }
}
