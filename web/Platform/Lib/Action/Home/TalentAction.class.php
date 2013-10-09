<?php

class TalentAction extends Action {

	// =================================================
	// 首页
	// =================================================
	
	public function index() {
		$this->display();
	}

	// =================================================
	// 登录
	// =================================================
	
	// 登录页面
	public function login() {
		$company = D('Base/Company')->r($_GET['id']);
		$this->assign('company', $company);
		$this->display();
	}

	// 登录处理
	public function loginDo() {
		$data = $_POST;
		//$data['company_id'] = 1;
		//$data['password'] = '1';
		
		$_SESSION = array();
		$_SESSION['company_id'] = (int)$data['company_id'];
		
		$flag = false;
		
		$talent = D('Rms/RmsTalent')->rByName('password', $data['password']);
		if (!empty($talent)) {
			$info['role'] = 3;
			$info['user_id'] = $talent['talent_id'];
			$info['user_name'] = $talent['name'];
			$this->loginSucceed($info);
			$this->ajaxReturn(array('status' => 'succeed', 'jumpUrl' => '/talent'));
		} else $this->ajaxReturn(array('status' => 'fail'));
	}

	// 登录成功
	public function loginSucceed($data) {
		$_SESSION['login'] = 1;
		$_SESSION['role'] = $data['role'];
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['user_name'] = $data['user_name'];
		if (!empty($_SESSION['company_id'])) {
			$company = D('Base/Company')->r($_SESSION['company_id']);
			$_SESSION['company_name'] = $company['realname'];
		}
	}

	// 登出
	public function logout() {
		$_SESSION = array();
		$this->redirect('/talent/login/id/1');
	}
}