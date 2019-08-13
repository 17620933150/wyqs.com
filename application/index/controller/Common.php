<?php
namespace app\index\controller;

header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;
use think\Session;
use think\helper\hash\Md5;

use think\controller;


class Common extends controller{

    public function _initialize(){
        $profile = db('sh_jsao')->where('id',1)->find();

        $sort = db('sh_sort')->where('id','<>',1)->select();
        foreach ($sort as $k=>$v) {
            $article[$v['id']] =  db('sh_article')->where('sort_id',$v['id'])->limit(6)->select();
            $art[$v['id']] = db('sh_article')->where('sort_id',$v['id'])->count();
        }

        $owner = db('sh_owner')
            ->whereOr('owner_case',1)
            ->whereOr('owner_story',1)
            ->whereOr('owner_letter',1)
            ->alias('a')
            ->join('sh_xq b','a.uid = b.id ','LEFT')
            ->field('a.*,b.xq_name as uidname')
            ->order('a.addtime DESC,a.owner_case DESC,a.owner_story DESC,a.owner_letter DESC')
            ->limit(30)
            ->select();//首页业主形信息

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
        $hjiamen = db('sh_article')
            ->where('sort_id',2)
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name,article_fm,article_content,addtime')
            ->limit(8)
            ->select();
        $hsensu = db('sh_article')
            ->where('sort_id',3)
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name,article_fm,article_content,addtime')
            ->limit(8)
            ->select();
        $lunbotu = db('sh_lunbotu')->select();
        $friend = db('sh_friend')->select();
        $this->assign([
            'friend'=>$friend,
            'lunbotu'=>$lunbotu,//轮播图
            'ownerdata'=>$owner,//首页业主形信息
            'hsensu'=>$hsensu,//首页胜诉
            'hjiamen'=>$hjiamen,//首页加盟签约
            'sort'=>$sort,//新闻分类
            'profile'=>$profile,//律所介绍
            'article'=>$article,//新闻
            'art'=>$art,
        ]);

    }


}
