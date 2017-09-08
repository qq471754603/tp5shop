<?php
/**
 * Created by PhpStorm.
 * User: luckly
 * Date: 17/9/1
 * Time: 下午12:11
 */
namespace app\admin\controller;
use think\Controller;
use think\Config;
use org\Auth;
class Index extends Controller{
    public function index(){
//        dump(Config::get('template'));die;
        return $this->fetch();
    }
    public function article_list(){
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }
    public function preg(){
        $str='2017-14-18';
        $tel='18538243005';
        $arr=preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$str,$gg);
        // $arr1=preg_match('/[\d]{11}/',$tel,$max);
        $arr2=preg_match('/^1[3578]{1}[\d]{9}/',$tel,$ter);
        // dump($arr);
        // dump($max[0]);
        dump($gg);
    }
    public function all(){
        $str = "<pre>学习php是一件快乐的事。</pre><pre>所有的phper需要共同努力！</pre>";
        $kw = "php";
        preg_match_all('/<pre>([\s\S]*?)<\/pre>/',$str,$mat);
        for($i=0;$i<count($mat[0]);$i++){
            $mat[0][$i] = $mat[1][$i];
            $mat[0][$i] = str_replace($kw, '<span style="color:#ff0000">'.$kw.'</span>', $mat[0][$i]);
            $str = str_replace($mat[1][$i], $mat[0][$i], $str);
        }
        echo $str;
    }

    public function indexs($name='胡显胜'){
        var_dump($this->request->param());
        $data=Db::name('comment')->find();
        // var_dump($data);
        $this->assign('data',$data);
        $this->assign('name',$name);
        return $this->fetch('index');
    }
    public function url(){
        echo Url::build('url2','a=1&b=2');
        echo '<hr>';
        echo Url('url2','');

    }
    public function url2(){
        echo $this->request->param();
    }
    public function fls(){
        echo 'Route';
    }
    public function cii(){
        echo '路由分组';
    }
    public function hello(){
//        没有继承controll的情况下要用下面
//        $request=Request::instance();
        echo $this->request->url();
        echo '<br>';
//        绑定参数,其它控制器可以直接使用,一般用在登陆上
        $this->request->bind('user_name','胡显胜');
        echo '<br>';
        echo $this->request->user_name;
        echo '<br>';
//        获取所有变量信息
        var_dump($this->request->param());
        echo $this->request->param('fd');
        echo '<br>';
        echo input('fd');
        echo '<br>';
//        助手函数也可以
        echo request()->url();
//         获取get参数
        print_r(request()->get());
        echo '<br>';
//        获取get传参的一个参数
        print_r(input('get.fd'));
//        获取cookie参数
        print_r(input('cookie.name'));
        echo '<br>';
//        获取上传文件信息
        print_r(input('file.image'));
        echo '<br>';
        echo '请求方法'.$this->request->method().'<br>';
        echo '访问IP'.$this->request->ip().'<br>';
        echo '是否AJax请求'.($this->request->isAjax()?'是':'否').'<br>';
        echo '当前域名'.$this->request->domain().'<br>';
        echo '当前入口文件'.$this->request->baseFile() . '<br>';
        echo '包含域名的完整URL地址'.$this->request->url(true).'<br>';
        echo 'URL地址的参数信息'.$this->request->query().'<br>';
        echo 'URL地址中的pathinfo信息'.$this->request->pathinfo().'<br>';
        echo 'URL地址中的后缀信息'.$this->request->ext().'<br>';
        echo '模块'.$this->request->module().'<br>';
        echo '控制器'.$this->request->controller().'<br>';
        echo '方法'.$this->request->action().'<br>';
    }
    public function hello2(){
        $data=['name'=>'thinkphp','status'=>'1'];
//        return $data;
//        return json($data);
//        return xml($data);
        $this->assign('name','模板渲染');
        return $this->fetch('index');
    }
    public function hello3()
    {
//        跳转成功后,跳转到hello方法(注册成功后,跳转到首页)
        $this->success('成功跳转', 'hello');
//        注册失败,重新跳转到注册页面
        $this->error('跳转错误', '/admin/index');
//        方法重定向
        $this->redirect('http://www.baidu.com');
    }
    public function test(){
        //插入记录
        $result=Db::execute("insert into user (id,name,sex,age,addtime)values (1,'胡显胜','男',27,'2017/7/4')");
        dump($result);
        //更新操作
        $result=Db::execute("update user set name='佩佩' where id=1");
//        查询操作
        $result=Db::query("select * from user where id=1");
//        dump($result);
//        删除操作
        $result=Db::execute("delete from user where id=1");
//        显示数据库列表
        $result=Db::query('show tables from tpshop');
        dump($result);
//        清空数据表
        $result=Db::execute('TRUNCATE table tpshop');
//        不同数据库里面的数据表,将databbase里面的配置添加到config里面改名
        $result=Db::connect('db2')->query('select * from username where id=1');
        dump($result);

        $result=Db::connect('db3')->query('select * from orders where id=1');
        dump($result);
//        参数绑定插入
        Db::execute('insert into user (id,name,sex,age,addtime)values(?,?,?,?,?)',[2,'thinkphp','2','28','2017-7-5']);
        $result=Db::query('select * from user where id=?',[2]);
        dump($result);
//        命名占位符绑定
        Db::execute('insert into user (id,name,sex,age,addtime)values(:id,:name,:sex,:age,:addtime)',['id'=>3,'name'=>'佩佩','sex'=>'2','age'=>'29','addtime'=>'2017-9-1']);
        $result=Db::query('select * from user where id=:id',['id'=>3]);
        dump($result);
    }
