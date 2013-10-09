<?php

class IndexAction extends Action {

	public function index() {
		$tabList = array();
		$tabList[] = array('name' => '面试管理', 'icon' => 'user1', 'url' => '/ois/ois_interview/showList');
		$tabList[] = array('name' => '面试官管理', 'icon' => 'user1', 'url' => '/ois/ois_interviewer/showList');
		$tabList[] = array('name' => '模板管理', 'icon' => 'user1', 'url' => '/ois/ois_template/showList');
		
		$this->assign('tabList', $tabList);
		$this->assign('pageTitle', '在线面试');
		$this->display('../Manage/Product/index');
	}

}