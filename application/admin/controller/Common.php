<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午1:32
 */

namespace app\admin\controller;


use think\Controller;

class Common extends Controller{
    protected function _initialize(){
        if(!session('id')||session('name')){
            $this->error('您尚未登录系统',url('login/index'));
        }
    }
}