<?php
namespace app\index\controller;

use think\Db;

/**
* 产品控制器
*/
class Product extends Base
{
    //异步产品列表请求
    public function productLst()
    {
        $productLst1 = Db::name('product')->where('classify','7')->where('status','1')->select();
        $productLst2 = Db::name('product')->where('classify','8')->where('status','1')->select();
        $productLst3 = Db::name('product')->where('classify','9')->where('status','1')->select();
        $productLst4 = Db::name('product')->where('classify','20')->where('status','1')->select();
        $productLst5 = Db::name('product')->where('classify','21')->where('status','1')->select();
        $productLst6 = Db::name('product')->where('classify','22')->where('status','1')->select();
        $productLst7 = Db::name('product')->where('classify','23')->where('status','1')->select();
        $productLst8 = Db::name('product')->where('classify','24')->where('status','1')->select();
        $productLst9 = Db::name('product')->where('classify','25')->where('status','1')->select();
        $productLst10 = Db::name('product')->where('classify','26')->where('status','1')->select();
        $productLst11 = Db::name('product')->where('classify','27')->where('status','1')->select();
        $productLst12 = Db::name('product')->where('classify','28')->where('status','1')->select();
        $productLst13 = Db::name('product')->where('classify','10')->where('status','1')->select();
        $productLst14 = Db::name('product')->where('classify','11')->where('status','1')->select();
        $productLst15 = Db::name('product')->where('classify','29')->where('status','1')->select();
        $productLst16 = Db::name('product')->where('classify','30')->where('status','1')->select();
        $productLst17 = Db::name('product')->where('classify','31')->where('status','1')->select();
        $productLst18 = Db::name('product')->where('classify','32')->where('status','1')->select();
        $productLst19 = Db::name('product')->where('classify','33')->where('status','1')->select();

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        echo json_encode([
            'productLst1' => $productLst1,
            'productLst2' => $productLst2,
            'productLst3' => $productLst3,
            'productLst4' => $productLst4,
            'productLst5' => $productLst5,
            'productLst6' => $productLst6,
            'productLst7' => $productLst7,
            'productLst8' => $productLst8,
            'productLst9' => $productLst9,
            'productLst10' => $productLst10,
            'productLst11' => $productLst11,
            'productLst12' => $productLst12,
            'productLst13' => $productLst13,
            'productLst14' => $productLst14,
            'productLst15' => $productLst15,
            'productLst16' => $productLst16,
            'productLst17' => $productLst17,
            'productLst18' => $productLst18,
            'productLst19' => $productLst19,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }

    //异步请求产品详情页
    public function productDetail()
    {
        $id = input('post.id');

        $product = Db::name('product')->where('id',$id)->field('id,title,description,chara')->find();
        // $chara = Db::name('product_chara')->where('pid',$product['id'])->select();
        $pic = Db::name('product_pic')->where('pid',$product['id'])->select();
        // foreach ($chara as $key => $val) {
        //     $chara[$key]['order'] = $key+1;
        // }

        //系统信息
        $system = Db::name('system')->order('id desc')->find();

        echo json_encode([
            'product' => $product,
            // 'chara' => $chara,
            'pic' => $pic,
            'seo' => ['keywords' => $system['seo_keywords'],'description' => $system['seo_description']],
        ]);
    }
}