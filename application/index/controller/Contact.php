<?php
namespace app\index\controller;

use think\Db;

/**
* 联系我们控制器
*/
class Contact extends Base
{
    //站点信息
    public function system()
    {
        $system = Db::name('system')->order('modify_time','desc')->find();
        $sys = explode(',',$system['tel']);
        unset($system['tel']);
        $system['tel1'] = $sys['0'];
        $system['tel2'] = $sys['1'];

        echo json_encode([
            'system' => $system,
        ]);
    }

    //留言板
    public function msg()
    {
        $data = input('post.');
        $data['createtime'] = time();

        $num = Db::name('message')->insert($data);

        if ($num) {
            echo json_encode(['msg' => 'success']);
        } else {
            echo json_encode(['msg' => 'error']);
        }

    }
}