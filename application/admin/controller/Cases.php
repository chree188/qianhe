<?php
namespace app\admin\controller;

use think\Db;
use app\admin\model\Cases as CasesModel;
use app\admin\model\Product as ProductModel;

/**
* 经典案例控制器
*/
class Cases extends Base
{
    //添加案例
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');  //接收表单数据

            //生成案例数组,因为之前的$data数组比较杂乱
            $case['title'] = $data['title'];
            $case['content'] = $data['content'];
            $case['createtime'] = time();

            $caseId = db('cases')->insertGetId($case);  //添加案例内容

            //设备名称
            $res = array();
            foreach ($data['name'] as $key => $val) {
                $num = Db::name('cases_equipment')->insert(['name' => $val,'cid' => $caseId]);
            }

            //图片处理
            $files = request()->file('pic');

            if ($files) {
                $name = 'cases';  //给定相应名字,作为uploads文件夹下的子文件夹
                $case = new ProductModel();  //实例化案例模型
                $pic = $case->img($files,$name);  //调用图像处理方法(上传)

                foreach ($pic as $key => $val) {
                    $num = Db::name('cases_pic')->insert(['pic' => 'uploads/'.$name.'/'.$val,'cid' => $caseId]);  //将返回的图片路径名称存入数据库
                }
            }

            $this->success('添加案例成功',url('Cases/lst'));

            return;
        }
        return view();
    }

    //案例列表
    public function lst()
    {
        $cases = Db::name('cases')->select();

        $this->assign(array(
           'cases' => $cases,
        ));
        return view();
    }

    //编辑案例设备
    public function editEqui($id)
    {
        if (request()->isPost()) {
            $data = input('post.');

            $num = Db::name('cases_equipment')->where('cid',$id)->delete();  //删除之前设备名称

            if ($num) {
                //存储功能特点
                foreach ($data['name'] as $key => $val) {
                    $n = Db::name('cases_equipment')->insert(['name' => $val,'cid' => $id]);
                }

                $this->success('编辑成功');
            } else {
                $this->error('编辑失败');
            }

        }

        $equi = Db::name('cases_equipment')->where('cid',$id)->order('id','asc')->select();

        $this->assign(array(
            'equi' => $equi,
            'id' => $id,
        ));
        return view();
    }

    //编辑案例图片
    public function editPic($id)
    {
        if (request()->isPost()) {
            $data = input('post.');

            if ($data['cid'] == '0') {
                //图片处理
                $files = request()->file('pic');

                if ($files) {
                    $name = 'cases';
                    $product = new ProductModel();
                    $pic = $product->img($files,$name);

                    foreach ($pic as $key => $val) {
                        $num = Db::name('Cases_pic')->insert(['pic' => 'uploads/'.$name.'/'.$val,'cid' => $id]);
                    }
                }

                $this->success('添加图片成功');
            } else {
                $url = Db::name('Cases_pic')->where('id',$data['cid'])->field('pic')->find();

                //删除图片
                unlink("./".$url['pic']);

                //图片处理
                $files = request()->file('pic');

                if ($files) {
                    $name = 'Cases';
                    $case = new ProductModel();
                    $pic = $case->img($files,$name);

                    foreach ($pic as $key => $val) {
                        $num = Db::name('Cases_pic')->where('id',$data['cid'])->update(['pic' => 'uploads/'.$name.'/'.$val]);
                    }
                }

                $this->success('修改图片成功');
            }

            return;
        }

        $pic = Db::name('cases_pic')->where('cid',$id)->select();

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
        $url = Db::name('cases_pic')->where('id',$id)->field('pic')->find();

        //删除图片
        @unlink("./".$url['pic']);

        $num = Db::name('cases_pic')->delete($id);

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
        $res = Db::name('cases')->where('id',$id)->field('status')->find();
        $status = $res['status'];

        if ($status == '1') {
            $st['status'] = '2';
            $num = Db::name('cases')->where('id',$id)->update($st);
            if ($num == '1') {
                return ['txt' => 'blank'];
            }
        } elseif($status == '2') {
            $st['status'] = '1';
            $num = Db::name('cases')->where('id',$id)->update($st);
            if ($num == '1') {
                return ['txt' => 'show'];
            }
        }
    }

    //编辑案例
    public function edit($id)
    {
        if (request()->isPost()) {
            $data = input('post.');

            $num = Db::name('cases')->where('id',$id)->update($data);

            if ($num >= 0) {
                $this->success('编辑案例成功',url('Cases/lst'));
            } else {
                $this->error('编辑案例失败');
            }

            return;
        }


        $case = Db::name('cases')->where('id',$id)->find();

        $this->assign(array(
            'case' => $case,
            'id' => $id,
        ));
        return view();
    }

    //删除案例
    public function del()
    {
        $id = input('get.id');

        //1.删除案例设备
        $num = Db::name('cases_equipment')->where('cid',$id)->delete();

        //2.删除案例信息
        $nu = Db::name('cases')->where('id',$id)->delete();

        //3.删除案例图片
        $pic = Db::name('cases_pic')->where('cid',$id)->field('pic')->select();
        //删除文件夹中的文件
        foreach ($pic as $key => $val) {
            @unlink("./".$val['pic']);
        }
        $n = Db::name('cases_pic')->where('cid',$id)->delete();

        if ($nu) {
            $this->success('删除案例成功!',url('Cases/lst'));
        } else {
            $this->error('删除案例失败!');
        }
    }

    //删除全部案例
    public function delAll()
    {
        $data = input('post.');
        unset($data['dynamic-table_length']);

        foreach($data['check'] as $key => $val) {

            $num = Db::name('cases')->delete($val);

            //删除案例设备
            $nu = Db::name('cases_equipment')->where('cid',$val)->delete();

            //删除案例图片
            $res = Db::name('cases_pic')->where('cid',$val)->field('pic')->select();
            foreach ($res as $k => $v) {
                unlink("./".$v['pic']);
            }
            $n = Db::name('cases_pic')->where('cid',$val)->delete();
        }

        $this->success('删除案例成功',url('Cases/lst'));
    }
}