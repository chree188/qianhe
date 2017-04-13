<?php
namespace app\index\controller;

use think\Db;
use app\index\model\Cases as casesModel;

/**
 * 经典案例控制器
 */
class Cases extends Base
{
    //经典案例列表
    public function lst()
    {
        if (input('post.id')) {
            $id = input('post.id');
        } else {
            $id = 1;
        }

        $cases = Db::name('cases')->where('id', $id)->find();
        $caseEquipment = Db::name('cases_equipment')->where('cid', $id)->select();
        $casePic = Db::name('cases_pic')->where('cid', $id)->select();
        foreach ($caseEquipment as $key => $val) {
            $caseEquipment[$key]['order'] = $key+1;
        }

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        //获取上一条 下一条id
        $case = new casesModel();
        $caseId = $case->getId($id);

        echo json_encode([
            'cases' => $cases,
            'caseEquipment' => $caseEquipment,
            'casePic' => $casePic,
            'caseId' => $caseId,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);

    }
}