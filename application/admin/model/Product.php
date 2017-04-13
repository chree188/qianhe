<?php
namespace app\admin\model;

use think\Model;

/**
* 经典案例模型
*/
class Product extends Model
{
    //图像处理
    public function img($files,$name)
    {
        static $arr = array();
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $name);

            $arr[] = $info->getSavename();
        }

        return $arr;
    }

    //缩略图处理
    public function thumb($thumb,$width,$height,$url)
    {
        $image = \think\Image::open($thumb);  //打开图片资源

        $type = $image->type();  //获取图片后缀
        $str = md5(time());  //保存名字
        $date = date('Ymd');
        $saveName = $date.'/'.$str.'.'.$type;  //拼接保存名字

        //判断是否有文件夹,没有则创建
        $path = './'.$url.$date;
        $this->mkFolder($path);  //调用创建方法

        $img = $image->thumb($width,$height,\think\Image::THUMB_CENTER)->save('./'.$url.$saveName);

        return $url.$saveName;
    }

    //分类排序方法
    public function sort($data,$pid=0,$level=0)
    {
        static $arr = array();  //定义静态空数组

        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $arr[] = $v;
                $this->sort($data,$v['id'],$level+1);  //递归调用排序方法,遍历出本栏目的下级栏目
            }
        }
        return $arr;
    }

    /*递归建立多层目录函数*/
    public function mkFolder($path)
    {
        if(!is_readable($path)){
            $this->mkFolder( dirname($path) );
            if(!is_file($path)) mkdir($path,0777);
        }
    }
}