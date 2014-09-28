<?php

return array(
     'db' => array(
        'class' => 'EOracleDB',
        'connectionString' => "(DESCRIPTION=(ADDRESS=(PROTOCOL =TCP)(HOST=192.168.0.216)(PORT = 1521))(CONNECT_DATA =(SERVER = DEDICATED)(SID=pangu01)))",
        'username' => 'ecshop',
        'password' => 'Yh^9(G$MgU'
    ),
    //集成后台	 
    'db_boss' => array(
        'class' => 'CDbConnection',
        'connectionString' => "mysql:host=192.168.0.216;port=33306;dbname=hm_bossadmin",
        'emulatePrepare' => true,
        'username' => 'hmeai',
        'password' => 'hmeai',
        'charset' => 'utf8',
        'tablePrefix' => 'eai_',
        'schemaCachingDuration' => 3600,
    ),
    'cache' => array(
        'class' => 'BaseMemCache',
        'hashKey'  => FALSE,
        'keyPrefix' => 'boss_service_',
        'servers' => array(
            array(
                'host' => '192.168.0.219',
                'port' => 11211
            )
        ),
    ),
    'mongodb' => array(
        'class' => 'EMongoDB',
        'connectionString' => 'mongodb://192.168.0.119:27017',
        'dbName' => 'admin',
        'fsyncFlag' => true,
        'safeFlag' => true,
        'useCursor' => false
    ),
);