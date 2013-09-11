<?php

class ManageAction extends Action {
	
	// 概览
	public function overview() {
		isLogin();
		$this->assign('controlName', '概览');
		$this->display();
	}
	
	// 面试管理
	public function interview() {
		isLogin();
		$this->assign('controlName', '面试管理');
		$this->display();
	}
	
}