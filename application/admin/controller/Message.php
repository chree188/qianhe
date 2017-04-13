<?php
namespace app\admin\controller;

use think\Db;

/**
 * Class Message
 * @package app\admin\controller
 */
class Message extends Base
{
   public function lst()
   {
       $msg = Db::name('message')->order('createtime','desc')->select();

       $this->assign(array(
          'msg' => $msg,
       ));
       return view();
   }
}
