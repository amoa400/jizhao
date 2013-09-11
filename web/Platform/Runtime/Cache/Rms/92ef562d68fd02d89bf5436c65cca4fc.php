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

<div class="header">
	<span class="title">新增求职者</span>
</div>

<div class="information2" style="margin-top:45px;text-align:center;">
	<div class="item myform">
		<form action="<?php echo U('/rms/rms_talent/createDo');?>" method="post" enctype="multipart/form-data">
			<input name="resume[]" type="file" onchange="$(this).submit()" multiple="multiple" class="hidden">
			<input type="button" class="mybtn mybtn_primary submitBtn" style="padding:15px 60px;" onclick="$('input[type=file]').click()" value="上传简历" md_default_value="上传简历">
			<span class="formSubmitingTip hidden">正在上传...</span>
			<span class="formDisabled hidden"></span>
			<span class="formForceSubmit hidden">1</span>
			<span class="formSubmitBtnName hidden">submitBtn</span>
		</form>
	</div>
	<div class="item">
		可批量上传，支持格式：pdf,doc,docx,txt
	</div>
	<div class="item myform">

	</div>
</div>

	</div>
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
</body>
</html>