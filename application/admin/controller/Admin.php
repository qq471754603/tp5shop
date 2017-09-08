<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/2
 * Time: 下午10:37
 */

namespace app\admin\controller;
use org\Auth;
use think\Db;
use think\Request;
use think\Controller;
class Admin extends Controller{
    public function admin_role(){

        return $this->fetch();
    }
    public function admin_role_add(){
        return $this->fetch();
    }
    public function admin_permission(){
        $data=Db::name('auth_rule')->order('id')->paginate(5);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function admin_permission_add(){
        return $this->fetch();
    }
//    添加权限
    public function admin_permission_add_data(Request $request){
        $data['name']=$_POST['name'];
        $data['title']=$_POST['title'];
        $data['type']=1;
        $data['status']=1;
        $data['addtime']=date('Y-m-d H:i:s',time());
//        dump($request->param());die;
        $result=Db::name('auth_rule')->insertGetId($data);
        if($result){
//            return $this->redirect('admin/admin_permission');
            return  $this->success("成功","admin_permission");
//            echo 1;
        }else{
//            echo 0;
            return $this->error("失败");

        }
    }
    public function admin_permission_del(Request $request){
        $id=$request->param('id');
        $result=Db::name('auth_rule')->delete($id);
        if($result){
            echo 1;
//            return  $this->success("成功","admin_permission",2);
        }else{
            echo 0;
//            return $this->error("失败");
        }
    }
    public function admin_permission_edit(Request $request){
        $id=$request->param('id');
        $data=Db::name('auth_rule')->where('id',$id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function admin_permission_update_data(Request $request){
        $data=$request->except('id');
        $result=Db::name('auth_rule')->where('id',$request->param('id'))->update($data);
        if($result){
            return  $this->success("修改成功");

        }else{
            return $this->error('更新失败');
        }
        return $this->fetch();
    }

}