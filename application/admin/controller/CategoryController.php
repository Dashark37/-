<?php
namespace app\admin\controller;
use app\admin\model\Category;
use think\Validate;
use app\admin\model\Article;
class CategoryController extends CommonController{

	//ajax删除
	public function ajaxDel(){
		if(request()->isAjax()){
			//1.接收参数cat_id
			$cat_id = input('cat_id');
			//2.判断分类下是否有子分类
			$where = [
				//'pid' => ['=',$cat_id]
				'pid' => $cat_id
			];
			$result1 = Category::where($where)->find();
			if($result1){
				//说明有子分类
				$response = ['code'=>-1,'message'=>'分类下有子分类，无法删除'];
				return json($response);die; //等价于 echo json_encode($response);die
			}
			//3.判断分类下面是否有文章
			$result2 = Article::where(["cat_id"=>$cat_id])->find();
			if($result2){
				//说明有子分类
				$response = ['code'=>-2,'message'=>'分类下有文章，无法删除'];
				return json($response);die; //等价于 echo json_encode($response);die
			}
			//4.只有上面两个条件都满足之后才可以删除分类
			if(Category::destroy($cat_id)){
				$response = ['code'=>200,'message'=>'删除成功'];
				return json($response);die; //等价于 echo json_encode($response);die
			}else{
				$response = ['code'=>-3,'message'=>'删除失败'];
				return json($response);die; //等价于 echo json_encode($response);die
			}
		}
	}

	public function upd(){
		$catModel = new Category();
		//判断是否是post请求
		if (request()->isPost()) {
			//1.接收参数
			$postData =input('post.');
			//2.验证数据 数据 验证器名 提示信息 是否批量验证
			$result = $this->validate($postData,'Category.upd',[],true);
			if ($result !== true) {
				$this->error( implode(',',$result) );
			}

			if ( $catModel->update($postData) ) {
					$this->success('编辑成功',url('admin/category/index'));
			}else{
				$this->error('编辑失败'); //自动打回上一个页面
			}
		}
		

		//接收参数cat_id,取出当前分类的数据
		$cat_id = input('cat_id');
		$catData = $catModel->find($cat_id);
		
		$data = $catModel->select();
		//halt($data);
		//无限极分类处理
		$cats = $catModel->getSonsCat($data);
		//halt($cats);
		//分配模板变量
		return $this-> fetch('',[
			'cats' => $cats,
			'catData' => $catData
		]);
	}

	public function add(){
		$catModel = new Category();
		//判断是否是post提交
		if (request()->isPost()) {
			//接收post参数
			$postData = input('post.'); //获取整个post数组参数

			//使用单独的验证器进行验证数据 数据 验证器名 提示信息 是否批量验证
			$result = $this->validate($postData,'Category.add',[],true);
			if ($result !== true) {

				$this->error( implode(',',$result) );
			}

			/*//验证器验证数据 unique:表名
			//1.定义验证规则
			$rule = [
				//表单字段名 => 验证规则(多个规则用竖线隔开)
				'cat_name' => 'require|unique:category',
				'pid'=> 'require'
			];
			//2.定义验证错误的提示信息
			$message = [
				'cat_name.require' => '分类名称必须填',
				'cat_name.unique' => '分类名称重复',
				'pid.require' => '必须选择一个分类'
			];
			//3.实例化验证器 开始验证数据
			$validate = new Validate($rule, $message); //参数规则,错误提示
			//验证是否通过 batch()批量验证 check()核对
			$result = $validate->batch()->check($postData);
			if(!$result){
				//没有通过 返回错误提示信息
				$this->error( implode(',',$validate->getError()) );
			}*/
			//验证通过之后进行数据入库
			if ($catModel->save($postData)) {
				$this->success('入库成功',url('admin/category/index'));
				
			}else{
				$this->error('入库失败');//自动打回上一页面
			}
		}


		//取出所有的分类,分配到模板中
		$data = $catModel->select()->toArray();

		//对分类数据进行递归处理(含层级缩进关系)
		$cats = $catModel->getSonsCat($data);
		return $this->fetch('',['cats'=>$cats]);
	}

	public function index(){
		//实例化模型
		$catModel = new Category();
		//查询数据 自己连自己查询
		$data =$catModel
			->field('t1.*,t2.cat_name p_name')//指定查询的字段
			->alias('t1')//设置当前数据表的别名
			->join('tp_category t2','t1.pid = t2.cat_id', 'left')//进行关联查询 参数一关联的表名 参数二 查询条件 参数三 连表类型
			->select();
		//进行无限极分类处理 (找子孙分类)
		$cats = $catModel->getSonsCat($data);
		//输出模板视图
		return $this->fetch('',['cats'=>$cats]);
	}

}