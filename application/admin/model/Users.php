<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/6
 * Time: 下午4:15
 */
namespace app\admin\model;
use think\Model;
class Users extends Model{
    //设置数据表(不含前缀)
    // protected $name='user';
    //类型转换
    protected $type=array(
        // 数据处理
        'addtime'=>'timestamp:Y-m-d',
    );
    // 查询范围age
    protected function scopeAge($query){
        // scope+查询范围
        $query->where('age,32');
    }
    //sex查询
    protected function scopeSex($query){
        $query->where('sex',2);
    }
    // 全局查询范围
    protected static function base($query){
        // $query->where('user_id',1);
    }
    //定义关联方法
    public function car(){
        return $this->hasOne('Car','uid','user_id');
    }

    //定义关联方法
    public function comm(){
        return $this->hasMany('comment','uid','user_id');
    }
    // status修改器
    protected function getStatusAttr($value){
        $status=[-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }
}
