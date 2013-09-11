<?php

class CompanyModel extends Model {
	// 变量
	public $errorInfo;

	// 新增
	public function c($data) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data)) return false;
		if ($this->create($data)) {
			$res = $this->add();
			return $res;
		} else {
			return $this->getError();
		}
	}
	
	// 更新
	public function u($data) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data)) return false;
		$this->save($data);
		return true;
	}

	// 获取
	public function r($company_id) {
		$sql = array('company_id' => $company_id);
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
	public function isExist($name, $data, $company_id) {
		$sql = array($name => $data);
		if (!empty($company_id)) $sql['company_id'] = array('NEQ', $company_id);
		$res = $this->where($sql)->find();
		return !empty($res);
	}
	
	// 验证数据是否正确
	public function isDataCorrect($data) {
		$this->errorInfo = array();
		// 名称 (realname)
		if (mb_strlen($data['realname'], 'utf8') == 0 || mb_strlen($data['realname'], 'utf8') > 50)
			$this->errorInfo['realname'] = '公司名称长度不能少于1位多于50位';
		else 
		if ($this->isExist('realname', $data['realname'], $data['company_id']))
			$this->errorInfo['realname'] = '该公司名称已存在';
		// 邮箱 (email)
		if (mb_strlen($data['email'], 'utf8') == 0 || mb_strlen($data['email'], 'utf8') > 40)
			$this->errorInfo['email'] = '电子邮箱长度不能少于1位多于40位';
		else
		if (!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $data['email']))
			$this->errorInfo['email'] = '电子邮箱格式不正确';
		else
		if ($this->isExist('email', $data['email'], $data['company_id']))
			$this->errorInfo['email'] = '该电子邮箱地址已存在';
		// 电话 (phone)
		if (!empty($data['phone'])) {
			if (mb_strlen($data['phone'], 'utf8') == 0 || mb_strlen($data['phone'], 'utf8') > 50)
				$this->errorInfo['phone'] = '电话长度不能多于30位';
		}
		// 联系人 (contact_name)
		if (!empty($data['contact_name'])) {
			if (mb_strlen($data['contact_name'], 'utf8') == 0 || mb_strlen($data['contact_name'], 'utf8') > 50)
				$this->errorInfo['contact_name'] = '联系人姓名长度不能多于20位';
		}

		// 是否正确
		if (empty($this->errorInfo)) return true;
		else return false;
	}
}