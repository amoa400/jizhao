<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/frame.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
	
	<title><?php echo ($pageTitle); ?> - 即招</title>
</head>

<body>

<div id="frame">

<style>
	.myform textarea {width:500px;height:80px;}
</style>

<div class="header">
	<span class="title">新建职位</span>
</div>

<div class="myform" style="margin-top:20px;">
	<form action="<?php echo U('/rms/rms_position/createDo');?>" method="post">
		<div class="item" style="margin:0;">
			<span class="tt">职位名称：</span>
			<input name="name" type="text" value="<?php echo ($com['realname']); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">职位描述：</span>
			<textarea name="description"></textarea>
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">职位要求：</span>
			<textarea name="requirement"></textarea>
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">　　　　　</span>
			<input type="submit" value="新增" class="mybtn mybtn_primary">
		</div>
		
		<span class="formSubmitTip hidden">新增</span>
		<span class="formSubmitingTip hidden">正在提交</span>
		<span class="formSuccessTip hidden">新增成功</span>
		<span class="formFailTip hidden">新增失败</span>
		<span class="formDisabled hidden"></span>
	</form>
</div>

	</div>
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
</body>
</html>