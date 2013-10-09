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

<link href="/css/ois/evaluation.css" rel="stylesheet" type="text/css">

<div class="header">
	<div class="logo">
		<a href="javascript:void(0)"><img src="/images/ois/logo.png"></a>
	</div>
	<div class="toolbar">
		<ul>
			<li><button class="btn btn-warning">稍后再评价</button></li>
			<li class="sub"><button class="btn btn-primary">提交评价</button></li>
		</ul>
	</div>
	<div class="clear"></div>
</div>

<div class="info">
	<div class="title"><span class="glyphicon glyphicon-file"></span>&nbsp;面试信息</div>
	<div class="content">
		<div class="item">
			<span class="tt">面试名称：</span>
			<span class="ct"><?php echo ($interview["name"]); ?></span>
		</div>
		<div class="item">
			<span class="tt">面试者：</span>
			<span class="ct"><?php echo ($interview["talent_name"]); ?></span>
		</div>
		<div class="item">
			<span class="tt">面试官：</span>
			<span class="ct"><?php echo ($interview["interviewer_name"]); ?></span>
		</div>
		<div class="item">
			<span class="tt">开始时间：</span>
			<span class="ct"><?php echo ($interview["real_start_time"]); ?></span>
		</div>
		<div class="item">
			<span class="tt">结束时间：</span>
			<span class="ct"><?php echo ($interview["real_end_time"]); ?></span>
		</div>
		<div class="item">
			<span class="tt">总用时：</span>
			<span class="ct"><?php echo intToUseTime($interview['real_end_time_int'] - $interview['real_start_time_int']); ?></span>
		</div>
		<div class="item" style="border:none;">
			<span class="tt">备注：</span>
			<span class="ct"><?php echo ($interview["remark"]); ?></span>
		</div>
	</div>
</div>

<div class="evaluation">
	<div class="title"><span class="glyphicon glyphicon-check"></span>&nbsp;面试评价</div>
	<textarea name="evaluation" placeholder="请填写您的评价..."><?php echo ($interview["evaluation"]); ?></textarea>
</div>

<script>

	function resetWidthHeight() {
		var bodyWidth = parseInt($('body').css('width'));
		var bodyHeight = parseInt($('body').css('height'));
		var pageWidth = parseInt($('.ois_container').css('width'));
		var pageHeight = parseInt($('.ois_container').css('height'));
		
		$('.info').css('height', pageHeight - 120);
		$('.info').css('width', parseInt(pageWidth * 0.3));
		$('.info .content').css('height', parseInt($('.info').css('height')) - 35);
		
		$('.evaluation').css('height', pageHeight - 120);
		$('.evaluation').css('width', pageWidth - parseInt($('.info').css('width')) - 22);
		$('.evaluation textarea').css('height', parseInt($('.evaluation').css('height')) - 35);
	}

	$(window).resize(function(){
		resetWidthHeight();
	});

	resetWidthHeight();


</script>

<script>

	$('.sub').click(function() {
		$.post('/ois/ois_room/evaluationDo', {id : <?php echo ($interview["interview_id"]); ?>, evaluation : $('textarea').val()},
			function(data) {
				location.href = "/ois/ois_room/end";
			}
		);
	});

</script>


</div>


</body>
</html>