<?php

class RmsTalentModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	
	public $fieldName = array(
		'talent_id' 			=> 		'编号',
		'name' 					=> 		'姓名',
		'gender_id' 			=> 		'性别',
		'gender' 				=> 		'性别',
		'age' 					=> 		'年龄',
		'education_id' 			=> 		'学历',
		'education' 			=> 		'学历',
		'position_id'			=> 		'职位',
		'position_name'			=> 		'职位',
		'join_time_int' 		=> 		'加入时间',
		'join_time' 			=> 		'加入时间',
		'status_id' 			=> 		'状态',
		'status' 				=> 		'状态',
		'province_id' 			=> 		'省份',
		'province' 				=> 		'省份',
		'city_id' 				=> 		'城市',
		'city' 					=> 		'城市',
		'school' 				=> 		'学校',
		'major' 				=> 		'专业',
		'phone' 				=> 		'手机',
		'email' 				=> 		'邮箱',
		'resume'				=>		'简历',
	);
	
	public $textareaField = array();
	
	public $selectField = array(
		'gender_id' => array(
			'1' => '男',
			'2' => '女',
		),
		'education_id' => array(
			'1' => '博士',
			'2' => '硕士',
			'3' => '本科',
			'4' => '专科',
			'5' => '其他',
		),
		'status_id' => array (
			'1' => '未查看',
			'2' => '简历通过',
			'3' => '笔试考查',
			'4' => '面试考查',
			'5' => '已录用',
			'6' => '已淘汰',
		),
	);
	
	// 自动完成
	protected $_auto = array(
		array('join_time_int', 'getTime', 1, 'function'),
		array('status_id', '1', 1),
	);
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_rms_talent';
	}
	
	// 创建
	public function c($data) {
		if (empty($data)) $data = $_POST;
		if ($this->create($data)) {
			$ret = $this->add();
			// 职位统计数更改
			if ($ret) {
				D('RmsPosition')->inc('enrollment', array('position_id' => $data['position_id']));
			}
			return $ret;
		} else {
			return false;
		}
	}
	
	// 更新
	public function u($data) {
		if (empty($data)) $data = $_POST;
		if (!$this->isDataCorrect($data)) return false;
		$old = $this->r($data['talent_id']);	// 若数据中没有position_id，则需小心
		$ret = $this->save($data);
		// 职位统计数更改
		if ($ret && $data['position_id'] != $old['position_id']) {
			D('RmsPosition')->dec('enrollment', array('position_id' => $old['position_id']));
			D('RmsPosition')->inc('enrollment', array('position_id' => $data['position_id']));
		}
		return $ret;
	}
	
	// 更新状态
	public function uStatus($talent_id, $status_id) {
		$data = array('talent_id' => $talent_id, 'status_id' => $status_id);
		$ret = $this->save($data);
	}
	
	// 获取
	public function r($talentId) {
		$sql = array('talent_id' => (int)$talentId);
		$ret = $this->where($sql)->find();
		return $ret;
	}
	
	// 获取（通过其他字段）
	public function rByName($name, $data) {
		$sql = array($name => $data);
		$res = $this->where($sql)->find();
		return $res;
	}
	
	// 获取列表
	public function rList($filter, $const) {
		global $tableName;
		$tableName = $this->tableName;
		$ret = D('Base/Common')->rList($filter, $const);
		return $ret;
	
		$mysql = $this;
		
		// 搜索条件
		$sql = array();
		// 性别
		if (!empty($filter['gender_id'])) $sql['gender_id'] = (int)$filter['gender_id'];
		// 学历
		if (!empty($filter['education_id'])) $sql['education_id'] = (int)$filter['education_id'];
		// 职位
		if (!empty($filter['position_id'])) $sql['position_id'] = (int)$filter['position_id'];
		// 状态
		if (!empty($filter['status_id'])) $sql['status_id'] = (int)$filter['status_id'];
		// 编号
		if (!empty($filter['talent_id'])) $sql['talent_id'] = $filter['talent_id'];
		// 姓名
		if (!empty($filter['name'])) $sql['name'] = array('LIKE', '%'. $filter['name'] . '%');
		// 年龄
		if (!empty($filter['age_st']) && !empty($filter['age_ed'])) 
			$sql['age'] = array('BETWEEN', array($filter['age_st'], $filter['age_ed']));
		else
		if (!empty($filter['age_st'])) 
			$sql['age'] = array('EGT', $filter['age_st']);
		else
		if (!empty($filter['age_ed'])) 
			$sql['age'] = array('ELT', $filter['age_ed']);
		// 时间
		if (!empty($filter['join_time_st']) && !empty($filter['join_time_ed'])) 
			$sql['join_time_int'] = array('BETWEEN', array(timeToInt($filter['join_time_st']), timeToInt($filter['join_time_ed']) + 86400));
		else
		if (!empty($filter['join_time_st'])) 
			$sql['join_time_int'] = array('EGT', timeToInt($filter['join_time_st']));
		else
		if (!empty($filter['join_time_ed'])) 
			$sql['join_time_int'] = array('ELT', timeToInt($filter['join_time_ed']) + 86400);
			
		// 获取条目数量
		$res = $mysql->where($sql)->field('COUNT(1) AS `count`')->find();
		
		// 分页
		if (!empty($filter['page'])) $mysql = $mysql->page((int)$filter['page'], 20);
		else $mysql = $mysql->page(1, 20);
	
		// 获取结果		
		$res['data'] = $mysql->where($sql)->order('`talent_id` DESC')->select();
		
		return $res;
	}
	
	// 删除
	public function d($talentId) {
		$sql = array('talent_id' => (int)$talentId);
		$old = $this->r($talentId);
		$ret = $this->where($sql)->delete();
		if ($ret) {
			D('RmsPosition')->dec('enrollment', array('position_id' => $old['position_id']));
		}
		return $ret;
	}
	
	// 验证数据是否正确
	public function isDataCorrect($data) {
		$this->errorInfo = array();
		// 名字
		if (mb_strlen($data['name'], 'utf8') == 0 || mb_strlen($data['name'], 'utf8') > 20)
			$this->errorInfo['name'] = '名字长度不能少于1位多于20位';
		// 性别
		if ((int)$data['gender_id'] != 1 && (int)$data['gender_id'] != 2)
			$this->errorInfo['gender_id'] = '性别错误';
		// 年龄
		if ((int)$data['age'] < 10 || (int)$data['age'] > 200)
			$this->errorInfo['age'] = '年龄错误';
		// 学历
		if ((int)$data['education_id'] < 1 || (int)$data['education_id'] > 5)
			$this->errorInfo['education_id'] = '学历错误';
		// 是否正确
		if (empty($this->errorInfo)) return true;
		else return false;
	}
	
}