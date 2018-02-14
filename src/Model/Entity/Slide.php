<?php
namespace CakePG\CakeSlide\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class Slide extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getBase64()
    {
        $img = file_get_contents($this->dir.$this->file);
        return 'data:'.$this->type.';base64,'.base64_encode($img);
    }
    protected function _getAssetUrl()
    {
        return $this->dir ? ASSETS.str_replace(STORAGE, '', $this->dir.$this->file) : null;
    }

    protected function _getPublishedMsg()
    {
        $publishStatus = Configure::read('CakeSlide.published');
        $display = Configure::read('CakeSlide.display');
        return $this->priority <= $display ?
        '<span class="badge badge-success">'.$publishStatus.'</span>' :
        '';
    }
}