//    查询构造器
    public function sqls(){
//        插入记录
        Db::table('user')->insert(['id'=>4,'name'=>'插入构造','sex'=>'1','age'=>32,'addtime'=>'2017-9-3']);
//        更新记录
        Db::table('user')->where('id',4)->update(['name'=>'这个是改的']);
//    查询数据
        $result=Db::table('user')->where('id',4)->select();
        dump($result);
//    删除数据
        Db::table('user')->where('id',2)->delete();

//        插入记录
        Db::name('user')->insert(['id'=>2,'name'=>'thinkphp','sex'=>2,'age'=>23,'addtime'=>'2017-4-3']);

//    链式操作
        $list=Db::name('user')
            ->where('id',1)
            ->field('id','name')
            ->order('id','desc')
            ->limit(2)
            ->select();
        dump($list);
    }
    //事物操作,在mysql数据库中请直接设置表类型为InnoDB
//    把需要执行的事物操作封装到闭包里面即可自动完成事务
    public function shiwu(){
        Db::transaction(function (){
//          两条语句同时成功才执行成功,否则回滚
            Db::table('user')->where('id',2)->delete();
            Db::table('user')->insert(['id'=>5,'name'=>'事物成功','sex'=>5,'age'=>89,'addtime'=>'2017-5-6']);
        });
//        手动控制事物的提交
        //启动事务
        Db::startTrans();
        try{
            Db::table('user')->delete(2);
            Db::table('user')->insert(['id'=>6,'name'=>'手动事务','sex'=>'男','age'=>23,'addtime'=>'2017-6-6']);
            echo 'try';
            //提交事务
            Db::commit();
        }catch (\Exception $e){
            echo 'catch';
            //回滚事务
            Db::rollback();
        }
    }
//    数据库查询语言
    public function sele(){
        $result=Db::name('user')->where('id',5)->find();
        $result=Db::name('user')->where('id','<',5)->select();
        $result=Db::name('user')->where('id','between',[3,5])->select();
//        可以写民>= <= <>  in[1,3,5]  between[1,8]
        $result=Db::name('user')->where('name','null')->select();
        dump($result);
//        使用EXP条件表达式,表示后面是原生的SQL语句表达式
        $result=Db::name('user')->where('id','exp',"> 1 and name ='这个是改的'")->select();
        dump($result);
//        使用多个字段查询,两个where之间是and关系
        $result=Db::name('user')
            ->where('id','>',3)
            ->where('age','like','%2%')
            ->select();
        dump($result);
//        或者
        $result=Db::name('user')
            ->where([
                'id'=>['>',3],
                'age'=>['like','%2%'],
            ])->select();
        dump($result);
        echo '<hr>';

//    or和and混合条件查询
        $result=Db::name('user')
            ->where('age','like','%2%')
            ->where('user_id',['in',[3,4,6]],['>=',4],'or')//id和>=是或者关系
            ->limit(5)
            ->select();
        dump($result);
        echo '<hr>';
//批量查询
        $result=Db::name('user')
            ->where('user_id&age','>',0)
            ->limit(2)
            ->select();
        dump($result);
    }
