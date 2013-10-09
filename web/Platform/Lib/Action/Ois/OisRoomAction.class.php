<?php
class OisRoomAction extends Action {

	public function process($statusId, $interviewId) {
		if ($statusId == 1) $this->redirect('/ois/ois_room/welcome/id/' . $interviewId);
		if ($statusId == 2) $this->redirect('/ois/ois_room/show/id/' . $interviewId);
		if ($statusId == 3 && $_SESSION['role'] == 2) $this->redirect('/ois/ois_room/evaluation/id/' . $interviewId);
		if ($statusId == 3 && $_SESSION['role'] != 2) $this->redirect('/ois/ois_room/end');
		if ($statusId == 4) $this->redirect('/ois/ois_room/end');
	}
	
	// 欢迎界面
	public function welcome() {
		// 面试信息
		$interview = D('Ois/OisInterview')->r($_GET['id']);
		$interview = A('Ois/OisInterview')->format($interview);
		
		// 检查权限
		$this->checkPermission($interview);
		if ($interview['status_id'] != 1) $this->process($interview['status_id'], $interview['interview_id']);
		
		// 生成会话编号
		$sessionId = randomChar();
		D('')->query('DELETE FROM `jz_' . $_SESSION['company_id'] . '_ois_room_session` WHERE `room_id` = ' . $interview['interview_id'] . ' AND `role_id` = ' . $_SESSION['role'] . ' AND `user_id` = ' . $_SESSION['user_id']);
		D('')->query('INSERT INTO `jz_' . $_SESSION['company_id'] . '_ois_room_session`(`room_id`, `role_id`, `user_id`, `session_id`) VALUES(' . $interview['interview_id']. ', ' . $_SESSION['role'] . ', ' . $_SESSION['user_id'] . ', \'' . $sessionId . '\')');

		$this->assign('interview', $interview);
		$this->assign('sessionId', $sessionId);
		$this->assign('pageTitle', '等待 - ' . $interview['name']);
		$this->display();
	}
	
	// 显示房间
    public function show() {
		// 面试信息
		$interview = D('Ois/OisInterview')->r($_GET['id']);
		$interview = A('Ois/OisInterview')->format($interview);

		// 检查权限
		$this->checkPermission($interview);
		if ($interview['status_id'] != 2) $this->process($interview['status_id'], $interview['interview_id']);

		// 生成会话编号
		$sessionId = randomChar();
		D('')->query('DELETE FROM `jz_' . $_SESSION['company_id'] . '_ois_room_session` WHERE `room_id` = ' . $interview['interview_id'] . ' AND `role_id` = ' . $_SESSION['role'] . ' AND `user_id` = ' . $_SESSION['user_id']);
		D('')->query('INSERT INTO `jz_' . $_SESSION['company_id'] . '_ois_room_session`(`room_id`, `role_id`, `user_id`, `session_id`) VALUES(' . $interview['interview_id']. ', ' . $_SESSION['role'] . ', ' . $_SESSION['user_id'] . ', \'' . $sessionId . '\')');

		$this->assign('interview', $interview);
		$this->assign('sessionId', $sessionId);
		$this->display();
    }
	
	// 评价
	public function evaluation() {
		// 面试信息
		$interview = D('Ois/OisInterview')->r($_GET['id']);
		$interview = A('Ois/OisInterview')->format($interview);
		if ($interview['evaluation'] == '--') $interview['evaluation'] = '';
		
		// 检查权限
		$this->checkPermission($interview);
		if ($interview['status_id'] != 3 || $_SESSION['role'] != 2) $this->process($interview['status_id'], $interview['interview_id']);
		
		$this->assign('interview', $interview);
		$this->assign('pageTitle', '面试评价 - '. $interview['name']);
		$this->display();
	}

	// 结束操作
	public function evaluationDo() {
		$data = array();
		$data['interview_id'] = $_POST['id'];
		$data['status_id'] = 4;
		$data['evaluation'] = $_POST['evaluation'];
		D('Ois/OisInterview')->u($data, false);
	}
	
	// 结束
	public function end() {
		$this->assign('pageTitle', '面试结束');
		$this->display();
	}
	
	// 检查权限
	public function checkPermission($interview) {
		$_SESSION['company_id'] = 1;
		$_SESSION['login'] = 1;
		if (empty($_SESSION['login'])) $this->error('您尚未登录');
		
		$flag = false;
		// 是否为管理员
		if ($_SESSION['role'] == 1) $flag = true;
		// 是否为面试官
		if ($_SESSION['role'] == 2 && $_SESSION['user_id'] == $interview['interviewer_id']) $flag = true;
		// 是否为面试者
		if ($_SESSION['role'] == 3 && $_SESSION['user_id'] == $interview['talent_id']) $flag = true;
		if (!$flag) $this->error('您没有权限进入该房间');
	}
	
	// 登录界面
	public function login() {
		$this->display();
	}
	
