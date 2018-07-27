<?php
namespace app\admin\controller;
use app\admin\model\Category;
class CategoryController extends CommonController{

	public function add(){
		$catModel = new Category();
		//取出所有的分类,分配到模板中
		$data = $catModel->select()->toArray();
		//对分类数据进行递归处理(含层级缩进关系)
		$cats = $catModel->getSonsCat($data);
		return $this->fetch('',['cats'=>$cats]);
	}
}