//    关联查询
    public function look(){
        // $result=Db::view('user','id,name,age')
        //     ->view('order',['orderid'=>'order_id','status','addtime'],'user.id'='order.id')
        //     ->where('order.status',1)
        //     ->order('id desc')
        //     ->select();
        //  dump($result);
    }
    public function qu(){
        // 获取某行某列某个值
        $name=Db::name('user')->where('id',5)->value('name');
        dump($name);
        // 获取某列
        $name=Db::name('user')->where('sex',2)->column('name');
        dump($name);
        echo '<hr>';
        // 获取id键名name位值的键值对
        $list=Db::name('user')
            ->where('sex',2)
            ->column('name','id');
        dump($list);
        //获取id键名的数据集
        $list=Db::name('user')
            ->where('sex',2)
            ->column('*','id');
        dump($list);
        // 聚合查询 count max min avg sum
        //统计user表的数据
        $count=Db::name('user')->where('sex',2)->count();
        dump($count);
        //统计user表的最大id
        $max=Db::name('user')->where('sex',2)->max('id');
        dump($max);
        // 建议字符串(用占位符的方式)   简单查询
        $result=Db::name('user')
            ->where("user_id > :id and name like :name",['id'=> 3,'name'=>'%个%'])
            ->select();
        dump($result);
        // 日期查询 建议 日期类型 使用int
        // 查询时间大于2016-1-1的数据,转换为时间戳
        $result=Db::name('user')
            ->whereTime('addtime','>','2017-5-7')
            ->select();
        dump($result);
        echo '<hr>';
        // 查询本周
        $result=Db::name('user')
            ->whereTime('addtime','>','this week')
            ->select();
        dump($result);
        // 查询创建时间在2017-4-1~2017-8-1的数据
        $result=Db::name('user')
            ->whereTime('addtime','between',['2017-4-1','2017-8-1'])
            ->select();
        dump($result);
        // 获取今天的数据,昨天yesterday 本周week 上周 last week
        $result=Db::name('user')
            ->whereTime('addtime','today')
            ->select();
        dump($result);
        // 分块查询(用于一次查多条数据)官网的查询方法
        Db::name('user')
            ->where('age','>',15)
            ->chunk(2,function($list){
                foreach ($list as $data) {
                    // 处理2条记录
                }
            });
        // 改造后
        $p=0;
        do{
            $result=Db::name('user')->limit($p,2)->select();
            $p+=2;
            dump($result);
            // 逻辑处理
        }while(count($result)>0);
    }
    public function userModel(){
//        在上面引入自定义model类
        $a=User::get(5);
        dump($a);

        // 实例化表类
        $user=new User();
        // 插入数据
        $user->name='胡显胜';
        $user->sex=2;
        $user->age=32;
        $user->addtime=date('Y-m-d H:i:s',time());
        // 换一种方法插入
        $user['name']='张佩佩';
        $user['sex']='1';
        $user['age']=18;
        $user['addtime']=date('Y-m-d H:i:s',time());
        // 保存数据
        $user->save();
        // 批量新增
        $user=new User();
        $list=[
            ['name'=>'你是','sex'=>2,'age'=>23,'addtime'=>date('Y-m-d H:i:s',time())],
            ['name'=>'我是','sex'=>1,'age'=>65,'addtime'=>date('Y-m-d H:i:s',time())],
        ];
        if($user->saveAll($list)){
            echo '批量添加成功';
        }

        // 查询数据

        $user=User::get(6);
        echo $user->name;
        // 因为实现了\ArrayAccess,可以将对象像数组一样来访问
        echo $user['name'];
        // 根据某个条件查询数据getByxxx()方法
        // 读取器和修改器
        $user=User::getByAge(55);
        echo $user['age'];
        $user->age=55;
        $user->save();
        echo $user->age;
        echo $user->addtime;

    }
    public function fanwei(){
        // $list=User::scope('sex',2)->all();
        // dump($list);
        $list=User::scope('sex')
            ->scope('age')
            ->scope(function($query){
                $query->order('id','desc');
            })
            ->all();
        dump($list);

    }
    public function insert(){
        // 一对多模型插入
        // $user=Users::get(1);
        // // 获取users对象的comm关联对象
        // $user->comm;
        // // 这是$user->comm是一个属性不能加()
        // foreach ($user->comm as $data) {
        //     echo $data->content."<hr>";
        // }
        // // 会基于user用户的id去查
        // $comm=$user->comm()->where('content','很好,不错')->find();
        // echo "评论id:{$comm->comment_id} 用户评论内容:{$comm->content}";
        // die;

        // 会将当前用户的id添加进去
        // $user=Users::get(1);
        // $comment=new Comment;
        // // dump($comment);die;
        // $comment->content='thinkphp5视频教程';
        // $comment->addtime=time();
        // $user->comm()->save($comment);
        // return '添加评论成功';


        // 一对多批量新增
        // $user=Users::get(1);
        // $comment=[
        //     ['content'=>'批量1','addtime'=>time()],
        //     ['content'=>'批量2','addtime'=>time()],
        // ];
        //   $user->comm()->saveAll($comment);
        //     return '添加comm成功';
        // $user=User::get(1);
        // echo User::getLastSql();

        // 关联查询
        // $user=Users::get(1);
        // Users::get(1,'comm');
        // $comm=$user->comm;
        // dump($comm);

        //关联过滤查询
        // $user=Users::get(1);
        // // //获取状态为1的关联数据
        // $comment=$user->comm()->where('is_show',1)->select();
        // // dump($comment);
        // foreach ($comment as $comm) {
        //     echo '评论是'.$comm->content;
        // }

        // $comm=$user->comm()->getByContent('很好,不错');
        // echo "评论id: {$comm->comment_id} 用户评论内容:{$comm->content}";


        // 根据关联数据来查询当前数据模型
        //查询有评论过的用户列表
        // $user=Users::has('comm')->select();

        //查询评论过2次以上的用户
        // $user=Users::has('comm','>=',2)->select();
        //查询评论内容含有(是)的用户
        // $user=Users::hasWhere('comm',['content'=>'是的'])->select();
        // dump($user);

        // 关联更新
        // $user=Users::get(1);
        // $comm=$user->comm()->getByContent('是的');
        // $comm->content="thinkphp快速入门";
        // $comm->save();


        //查询构建器的update方法进行更新
        // $user=Users::get(1);
        // $user->comm()->where('content','是的')->update(['content'=>'这是个牛X的东西']);


        // 删除部分关联数据
        // $user=Users::get(1);
        //删除部分关联数据
        // $comm=$user->comm()->getByContent('是的');
        // $comm->delete();


        //删除所有的关联数据
        // $user=Users::get(1);
        // $user->comm()->delete();


        // 一对一
        // $user=Users::get(2);
        // echo '用户id'.$user->car->uid.'<br>车品牌:'.$user->car->brand.'<br>车牌号:'.$user->car->plate_number.'<br>';
        //     echo $user->getLastSql();

        // 新增用户 关联汽车
        $user=new Users;
        $user->email='2311@qq.com';
        $user->name='小张';
        $user->birthday='1989-10-12';
        if($user->save()){
            $car['brand']='奔驰';
            $car['plate_number']='鄂A66666';
            // uid不指定
            $user->car()->save($car);
            return '用户'.$user->name.'新增成功<br>';
        }else{
            return $user->getError();
        }
    }
    // 关联查询
    public function guan(){
        $user=Users::get(2);
        echo $user->email;
        echo $user->car->brand;
        echo $user->car->plate_number;
    }
    // 关联更新
    public function huan(){
        $user=Users::get(1);
        $user->email='Thinkdphp@qq.com';
        if($user->save()){
            $user->car->plate_number='皖A333333';
            $user->car->brand='奇瑞QQ';
            $user->car->save();
            return '用户更新成功';
        }else{
            return $user->getError();
        }
    }
    public function shan(){
        //关联删除
        $user=Users::get(2);
        if($user->delete()){
            //删除关联数据
            $user->car->delete();
            return '用户'.$user->email.'删除成功';
        }else{
            return $user->getError();
        }
    }
    //多对多
    public function wuliu(){
        $region=Region::getByName('北京市');
        // 新增配送区域,并自动写入枢纽表
        $region->shippingArea()->save(['shipping_area_name'=>'中国首都']);

    }
    public function lian(){
        //多对多关联
        // region地区表
        // shipping_area物流配置表
        // tp_area_region地区对应表
        //关联新增
        // 给某个地区增加编辑配送区域,并且由于这个配送区域还没创建过,所以可以使用下面这个方法
        $region=Region::get(28558);
        //新增配送区域,并自动写入枢纽表,这里会写入关联的id
        $region->shippingArea()->save(['shipping_area_name'=>'一线城市']);
        // 给当前用户新增多个用户角色
        $region->shippingArea()->saveAll([
            ['shipping_area_name'=>'珠三角'],
            ['shipping_area_name'=>'全国一线城市'],
        ]);
        return '配送区域新增成功';

        // 给一个地区添加一个现有的配送区域
        $shippingArea=ShippingArea::get(2);
        $shippingArea=ShippingArea::getByShippingAreaName('珠三角');
        //添加枢纽表数据(使用attach方法增加中间表数据)
        $region->shippingArea()->attach($shippingArea);
        $region->shippingArea()->attach(63);
        return '配送区域新增成功';


        //关联删除
        $region=Region::getByName('北京市');
        $shippingArea=ShippingArea::get(2);
        //删除关联数据,但不删除关联模型数据
        $region->shippingArea()->detach($shippingArea);
        //如果有必要,也可以删除枢纽表的同时删除关联模型
        $region->shippingArea()->detach($shippingArea,true);
        return '配送区域删除成功';



        // 关联查询
        $reigon=Region::get(28558);
        echo $region->shippingArea[0]->shipping_area_name.'===<br>';
        echo $region->shippingArea[1]->shipping_area_name.'===<br>';
    }

    public function mo(){
        $user=Users::get(4);
        dump($user->toArray());
        // 隐藏属性数据
        // dump($user->hidden(['name','birthday','time'])->toArray());
        //指定显示
        // dump($user->visible(['name','email'])->toArray());
        dump($user->append(['status'])->toArray());
        // 获取指定原始数据
        dump($user->getData('status'));
        // 获取全部原始数据
        dump($user->getData());
        dump($user->toJson());
        echo Users::get(1);

    }
    // 遍历数据到前端
    public function list5(){
        $list=Users::where('user_id','>',0)->select();

        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
    }

    // 数据分页
    public function list(){
        //每页显示2条数据
        $list=Users::paginate(1);
        // dd($list);
        // echo Users::getLastSql();
        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
    }
    public function test28(){

        $list=Usrs::where('user_id','>',0)->select();
        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
    }
    public function test40(){
        // session_start();
        // echo $_SESSION['aa']
        // setCookie('bb',55);
        //设置
        // 设置cookie有效期3600秒
        Cookie::set('user_name','胡显胜',900);
        echo Cookie::get('user_name');
        // 支持数组
        Cookie::set('teacher',['a'=>'zhang','b'=>'wang','chen','zhao']);
        // dd(Cookie::get('teacher'));
        // 建议的读取cookie数据的方法是通过Request请求对象的cookie方法
        echo '<hr>';
        echo $this->request->cookie('user_name');

        // 判断
        echo Cookie::has('user_name');

        //删除cookie
        Cookie::delete('user_name');

        // 清空指定前缀的cookie
        Cookie::clear('think');






        //助手函数
        // 初始化
        cookie(['prefix'=>'think','expire'=>3600]);
        //设置
        cookie('name','value123',3899);
        //判断
        echo cookie('?name');
        //获取
        echo cookie('name');
        //删除
        cookie('name','null');
        //清除
        cookie(null,'think');
    }
    // 验证码
    public function test41(){

    }
}