	// 获取实时信息
	public function getInfo() {
		set_time_limit(3);

		/*
		$_GET['room_id'] = 1;
		$_GET['user_id'] = 1;
		$_GET['session_id'] = '5074387616';
		$_GET['plugin'] = 'message';
		$_GET['identifier'] = '0';
		*/
		
		$roomId = $this->_get('room_id');
		$userId = $this->_get('user_id');
		$sessionId = $this->_get('session_id');
		$pluginList = split(',', $this->_get('plugin'));
		$identifierList = split(',', $this->_get('identifier'));
		while (1) {
			// 检查当前会话是否有效
			$session = D('Session')->r($roomId, $userId);
			if ($session['session_id'] != $sessionId) {
				$data = array();
				$data['error'] = '无效会话';
				echo $this->_get('jsonp_callback').'('.json_encode($data).')';
				die();
			}
			// 获取每个插件的最新内容
			$flag = false;
			$content = array();
			foreach($pluginList as $key => $item) {
				// 消息插件
				if ($item == 'message') {
					$content['message'] = array();
					$content['message']['content'] = D('Plugin')->rList($roomId, 'message', $identifierList[$key], 0);
					$content['message']['identifier'] = 0;
					foreach($content['message']['content'] as $key2 => $item2) {
						if ($item2['id'] > $content['message']['identifier'])
							$content['message']['identifier'] = $item2['id'];
						if ($item2['user_id'] == 0)
							$content['message']['content'][$key2]['type'] = '0';
						else
						if ($item2['user_id'] == 1) {
							$content['message']['content'][$key2]['type'] = '1';
							$content['message']['content'][$key2]['author'] = '面试官';
						}
						else {
							$content['message']['content'][$key2]['type'] = '2';
							$content['message']['content'][$key2]['author'] = '求职者';
						}
					}
					if (!empty($content['message']['content'])) $flag = true;
					else unset($content['message']);
				}
				// 代码插件
				if ($item == 'code') {
					$content['code'] = D('Plugin')->r($roomId, 'code', $identifierList[$key]);
					$content['code'] = $content['code'][0];
					if (!empty($content['code'])) $flag = true;
					else unset($content['code']);
				}
				// 黑板插件
				if ($item == 'blackboard') {
					$content['ttt'] .= '[';
					$content['blackboard'] = array();
					$content['blackboard']['content'] = D('Plugin')->rList($roomId, 'blackboard', $identifierList[$key], $userId);
					$content['blackboard']['identifier'] = 0;
					foreach($content['blackboard']['content'] as $item2) {
						if ($item2['id'] > $content['blackboard']['identifier'])
							$content['blackboard']['identifier'] = $item2['id'];
					}
					if (!empty($content['blackboard']['content'])) $flag = true;
					else unset($content['blackboard']);
				}
				// 网页插件
				if ($item == 'webpage') {
					$content['webpage'] = array();
					$content['webpage']['content'] = D('Plugin')->rList($roomId, 'webpage', $identifierList[$key], $userId);
					$content['webpage']['identifier'] = 0;
					foreach($content['webpage']['content'] as $item2) {
						if ($item2['id'] > $content['webpage']['identifier'])
							$content['webpage']['identifier'] = $item2['id'];
					}
					if (!empty($content['webpage']['content'])) $flag = true;
					else unset($content['webpage']);
				}
			}
			// 检查是否有更新
			if ($flag) {
				// 获取面试时间
				$content['time'] = array();
				$content['time']['start_time'] = D('Variable')->r($roomId, 'start_time');
				$content['time']['cnt_time'] = getTime();
				// 存在更新，返回数据
				echo $this->_get('jsonp_callback').'('.json_encode($content).')';
				die();
			}
			usleep(100000);
		}
	}
	
	// 更新实时信息
	public function updateInfo() {
		$post = $_POST;
		//$post = array();
		//$post['room_id'] = 1;
		//$post['user_id'] = 1;
		//$post['message']['content'] = array('1','2');
		//$post['webpage']['content'] = array();
		//$post['webpage']['content'][] = array('type' => 'create', 'name' => '4445', 'url' => 'http://');
		//$post['blackboard']['content'] = 1;
		//$post['code']['content'] = 1;
		//$post['code']['identifier'] = 21;
		//dump($post);

		foreach($post as $key => $item) {
			// 消息插件
			if ($key == 'message') {
				foreach($post['message']['content'] as $item2) {
					$data = array();
					$data['room_id'] = $post['room_id'];
					$data['user_id'] = $post['user_id'];
					$data['content'] = $item2['content'];
					$data['time'] = getTime();
					D('Plugin')->c('message', $data);
				}
			}
			// 代码插件
			if ($key == 'code') {
				$data = array();
				$data['code'] = $post['code']['content'];
				$data['identifier'] = $post['code']['identifier']+1;
				D('Plugin')->u($post['room_id'], 'code', $post['code']['identifier'], $data);
			}
			// 黑板插件
			if ($key == 'blackboard') {
				if (strstr($post['blackboard']['content'], 'clear')) {
					$data = array();
					$data['room_id'] = $post['room_id'];
					$data['user_id'] = 0;
					D('Plugin')->c('blackboard', $data);
					$sql = array();
					$sql['room_id'] = $post['room_id'];
					$sql['user_id'] = array('NEQ', 0);
					D('Plugin')->d('blackboard', $sql);
				}
				$data = array();
				$data['room_id'] = $post['room_id'];
				$data['content'] = $post['blackboard']['content'];
				$data['user_id'] = $post['user_id'];
				D('Plugin')->c('blackboard', $data);
			}
			// 网页插件
			if ($key == 'webpage') {
				$tot = count($post['webpage']['content']);
				for ($i = 0; $i < $tot; $i++) {
					$type = $post['webpage']['content'][$i]['type'];
					$name = $post['webpage']['content'][$i]['name'];
					$url = $post['webpage']['content'][$i]['url'];
					if ($type == 'create' || $type == 'redirect') {
						$data = array();
						$data['room_id'] = $post['room_id'];
						$data['user_id'] = $post['user_id'];
						$data['name'] = $name;
						$data['url'] = $url;
						D('Plugin')->c('webpage', $data);
					}
					if ($type == 'close') {
						$data = array();
						$data['room_id'] = $post['room_id'];
						$data['user_id'] = $post['user_id'];
						$data['name'] = $name;
						$data['url'] = 'close';
						D('Plugin')->c('webpage', $data);
					}
				}
			}
		}
		
	}
}