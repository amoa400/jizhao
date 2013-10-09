<?php

class CommonModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	
	// 构造函数
	public function _initialize() {
		global $tableName;
		$this->tableName = $tableName;
	}
	
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
}