<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 控制器基类
 */
class Base extends Controller
{
    //初始化方法
    public function _initialize()
    {
        $system = Db::name('system')->order('id','desc')->find();  //查询系统设置

        //查询分页banner图
        $pcpage = Db::name('banner')->where('classify',34)->field('path')->find();  //pc端
        $phpage = Db::name('banner')->where('classify',35)->field('path')->find();  //手机端

        $this->assign(array(
            'system' => $system,
            'pcpage' => $pcpage,
            'phpage' => $phpage,
        ));
    }
}