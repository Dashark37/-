<?php
//定义当前类所在的命名空间
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\Category;
use app\admin\model\Article;
//定义控制器名(和文件名一致)
class TestController extends Controller {

	public function model(){
		echo md5("123456".config('password_salt')); die;
		//实例化模型
		$catModel = new Article();
		//join('其他表 别名','条件','连表类型')
		$data = $catModel
				->field("t1.*,t2.cat_name")//查询指定的字段
				->alias('t1')//当前数据表设置别名
				->join("tp_category t2","t1.cat_id = t2.cat_id","left")
				->select();
				//->taArroy();//设置返回类型
			dump($data);
	}



 	public function  index(Request $request){
 		dump($request);
 		
 	} 

 	public function test(){
 		$cate = new Category();
 		$data = $cate->get(1);
 		dump($data);
 		
 	}
}