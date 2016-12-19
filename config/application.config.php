<?php

return [
    //加载的模块
    'modules' => [
        'Application',
    ],
    //模块路径
    'module_paths' => array(
        './module',
        './vendor',
    ),
    //加载的配置文件（autoload目录下的php文件）
    'config' => [
        'database',
    ]
];