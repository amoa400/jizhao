<?php

class RmsPositionAction extends Action {
	// 初始化
	public function _initialize() {
		isLogin(1);
	}
	
	// 显示列表
	public function showList() {
		// 获取列表
		$ret = D('Rms/RmsPosition')->rList($_GET);
		$positionList = $ret['data'];
		
		// 分页信息
		$pager['count'] = $ret['count'];
		$pager['cntPage'] = $_GET['page'];
		if (empty($pager['cntPage'])) $pager['cntPage'] = 1;
		$pager['totPage'] =  ceil($pager['count'] / 20);

		foreach($positionList as $key => $position) {
			$positionList[$key] = $this->format($position);
			// 缩短描述
			$positionList[$key]['description'] = msubstr($position['description'], 0, 100);
		}
		$this->assign('positionList', $positionList);
		$this->assign('pager', $pager);
		$this->display();
	}
	
	// 创建
	public function create() {
		$this->display();
	}
	
	// 创建处理
	public function createDo() {
		$posDo = D('RmsPosition');
		$res = $posDo->c($data);
		// 返回
		$ret = array();
		if ($res == false) {
			$ret['retStatus'] = 'fail';
			$ret['error'] = $posDo->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
			$ret['jumpAction'] = 'position';
			$ret['jumpFunc'] = 'showList';
		}
		$this->ajaxReturn($ret);
	}
	
	// 修改职位
	public function edit() {
		$position = D('RmsPosition')->r($_GET['position_id']);
		$this->assign('position', $position);
		$this->assign('pageTitle', '编辑职位 - ' . $position['name']);
		$this->display();
	}
	
	// 修改职位（处理）
	public function editDo() {
		$posDo = D('RmsPosition');
		$res = $posDo->u();
		// 返回
		if ($res == false && !empty($posDo->errorInfo)) {
			$ret['retStatus'] = 'fail';
			$ret['error'] = $posDo->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
		}
		$this->ajaxReturn($ret);
	}
	
	// 显示职位
	public function show() {
		$position = D('RmsPosition')->r($_GET['position_id']);
		$position = $this->format($position);
		$this->assign('position', $position);
		$this->assign('pageTitle', '查看职位 - ' . $position['name']);
		$this->display();
	}
	
	// 删除职位
	public function delete() {
		D('RmsPosition')->d($_GET['position_id']);
		if ($_GET['close_window'] == 1) {
			echo '<script>window.close()</script>';
		}
		else {
			$this->success('删除成功！');
		}
	}
	
	//  删除列表
	public function deleteList() {
		$positionIdList = split('\|', $_GET['id_list']);
		foreach($positionIdList as $positionId) {
			if (empty($positionId)) continue;
			D('RmsPosition')->d($positionId);
		}
		$this->success('删除成功！');
	}
	
	// 格式化
	public function format($position) {
		// 时间
		$position['create_time'] = IntToTime($position['create_time_int']);
		// 状态
		switch ($position['status_id']) {
			case 1:
				$position['status'] = '未发布';
				break;
			default:
				$position['status'] = '未知';
		}
		return $position;
	}
}