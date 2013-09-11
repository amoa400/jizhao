<?php

class RmsTalentStatusModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_rms_talent_status';
	}
	
	// 获取列表
	public function rList() {
		$res = $this->select();
		return $res;
	}
	
}