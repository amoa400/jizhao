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

<link rel="stylesheet" href="http://nicolasgallagher.com/lab/css3-github-buttons/gh-buttons.css">

<div class="header">
	<span class="title">公司设置</span>
</div>

<div class="myform" style="margin-top:20px;">
	<form action="<?php echo U('/sys/sys_system/companyInfoEditDo');?>" method="post">
		<div class="item" style="margin:0;">
			<span class="tt">公司名称：</span>
			<input name="realname" type="text" value="<?php echo ($com['realname']); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">电子邮箱：</span>
			<input name="email" type="text" value="<?php echo ($com['email']); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">联系人员：</span>
			<input name="contact_name" type="text" value="<?php echo ($com['contact_name']); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">联系电话：</span>
			<input name="phone" type="text" value="<?php echo ($com['phone']); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">　　　　　</span>
			<input type="submit" value="保存" class="mybtn mybtn_primary">
		</div>
		
		<span class="formSubmitTip hidden">保存</span>
		<span class="formSubmitingTip hidden">正在保存</span>
		<span class="formSuccessTip hidden">保存成功</span>
		<span class="formFailTip hidden">保存失败</span>
		<span class="formDisabled hidden"></span>
	</form>
</div>

	</div>
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
</body>
</html>