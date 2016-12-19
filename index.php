<?php
define('BASEDIR', __DIR__);
require BASEDIR . '/Smile/Loader.php';
spl_autoload_register('\\Smile\\Loader::autoload');

\Smile\Smile::getInstance()->start();
