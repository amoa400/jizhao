<?php

class OisInterviewerModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;

	public $fieldName = array(
		'interviewer_id' 		=> 		'编号',
		'name' 					=> 		'姓名',
		'email' 				=> 		'邮箱',
		'phone' 				=> 		'手机',
	);
	
	public $textareaField = array();
	
	public $selectField = array();
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_ois_interviewer';
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
	public function u($data) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data)) return false;
		$ret = $this->save($data);
		return $ret;
	}
	
	// 获取
	public function r($interviewer_id) {
		$sql = array('interviewer_id' => (int)$interviewer_id);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取（通过其他字段）
	public function rByName($name, $data) {
		$sql = array($name => $data);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取列表
	public function rList() {	
		// 获取结果
		$res = $this->field('COUNT(1) AS `count`')->find();
		$res['data'] = $this->order('`interviewer_id` DESC')->select();
		return $res;
	}
	
	// 删除
	public function d($interviewer_id) {
		$sql = array('interviewer_id' => (int)$interviewer_id);
		$ret = $this->where($sql)->delete();
		return $ret;
	}
	
	// 字段是否存在
	public function fieldExist($field, $data, $interviewer_id) {
		$sql = array();
		$sql[$field] = $data;
		if (!empty($interviewer_id))
			$sql['interviewer_id'] = array('NEQ', $interviewer_id);
		$res = $this->where($sql)->find();
		return !empty($res);
	}
	
	// 验证数据是否正确
	public function isDataCorrect($data) {
		$this->errorInfo = array();
		// 名称
		if (mb_strlen($data['name'], 'utf8') == 0 || mb_strlen($data['name'], 'utf8') > 20)
			$this->errorInfo['name'] = '名称长度不能少于1位多于20位';
		// 邮箱
		if (mb_strlen($data['email'], 'utf8') == 0 || mb_strlen($data['email'], 'utf8') > 20)
			$this->errorInfo['email'] = '邮箱长度不能少于1位多于40位';
		else
		if (!validEmail($data['email']))
			$this->errorInfo['email'] = '电子邮箱格式错误';
		else
		if ($this->fieldExist('email', $data['email'], $data['interviewer_id']))
			$this->errorInfo['email'] = '电子邮箱已存在';
		// 手机
		if (mb_strlen($data['phone'], 'utf8') == 0 || mb_strlen($data['phone'], 'utf8') > 20)
			$this->errorInfo['phone'] = '手机长度不能少于1位多于20位';

		// 是否正确
		if (empty($this->errorInfo)) return true;
		else return false;
	}
	
}