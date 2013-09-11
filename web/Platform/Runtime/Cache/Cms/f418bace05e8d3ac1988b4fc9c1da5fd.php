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
	 <span class="title">信息修改</span>
</div>

<div class="information corner5" style="margin:0;">
	<div class="title"><i class="icon2 icon2_blue icon2_info"></i>&nbsp;&nbsp;基本信息</div>
	<div class="clear"></div>
	<div class="content myform" style="margin-top:15px;">
		<form action="<?php echo U('/cms/cms_company/infoEdit');?>" method="post">
		<div class="item">
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
			<input type="submit" value="修改信息" class="btn btn-primary">
		</div>
		</form>
	</div>
</div>

	</div>
</body>
</html>