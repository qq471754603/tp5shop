<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/4
 * Time: 上午8:26
 */

namespace app\admin\controller;
use think\Controller;

class Picture extends Controller {
    public function picture_add(){
        return $this->fetch();
    }
    public function picture_list(){
        return $this->fetch();
    }
    public function picture_show(){
        return $this->fetch();
    }

}