<?php
namespace app\admin\model;
use think\Model;
class User extends Model{
	public function checkUser($username, $password){
		$where = [
		'username' => $username,
		'password' => md5($password.config('password_salt')),
	];
	$userInfo = $this->where($where)->find(); 
	if($userInfo){
		//用户信息存储到session中去
		session('user_id',$userInfo['user_id']);
		session('username',$userInfo['username']);
		return true;
	}else{
		return false;
	}

	}
}