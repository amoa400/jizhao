<?php

class RmsPositionAction extends Action {
	// 初始化
	public function _initialize() {
		isLogin(1);
	}
	
	// 创建
	public function create() {
		$const = array();
		$const['title'] = '职位';
		$const['group'] = 'rms';
		$const['action'] = 'position';
		$const['showField'] = array('name', 'description', 'requirement');
		
		A('Base/Common')->create($const);
	}
	
	// 修改职位
	public function edit() {
		$const = array();
		$const['title'] = '职位';
		$const['group'] = 'rms';
		$const['action'] = 'position';
		$const['id'] = $_GET['position_id'];
		$const['disableField'] = array('position_id');
		$const['showField'] = array('position_id', 'name', 'description', 'requirement', 'status_id');
		
		A('Base/Common')->edit($const);
	}
	
	// 显示职位
	public function show() {
		$const = array();
		$const['title'] = '职位';
		$const['group'] = 'rms';
		$const['action'] = 'position';
		$const['id'] = $_GET['position_id'];
		$const['showField'] = array('position_id', 'name', 'description', 'requirement', 'enrollment', 'create_time', 'status');
		
		A('Base/Common')->show($const);
	}

	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '职位';
		$const['group'] = 'rms';
		$const['action'] = 'position';
		$const['toolbar'] = array(
			'create' => array('on' => 1),
			'delete' => array('on' => 1),
		);
		$const['showField'] = array('position_id', 'name', 'description', 'enrollment', 'create_time', 'status');
		$const['linkField'] = array(
			'name' =>		
				array('/rms/rms_position/show/position_id/{$0$}', array('position_id')),
		);
		$const['showFilterField'] = array('position_id', 'name', 'enrollment',  'status_id', 'create_time_int');
		$const['specialFilterField'] = array(
			'enrollment' =>
				array('between'),
			'create_time_int' =>
				array('timeBetween'),
		);
		$const['moreField'] = array(
			array('停止发布'),
			array('发布职位'),
			array('关闭职位'),
		);
		$const['page'] = $_GET['page'];
		$const['order'] = array('position_id', 'DESC');
		
		A('Base/Common')->showList($const);
	}
	
	// 格式化
	public function format($position) {
		// 时间
		$position['create_time'] = IntToTime($position['create_time_int']);
		// 状态
		switch ($position['status_id']) {
			case 1:
				$position['status'] = '未发布';
				break;
			default:
				$position['status'] = '未知';
		}
		return $position;
	}
}