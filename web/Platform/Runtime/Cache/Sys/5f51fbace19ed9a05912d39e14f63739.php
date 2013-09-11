<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="description" content="管理平台 - __NAME__" />
	<title>管理平台 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/global.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="header">
	<div class="logo">
		<a href="<?php echo U('/manage/');?>"><img src="/images/logo.png"></a>
	</div>
	<div class="naviRight">
		<ul>
			<li><?php echo (session('user_name')); ?></li>
			<li><?php echo (session('company_name')); ?></li>
			<li>帮助</li>
			<a href="<?php echo U('/home/company/logout');?>"><li style="border:0;">退出</li></a>
		</ul>
	</div>
	<div class="clear"></div>
</div>

<link href="/css/manage/product.css" rel="stylesheet" type="text/css">

<div id="product" class="main_body">

<div name="sys" class="control_menu">

	<div name="system" class="item">
		<span class="lv1">
			<i class="icon1 icon1_blue icon1_overview"></i>&nbsp;&nbsp;&nbsp;系统设置
		</span>
		<div class="sub">
			<span name="overview" class="lv2">
				<i class="icon1 icon1_blank"></i>&nbsp;&nbsp;&nbsp;系统概览
			</span>
			<span name="companyInfoEdit" class="lv2">
				<i class="icon1 icon1_blank"></i>&nbsp;&nbsp;&nbsp;公司设置	
			</span>
		</div>
	</div>
	
</div>

<script>
	$(document).ready(function() {
		var hash = window.location.hash;
		if (hash != '') {
			hash[0] = '1';
			var temp = hash.split('#');
			hash = temp[1];
			var name = hash.split('_');
			$('.item[name="'+ name[0] +'"] .lv2[name="' + name[1] + '"]').click();
		}
		else $('.item[name="system"] .lv2[name="overview"]').click();
	});
</script>

	<iframe class="main_frame">
	</iframe>
	
	<div class="clear"></div>
</div>

	
	<div class="clear"></div>
</div>

<script src="/js/manage/product.js" type="text/javascript" ></script>


<div class="grey"></div>

<script src="/js/manage/global.js" type="text/javascript" ></script>

</body>
</html>