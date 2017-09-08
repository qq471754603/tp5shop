<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午4:11
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Url;
use think\Cookie;
use app\admin\model\Users;//引入自定义model类
class Product extends Controller{
    // 商品品牌加载
    public function product_brand(){
        return $this->fetch();
    }
    //分类模板加载
    public function product_category(){

        return $this->fetch();
    }
    public function product_category_add(){
        $data=Db::name('goods_type')->select();
        // 引入扩展类
        $tree=\org\Data::tree($data,'name','id');
//        dump($tree);
        $this->assign('list',$tree);
        return $this->fetch();
    }
    public function product_list(){
//        $result=Db::name('product')->select();
//        $this->assign('list',$result);
        return $this->fetch();
    }
//    添加分类
    public function product_add_data(Request $request){
//        id,pid,path,name字段
        if(empty($this->request->param('path'))){
            $data['name']=$this->request->param('name');
            //获取插入数据的id
            $id=Db::name('goods_type')->insertGetId($data);
            $list['path']='0,'.$id;
            //插入路径
            $insert=Db::name('goods_type')->where('id',$id)->update($list);
            echo '<script>alert("添加顶级分类***'.$data['name'].'***成功");parent.location.href="product_category"</script>';
        }elseif(!empty($this->request->param('path'))){
            $data['path']=$this->request->param('path');
            $data['name']=$this->request->param('name');
            // 获取选择分类的id
            $pid=explode(',',$data['path']);
            $data['pid']=array_pop($pid);
            $id=Db::name('goods_type')->insertGetId($data);
            // 拼接新插入分类的path路径
            $list['path']=$data['path'].','.$id;
            $result=Db::name('goods_type')->where('id',$id)->update($list);
//             echo '<script>alert("添加子分类***'.$data['name'].'***成功");location.replace(location.href)</script>';
            echo '<script>alert("添加子分类***'.$data['name'].'***成功");parent.location.href="product_category"</script>';
        }
    }
    // ajax获取分类
    public function product_ajax(){
        $m=Db::name('goods_type')->field('id,name,pid')->select();
        echo  json_encode($m);
    }
    //删除分类
    public function product_del(){
        $list=Db::name('goods_type')->where('pid','=',$_GET['id'])->select();
        if($list){
            echo 0;
        }else{
            $result=Db::name('goods_type')->where('id',$_GET['id'])->delete();
            echo 1;
        }
    }
// 获取商品分类
    public function product_add(){
//             $a=array(1=>5,5=>8,22,2=>'8',81);
//             dump($a);
//         Echo $a[7];
//         Echo $a[6];

//         $a[bar]='hello';
// //数组下标为bar的常量值，若bar不是常量，则为bar字串
//         echo $a[bar];
//         echo $a['bar'];

        // Echo $a[3];
//        die;
        $data=Db::name('goods_type')->select();
        // 引入扩展类
        $tree=\org\Data::tree($data,'name','id');
        $this->assign('list',$tree);
        return $this->fetch();
    }
    //添加商品
    public function product_goods_add(Request $request){
        // 获取表单数据
        $data=input('post.');
        dump($data);die;
        // 获取表单上传文件
        $files = $this->request->file('imagepath');
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads');
            // 将文件名组装起来
            $item[]=$info->getSaveName();
        }
        // 拼接文件名
        $data['imagepath']=implode(',',$item);
        $str=explode(',',$_POST['tid']);
        $data['tid']=$str[0];
        $data['tpid']=$str[1];
        $result=Db::name('product')->insert($data);
        return $this->success('添加商品成功','index/product_add');
    }
    public function product_add_images(){
        $up = new \org\Upload();
    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
//        路径一定要设置好,上传时路径和用图片时的路径不一样
    $up -> set("path",ROOT_PATH . 'public' . DS . 'uploads' );
    $up -> set("maxsize", 2000000);
    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
    $up -> set("israndname", true);
    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
    if($up -> upload("pic")) {
        $name=$up->getFileName();
        $data['filepath']='/uploads/'.$name[0];
        $result=Db('goods_files')->insertGetId($data);
        $file=['id'=>$result,'imagepath'=>$data['filepath']];
        echo json_encode($file);
    } else {
        echo '<pre>';
//        //获取上传失败以后的错误提示
        var_dump($up->getErrorMsg());
        echo '</pre>';
    }



    }
    public function product_del_images(Request $request){
        $id=$request->param('id');
        $image=Db::name('goods_files')->where('id',$id)->find();
//        拼接ROOT_PATH这个很重要,和上传时一样
        $imagepath=ROOT_PATH.'public'.$image['filepath'];
//        dump($imagepath);
        $result=Db::name('goods_files')->delete($id);
        if($result){
            unlink($imagepath);
            echo 1;
        }else{
            echo 0;
        }
    }

    public function preg(){
        $str="2017-11-23";
        $arr=preg_match("/2017/", $str);
        dump($arr);

    }
    // 正则
    public function pregs(){
        $str='2017-14-18';
        $tel='18538243005';
        $arr=preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$str,$gg);
        // $arr1=preg_match('/[\d]{11}/',$tel,$max);
        $arr2=preg_match('/^1[3578]{1}[\d]{9}/',$tel,$ter);
        // dump($arr);
        // dump($max[0]);
        dump($gg);
    }
}