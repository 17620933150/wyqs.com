<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;

//use app\Admin\controller\Common;

//use think\controller;
use app\Admin\controller\Common;
use think\Db;

//权限
class Owner extends Common {

    function propertylst() {
        $property = db('sh_property')
                ->paginate(12);
        return view('owner/propertylst',['property'=>$property]);
    }

    function propertyadd() {
        if(request()->isPost()) {
            $rolefl = input('post.');
            $rolefl["addtime"] = date("Y-m-d H:i",time());
            $rolefl['settle'] = '0';
            $rolefl['owner_letter'] = '0';
            $rolefl['owner_story'] = '0';
            $rolefl['owner_case'] = '0';
            $ren = db('sh_property')->strict(false)->insert($rolefl);
            if ($ren == 1) {
                $data['msg'] = '添加成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '添加失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }
        return view('owner/propertyadd');
    }

    function propertyedit() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
         if(request()->isPost()) {
             $rolefl = input('post.');
             $ren = db('sh_property')
                 ->where('id',$key)
                 ->update([
                     'property_contact'=>$rolefl['property_contact'],
                     'property_contactno'=>$rolefl['property_contactno'],
                     'property_content'=>$rolefl['property_content'],
                     'property_end'=>$rolefl['property_end'],
                     'property_name'=>$rolefl['property_name'],
                     'property_phone'=>$rolefl['property_phone'],
                     'property_start'=>$rolefl['property_start'],
                     'property_mark'=>$rolefl['property_mark'],
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
        $property = db('sh_property')->where('id',$key)->find();

        return view('owner/propertyedit',['property'=>$property]);
    }

    public function propertydel() {
        if(request()->isPost()) {
            $key = input('key');
            if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
                die('访问错误');
            }
            $del = db('sh_property')->delete($key);
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

    function xqlst() {
        $key = input('key');

        return view('owner/xqlst',['key'=>$key]);
    }

    function xqlstjson() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        $page = input('page');
        $limit = input('limit');

        if (preg_match("/^\d*$/",$page) !== 1 || preg_match("/^\d*$/",$limit) !== 1 ) {
            die('访问错误');
        }

        $head = ($page-1) * $limit;
        $end = $head+$limit;

        $sql = "SELECT count(*) as count  from sh_xq where xq_uid=".$key;
        $xqlst = db('sh_xq')->where('xq_uid',$key)->limit($head,$limit)->select();

//        $sql = "SELECT count(*) as count  from sh_xq where xq_uid=".$key;
//        $xqlst = db('sh_xq')->where('xq_uid',$key)->select();

        $count = Db::query($sql);
        $data['code'] = '0';
        $data['msg'] = '';
        $data['count'] = $count[0]['count'];
        $data['data'] = $xqlst;
        return json($data);
    }

    function xqadd() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        if(request()->isPost()) {
            $rolefl = input('post.');
            $rolefl["xq_uid"]= $key;
            $rolefl["addtime"] = date("Y-m-d H:i",time());
            $ren = db('sh_xq')->strict(false)->insert($rolefl);
            if ($ren == 1) {
                $data['msg'] = '添加成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '添加失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }
        return view('owner/xqadd');
    }

    function xqedit() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        if(request()->isPost()) {
            $rolefl = input('post.');
            $ren = db('sh_xq')
                ->where('id',$rolefl['id'])
                ->update([
                    $rolefl['field']=>$rolefl['value'],
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
    }


    function ownerlst() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        return view('owner/ownerlst',['key'=>$key]);
    }

    function ownerjson() {
        $key = input('key');//id
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        $page = input('page');//页码
        $limit = input('limit');//每页显示页数
        if (preg_match("/^\d*$/",$page) !== 1 || preg_match("/^\d*$/",$limit) !== 1 ) {
            die('访问错误');
        }
        $head = ($page-1) * $limit;
        $end = $head+$limit;

        $ownername = input('ownername');
        $shipping = input('shipping');

        if ($shipping !== NULL ||  $ownername !== NULL) {
            if ($shipping == '0' ) {
                if ($ownername !== '') {
                    //dump(111);
                    $sql = "SELECT count(*) as count from sh_owner where uid=".$key." and owner_name like '%".$ownername."%'";
                    //dump($sql);
                    $xqlst = db('sh_owner')
                        ->where('uid',$key)
                        ->where('owner_name','like',"%$ownername%")
                        ->limit($head,$limit)
                        ->select();
                }else {
//                    dump(222);
                    $sql = "SELECT count(*) as count from sh_owner where uid=".$key;
                    $xqlst = db('sh_owner')->where('uid',$key)->limit($head,$limit)->select();
                }
            }else{
                if ($ownername !== '') {
                    if ($shipping == '是') {
                        //dump(333);
                        $sql = "SELECT count(*) as count from sh_owner where uid=".$key." and owner_name like '%".$ownername."%' and settle = '".$shipping."'";
                        $xqlst = db('sh_owner')
                            ->where('uid',$key)
                            ->where('owner_name','like',"%$ownername%")
                            ->where('settle',"$shipping")
                            ->limit($head,$limit)
                            ->select();
                    }else {
                        //dump(444);
                        $sql = "SELECT count(*) as count from sh_owner where uid=".$key." and owner_name like '%".$ownername."%' and settle != '是'";
                        $xqlst = db('sh_owner')
                            ->where('uid',$key)
                            ->where('owner_name','like',"%$ownername%")
                            ->where('settle','<>',"是")
                            ->limit($head,$limit)
                            ->select();
                    }
                }else {
                    if ($shipping == '是') {
                        $sql = "SELECT count(*) as count from sh_owner where uid=".$key." and settle = '".$shipping."'";
                        $xqlst = db('sh_owner')
                            ->where('uid',$key)
                            ->where('settle',"$shipping")
                            ->limit($head,$limit)
                            ->select();
                    }else {
                        $sql = "SELECT count(*) as count from sh_owner where uid=".$key." and settle != '是'";
                        $xqlst = db('sh_owner')
                            ->where('uid',$key)
                            ->where('settle','<>',"是")
                            ->limit($head,$limit)
                            ->select();
                    }
                }
            }
        }else {
            $sql = "SELECT count(*) as count  from sh_owner where uid=".$key;
            $xqlst = db('sh_owner')->where('uid',$key)->limit($head,$limit)->select();
        }

        $count = Db::query($sql);
        $data['code'] = '0';
        $data['msg'] = '';
        $data['count'] =  $count[0]['count'];
        $data['data'] = $xqlst;
        return json($data);
    }

    function owneradd() {
        $key = input('key');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        if(request()->isPost()) {
            $rolefl = input('post.');
            $rolefl["uid"]= $key;
            $rolefl["addtime"] = date("Y-m-d H:i",time());
            $ren = db('sh_owner')->strict(false)->insert($rolefl);
            if ($ren == 1) {
                $data['msg'] = '添加成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '添加失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }
        return view('owner/owneradd');
    }

    function owneredit() {
        $key = input('id');
        if ($key == null || preg_match("/^\d*$/",$key) !== 1) {
            die('访问错误');
        }
        if(request()->isPost()) {
            $rolefl = input('post.');
            $ren = db('sh_owner')
                ->where('id',$rolefl['id'])
                ->update([
                    $rolefl['field']=>$rolefl['value'],
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
    }




}






?>
