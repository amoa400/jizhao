<?php

class CommonAction extends Action {
	
	// 创建
	public function create($const) {
		$dataClass = D(ucfirst($const['group']) . '/' . ucfirst($const['group']) . ucfirst($const['action']));
		$this->assign('tabTitle', '新建 - ' . $const['title']);
		$this->assign('const', $const);
		$this->assign('fieldName', $this->alignText($dataClass->fieldName));
		$this->assign('textareaField', $dataClass->textareaField);
		$this->assign('selectField', $dataClass->selectField);
		$this->display('../Base/Common/create');
	}
	
	// 创建完成
	public function createDo() {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $_POST['jz_group'];
		$jzAction = $_POST['jz_action'];
		$dataClass = D('Common');
		$res = $dataClass->c($_POST);
		// 返回
		if (!empty($dataClass->errorInfo)) {
			$ret['retStatus'] = 'fail';
			if (!empty($dataClass->errorInfo))
				$ret['error'] = $dataClass->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
			$ret['jumpUrl'] = '/'. $_POST['jz_group'] . '/' . $_POST['jz_group'] . '_' . $_POST['jz_action'] . '/show/' . $_POST['jz_action'] . '_id/' . $res;
		}
		$this->ajaxReturn($ret);
	}

	// 编辑
	public function edit($const) {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $const['group'];
		$jzAction = $const['action'];
		$dataClass = D('Base/Common');
		$data = $dataClass->r($const['id']);
		//$data = A($const['group'] . '/' . $const['group'] . $const['action'])->format($data);
		
		$omClass = D(ucfirst($const['group']) . '/' . ucfirst($const['group']) . ucfirst($const['action']));

		$this->assign('tabTitle', '编辑' . ' - ' . $data['name']);
		$this->assign('const', $const);
		$this->assign('data', $data);
		$this->assign('fieldName', $this->alignText($omClass->fieldName));
		$this->assign('textareaField', $omClass->textareaField);
		$this->assign('selectField', $omClass->selectField);
		$this->display('../Base/Common/edit');
	}
	
	// 编辑完成
	public function editDo() {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $_POST['jz_group'];
		$jzAction = $_POST['jz_action'];
		$dataClass = D('Common');
		$res = $dataClass->u($_POST);
		// 返回
		if (!empty($dataClass->errorInfo)) {
			$ret['retStatus'] = 'fail';
			if (!empty($dataClass->errorInfo))
				$ret['error'] = $dataClass->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
			$ret['jumpUrl'] = '/'. $_POST['jz_group'] . '/' . $_POST['jz_group'] . '_' . $_POST['jz_action'] . '/show/' . $_POST['jz_action'] . '_id/' . $_POST[$_POST['jz_action'] . '_id'];
		}
		$this->ajaxReturn($ret);
	}
	
	// 显示
	public function show($const) {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $const['group'];
		$jzAction = $const['action'];
		$dataClass = D('Base/Common');
		$data = $dataClass->r($const['id']);
		$data = A($const['group'] . '/' . $const['group'] . $const['action'])->format($data);
		
		foreach($const['linkField'] as $key => $item) {
			$len = strlen($item);
			$flag = false;
			$s = '';
			$const['linkField'][$key] = '';
			for ($i = 0; $i < $len; $i++) {
				if ($item[$i] == '{') {
					$flag = true;
					continue;
				}
				if ($item[$i] == '}') {
					$const['linkField'][$key] .= $data[$s];
					$flag = false;
					$s = '';
					continue;
				}
				if ($flag) $s .= $item[$i];
				else $const['linkField'][$key] .= $item[$i];
			}
		}
		
		$this->assign('tabTitle', '查看' . ' - ' . $data['name']);
		$this->assign('const', $const);
		$this->assign('data', $data);
		$this->assign('fieldName', $this->alignText(D(ucfirst($const['group']) . '/' . ucfirst($const['group']) . ucfirst($const['action']))->fieldName));
		$this->display('../Base/Common/show');
	}
	
