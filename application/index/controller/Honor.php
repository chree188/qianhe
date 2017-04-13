<?php
namespace app\index\controller;

use think\Db;

/**
* 公司荣誉控制器
*/
class Honor extends Base
{
    //异步请求公司荣誉
    public function honor()
    {
        $honor = Db::name('image')->where('classify','17')->field('url')->select();

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        echo json_encode([
            'honor' => $honor,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }
}