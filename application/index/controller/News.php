<?php
namespace app\index\controller;

use think\Db;

/**
* 新闻控制器
*/
class News extends Base
{
    //新闻列表
    public function lst()
    {
        if (input('post.page')) {
            $page = input('post.page');
        } else{
            $page = 1;
        }

        $pagesize = input('post.pagesize');

        $hot = Db::name('news')->where('classify','12')->where('status','1')->order('createtime','desc')->field('id,title,createtime,description,thumbnail')->limit(3)->select();
        $lst = Db::name('news')->where('classify','13')->where('status','1')->order('createtime','desc')->field('id,title,createtime,description,thumbnail')->page($page,$pagesize)->select();

        //新闻总条数
        $count = Db::name('news')->where('classify','13')->where('status','1')->count();

        //新闻总页数
        $pagenum = ceil($count/$pagesize);

        echo json_encode([
            'hot' => $hot,
            'lst' => $lst,
            'conut' => $count,
            'pagenum' => $pagenum,
        ]);
    }

    //新闻详情
    public function detail()
    {
        if (input('post.id')) {
            $id = input('post.id');
        } else {
            $id = 1;
        }

        $news = Db::name('news')->where('id',$id)->where('status','1')->field('title,content,bro_num,createtime')->find();

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        //增加浏览数
        Db::name('news')
            ->where('id', $id)
            ->setInc('bro_num');

        //获取上一条 下一条id
        $n = new \app\index\model\News();
        $upDown = $n->getId($id);

        echo json_encode([
            'news' => $news,
            'upDown' => $upDown,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }
}