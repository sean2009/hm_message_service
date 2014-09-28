<?php

define ( 'YII_DEBUG', true );
define ( 'ROOT_PATH', dirname ( __FILE__ ) . DIRECTORY_SEPARATOR );
define('YII_IS_MONITORING', false);

$configfile = ROOT_PATH . 'protected/config/main.php';

require_once ('../yiiext/yii_ext_lib/bootStrap.php');

// create a Web application instance and run
Yii::createWebApplication ($configfile)->run();
