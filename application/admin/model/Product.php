<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午7:33
 */
namespace app\admin\model;
use think\Model;
class Product extends Model{
//    数据列表
   static public function datalist(){
       $product=new Product();
       $data=where('goods_type')->select();
        return $tree=\org\Data::tree($data,'name','id');
    }
}