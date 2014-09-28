<?php

include_once dirname(__FILE__) . '/' . DEV_ENVIRONMENT . '/constants.php';

return array(
    'basePath' => ROOT_PATH . 'protected' . DIRECTORY_SEPARATOR,
    'name' => 'ec.com',
    'defaultController' => 'index',
    'runtimePath' => ROOT_PATH . 'data' . DIRECTORY_SEPARATOR . 'runtimes' . DIRECTORY_SEPARATOR,
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Shanghai',
    'charset' => 'utf-8',
//	'layoutpath' => false,
// 	'layoutpath' => YII_ROOT_PATH.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR,
    'import' => array(
        'application.config.config.php',
        'application.components.*',
        'application.forms.*',
        'application.models.*',
        'application.mongoDbModels.*',
        'application.services.*',
        'yii_ext_lib.extensions.yiidebugtb.*',
        'yii_ext_lib.extensions.yiimongodb.*',
        'yii_ext_lib.extensions.yiioracledb.*',
    ),
    'components' => array_merge(array(
        'errorHandler'=>array(
            'errorAction' => 'public/error',
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer'
        )
        ), require(dirname(__FILE__) . '/' . DEV_ENVIRONMENT . '/components.php')),
    'params' => require(dirname(__FILE__) . '/' . DEV_ENVIRONMENT . '/params.php'),
);
