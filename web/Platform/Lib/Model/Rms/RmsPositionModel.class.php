<?php

class RmsPositionModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	
	// 自动完成
	protected $_auto = array(
		array('enrollment', '0', 1),
		array('create_time_int', 'getTime', 1, 'function'),
		array('status_id', '1', 1),
	);
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_rms_position';
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
		$ret = $this->save( $data );
		return $ret;
	}
	
	// 获取
	public function r($positionId) {
		$sql = array('position_id' => (int)$positionId);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取名字
	public function rName($positionId) {
		$sql = array('position_id' => (int)$positionId);
		$ret = $this->field('position_id,name')->where($sql)->find();
		return $ret['name'];
	}
	
	// 获取名字列表
	public function rNameList($positionIdList) {
		$sql = array();
		$sql['position_id'] = array('in', (string)$positionIdList);
		$ret = $this->field('position_id,name')->where($sql)->select();
		return $ret;
	}
	
	// 获取列表
	public function rList($filter) {
		$mysql = $this;
		
		// 搜索条件
		$sql = array();
		// 状态
		if (!empty($filter['status_id'])) $sql['status_id'] = (int)$filter['status_id'];
		// 编号
		if (!empty($filter['position_id'])) $sql['position_id'] = $filter['position_id'];
		// 名称
		if (!empty($filter['name'])) $sql['name'] = array('LIKE', '%'. $filter['name'] . '%');
		// 人数
		if (!empty($filter['enrollment_st']) && !empty($filter['enrollment_ed'])) 
			$sql['enrollment'] = array('BETWEEN', array($filter['enrollment_st'], $filter['enrollment_ed']));
		else
		if (!empty($filter['age_st'])) 
			$sql['enrollment'] = array('EGT', $filter['enrollment_st']);
		else
		if (!empty($filter['age_ed'])) 
			$sql['enrollment'] = array('ELT', $filter['enrollment_ed']);
			
		// 获取条目数量
		$res = $mysql->where($sql)->field('COUNT(1) AS `count`')->find();
		
		// 分页
		if (!empty($filter['page'])) $mysql = $mysql->page((int)$filter['page'], 20);
		else $mysql = $mysql->page(1, 20);
		
		// 结果
		$res['data'] = $mysql->where($sql)->order('`position_id` DESC')->select();
		
		return $res;
	}
	
	// 获取列表（仅显示编号名字对）
	public function rListPair() {
		$data = $this->field('`position_id`, `name`')->select();
		$ret = array();
		foreach ($data as $value) {
			$ret[$value['position_id']] = $value['name'];
		}
		return $ret;
	}
	
	// 删除
	public function d($positionId) {
		$sql = array('position_id' => (int)$positionId);
		$ret = $this->where($sql)->delete();
		return $ret;
	}
	
	// 累加数据
	public function inc($field, $sql, $num = 1) {
		$this->where($sql)->setInc($field);
	}
	
	// 累减数据
	public function dec($field, $sql, $num = 1) {
		$this->where($sql)->setDec($field);
	}
	
	// 验证数据是否正确
	public function isDataCorrect($data) {
		$this->errorInfo = array();
		// 职位名称
		if (mb_strlen($data['name'], 'utf8') == 0 || mb_strlen($data['name'], 'utf8') > 50)
			$this->errorInfo['name'] = '职位名称长度不能少于1位多于50位';
		// 职位描述
		if (mb_strlen($data['description'], 'utf8') == 0 || mb_strlen($data['description'], 'utf8') > 1500)
			$this->errorInfo['description'] = '职位描述长度不能少于1位多于1500位';
		// 职位要求
		if (mb_strlen($data['requirement'], 'utf8') == 0 || mb_strlen($data['requirement'], 'utf8') > 1500)
			$this->errorInfo['requirement'] = '职位要求长度不能少于1位多于1500位';
		// 是否正确
		if (empty($this->errorInfo)) return true;
		else return false;
	}
}