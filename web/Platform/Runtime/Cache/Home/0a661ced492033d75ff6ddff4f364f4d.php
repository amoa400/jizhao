<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="description" content="即招 - 在线招聘平台" />
	<title>身份验证 - 即招</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/home/login.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
	
</head>

<body>


<div class="header">
	<div class="logo">
		<img src="/images/home/login/logo.png">
	</div>
	<div class="clearfix"></div>
</div>

<div class="main">
<div class="main2">
	<div class="poster"><img src="/images/home/login/poster.png"></div>
	
	<div class="form" style="margin-top:40px;">
		<input name="company_id" value="<?php echo ($company["company_id"]); ?>" style="display:none;">
		<div class="title"><span class="glyphicon glyphicon-home"></span> 欢迎回来</div>
		<div class="input-group" style="text-align:center;width:100%;font-size:40px;">
		  <?php echo (session('user_name')); ?>
		</div>
		<div class="input-group" style="text-align:center;width:100%;">
			<a href="/talent/logout">登出</a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</div>

<div class="footer">
Copyright © 2013-2014&nbsp;&nbsp;-&nbsp;&nbsp;<a href="/">即招在线招聘平台(JZhao.cn)</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="#">关于我们</a>
</div>

<script>

	var flag = false;

	$('.submit').click(function() {
		if (flag) return;
		flag = true;
		
		var thisObj = this;
		$(thisObj).val('登录中...');
		$(thisObj).addClass('btn-warning');
		
		var company_id = $('input[name="company_id"]').val();
		var email = $('input[name="email"]').val();
		var password = $('input[name="password"]').val();
		var remember = 0;
		if ($('input[name="remember"]').attr('checked') != null) remember = 1;

		$.post('/talent/loginDo', {company_id : company_id, email : email, password : password, remember : remember},
			function(res) {
				if (res.status == 'succeed') {
					location.href = res.jumpUrl;
				} else {
					$(thisObj).val('登录失败');
					$(thisObj).addClass('btn-danger');
					$(thisObj).removeClass('btn-warning');
					setTimeout('$(".submit").val("登　录");$(".submit").removeClass("btn-danger");', 2000);
				}
				flag = false;
			}
		);
	});
	
	$('input').bind("keydown", function(e) {
		if (e.which == 13) {
			$('.submit').click();
		}
	});

</script>

</body>
</html>