<?php
namespace app\admin\controller;

use think\Db;
use app\admin\model\Product as ProductModel;

/**
* 产品控制器
*/
class Product extends Base
{
    //添加产品
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');  //接收表单数据
            $product = new ProductModel();  //实例化产品模型

            //缩略图处理
            $thumb = request()->file('thumb');

            if ($thumb) {
                $width = 360;
                $height = 305;
                $url = 'uploads/product/';
                $th = $product->thumb($thumb,$width,$height,$url);
                $pro['thumb'] = $th;
            }

            //生成案例数组,因为之前的$data数组比较杂乱
            $pro['title'] = $data['title'];
            $pro['description'] = $data['description'];
            $pro['classify'] = $data['classify'];
            $pro['chara'] = $data['chara'];
            $pro['createtime'] = time();

            $productId = db('product')->insertGetId($pro);  //添加案例内容

            //存储功能特点
            $res = array();
            foreach ($data['tit'] as $key => $val) {
                $res['tit'] = $val;
                $res['desc'] = $data['desc'][$key];
                $res['pid'] = $productId;
                $num = Db::name('product_chara')->insert($res);
            }

            //图片处理
            $files = request()->file('pic');

            if ($files) {
                $name = 'product';
                $pic = $product->img($files,$name);

                foreach ($pic as $key => $val) {
                    $num = Db::name('product_pic')->insert(['pic' => 'uploads/'.$name.'/'.$val,'pid' => $productId]);
                }
            }

            $this->redirect('Product/lst');  //跳转到列表页

