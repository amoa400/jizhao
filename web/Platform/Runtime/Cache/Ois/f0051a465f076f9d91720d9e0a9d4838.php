<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="面试房间____NAME__在线招聘平台" />
	<title><?php echo ($pageTitle); ?> - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/ois/global.css" rel="stylesheet" type="text/css">

	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
</head>

<body>

<div class="ois_container">

<link href="/css/ois/end.css" rel="stylesheet" type="text/css">

<div class="info">
	<div class="item"><img src="/images/ois/logo.png"></div>
	<?php if ($_SESSION['role'] == 2) { ?>
	<div class="item"><img src="/images/ois/end2.png"></div>
	<?php } else { ?>
	<div class="item"><img src="/images/ois/end.png"></div>
	<?php } ?>
	<div class="item">Copyright © 2013-2014&nbsp;&nbsp;-&nbsp;&nbsp;<a href="/">即招在线招聘平台(JZhao.cn)</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="/about">关于我们</a></div>
</div>

<script>

	function resetWidthHeight() {
		var bodyWidth = parseInt($('body').css('width'));
		var bodyHeight = parseInt($('body').css('height'));
		var pageWidth = parseInt($('.ois_container').css('width'));
		var pageHeight = parseInt($('.ois_container').css('height'));
		
		$('.info').css('padding-top', (pageHeight - 350) / 3);
	}

	$(window).resize(function(){
		resetWidthHeight();
	});

	resetWidthHeight();


</script>


</div>


</body>
</html>