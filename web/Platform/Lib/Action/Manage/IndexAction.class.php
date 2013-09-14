<?php

class IndexAction extends Action {

	// 控制台首页
	public function index() {
		isLogin();
		$this->assign('pageTitle', '首页');
		$this->display();
	}
}