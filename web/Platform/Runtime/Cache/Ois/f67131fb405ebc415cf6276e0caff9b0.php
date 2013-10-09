<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="description" content="管理平台 - __NAME__" />
	<title><?php echo ($pageTitle); ?> - 管理平台 - __NAME__</title>

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

<div id="product">



<div class="control_menu">
	<a href="#interview_showList" class="item" ><i class="icon1 icon1_blue icon1_user1"></i>&nbsp;&nbsp;&nbsp;面试管理</a>
	<span class="item" href="<?php echo U('/ois/ois_interview/showList');?>" ><i class="icon1 icon1_blue icon1_user1"></i>&nbsp;&nbsp;&nbsp;面试官管理</span>
	<span class="item" href="<?php echo U('/ois/ois_interview/showList');?>" ><i class="icon1 icon1_blue icon1_user1"></i>&nbsp;&nbsp;&nbsp;模板管理</span>
	<span class="split">&nbsp;</span>
</div>

<div class="main_body">


	<iframe class="main_frame">
	</iframe>
	
	<div class="clear"></div>
</div>

	
	</div>
	</div>
	
	<div class="clear"></div>
</div>

<script src="/js/manage/product.js" type="text/javascript" ></script>


<div class="grey"></div>

<script src="/js/manage/global.js" type="text/javascript" ></script>

</body>
</html>