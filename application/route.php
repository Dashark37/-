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

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
use think\Route;

//定义路由规则
Route::get("index","admin/demo/index");
Route::get("test","admin/test/index");

//定义网站根目录路由
Route::get("/","admin/index/index");
//后台首页路由
Route::get("left","admin/index/left");
Route::get("top","admin/index/top");
Route::get("main","admin/index/main");
//输出登录页面的路由
Route::get("login","admin/public/login");