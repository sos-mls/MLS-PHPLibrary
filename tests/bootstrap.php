<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
// require all src files
$files = glob(dirname(__FILE__).'/../src/*.php');

foreach ($files as $file) {
    require_once($file);   
}

Yii::createWebApplication($config);