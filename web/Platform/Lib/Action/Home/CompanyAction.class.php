<?php

class CompanyAction extends Action {

	// =================================================
	// 注册
	// =================================================

	// 注册页面
    public function register(){
		$this->display();
    }
	// 注册处理
	public function registerDo() {
		$ret = array();
		$ret['error'] = false;
		// 公司名称（至多50个字）
		if (mb_strlen($this->_post('realname'), 'utf8') == 0 || mb_strlen($this->_post('realname'), 'utf8') > 50) {
			$ret['realname'] = '公司名称长度不能少于1位多于50位';
			$ret['error'] = true;
		}
		else 
		if (D('Base/Company')->isExist('realname', $this->_post('realname'))) {
			$ret['realname'] = '该公司名称已存在';
			$ret['error'] = true;
		}
		// 电子邮箱（至多50个字）
		if (mb_strlen($this->_post('email'), 'utf8') == 0 || mb_strlen($this->_post('email'), 'utf8') > 40) {
			$ret['email'] = '电子邮箱长度不能少于1位多于40位';
			$ret['error'] = true;
		}
		else
		if (!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $this->_post('email'))) {
		
			$ret['email'] = '电子邮箱格式不正确';
			$ret['error'] = true;
		}
		else
		if (D('Base/User')->isExist('email', $this->_post('email'))) {
			$ret['email'] = '该电子邮箱地址已存在';
			$ret['error'] = true;
		}
		// 密码
		if (mb_strlen($this->_post('password'), 'utf8') < 6 || mb_strlen($this->_post('password'), 'utf8') > 20) {
			$ret['password'] = '密码长度不能少于6位多于20位';
			$ret['error'] = true;
		}
		// 重复密码
		if (mb_strlen($this->_post('rePassword'), 'utf8') < 6 || mb_strlen($this->_post('rePassword'), 'utf8') > 20) {
			$ret['rePassword'] = '密码长度不能少于6位多于20位';
			$ret['error'] = true;
		}
		else
		if ($this->_post('password') != $this->_post('rePassword')) {
			$ret['rePassword'] = '两次输入的密码不一致';
			$ret['error'] = true;
		}
		// 注册
		if (!$ret['error']) {
			$company_id = D('Base/Company')->c();
			$data = array();
			$data['company_id'] = $company_id;
			$data['user_id'] = 1;
			$data['role'] = 1;
			$data['email'] = $this->_post('email');
			$data['password'] = $this->_post('password');
			$data['realname'] = '管理员';
			D('Base/User')->c($data);
			$this->loginDo(array('email' => $this->_post('email'), 'password' => $this->_post('password')));
		}
		// 返回
		$this->ajaxReturn($ret);
	}
	// 注册验证
	public function registerCheck() {
		$data = array();
		if ($this->_post('name') == 'realname' && D('Base/Company')->isExist($this->_post('name'), $this->_post('data')))
			$data['error'] = '该公司名称已存在';
		if ($this->_post('name') == 'email' && D('Base/User')->isExist($this->_post('name'), $this->_post('data')))
			$data['error'] = '该电子邮箱地址已存在';
		$this->ajaxReturn($data);
	}
	
	// =================================================
	// 登录
	// =================================================
	
	// 登录页面
	public function login() {
		$this->display();
	}
	// 登录处理
	public function loginDo($data = 0) {
		if (!empty($data)) $_POST = $data;
		$user = D('Base/User')->rByName('email', $this->_post('email'));
		if (empty($user)) {
			$this->ajaxReturn(array('error' => '电子邮箱不存在'));
		} else {
			if ($user['password'] != encrypt($this->_post('password')))
				$this->ajaxReturn(array('error' => '登录密码错误'));
			else {
				$company = D('Base/Company')->r($user['company_id']);
				$data = $user;
				$data['user_name'] = $user['realname'];
				$data['company_name'] = $company['realname'];
				$this->loginSucceed($data);
			}
		}
	}
	// 登录成功
	public function loginSucceed($data) {
		$_SESSION['login'] = 1;
		$_SESSION['role'] = $data['role'];
		$_SESSION['company_id'] = $data['company_id'];
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['company_name'] = $data['company_name'];
		$_SESSION['user_name'] = $data['user_name'];
	}
	// 登出
	public function logout() {
		unset($_SESSION['login']);
		unset($_SESSION['role']);
		unset($_SESSION['company_id']);
		unset($_SESSION['user_id']);
		unset($_SESSION['company_name']);
		unset($_SESSION['user_name']);
		unset($_SESSION);
		$this->redirect('/');
	}
}