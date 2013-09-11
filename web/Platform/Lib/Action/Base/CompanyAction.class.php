<?php

class CompanyAction extends Action {

	// 格式化
	public function format($com) {
		foreach($com as $key => $item) {
			if ($item == '')
				$com[$key] = '未填写';
		}
		return $com;
	}
}