<?php

class OisInterviewModel extends Model {
	// 变量
	protected $tableName;
	public $errorInfo;

	// 字段名称
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
	
	// 文本框字段
	public $textareaField = array('remark', 'evaluation');
	
	// 选择字段
	public $selectField = array(
		'status_id' 			=>		array(
			'1'		=>		'未开始',
			'2'		=>		'已开始',
			'3'		=>		'已结束',
			'4'		=>		'已评价',
		),
	);
	
	// 数据正确规则
	public $dataRule = array(
		array('talent_id', 'empty'),
		array('interviewer_id', 'empty'),
		array('start_time_int', 'empty'),
		array('name', 'empty'),
		array('name', 'length', array(1, 50)),
		array('remark', 'length', array(1, 500), 1),
	);
	
	//数据填充规则
	public $fillRule = array(
		array('talent_name', array('rms', 'talent', 'talent_id', 'name'), 'getField'),
		array('interviewer_name', array('ois', 'interviewer', 'interviewer_id', 'name'), 'getField'),
		array('status_id', '1', '', 1),
	);

	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_ois_interview';
	}

}