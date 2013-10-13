<?php

class OisInterviewAction extends Action {
	
	// 创建
	public function create() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['showField'] = array('name', 'talent_id', 'interviewer_id', 'start_time_int', 'remark');
		$const['specialField'] = array(
			'start_time_int' =>
				array('datetime'),
			'talent_id' =>
				array('namePicker', '/base/common/getIdNameList/group/rms/action/talent'),
			'interviewer_id' =>
				array('namePicker', '/base/common/getIdNameList/group/ois/action/interviewer'),
		);
		
		A('Base/Common')->create($const);
	}

	// 编辑
	public function edit() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['id'] = $_GET['interview_id'];
		$const['disableField'] = array('interview_id');
		$const['showField'] = array('interview_id', 'name', 'talent_id', 'interviewer_id', 'status_id', 'start_time_int', 'remark');
		$const['specialField'] = array(
			'start_time_int' =>
				array('datetime'),
			'talent_id' =>
				array('namePicker', '/base/common/getIdNameList/group/rms/action/talent'),
			'interviewer_id' =>
				array('namePicker', '/base/common/getIdNameList/group/ois/action/interviewer'),
		);
		
		A('Base/Common')->edit($const);
	}
	
	// 显示
	public function show() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['id'] = $_GET['interview_id'];
		$const['showField'] = array('interview_id', 'name', 'talent_name', 'interviewer_name', 'status', 'start_time', 'remark', 'real_start_time', 'real_end_time', 'evaluation');
		$const['linkField'] = array(
			'talent_name'		=>	'/rms/rms_talent/show/talent_id/{talent_id}',
			'interviewer_name'	=>	'/ois/ois_interviewer/show/interviewer_id/{interviewer_id}',
		);
		
		A('Base/Common')->show($const);
	}
	

	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['toolbar'] = array(
			'create' => array('on' => 1),
			'delete' => array('on' => 1),
		);
		$const['showField'] = array('interview_id', 'name', 'talent_name', 'interviewer_name', 'start_time', 'status');
		$const['linkField'] = array(
			'name' =>		
				array('/ois/ois_interview/show/interview_id/{$0$}', array('interview_id')),
			'talent_name' =>		
				array('/rms/rms_talent/show/talent_id/{$0$}', array('talent_id')),
			'interviewer_name' =>		
				array('/ois/ois_interviewer/show/interviewer_id/{$0$}', array('interviewer_id')),
		);
		$const['showFilterField'] = array('interview_id', 'name', 'remark', 'talent_name', 'interviewer_name',  'status_id', 'start_time_int', 'real_start_time_int', 'real_end_time_int');
		$const['specialFilterField'] = array(
			'start_time_int' =>
				array('timeBetween'),
			'real_start_time_int' =>
				array('timeBetween'),
			'real_end_time_int' =>
				array('timeBetween'),
		);
		$const['moreField'] = array(
			array('进入房间', array('/ois/ois_room/show/id/{$0$}', array('interview_id'), '_blank')),
			array('通知面试者'),	// TODO
			array('通知面试官'),	// TODO
		);
		$const['page'] = $_GET['page'];
		$const['order'] = array('interview_id', 'DESC');
		
		A('Base/Common')->showList($const);
	}
	
	// 格式化
	public function format($interview) {
		// 时间
		$interview['start_time'] = IntToTime($interview['start_time_int']);
		if (empty($interview['real_start_time_int'])) $interview['real_start_time'] = '--';
		else $interview['real_start_time'] = IntToTime($interview['real_start_time_int']);
		if (empty($interview['real_end_time_int'])) $interview['real_end_time'] = '--';
		else $interview['real_end_time'] = IntToTime($interview['real_end_time_int']);
		// 状态
		switch ($interview['status_id']) {
			case 1:
				$interview['status'] = '未开始';
				break;
			case 2:
				$interview['status'] = '已开始';
				break;
			case 3:
				$interview['status'] = '已结束';
				break;
			case 4:
				$interview['status'] = '已评价';
				break;
		}
		// 备注
		if (empty($interview['remark'])) $interview['remark'] = '--';
		else $interview['remark'] = nl2br($interview['remark']);
		// 评价
		if (empty($interview['evaluation'])) $interview['evaluation'] = '--';
		
		return $interview;
	}
}