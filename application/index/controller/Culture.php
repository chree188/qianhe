<?php
namespace app\index\controller;

use think\Db;

/**
* 企业文化控制器
*/
class Culture extends Base
{
    //异步请求文化图片
    public function culture()
    {
        $culture = Db::name('image')->where('classify','18')->field('description,url')->select();

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        echo json_encode([
            'culture' => $culture,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }
}