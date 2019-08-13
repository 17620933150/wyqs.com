<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\Admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Jsao extends controller {

    function jsaoedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_jsao')
                ->where('id',$key)
                ->update([
                    'jsao_content'=>$date['jsao_content'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                ]);
            if ($ren == 1) {
                $data['msg'] = '修改成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '修改失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }
        $jsao = db('sh_jsao')->where('id',$key)->find();
        return view('jsao/jsaoedit',['jsao'=>$jsao]);
    }

    function xiagnmuedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_xiangmu')
                ->where('id',$key)
                ->update([
                    'jsao_content'=>$date['xm_content'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                ]);
            if ($ren == 1) {
                $data['msg'] = '修改成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '修改失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }
        $jsao = db('sh_xiangmu')->where('id',$key)->find();
        return view('jsao/xiangmuedit',['xm'=>$jsao]);
    }


}






?>
