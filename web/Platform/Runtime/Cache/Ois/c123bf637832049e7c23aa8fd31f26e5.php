<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo ($pageTitle); ?> - 管理平台 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/jizhao-ui.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/frame.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript"></script>
	<script src="/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/js/jizhao-ui.js" type="text/javascript"></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="frame">

<style>
.myform .item .tt {width:75px;}
</style>

<div class="header">
	<span class="title"><?php echo ($tabTitle); ?></span>
</div>

<div class="myform" style="margin-top:15px;">
	<form name="form" action="<?php echo U('/ois/ois_interview/createDo');?>" method="post">
		<div class="item">
			<span class="tt">面&nbsp;&nbsp;试&nbsp;&nbsp;者：</span>
			<input name="talent_id" type="text" value="<?php echo ($talent["talent_id"]); ?>" style="display:none;">
			<input name="talent_name" type="text" value="<?php echo ($talent["name"]); ?>" style="display:none;">
			<input type="text" value="<?php echo ($talent["name"]); ?>" disabled="disabled">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">面&nbsp;&nbsp;试&nbsp;&nbsp;官：</span>
			<input name="interviewer_id" type="text">
			<input name="interviewer_name" type="text" style="display:none;">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">开始时间：</span>
			<input name="start_time" type="text" placeholder="YYYY-MM-DD HH:II">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">名　　称：</span>
			<input name="name" type="text">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">备　　注：</span>
			<textarea name="remark" class="wide_textarea"></textarea>
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">　　　　　</span>
			<input type="submit" value="创建" class="mybtn mybtn_primary">&nbsp;
			<input type="button" value="重置" class="mybtn mybtn_danger" onclick="location.reload()">&nbsp;
		</div>

		<span class="formSubmitTip hidden">创建</span>
		<span class="formSubmitingTip hidden">正在创建</span>
		<span class="formSuccessTip hidden">创建成功</span>
		<span class="formFailTip hidden">创建失败</span>
		<span class="formDisabled hidden"></span>
	</form>
</div>


		<div style="height:20px;">&nbsp;</div>
	</div>

	<script src="/js/manage/frame.js" type="text/javascript" ></script>
	
	<?php if (!empty($tabTitle)) { ?>
	<script>changeTab2('<?php echo ($tabTitle); ?>');</script>
	<?php } ?>
	
</body>
</html>