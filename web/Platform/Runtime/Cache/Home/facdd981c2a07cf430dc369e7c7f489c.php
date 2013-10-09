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
				<a href="/company/register"><li class="btn btn-warning">免费注册</li></a>
				<a href="/company/login/id/1"><li class="btn btn-info">即刻登录</li></a>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>

<link href="/css/home/company.css" rel="stylesheet" type="text/css">

<div id="register" class="main_container shadow5w">
	<div class="header">
		<i class="icon icon-user icon-white"></i>&nbsp;公司注册（请务必填写真实信息）
	</div>
	<div class="form">
		<form class="registerForm" action="<?php echo U('Company/registerDo');?>" method="post">
		<ul>
			<li class="realname">
				<span class="star">*</span>
				<span class="tt">公司名称：</span>
				<input name="realname" type="text">
				<span class="tip">请填写公司或者组织的名称</span>
			</li>
			<li class="email">
				<span class="star">*</span>
				<span class="tt">电子邮箱：</span>
				<input name="email" type="text">
				<span class="tip">请填写公司或者组织邮箱地址</span>
			</li>
			<li class="password">
				<span class="star">*</span>
				<span class="tt">登录密码：</span>
				<input name="password" type="password" placeholder="">
				<span class="tip">6~20位，区分大小写</span>
			</li>
			<li class="rePassword">
				<span class="star">*</span>
				<span class="tt">重复密码：</span>
				<input name="rePassword" type="password" placeholder="">
				<span class="tip">请重复您的密码</span>
			</li>
			<li class="phone">
				<span class="star"></span>
				<span class="tt">公司电话：</span>
				<input name="phone" type="text" placeholder="">
				<span class="tip">请填写公司或者组织的电话</span>
			</li>
			<li class="contact_name">
				<span class="star"></span>
				<span class="tt">联系人：</span>
				<input name="contact_name" type="text" placeholder="">
				<span class="tip">请填写联系人姓名</span>
			</li>
			<li>
				<span class="star"></span>
				<span class="tt"></span>
				<input type="submit" class="btn btn-primary" value="立即注册">
			</li>
			<li class="rule">
				<span class="star"></span>
				<span class="tt"></span>
				<span class="ct">点击注册表示您已阅读并同意<a href="#">《__NAME__服务条款》</a></span>
			</li>
		</ul>
		</form>
	</div>
	
	<div class="info">
		<ul>
			<li class="border"><a href="<?php echo U('Company/login');?>">已有账号，直接登录 >></a></li>
			<li>快速注册：</li>
			<li>请拨打 __PHONE__</li>
			<li class="tip">仅限中国大陆手机用户使用拨打免费，不产生任何费用</li>
			<!--
			<li>合作客户：</li>
			<li>
				<span class="hz" style="margin:0;"><a href="#"><img src="/images/base/company/register_hz1.png"></a></span>
				<span class="hz" style="margin-top:0;"><a href="#"><img src="/images/base/company/register_hz2.png"></a></span>
				<span class="hz" style="margin-left:0;"><a href="#"><img src="/images/base/company/register_hz3.png"></a></span>
				<span class="hz"><a href="#"><img src="/images/base/company/register_hz4.png"></a></span>
				<div class="clear"></div>
			</li>
			-->
		</ul>
	</div>
	<div class="clear"></div>
</div>


<script src="/js/home/company.js" type="text/javascript" ></script>


<div id="footer" style="text-align:center;margin-top:20px;margin-bottom:20px;">
	__NAME__在线招聘平台 - JZhao.cn
</div>


</body>
</html>