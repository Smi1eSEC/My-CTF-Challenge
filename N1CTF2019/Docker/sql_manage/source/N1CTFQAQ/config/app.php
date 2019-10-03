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

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'              => '',
    // 应用Trace（环境变量优先读取）
    'app_trace'             => false,
    // 应用的命名空间
    'app_namespace'         => '',
    // 是否启用路由
    'with_route'            => true,
    // 是否启用事件
    'with_event'            => true,
    // 自动多应用模式
    'auto_multi_app'        => false,
    // 应用映射（自动多应用模式有效）
    'app_map'               => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'           => [],
    // 默认应用
    'default_app'           => 'index',
    // 默认时区
    'default_timezone'      => 'Asia/Shanghai',
    // 是否开启多语言
    'lang_switch_on'        => false,
    // 默认语言
    'default_lang'          => 'zh-cn',
    // 默认验证器
    'default_validate'      => '',

    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl' => app()->getThinkPath() . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'   => app()->getThinkPath() . 'tpl/dispatch_jump.tpl',

    'exception_tmpl'        => app()->getThinkPath() . 'tpl/think_exception.tpl',

    'error_message'         => 'Page error! Please try again later.',
    // 显示错误信息
    'show_error_msg'        => false,
];
