<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午4:16
 */
namespace app\admin\validate;
use think\Validate;
class Users extends Validate{
    //验证规则
    protected $rule=[
        ['name','require|min:5','昵称必须|昵称不能短于5个字符'],
        ['email','email','邮箱格式错误'],
        ['birthday','dateFormat:Y-m-d','生日格式错误'],
        // ['email','checkEmail:qq.com','必须包含qq.com'],
    ];
    protected function checkMail($value,$rule){
        $result=strstr($value,$rule);
        if($result){
            return true;
        }else{
            return "邮箱必须包含 $rule 域名";
        }
    }
}