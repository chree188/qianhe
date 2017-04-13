<?php
namespace app\index\controller;

use think\Db;

/**
 * 首页控制器
 */
class Index extends Base
{
    //前端首页跳转方法
    public function index()
    {
        return view();
    }

    //关于我们页面跳转
    public function aboutus()
    {
        return view();
    }

    //产品跳转
    public function product()
    {
        return view();
    }

    //案例跳转
    public function cases()
    {
        return view();
    }

    //公司文化跳转
    public function culture()
    {
        return view();
    }

    //联系我们跳转
    public function contact()
    {
        return view();
    }

    //新闻页跳转
    public function news()
    {
        return view();
    }

    //荣誉跳转
    public function honor()
    {
        return view();
    }
    // 产品详情
    public function productdetail()
    {
        return view();
    }

    //新闻详情跳转
    public function newsdetail()
    {
        return view();
    }

    //异步请求首页信息
    public function ajaxIndex()
    {
        //pc端banner
        $pcbanner = Db::name('banner')->where('status','1')->where('classify','14')->field('path')->order('rank','desc')->select();

        //手机端banner
        $mbanner = Db::name('banner')->where('status','1')->where('classify','15')->field('path')->order('rank','desc')->select();

        //首页关于我们
        $aboutus = Db::name('image')->where('classify','16')->field('title,description,url')->find();

        //首页荣誉墙
        $honor = Db::name('image')->where('classify','17')->field('url')->limit(4)->select();

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        //首页案例展示
        $cases = Db::name('cases')->where('status','1')->field('id,title,content,status')->select();
        foreach ($cases as $key => $val) {
            $res = Db::name('cases_pic')->where('cid',$val['id'])->field('pic')->find();
            $cases[$key]['img'] = $res['pic'];
            $cases[$key]['content'] = mb_substr($val['content'],0,40,"utf-8");
            $cases[$key]['title'] = mb_substr($val['title'],0,15,"utf-8");
        }

        //首页新闻
        $news = Db::name('news')->where('status','1')->field('id,title,description,createtime')->order('id desc')->limit(4)->select();

        echo json_encode([
            'pcbanner' => $pcbanner,
            'mbanner' => $mbanner,
            'aboutus' => $aboutus,
            'honor' => $honor,
            'cases' => $cases,
            'news' => $news,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }
}
