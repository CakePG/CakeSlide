<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Cake\Core\Configure;

Configure::load('CakePG/CakeSlide.slide');
collection((array)Configure::read('Slide.config'))->each(function ($file) {
    Configure::load($file);
});
Configure::load('CakePG/CakeSlide.const');
