<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate{
	//1.定义验证规则
		protected $rule = [
				//表单字段名 => 验证规则(多个规则用竖线隔开)
				'cat_name' => 'require|unique:category',
				'pid'=> 'require'
			];
			//2.定义验证错误的提示信息
		protected $message = [
				'cat_name.require' => '分类名称必须填',
				'cat_name.unique' => '分类名称重复',
				'pid.require' => '必须选择一个分类'
			];
		//定义验证的场景
		protected $scene = [
			//场景名=> ['规则名称' => '规则|规则2']
			//在add场景验证cat_name和pid字段的所有的规则
			'add'=>['cat_name','pid'],
			//在upd场景验证cat_name的require规则和验证pid字段的所有规则
			'upd'=>['cat_name'=>'require','pid']
		];
}