<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="description" content="__NAME__ - 在线招聘平台" />
	<title>__NAME__ - 在线招聘平台</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/home/global.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="header" class="shadow5b">
	<div class="main_container">
		<div class="logo">
			<a href="/"><img src="/images/logo.png"></a>
		</div>
		<div class="navi">
			<ul>
				<a href="/"><li class="normal active">即招首页</li></a>
				<li class="normal">产品简介</li>
				<li class="normal">价格方案</li>
				<li class="normal">关于我们</li>
				<a href="<?php echo U('Company/register');?>"><li class="btn btn-warning">免费注册</li></a>
				<a href="<?php echo U('Company/login');?>"><li class="btn btn-info">即刻登录</li></a>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>



<div id="footer" style="text-align:center;margin-top:20px;margin-bottom:20px;">
	__NAME__在线招聘平台 - JZhao.cn
</div>


</body>
</html>