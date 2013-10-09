<?php

class OisInterviewerAction extends Action {

	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['table'] = 'OisInterviewer';
		$const['toolbar'] = array(
			'create' => array('on' => 1),
			'delete' => array('on' => 1),
		);
		$const['hideField'] = array();
		$const['linkField'] = array(
			'name' =>		
				array('/ois/ois_interviewer/show/interviewer_id/{$0$}', array('interviewer_id')),
		);
		$const['page'] = $_GET['page'];
		
		A('Base/Common')->showList($const);
	}
	
	// 创建
	public function create() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['table'] = 'OisInterviewer';
		$const['fieldWidth'] = '0';
		$const['hideField'] = array('interviewer_id');
		
		A('Base/Common')->create($const);
	}
	
	// 创建操作
	public function createDo() {
		$data = $_POST;

		$const = array();
		$const['table'] = 'OisInterviewer';
		$const['jumpUrl'] = '/ois/ois_interviewer/show/interviewer_id/';
		A('Base/Common')->createDo($data, $const);
	}
	
	// 编辑
	public function edit() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['table'] = 'OisInterviewer';
		$const['id'] = $_GET['interviewer_id'];
		$const['disableField'] = array('interviewer_id');
		
		A('Base/Common')->edit($const);
	}
	
	// 编辑完成
	public function editDo() {
		$data = $_POST;
		
		$const = array();
		$const['table'] = 'OisInterviewer';
		$const['jumpUrl'] = '/ois/ois_interviewer/show/interviewer_id/' . $data['interviewer_id'];
		A('Base/Common')->editDo($data, $const);
	}
	
	// 显示
	public function show() {
		$const = array();
		$const['title'] = '面试官';
		$const['group'] = 'ois';
		$const['action'] = 'interviewer';
		$const['table'] = 'OisInterviewer';
		$const['id'] = $_GET['interviewer_id'];
		
		A('Base/Common')->show($const);
	}
	
	// 删除
	public function delete() {
		$const = array();
		$const['table'] = 'OisInterviewer';
		$const['id'] = $_GET['interviewer_id'];
		$const['close_window'] = $_GET['close_window'];
		
		A('Base/Common')->delete($const);
	}
	
	// 删除多个
	public function deleteList() {
		$const = array();
		$const['table'] = 'OisInterviewer';
		$const['idList'] = $_GET['id_list'];
		
		A('Base/Common')->deleteList($const);
	}
	
	// 格式化
	public function format($interviewer) {
		return $interviewer;
	}
	
}