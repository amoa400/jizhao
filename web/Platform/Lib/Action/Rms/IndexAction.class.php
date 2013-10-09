<?php

class IndexAction extends Action {

	public function index() {
		$tabList = array();
		$tabList[] = array('name' => '求职者管理', 'icon' => 'user1', 'url' => '/rms/rms_talent/showList');
		$tabList[] = array('name' => '职位管理', 'icon' => 'user1', 'url' => '/rms/rms_position/showList');

		$this->assign('tabList', $tabList);
		$this->assign('pageTitle', '招聘管理');
		$this->display('../Manage/Product/index');
	}

}