	// 显示列表
	public function showList($const) {
		$dataClass = D(ucfirst($const['group']) . '/' . ucfirst($const['group']) . ucfirst($const['action']));

		// 筛选条件
		$filter = array();
		foreach($_GET as $key => $value) {
			if ($key == '_URL_') continue;
			$flag = false;
			foreach($const['specialFilterField'] as $key2 => $value2) {
				// 时间区间
				if ($value2[0] == 'timeBetween' && $key == $key2 . '_s') {
					$flag = true;
					$filter[$key2]['s'] = $value;
				}
				if ($value2[0] == 'timeBetween' && $key == $key2 . '_e') {
					$flag = true;
					$filter[$key2]['e'] = $value;
				}
				// 普通区间
				if ($value2[0] == 'between' && $key == $key2 . '_s') {
					$flag = true;
					$filter[$key2]['s'] = $value;
				}
				if ($value2[0] == 'between' && $key == $key2 . '_e') {
					$flag = true;
					$filter[$key2]['e'] = $value;
				}
			}
			if ($flag) continue;
			if (!empty($dataClass->selectField[$key])) {
				$filter[$key] = split('\|', $value);
			} else $filter[$key] = $value;
		}
	
		// 筛选
		global $jzGroup;
		global $jzAction;
		$jzGroup = $const['group'];
		$jzAction = $const['action'];
		$ret =  D('Base/Common')->rList($filter, $const);
		$dataList = $ret['data'];
		foreach($dataList as $key => $data) {
			$dataList[$key] = A($const['group'] . '/' . $const['group'] . $const['action'])->format($data);
			// 替换链接
			$dataList[$key]['linkField'] = array();
			foreach($const['linkField'] as $key2 => $value2) {
				$dataList[$key]['linkField'][$key2] = $value2[0];
				foreach($value2[1] as $key3 => $value3)
					$dataList[$key]['linkField'][$key2] = str_replace('{$' . $key3 . '$}', $data[$value3], $dataList[$key]['linkField'][$key2]);
			}
			// 替换连接（更多）
			$dataList[$key]['moreField'] = array();
			foreach($const['moreField'] as $key2 => $value2) {
				$dataList[$key]['moreField'][$key2] = array();
				$dataList[$key]['moreField'][$key2]['name'] = $value2[0];
				$dataList[$key]['moreField'][$key2]['url'] = $value2[1][0];
				foreach($value2[1][1] as $key3 => $value3)
					$dataList[$key]['moreField'][$key2]['url'] = str_replace('{$' . $key3 . '$}', $data[$value3], $dataList[$key]['moreField'][$key2]['url']);
				if (!empty($value2[1][2]))
					$dataList[$key]['moreField'][$key2]['target'] = $value2[1][2];
				else
					$dataList[$key]['moreField'][$key2]['target'] = 'new_tab';
			}
		}
		
		// 分页信息
		$pager['count'] = $ret['count'];
		$pager['cntPage'] = $const['page'];
		if (empty($pager['cntPage'])) $pager['cntPage'] = 1;
		$pager['totPage'] =  ceil($pager['count'] / 20);
		
		// 筛选器信息
		$const['filterDefaultValue'] = array();
		foreach($const['filterDefault'] as $key => $item) {
			$const['filterDefaultValue'][$key] = D('Common')->getField($item[2], $_GET[$item[2]], $item[3], $item[0], $item[1]);
		}

		$this->assign('pageTitle', $const['title'] . '管理');
		$this->assign('const', $const);
		$this->assign('dataList', $dataList);
		$this->assign('pager', $pager);
		$this->assign('fieldName', $dataClass->fieldName);
		$this->assign('fieldNameAlign', $this->alignText($dataClass->fieldName));
		$this->assign('textareaField', $dataClass->textareaField);
		$this->assign('selectField', $dataClass->selectField);
		$this->display('../Base/Common/showList');
	}
	
	// 删除
	public function delete() {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $_GET['group'];
		$jzAction = $_GET['action'];
		D('Common')->d($_GET['id']);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 删除多个
	public function deleteList() {
		$idList = split('\|', $_GET['id_list']);
		global $jzGroup;
		global $jzAction;
		$jzGroup = $_GET['group'];
		$jzAction = $_GET['action'];
		D('Common')->dList($idList);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 获取编号名称对应表
	public function getIdNameList() {
		global $jzGroup;
		global $jzAction;
		$jzGroup = $_GET['group'];
		$jzAction = $_GET['action'];
		$res = D('Common')->getIdNameList();
		$this->ajaxReturn($res);
	}
	
	// 获取GET的编号
	public function getGetIdList() {
		$idList = array();
		if (!empty($_GET['id_list'])) {
			$idList = split('\|', $_GET['id_list']);
		} else 
		if (!empty($_GET['id'])) {
			$idList[0] = $_GET['id'];
		}
		return $idList;
	}

	// 对齐文字
	public function alignText($data) {
		$maxLen = 0;
		foreach ($data as $item) {
			$maxLen = max($maxLen, mb_strlen($item, 'utf-8'));
		}
		
		foreach ($data as $key => $item) {
			if ($maxLen == 3 && mb_strlen($item, 'utf-8') == 2) {
				$data[$key] = $item[0].$item[1].$item[2].'　'.$item[3].$item[4].$item[5];
			}
			if ($maxLen == 4 && mb_strlen($item, 'utf-8') == 2) {
				$data[$key] = $item[0].$item[1].$item[2].'　　'.$item[3].$item[4].$item[5];
			}
			if ($maxLen == 4 && mb_strlen($item, 'utf-8') == 3) {
				$data[$key] = $item[0].$item[1].$item[2].'&nbsp;&nbsp;'.$item[3].$item[4].$item[5].'&nbsp;&nbsp;'.$item[6].$item[7].$item[8];
			}
		}
		return $data;
	}
}