<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 事件定义文件
return [
    'bind'      => [
    ],
    'listen'    => [
        'AppInit'      => [
            'think\listener\LoadLangPack',
        ],
        'AppBegin'     => [
            'think\listener\CheckRequestCache',
        ],
        'AppEnd'       => [],
        'LogLevel'     => [],
        'LogWrite'     => [],
        'ResponseSend' => [],
        'ResponseEnd'  => [],
    ],
    'subscribe' => [
    ],
];
