<?php
namespace app\index\controller;

header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;
use think\Session;
use think\helper\hash\Md5;
use app\index\controller\Common;

use think\controller;


class Index extends Common{

    public function index(){
        return view('index/index');
    }
    public function profile() {
        return view('index/profile');
    }
    public function xmews() {
        return view('index/xmews');
    }
    public function jiameng() {
        if(request()->isPost()) {
            $date = input('post.');
            $date['addtime'] = date("Y-m-d H:i",time());
            $ren = db('sh_jm')->strict(false)->insert($date);
            if ($ren == 1) {
                $data['msg'] = '提交成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '提交失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }

        }
        return view('index/jiameng');
    }
    public function news() {
        return view('index/news');
    }
    public function chax() {
        if(request()->isPost()) {
            $date = input('post.');
            $card = db('sh_owner')
                ->where('owner_card',$date['owner_card'])
                ->find();
            if ($card == NULL) {
                $owner = db('sh_owner')
                    ->where('owner_name',$date['owner_name'])
                    ->where('owner_phone',$date['owner_phone'])
                    ->alias('a')
                    ->join('sh_xq b','a.uid = b.id ','LEFT')
                    ->field('a.*,b.xq_name as uidname')
                    ->select();
                if ($owner == NULL) {
                    $data['msg'] = '姓名与电话不匹配!';
                    $data['taatus'] = '200';
                    $data['way'] = 'true';
                    return json($data);
                }
                    db('sh_owner')
                    ->where('owner_name',$date['owner_name'])
                    ->where('owner_phone',$date['owner_phone'])
                    ->update([
                        'owner_card'=>$date['owner_card'],
                    ]);
            }else {
                $owner = db('sh_owner')
                    ->where('owner_name',$date['owner_name'])
                    ->where('owner_phone',$date['owner_phone'])
                    ->where('owner_card',$date['owner_card'])
                    ->alias('a')
                    ->join('sh_xq b','a.uid = b.id ','LEFT')
                    ->field('a.*,b.xq_name as uidname')
                    ->select();
            }

            foreach($owner as $k=>$v) {
                if($v['owner_case']== 1){
                    $owner[$k]['mode'] = '已立案处理';
                    continue;
                }else if ($v['owner_story']== 1) {
                    $owner[$k]['mode'] = '已提交起诉状';
                    continue;
                }else if ($v['owner_letter']== 1) {
                    $owner[$k]['mode'] = '已提交律师函';
                    continue;
                }
            }

            return json($owner);

        }
        return view('index/chax');
    }
    public function newsd() {
        $key = input('key');
        if ($key == NULL) {
            die('访问错误');
        }
        $articled = db('sh_article')
                ->where('a.id',$key)
                ->alias('a')
                ->join('sh_sort b','a.sort_id = b.id ','LEFT')
                ->field('a.*,b.sort_name')
                ->find();
        return view('index/newsdata',['articled'=>$articled]);
    }

    public function newspa() {
        $page = input('page');
        $limit = input('limit');
        $sid = input('sid');
        if (preg_match("/^\d*$/",$page) !== 1 || preg_match("/^\d*$/",$limit) !== 1 || preg_match("/^\d*$/",$sid) !== 1 ) {
            die('访问错误');
        }
        $head = ($page-1) * $limit;
        $end = $head+$limit;
        $count = db('sh_article')->where('sort_id',$sid)->count();
        $xqlst = db('sh_article')->where('sort_id',$sid)->limit($head,$limit)->select();
        $data['code'] = '0';
        $data['msg'] = '';
        $data['page'] = $page;
        $data['count'] = $count;
        $data['limit'] = $limit;
        $data['data'] = $xqlst;
        return json($data);

    }


}
