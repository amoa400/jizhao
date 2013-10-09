<?php

class OisInterviewAction extends Action {

	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['table'] = 'OisInterview';
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
		$const['hideFilterField'] = array('talent_id', 'interviewer_id', 'status', 'start_time', 'real_start_time', 'real_end_time');
		$const['specialFilterField'] = array(
			'start_time_int' =>
				array('timeBetween'),
			'real_start_time_int' =>
				array('timeBetween'),
			'real_end_time_int' =>
				array('timeBetween'),
		);
		$const['moreList'] = array(
			array('进入房间'),
			array('通知面试者'),
			array('通知面试官'),
		);
		$const['page'] = $_GET['page'];
		$const['order'] = array('interview_id', 'DESC');
		
		A('Base/Common')->showList($const);
	}
	
	// 创建
	public function create() {
		$talent = D('Rms/RmsTalent')->r($_GET['talent_id']);
		
		$this->assign('talent', $talent);
		$this->assign('tabTitle', '新建面试');
		$this->display();
	}
	
	// 编辑
	public function edit() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['table'] = 'OisInterview';
		$const['id'] = $_GET['interview_id'];
		$const['disableField'] = array('interview_id', 'real_start_time', 'real_end_time');
		$const['hideField'] = array('status', 'talent_name', 'interviewer_name', 'start_time_int', 'end_time_int', 'real_start_time_int', 'real_end_time_int');
		$const['fieldWidth'] = '75';
		
		A('Base/Common')->edit($const);
	}
	
	// 编辑完成
	public function editDo() {
		$data = $_POST;
		$data['start_time_int'] = timeToInt($data['start_time']);
		$data['end_time_int'] = timeToInt($data['end_time']);
		
		$const = array();
		$const['table'] = 'OisInterview';
		$const['jumpUrl'] = '/ois/ois_interview/show/interview_id/' . $data['interview_id'];
		A('Base/Common')->editDo($data, $const);
	}
	
	// 显示
	public function show() {
		$const = array();
		$const['title'] = '面试';
		$const['group'] = 'ois';
		$const['action'] = 'interview';
		$const['table'] = 'OisInterview';
		$const['id'] = $_GET['interview_id'];
		$const['hideField'] = array('talent_id', 'interviewer_id', 'status_id', 'start_time_int', 'real_start_time_int', 'real_end_time_int');
		$const['linkField'] = array(
			'talent_name'		=>	'/rms/rms_talent/show/talent_id/{talent_id}',
			'interviewer_name'	=>	'/ois/ois_interviewer/show/interviewer_id/{interviewer_id}',
		);
		
		A('Base/Common')->show($const);
	}
	
	// 删除
	public function delete() {
		D('OisInterview')->d($_GET['interview_id']);
		if ($_GET['close_window'] == 1) {
			echo '<script>parent.closeTabFromChild(this);</script>';
		}
		else {
			$this->redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	// 删除多个
	public function deleteList() {
		$interviewIdList = split('\|', $_GET['id_list']);
		foreach($interviewIdList as $interviewId) {
			if (empty($interviewId)) continue;
			D('OisInterview')->d($interviewId);
		}
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 创建操作
	public function createDo() {
		$data = $_POST;
		$data['start_time_int'] = timeToInt($data['start_time']);
		
		$interDo = D('OisInterview');
		$res = $interDo->c($data);
		if (!$res && !empty($interDo->errorInfo)) {
			$ret['retStatus'] = 'fail';
			foreach($interDo->errorInfo as $key => $error) {
				$ret['error'][$key] = $error;
			}
		}
		else {
			$ret['retStatus'] = 'success';
			$ret['jumpUrl'] = U('/ois/ois_interview/show?interview_id=' . $res);
		}

		$this->ajaxReturn($ret);
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