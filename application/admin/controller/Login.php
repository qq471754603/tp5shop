<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午1:27
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller{
    public function index(){
        return $this->fetch();
    }
}