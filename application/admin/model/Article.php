<?php 
namespace app\admin\model;
use think\Model;
class Article extends Model{
	//时间戳自动维护
	protected $autoWriteTimestamp = true;
	//当时间字段不为create_time和update_time，通过以下属性指定
	protected $createTime = "create_at";
}