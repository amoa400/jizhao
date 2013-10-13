<?php

class OisInterviewerAction extends Action {

	// 创建
	public function create() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['showField'] = array('name', 'email', 'phone');
		
		A('Base/Common')->create($const);
	}
	
	// 编辑
	public function edit() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['id'] = $_GET['interviewer_id'];
		$const['disableField'] = array('interviewer_id');
		$const['showField'] = array('interviewer_id', 'name', 'email', 'phone');
		
		A('Base/Common')->edit($const);
	}
	
	// 显示
	public function show() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['id'] = $_GET['interviewer_id'];
		$const['showField'] = array('interviewer_id', 'name', 'email', 'phone');
		
		A('Base/Common')->show($const);
	}
	
	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['toolbar'] = array(
			'create' => array('on' => 1),
			'delete' => array('on' => 1),
		);
		$const['showField'] = array('interviewer_id', 'name', 'email', 'phone');
		$const['linkField'] = array(
			'name' =>		
				array('/ois/ois_interviewer/show/interviewer_id/{$0$}', array('interviewer_id')),
		);
		$const['showFilterField'] = array('interviewer_id', 'name', 'email', 'phone');
		$const['specialFilterField'] = array();
		$const['moreField'] = array(
			array('发邮件'),	// TODO
			array('发短信'),	// TODO
		);
		$const['page'] = $_GET['page'];
		$const['order'] = array('interviewer_id', 'DESC');
		
		A('Base/Common')->showList($const);
	}
	
	// 格式化
	public function format($interviewer) {
		return $interviewer;
	}	
}