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
</head>

<body>

<div id="frame">

<div class="header">
	<span class="title">公司信息修改</span>
</div>

<div class="myform" style="margin-top:20px;">
	<form action="<?php echo U('/cms/cms_company/infoEditDo');?>" method="post">
	<div class="item" style="margin:0;">
		<span class="tt">公司名称：</span>
		<input type="text" value="<?php echo ($com['realname']); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">电子邮箱：</span>
		<input type="text" value="<?php echo ($com['email']); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">联系人员：</span>
		<input type="text" value="<?php echo ($com['contact_name']); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">联系电话：</span>
		<input type="text" value="<?php echo ($com['phone']); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">　　　　　</span>
		<input type="submit" value="保存" class="btn btn-primary">
	</div>
	</form>
</div>

	</div>
</body>
</html>