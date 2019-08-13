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
use think\Route;



Route::rule('index','index/index/index');//网站首页
Route::rule('profile','index/index/profile');//律所介绍
Route::rule('xmews','index/index/xmews');//项目介绍
Route::rule('news','index/index/news');//新闻中心
Route::rule('jiameng','index/index/jiameng');//招商合作
Route::rule('chax','index/index/chax');//业主查询
Route::rule('new/:key','index/index/newsd');//新闻详情

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];

