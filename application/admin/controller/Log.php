<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\Admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Log extends controller {
    function loglst() {
        $log = db('sh_log')
            ->alias('a')
            ->join('sh_user b','a.user_id = b.user_id','LEFT')
            ->order('addtime DESC')
            ->field('a.*,b.username')
            ->paginate(12);
        return view('log/loglst',['log'=>$log]);
    }
}



?>
