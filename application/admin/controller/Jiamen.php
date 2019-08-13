<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\Admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Jiamen extends Common {

    function jiamenlst() {
        $search = input('search');//关键字
        if ($search !== null ) {
                $jiamens = db('sh_jm')
                    ->where("jm_name|jm_gsname|jm_city|jm_phone","like","%".$search."%")
                    ->order('addtime DESC')
                    ->paginate(12, false, ['query' =>['search'=>$search],]);
        }else {
            $jiamens = db('sh_jm')
                ->order('addtime DESC')
                ->paginate(12);
        }

        return view('jiamen/jiamenlst',['jiamens'=>$jiamens,'search'=>$search]);

    }

    function jiamenedit() {
        $key = input('key');
        $jiamen = db('sh_jm')->where('id',$key)->find();
        db('sh_jm')->where('id',$key)->update(['status'=>1,]);
        return view('jiamen/jiamenedit',['jiamen'=>$jiamen]);
    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('sh_jm')->delete($key);
            if ($del == 1 ) {
                $data['msg'] = '删除成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '删除失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }else{
            die('访问错误');
        }
    }



}






?>
