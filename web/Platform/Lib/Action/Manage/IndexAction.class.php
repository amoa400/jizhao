<?php

class IndexAction extends Action {

	// 控制台首页
	public function index() {
		isLogin();
		$this->display();
	}
}