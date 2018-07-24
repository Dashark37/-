<?php
//定义当前类所在的命名空间
namespace app\admin\controller;
use think\Controller;
//定义控制器名(和文件名一致)
class TestController extends Controller {
 	public function  index(){
 		return "我最爱南瓜 南瓜最爱鲨鱼";
 	} 

 	public function test(){
 		//$this->success($msg,$url,$data,$time)
 		$this->success("操作成功",url('/top'),'',2);
 		//失败的话 第二个参数不用写,直接打回上一页
 	}
}