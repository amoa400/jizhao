<?php

class RmsTalentAction extends Action {
	public $positionList;
	public $errorInfo;
	
	// 初始化
	public function _initialize() {
		isLogin(1);
	}
	
	// 创建新求职者
	public function create() {
		$this->display();
	}
	
	// 创建新求职者（处理）
	// TODO
	public function createDo() {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->maxSize  = 5242880;
		$upload->allowExts  = array('pdf', 'doc', 'docx', 'txt');
		$upload->savePath =  './uploads/' . $_SESSION['company_id'] . '/resume/';
		if(!$upload->upload()) {
			$this->error($upload->getErrorMsg(), U('/rms/rms_talent/create'));
		}
		else {
			$talentIdList = '';
			$filenameList = '';
			$info = $upload->getUploadFileInfo();
			foreach($info as $item) {
				// TODO：自动解析简历
				$talentDo = D('RmsTalent');
				$talentId = $talentDo->c(array('resume_extension' => $item['extension']));
				$talentIdList .= $talentId . '|';
				$filenameList .= $item['name'] . '|';
				rename($item['savepath'] . $item['savename'], $item['savepath'] . $talentId . '.' . $item['extension']);
			}
			$this->redirect('/rms/rms_talent/createEdit?talent_id_list=' . $talentIdList . '&filename_list=' . $filenameList);
		}
	}
	
	// 编辑求职者（创建求职者后）
	public function createEdit() {
		// 求职者列表
		$talentList = array();
		$talentIdList = split('\|', $_GET['talent_id_list']);
		foreach($talentIdList as $talentId) {
			if (empty($talentId)) continue;
			$talentList[] = D('RmsTalent')->r($talentId);
		}
		// 简历名称列表
		$filenameList = split('\|', $_GET['filename_list']);
		$this->assign('filenameList', $filenameList);
		foreach($filenameList as $key => $filename) {
		if (empty($filename)) continue;
			$talentList[$key]['resume_name'] = $filename;
		}
		// 获取职位列表
		$ret = D('RmsPosition')->rList();
		$positionList = $ret['data'];
		
		$this->assign('mode', $_GET['mode']);
		$this->assign('talentList', $talentList);
		$this->assign('positionList', $positionList);
		$this->display();
	}
	
	// 编辑求职者处理（创建求职者后）
	public function createEditDo() {
		$ret['retStatus'] = 'success';
		$ret['jumpUrl'] = U('/rms/rms_talent/showList');
		foreach($_POST['talent_id'] as $item) {
			$data = array();
			$data['talent_id'] = $item;
			$data['name'] = $_POST['name_' . $item];
			$data['gender_id'] = $_POST['gender_id_' . $item];
			$data['age'] = $_POST['age_' . $item];
			$data['education_id'] = $_POST['education_id_' . $item];
			$data['position_id'] = $_POST['position_id_' . $item];
			$talDo = D('RmsTalent');
			$res = $talDo->u($data);
			if (!$res && !empty($talDo->errorInfo)) {
				$ret['retStatus'] = 'fail';
				foreach($talDo->errorInfo as $key => $error) {
					$ret['error'][$key . '_' . $item] = $error;
				}
			}
		}
		$this->ajaxReturn($ret);
	}
	
	// 修改求职者
	public function edit() {
		$const = array();
		$const['title'] = '求职者';
		$const['group'] = 'rms';
		$const['action'] = 'talent';
		$const['id'] = $_GET['talent_id'];
		$const['disableField'] = array('talent_id');
		$const['showField'] = array('talent_id', 'name', 'gender_id', 'age', 'education_id', 'position_id', 'status_id', 'province', 'city', 'school', 'major', 'phone', 'email', 'resume');
		$const['specialField'] = array(
			'position_id' =>
				array('namePicker', '/base/common/getIdNameList/group/rms/action/position'),
			'resume' =>
				array('file'),
		);
		
		A('Base/Common')->edit($const);
	}
	
	// 修改求职者（处理）
	public function editDo() {
		// 简历
		if (!empty($_FILES['resume']['name'])) {
			if (!$this->uploadParseResume($_POST['talent_id'])) {
				$ret['retStatus'] = 'fail';
				$ret['error'] = array('resume' => $this->errorInfo);
				$this->ajaxReturn($ret);
				die();
			}
		}
		// 其他信息
		$talDo = D('RmsTalent');
		$res = $talDo->u();
		// 返回
		if ($res == false && !empty($talDo->errorInfo)) {
			$ret['retStatus'] = 'fail';
			$ret['error'] = $talDo->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
		}
		$this->ajaxReturn($ret);
	}
	
