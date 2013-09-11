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
	<span class="title">系统概览</span>
</div>

<div class="information corner3" style="margin-top:20px;">
	<div class="title"><i class="icon2 icon2_blue icon2_info"></i>&nbsp;&nbsp;系统信息</div>
	<div class="toolbar">
		<a href="#company_info" class="item" onclick="parent.controlMenuClick('company', 'infoEdit');"><i class="icon icon-edit"></i>&nbsp;修改</a>
	</div>
	<div class="clear"></div>
	<div class="content">
		<span class="item">公司名称：<?php echo ($com["realname"]); ?></span>
		<span class="item">电子邮箱：<?php echo ($com["email"]); ?></span>
		<span class="item">联系人员：<?php echo ($com["contact_name"]); ?></span>
		<span class="item">联系电话：<?php echo ($com["phone"]); ?></span>
	</div>
</div>

<div class="information corner3">
	<div class="title"><i class="icon2 icon2_blue icon2_user"></i>&nbsp;&nbsp;工作人员</div>
	<div class="toolbar">
		<a href="#company_info" class="item"><i class="icon icon-edit"></i>&nbsp;修改</a>
	</div>
	<div class="clear"></div>
	<div class="content">
		<span class="item">管理员：1人</span>
		<span class="item">招聘员：0人</span>
		<span class="item">面试官：0人</span>
	</div>
</div>

	</div>
</body>
</html>