            return;
        }

        $category = Db::name('category')->select();  //查询所有分类

        $product = new ProductModel();  //实例化产品模型
        $cate = $product->sort($category,$pid=1);  //调用排序方法

        $this->assign(array(
            'category' => $cate,
        ));
        return view();
    }

    //产品列表页
    public function lst()
    {
        $product = Db::name('product')->alias('p')->field('p.*,c.catename')->join('sh_category c','p.classify=c.id')->order('id','asc')->select();

        $this->assign(array(
            'product' => $product,
        ));
        return view();
    }

    //编辑产品特点
    public function editChara($id)
    {
        if (request()->isPost()) {
            $data = input('post.');

            $num = Db::name('product_chara')->where('pid',$id)->delete();  //删除之前功能特点

            if ($num) {
                //存储功能特点
                $res = array();
                foreach ($data['tit'] as $key => $val) {
                    $res['tit'] = $val;
                    $res['desc'] = $data['desc'][$key];
                    $res['pid'] = $id;
                    $n = Db::name('product_chara')->insert($res);
                }

                $this->success('编辑成功');
            } else {
                $this->error('编辑失败');
            }

        }

        $chara = Db::name('product_chara')->where('pid',$id)->order('id','asc')->select();

        $this->assign(array(
            'chara' => $chara,
            'id' => $id,
        ));
        return view();
    }

    //编辑产品图片
    public function editPic($id)
    {
        if (request()->isPost()) {
            $data = input('post.');

            if ($data['pid'] == '0') {
                //图片处理
                $files = request()->file('pic');

                if ($files) {
                    $name = 'product';
                    $product = new ProductModel();
                    $pic = $product->img($files,$name);

                    foreach ($pic as $key => $val) {
                        $num = Db::name('product_pic')->insert(['pic' => 'uploads/'.$name.'/'.$val,'pid' => $id]);
                    }
                }

                $this->success('添加图片成功');
            } else {
                $url = Db::name('product_pic')->where('id',$data['pid'])->field('pic')->find();

                //删除图片
                @unlink("./".$url['pic']);

                //图片处理
                $files = request()->file('pic');

                if ($files) {
                    $name = 'product';
                    $product = new ProductModel();
                    $pic = $product->img($files,$name);

                    foreach ($pic as $key => $val) {
                        $num = Db::name('product_pic')->where('id',$data['pid'])->update(['pic' => 'uploads/'.$name.'/'.$val]);
                    }
                }

                $this->success('修改图片成功');
            }

            return;
        }

        $pic = Db::name('product_pic')->where('pid',$id)->select();

        $this->assign(array(
            'pic' => $pic,
            'id' => $id,
        ));
        return view();
    }

    //删除图片
    public function delImg()
    {
        $id = input('get.id');
        $url = Db::name('product_pic')->where('id',$id)->field('pic')->find();

        //删除图片
        @unlink("./".$url['pic']);

        $num = Db::name('product_pic')->delete($id);

        if ($num) {
            $this->success('删除图片成功');
        } else {
            $this->error('删除图片失败');
        }

    }

    //是否显示
    public function show()
    {
        $id = input('post.id');

        //查询新闻表
        $res = Db::name('product')->where('id',$id)->field('status')->find();
        $status = $res['status'];

        if ($status == '1') {
            $st['status'] = '2';
            $num = Db::name('product')->where('id',$id)->update($st);
            if ($num == '1') {
                return ['txt' => 'blank'];
            }
        } elseif($status == '2') {
            $st['status'] = '1';
            $num = Db::name('product')->where('id',$id)->update($st);
            if ($num == '1') {
                return ['txt' => 'show'];
            }
        }
    }

    //编辑产品
    public function edit($id)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $product = new ProductModel();  //实例化产品模型

            //缩略图处理
            $thumb = request()->file('thumb');

            if ($thumb) {
                $url = Db::name('product')->where('id',$id)->field('thumb')->find();
                //删除图片
                @unlink("./".$url['thumb']);

                $width = 360;
                $height = 305;
                $url = 'uploads/product/';
                $th = $product->thumb($thumb,$width,$height,$url);
                $data['thumb'] = $th;
            }

            $num = Db::name('product')->where('id',$id)->update($data);

            if ($num >= 0) {
                $this->success('编辑产品成功',url('Product/lst'));
            } else {
                $this->error('编辑产品失败');
            }

            return;
        }

        $category = Db::name('category')->select();  //查询所有分类

        $product = new ProductModel();  //实例化产品模型
        $cate = $product->sort($category,$pid=1);  //调用排序方法

        $pro = Db::name('product')->where('id',$id)->find();

        $this->assign(array(
            'category' => $cate,
            'product' => $pro,
            'id' => $id,
        ));
        return view();
    }

    //删除产品
    public function del()
    {
        $id = input('get.id');

        $thumb = Db::name('product')->where('id',$id)->field('thumb')->find();

        //删除图片
        @unlink("./".$thumb['thumb']);
        $num = Db::name('product')->delete($id);

        //删除产品功能特性
        $nu = Db::name('product_chara')->where('pid',$id)->delete();

        //删除产品图片
        $res = Db::name('product_pic')->where('pid',$id)->field('pic')->select();
        foreach ($res as $key => $val) {
            @unlink("./".$val['pic']);
        }
        $n = Db::name('product_pic')->where('pid',$id)->delete();

        if ($num) {
            $this->success('删除产品成功',url('Product/lst'));
        } else {
            $this->error('删除产品失败');
        }

    }

    //多选删除
    public function delAll()
    {
        $data = input('post.');
        unset($data['dynamic-table_length']);

        foreach($data['check'] as $key => $val) {
            $thumb = Db::name('product')->where('id',$val)->field('thumb')->find();

            //删除图片
            @unlink("./".$thumb['thumb']);
            $num = Db::name('product')->delete($val);

            //删除产品功能特性
            $nu = Db::name('product_chara')->where('pid',$val)->delete();

            //删除产品图片
            $res = Db::name('product_pic')->where('pid',$val)->field('pic')->select();
            foreach ($res as $k => $v) {
                @unlink("./".$v['pic']);
            }
            $n = Db::name('product_pic')->where('pid',$val)->delete();
        }

        $this->success('删除产品成功',url('Product/lst'));
    }
}