	// 显示求职者
	public function show() {
		$const = array();
		$const['title'] = '求职者';
		$const['group'] = 'rms';
		$const['action'] = 'talent';
		$const['id'] = $_GET['talent_id'];
		$const['showField'] = array('talent_id', 'name', 'gender', 'age', 'education', 'position_name', 'join_time', 'status', 'province', 'city', 'school', 'major', 'phone', 'email', 'resume');
		$const['linkField'] = array(
			'position_name'		=>	'/rms/rms_position/show/position_id/{position_id}',
		);
		
		A('Base/Common')->show($const);
	}
	

	// 显示列表
	public function showList() {
		$const = array();
		$const['title'] = '求职者';
		$const['group'] = 'rms';
		$const['action'] = 'talent';
		$const['toolbar'] = array(
			'create' => array('on' => 1),
			'delete' => array('on' => 1),
			'other' => array(
				array('简历通过', '/rms/rms_talent/resumeOK'),
				array('安排笔试', '/rms/rms_talent/arrangeExam'),
				array('安排面试', '/rms/rms_talent/arrangeInterview'),
				array('录用', '/rms/rms_talent/hire'),
				array('淘汰', '/rms/rms_talent/eliminate'),
				array('发邮件', '/rms/rms_talent/sendEmail'),
				array('发短信', '/rms/rms_talent/sendMessage'),
			),
		);
		$const['showField'] = array('talent_id', 'name', 'gender', 'age', 'education', 'shcool', 'position_name', 'join_time', 'status');
		$const['linkField'] = array(
			'name' =>		
				array('/rms/rms_talent/show/talent_id/{$0$}', array('talent_id')),
			'position_name' =>		
				array('/rms/rms_position/show/position_id/{$0$}', array('position_id')),
		);
		$const['showFilterField'] = array('talent_id', 'name', 'gender_id', 'position_id', 'age', 'education_id', 'join_time_int', 'status_id', 'school', 'major', 'phone', 'email');
		$const['specialFilterField'] = array(
			'join_time_int' =>
				array('timeBetween'),
			'age' =>
				array('between'),
			'position_id' =>
				array('namePicker', '/base/common/getIdNameList/group/rms/action/position'),
		);
		$const['filterDefault'] = array(
			'position_id' =>
				array('rms', 'position', 'position_id', 'name'),
		);
		$const['moreField'] = array(
			array('简历通过', array('/rms/rms_talent/resumeOK/id/{$0$}', array('talent_id'))),
			array('安排笔试', array('/rms/rms_talent/arrangeExam/id/{$0$}', array('talent_id'))),
			array('安排面试', array('/rms/rms_talent/arrangeInterview/id/{$0$}', array('talent_id'))),
			array('录用', array('/rms/rms_talent/hire/id/{$0$}', array('talent_id'))),
			array('淘汰', array('/rms/rms_talent/eliminate/id/{$0$}', array('talent_id'))),
			array('发邮件', array('/rms/rms_talent/sendEmail/id/{$0$}', array('talent_id'))),
			array('发短信', array('/rms/rms_talent/sendMessage/id/{$0$}', array('talent_id'))),
		);
		$const['page'] = $_GET['page'];
		$const['order'] = array('talent_id', 'DESC');
		
		A('Base/Common')->showList($const);
	}
	
	// 上传并解析简历
	public function uploadParseResume($talentId) {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->maxSize  = 5242880;
		$upload->allowExts  = array('pdf', 'doc', 'docx', 'txt');
		$upload->savePath =  './uploads/' . $_SESSION['company_id'] . '/resume/';
		if(!$upload->upload()) {
			$this->errorInfo = $upload->getErrorMsg();
			return false;
		}
		else {
			$talentIdList = '';
			$filenameList = '';
			$info = $upload->getUploadFileInfo();
			foreach($info as $item) {
				// TODO：自动解析简历
				$talentDo = D('RmsTalent');
				$talentDo->u(array('talent_id' => $talentId, 'resume_extension' => $item['extension']));
				unlink($item['savepath'] . $talentId . '.pdf');
				unlink($item['savepath'] . $talentId . '.doc');
				unlink($item['savepath'] . $talentId . '.docx');
				unlink($item['savepath'] . $talentId . '.txt');
				rename($item['savepath'] . $item['savename'], $item['savepath'] . $talentId . '.' . $item['extension']);
			}
			return true;
		}
	}
	
