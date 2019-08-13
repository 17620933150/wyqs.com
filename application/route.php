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



Route::rule('index','index/index/index');//��վ��ҳ
Route::rule('profile','index/index/profile');//��������
Route::rule('xmews','index/index/xmews');//��Ŀ����
Route::rule('news','index/index/news');//��������
Route::rule('jiameng','index/index/jiameng');//���̺���
Route::rule('chax','index/index/chax');//ҵ����ѯ
Route::rule('new/:key','index/index/newsd');//��������

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];

