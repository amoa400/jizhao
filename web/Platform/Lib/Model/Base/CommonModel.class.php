<?php

class CommonModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	public $om;	// 原来的model
	public $group;
	public $action;
	
	// 构造函数
	public function _initialize() {
		global $jzGroup;
		global $jzAction;
		if (!empty($jzGroup) && !empty($jzAction)) {
			$this->tableName = $_SESSION['company_id'] . '_' . $jzGroup . '_' . $jzAction;
			$this->om = D(ucfirst($jzGroup) . '/' . ucfirst($jzGroup) . ucfirst($jzAction));
		}
		$this->group = $jzGroup;
		$this->action = $jzAction;
	}
	
	// 设定数据库
	public function setDb($group = '', $action = '') {
		if (!empty($group) && !empty($action)) {
			$this->trueTableName = 'jz_'. $_SESSION['company_id'] . '_' . $group . '_' . $action;
			$this->group = $group;
			$this->action = $action;
		}
	}
	
	// 创建
	public function c($data) {
		if (empty($data)) $data = $_POST;
		$data = $this->fillData($data, 1);
		if (!$this->isCorrect($data)) return false;
		if ($this->create($data)) {
			$ret = $this->add();
			return $ret;
		} else {
			return false;
		}
	}
	
	// 修改
	public function u($data) {
		if (empty($data)) $data = $_POST;
		$data = $this->fillData($data, 2);
		if (!$this->isCorrect($data)) return false;
		$ret = $this->save($data);	
		return $ret;
	}
	
	// 获取
	public function r($id) {
		$sql = array($this->action . '_id' => (int)$id);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取列表
	public function rList($filter, $const) {
		$mysql = $this;
		$sql = array();
		
		// 筛选条件
		foreach($filter as $key => $value) {
			if ($key == 'page') continue;
			// 特殊条件
			if (!empty($const['specialFilterField'][$key])) {
				// 时间区间
				if ($const['specialFilterField'][$key][0] == 'timeBetween') {
					$st = timeToInt($filter[$key]['s']);
					$ed = timeToInt($filter[$key]['e']) + 86399;

					if (!empty($filter[$key]['s']) && !empty($filter[$key]['e']))
						$sql[$key] = array('BETWEEN', array($st, $ed));
					else
					if (!empty($filter[$key]['s'])) 
						$sql[$key] = array('EGT', $st);
					else
					if (!empty($filter[$key]['e'])) 
						$sql[$key] = array('ELT', $ed);
				}
				// 普通区间
				if ($const['specialFilterField'][$key][0] == 'between') {
					$st = $filter[$key]['s'];
					$ed = $filter[$key]['e'];

					if (!empty($st) && !empty($ed))
						$sql[$key] = array('BETWEEN', array($st, $ed));
					else
					if (!empty($st)) 
						$sql[$key] = array('EGT', $st);
					else
					if (!empty($ed)) 
						$sql[$key] = array('ELT', $ed);
				}
				// 名称选择
				if ($const['specialFilterField'][$key][0] == 'namePicker') {
					$sql[$key] = $value;
				}
			}
			// 选择框
			else
			if (gettype($value) == 'array') {
				$sql[$key] = array('in', $value);
			}
			// 文本框
			else {
				if (strstr($this->fields['_type'][$key], 'char')) {
					// 模糊匹配
					$sql[$key] = array('LIKE', '%' . $value . '%');
				} else {
					// 精确匹配
					$sql[$key] = $value;
				}
			}
		}
		//dump($sql);
		
		$ret = $mysql->where($sql)->field('COUNT(1) AS `count`')->find();
		if (!empty($filter['page'])) $mysql = $mysql->page((int)$filter['page'], 20);
		else $mysql = $mysql->page(1, 20);
		$ret['data'] = $this->where($sql)->order('`' . $const['order'][0] . '` ' . $const['order'][1])->select();
		//dump($this->getLastSql());
		return $ret;
	}
	
	// 删除
	public function d($id) {
		$sql = array();
		$sql[$this->action . '_id'] = $id;
		$ret = $this->where($sql)->delete();
		return $ret;
	}
	
	// 删除列表
	public function dList($idList) {
		$sql = array();
		$sql[$this->action . '_id'] = array('in', $idList);
		$ret = $this->where($sql)->delete();
		return $ret;
	}
	
	// 获取某个字段
	public function getField($name, $value, $target, $group = '', $action = '') {
		$this->setDb($group, $action);
		$sql = array();
		$sql[$name] = $value;
		$ret = $this->field($target)->where($sql)->find();
		return $ret[$target];
	}
	
	// 修改某个字段
	public function changeField($name, $value, $idList, $group = '', $action = '') {
		$this->setDb($group, $action);
		$data[$name] = $value;
		$sql[$this->action . '_id'] = array('in', $idList);
		$ret = $this->where($sql)->save($data);
		return $ret;
	}
	
	// 获取编号名称对应表
	public function getIdNameList() {
		$ret = $this->field('`'. $this->action . '_id` AS `id`, `name`')->order('`'. $this->action . '_id` DESC')->select();
		return $ret;
	}

	// 验证数据是否合法
	public function isCorrect($data) {
		$this->errorInfo = array();
		foreach($this->om->dataRule as $item) {
			$key = $item[0];
			$keyName = $this->om->fieldName[$key];
			if (!empty($this->errorInfo[$key])) continue;
			if ($item[3] == 1 && empty($data[$key])) continue;
			// 空
			if ($item[1] == 'empty') {
				if (empty($data[$key]))
					$this->errorInfo[$key] = $keyName . '不能为空';
			}
			// 长度
			else
			if ($item[1] == 'length') {
				$len = strlen($data[$key]);
				if ($item[2][0] != -1 && $len < $item[2][0])
					$this->errorInfo[$key] = $keyName . '的长度不能小于' . $item[2][0] . '位';
				if ($item[2][1] != -1 && $len > $item[2][1])
					$this->errorInfo[$key] = $keyName . '的长度不能大于' . $item[2][1] . '位';
			}
			// 邮箱
			else
			if ($item[1] == 'email') {
				if (!validEmail($data[$key]))
					$this->errorInfo[$key] = $keyName . '格式错误';
			}
			// 字段是否存在
			else
			if ($item[1] == 'exist') {
				$dataClass = new CommonModel('Common');
				$id = $dataClass->getField($key, $data[$key], $this->action . '_id');
				if ($id != $data[$this->action . '_id'])
					$this->errorInfo[$key] = $keyName . '已存在';
			}
			//
			else {
			}
		}
		return empty($this->errorInfo);
	}
	
	// 数据填充
	public function fillData($data, $type = 0) {
		foreach($this->om->fillRule as $item) {
			$key = $item[0];
			if (!empty($item[3]) && $type != $item[3]) continue;
			//  直接填充
			if (empty($item[2])) {
				$data[$key] = $item[1];
			}
			// 获取字段
			else
			if ($item[2] == 'getField') {
				global $jzGroup;
				global $jzAction;
				$jzGroup = $item[1][0];
				$jzAction = $item[1][1];
				//$data[$item[1][2]]= 2;
				$dataClass = new CommonModel('Common');
				//dump($data[$item[1][2]]);
				$data[$key] = $dataClass->getField($item[1][2], $data[$item[1][2]], $item[1][3]);
			}
			// 获取当前时间
			else
			if ($item[2] == 'getTime') {
				$data[$key] = getTime();
			}
			//
			else {
			}
		}
		//dump($data);
		//die();
		return $data;
	}
}