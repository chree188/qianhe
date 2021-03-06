<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2017/2/24
 * Time: 12:53
 */
namespace app\index\model;

use think\Model;

/**
 * Class Cases 案例模型
 * @package app\index\model
 */
class Cases extends Model
{
    public function getId($caseid)
    {
        //查询数据库,得到所有的案例id
        $cid = $this->field('id')->select();

        //通过遍历,得到数组的一维数组
        static $arr = array();
        foreach ($cid as $key => $val) {
            $arr[] = $val['id'];
        }

        //将一维数组反转,通过id得到id所处数组的位置
        $farr = array_flip($arr);

        //拿到当前数组的key值
        $thisKey = $farr[$caseid];

        //计算数组元素个数
        $count = count($arr);

        //分别拿到上一个和下一个数组的key值
        if ($thisKey == 0) {
            $prevId = $arr[$count - 1];
        } else {
            $prevId = $arr[$thisKey-1];
        }
        if ($thisKey == $count-1) {
            $nextId = $arr[0];
        } else {
            $nextId = $arr[$thisKey+1];
        }

        return ['prevId' => $prevId,'nextId' => $nextId];
    }
}