<?php

class SysSystemAction extends Action {

	// ��˾����
	public function overview() {
		isLogin(1);
		$com = D('Base/Company')->r($_SESSION['company_id']);
		$com = A('Base/Company')->format($com);
		$this->assign('com', $com);
		$this->display();
	}
	
	// ��Ϣ�޸�
	public function companyInfoEdit() {
		isLogin(1);
		$com = D('Base/Company')->r($_SESSION['company_id']);
		$this->assign('com', $com);
		$this->display();
	}

	// ��Ϣ�޸ģ�����
	public function companyinfoeditdo() {
		isLogin(1);
		$data = $_POST;
		$data['company_id'] = $_SESSION['company_id'];
		$comDo = D('Base/Company');
		$res = $comDo->u($data);
		// ����
		$ret = array();
		if ($res == false) {
			$ret['retStatus'] = 'fail';
			$ret['error'] = $comDo->errorInfo;
		} else {
			$ret['retStatus'] = 'success';
		}
		$this->ajaxReturn($ret);
	}

}