	// 简历通过
	public function resumeOK() {
		$idList = A('Base/Common')->getGetIdList();
		D('Base/Common')->changeField('status_id', 2, $idList, 'rms', 'talent');
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 安排笔试
	public function arrangeExam() {
		$idList = A('Base/Common')->getGetIdList();
		D('Base/Common')->changeField('status_id', 3, $idList, 'rms', 'talent');
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 安排面试
	public function arrangeInterview() {
		$idList = A('Base/Common')->getGetIdList();
		D('Base/Common')->changeField('status_id', 4, $idList, 'rms', 'talent');
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 录用
	public function hire() {
		$idList = A('Base/Common')->getGetIdList();
		D('Base/Common')->changeField('status_id', 5, $idList, 'rms', 'talent');
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 淘汰
	public function eliminate() {
		$idList = A('Base/Common')->getGetIdList();
		D('Base/Common')->changeField('status_id', 6, $idList, 'rms', 'talent');
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 发送邮件
	public function sendEmail() {
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 发送短信
	public function sendMessage() {
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 格式化数据
	public function format($talent) {
		// 性别
		switch ($talent['gender_id']) {
			case 1:
				$talent['gender'] = '男';
				break;
			case 2:
				$talent['gender'] = '女';
				break;
			default:
				$talent['gender'] = '未知';
		}
		// 教育
		switch ($talent['education_id']) {
			case 1:
				$talent['education'] = '博士';
				break;
			case 2:
				$talent['education'] = '硕士';
				break;
			case 3:
				$talent['education'] = '本科';
				break;
			case 4:
				$talent['education'] = '专科';
				break;
			case 5:
				$talent['education'] = '其他';
				break;
			default:
				$talent['education'] = '未知';
		}
		// 时间
		$talent['join_time'] = IntToTime($talent['join_time_int']);
		// 状态
		switch ($talent['status_id']) {
			case 1:
				$talent['status'] = '未查看';
				break;
			case 2:
				$talent['status'] = '简历通过';
				break;
			case 3:
				$talent['status'] = '笔试考查';
				break;
			case 4:
				$talent['status'] = '面试考查';
				break;
			case 5:
				$talent['status'] = '已录用';
				break;
			case 6:
				$talent['status'] = '已淘汰';
				break;
			default:
				$talent['status'] = '未知';
		}
		// 职位
		//$talent['position'] = D('RmsPosition')->rName($talent['position_id']);
		return $talent;
	}
	
	// 随机生成数据
	public function random() {
		$txt = '玉刊示末未击打巧正扑扒功扔去甘世古节本术可丙左厉右石布龙平灭轧东卡北占业旧帅归且旦目叶甲申叮电号田由史只央兄叼叫另叨叹四生失禾丘付仗代仙们仪白仔他斥瓜乎丛令用甩印乐句匆册犯外处冬鸟务包饥主市立闪兰半汁汇头汉宁穴它讨写让礼训必议讯记永司尼民出辽奶奴加召皮边发孕圣对台矛纠母幼丝';
		$count = $_GET['count'];
		if (empty($count)) $count = 1;
		for ($i = 0; $i < $count; $i++) {
			$data = array();
			// 名字
			$t = rand()%10;
			if ($t < 6) $t2 = 3; else
			if ($t < 9) $t2 = 2;
			else $t2 = 4;
			for ($j = 0; $j < $t2; $j++) {
				$t = rand()%120;
				$data['name'] .= $txt[$t*3].$txt[$t*3+1].$txt[$t*3+2];
			}
			// 性别
			$t = rand()%3;
			if ($t < 2) $data['gender_id'] = 1;
			else $data['gender_id'] = 2;
			// 年龄
			$data['age'] = 18 + rand()%20;
			// 学历
			$data['education_id'] = 1 + rand()%5;
			// 职位
			$data['position_id'] = 1 + rand()%8;
			// 状态
			$data['status_id'] = 1 + rand()%6;
			// 学校			
			$t2 = 4 + rand()%5;
			for ($j = 0; $j < $t2; $j++) {
				$t = rand()%120;
				$data['school'] .= $txt[$t*3].$txt[$t*3+1].$txt[$t*3+2];
			}
			
			$ret = D('RmsTalent')->c($data);
			$data['talent_id'] = $ret;
			D('RmsTalent')->u($data);
		}
	}

}