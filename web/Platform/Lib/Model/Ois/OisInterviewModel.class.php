<?php

class OisInterviewModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;

	public $fieldName = array(
		'interview_id' 			=> 		'编号',
		'name' 					=> 		'名称',
		'talent_id' 			=> 		'面试者',
		'talent_name' 			=> 		'面试者',
		'interviewer_id' 		=> 		'面试官',
		'interviewer_name'		=> 		'面试官',
		'status_id' 			=> 		'状态',
		'status' 				=> 		'状态',
		'start_time_int' 		=> 		'开始时间',
		'start_time' 			=> 		'开始时间',
		'remark' 				=> 		'备注',
		'real_start_time_int' 	=> 		'实际开始',
		'real_start_time' 		=> 		'实际开始',
		'real_end_time_int' 	=> 		'实际结束',
		'real_end_time' 		=> 		'实际结束',
		'evaluation' 			=> 		'评价',
	);
	
	public $textareaField = array('remark', 'evaluation');
	
	public $selectField = array(
		'status_id' 			=>		array(
			'1'		=>		'未开始',
			'2'		=>		'已开始',
			'3'		=>		'已结束',
			'4'		=>		'已评价',
		),
	);
	
	// 自动完成
	protected $_auto = array(
		array('status_id', '1', 1),
	);

	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_ois_interview';
	}
	
	// 创建
	public function c($data) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data)) return false;
		if ($this->create($data)) {
			$ret = $this->add();
			return $ret;
		} else {
			return false;
		}
	}
	
	// 更新
	public function u($data, $force = true) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data, $force)) return false;
		$ret = $this->save($data);
		return $ret;
	}
	
	// 获取
	public function r($interview_id) {
		$sql = array('interview_id' => (int)$interview_id);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取列表
	public function rList($filter, $const) {
		global $tableName;
		$tableName = $this->tableName;
		$ret = D('Base/Common')->rList($filter, $const);
		return $ret;
	}
	
	// 删除
	public function d($interview_id) {
		$sql = array('interview_id' => (int)$interview_id);
		$ret = $this->where($sql)->delete();
		return $ret;
	}
	
	// 验证数据是否正确
	public function isDataCorrect($data, $force = true) {
		$this->errorInfo = array();
		// 面试者
		if ($force || !empty($data['talent_id'])) {
			if (empty($data['talent_id']))
				$this->errorInfo['talent_name'] = '面试者编号错误';
		}
		// 面试官
		if ($force || !empty($data['interviewer_id'])) {
			if (empty($data['interviewer_id']))
				$this->errorInfo['interviewer_name'] = '面试官编号错误';
		}
		// 开始时间
		if ($force || !empty($data['start_time_int'])) {
			if ($data['start_time_int'] < getTime())
				$this->errorInfo['start_time'] = '开始时间不能小于当前时间';
		}
		// 名称
		if ($force || !empty($data['name'])) {
			if (mb_strlen($data['name'], 'utf8') == 0 || mb_strlen($data['name'], 'utf8') > 50)
				$this->errorInfo['name'] = '名称长度不能少于1位多于50位';
		}

		// 是否正确
		if (empty($this->errorInfo)) return true;
		else return false;
	}
	
}