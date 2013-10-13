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
	
	// 文本框字段
	public $textareaField = array();
	
	// 选择字段
	public $selectField = array();

	// 数据正确规则
	public $dataRule = array(
		array('name', 'empty'),
		array('name', 'length', array(1, 20)),
		array('email', 'empty'),
		array('email', 'email'),
		array('email', 'length', array(1, 40)),
		array('email', 'exist'),
		array('phone', 'empty'),
		array('phone', 'length', array(7, 20)),
	);
	
	//数据填充规则
	public $fillRule = array();	
	
	// 构造函数
	public function _initialize() {
		$this->tableName = $_SESSION['company_id'] . '_ois_interviewer';
	}
	
}