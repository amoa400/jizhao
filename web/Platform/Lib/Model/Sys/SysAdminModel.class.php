<?php

class SysAdminModel extends Model {
	protected $_auto = array ( 
		array('password', 'encrypt', 3, 'function'),
	);
	
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_sys_admin';
	}
	
	// 新增
	public function c($data) {
		if (empty($data)) $data = $_POST;
		if ($this->create($data)) {
			$res = $this->add();
			return $res;
		} else {
			return $this->getError();
		}
	}

	// 获取
	public function r($company_id, $user_id) {
		$sql = array('company_id' => $company_id, 'user_id' => $user_id);
		$res = $this->where($sql)->find();
		return $res;
	}
	
	// 获取（通过其他字段）
	public function rByName($name, $data) {
		$sql = array($name => $data);
		$res = $this->where($sql)->find();
		return $res;
	}

	// 是否存在
	public function isExist($name, $data) {
		$sql = array($name => $data);
		$res = $this->where($sql)->find();
		return !empty($res);
	}
}