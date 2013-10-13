<?php

class RmsPositionModel extends Model {
	// 变量
	protected $tableName; 
	public $errorInfo;
	
	// 字段名称
	public $fieldName = array(
		'position_id' 			=> 		'编号',
		'name' 					=> 		'名称',
		'description' 			=> 		'职位描述',
		'requirement' 			=> 		'职位要求',
		'enrollment' 			=> 		'求职人数',
		'create_time_int'		=> 		'创建时间',
		'create_time'			=> 		'创建时间',
		'status_id' 			=> 		'状态',
		'status' 				=> 		'状态',
	);
	
	// 文本框字段
	public $textareaField = array('description', 'requirement');
	
	// 选择字段
	public $selectField = array(
		'status_id' 			=>		array(
			'1'		=>		'未发布',
			'2'		=>		'进行中',
			'3'		=>		'已结束',
		),
	);
	
	// 数据正确规则
	public $dataRule = array(
		array('name', 'empty'),
		array('name', 'length', array(1, 50)),
		array('description', 'empty'),
		array('description', 'length', array(1, 1500)),
		array('requirement', 'empty'),
		array('requirement', 'length', array(1, 1500)),
	);
	
	//数据填充规则
	public $fillRule = array(
		array('status_id', '1', '', 1),
		array('create_time_int', '', 'getTime', 1),
	);

	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_rms_position';
	}
}