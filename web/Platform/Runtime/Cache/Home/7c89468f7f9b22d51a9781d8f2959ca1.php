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

<link href="/css/home/company.css" rel="stylesheet" type="text/css">

<div id="register" class="main_container shadow5w" style="">
	<div class="header">
		<i class="icon icon-user icon-white"></i>&nbsp;即刻登录（尽享一站式的招聘体验）
	</div>
	<div class="form">
		<form class="loginForm" action="<?php echo U('Company/loginDo');?>" method="post">
		<ul>
			<li>
				<span class="star">*</span>
				<span class="tt">电子邮箱：</span>
				<input name="email" type="text">
			</li>
			<li class="password">
				<span class="star">*</span>
				<span class="tt">登录密码：</span>
				<input name="password" type="password" placeholder="">
			</li>
			<li>
				<span class="star"></span>
				<span class="tt"></span>
				<input type="submit" class="btn btn-primary" value="立即登录">
			</li>
		</ul>
		</form>
	</div>
	
	<div class="info">
		<ul>
			<li class="border"><a href="<?php echo U('Company/register');?>">还没账号？免费注册 >></a></li>
			<li>登录遇到问题？</li>
			<li>请拨打 __PHONE__</li>
			<li class="tip">仅限中国大陆手机用户使用拨打免费，不产生任何费用</li>
		</ul>
	</div>
	<div class="clear"></div>
</div>

<style>
	#register {height:240px;overflow:hidden;}
	#register .form {height:165px}
</style>

<script src="/js/home/company.js" type="text/javascript" ></script>


<div id="footer" style="text-align:center;margin-top:20px;margin-bottom:20px;">
	__NAME__在线招聘平台 - JZhao.cn
</div>


</body>
</html>