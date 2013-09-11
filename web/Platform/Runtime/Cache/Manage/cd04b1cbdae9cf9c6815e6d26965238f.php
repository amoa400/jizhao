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

<link href="/css/manage/index.css" rel="stylesheet" type="text/css">

<div id="index" class="main_body">

	<div class="product">
		<div class="title">
			__NAME__产品与服务
		</div>
			
		<div class="item">
			<a href="<?php echo U('/rms/');?>" class="pic manage"></a>
			<ul>
				<li class="tt"><a href="<?php echo U('/rms/');?>">招聘管理（RMS）</a></li>
				<li class="ct"><a href="<?php echo U('/rms/');?>">进入管理 >></a></li>
			</ul>
		</div>
		
		<div class="item">
			<a href="<?php echo U('/ois/');?>" class="pic interview"></a>
			<ul>
				<li class="tt"><a href="<?php echo U('/ois/');?>">在线面试（OIS）</a></li>
				<li class="ct"><a href="<?php echo U('/ois/');?>">进入管理 >></a></li>
			</ul>
		</div>
		
		<div class="item">
			<div class="pic exam"></div>
			<ul>
				<li class="tt">在线笔试（OES）</li>
				<li class="ct"><a href="<?php echo U('/ois/');?>">进入管理 >></a></li>
			</ul>
		</div>
		
		<div class="item">
			<a href="<?php echo U('/cms/');?>" class="pic setting"></a>
			<ul>
				<li class="tt"><a href="<?php echo U('/sys/');?>">系统设置（SYS）</a></li>
				<li class="ct"><a href="<?php echo U('/sys/');?>">进入管理 >></a></li>
			</ul>
		</div>
		
		<div class="clear"></div>
		
		<div class="dividing">&nbsp;</div>
		
		<div class="item">
			<div class="pic other"></div>
			<ul>
				<li class="tt">其他功能（???）</li>
				<li>即将上线</li>
			</ul>
		</div>
		
		<div class="item">
			<div class="pic other"></div>
			<ul>
				<li class="tt">其他功能（???）</li>
				<li>即将上线</li>
			</ul>
		</div>
		
		<div class="item">
			<div class="pic other"></div>
			<ul>
				<li class="tt">其他功能（???）</li>
				<li>即将上线</li>
			</ul>
		</div>
		
		<div class="clear"></div>
	</div>
	
	<div class="info">		
		<div class="item">
			<div class="tt">相关链接</div>
			<ul>
				<li>产品使用手册</li>
				<li>解决方案频道</li>
			</ul>
		</div>
	</div>
	
	<div class="clear"></div>

</div>


<div class="grey"></div>

<script src="/js/manage/global.js" type="text/javascript" ></script>

</body>
</html>