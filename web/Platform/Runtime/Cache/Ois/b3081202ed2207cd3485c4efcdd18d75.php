<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo ($pageTitle); ?> - 管理平台 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/frame.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="frame">


<div class="header">
	<span class="title">新建<?php echo ($const["title"]); ?></span>
</div>

<div class="myform" style="margin-top:15px;">
<form name="form" action="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/createDo" method="post">

	<table>
		<?php foreach ($fieldName as $key => $item) { ?>
		<?php
 if (in_array($key, $const['hideField'])) continue; ?>
		<tr class="item">
			<td class="tt"><?php echo ($item); ?>：</td>
			<td class="cont"><input name="<?php echo ($key); ?>" type="text" class="form-control" value=""></td>
			<td class="tip"></td>
		</tr>
		<?php } ?>
		<tr class="item">
			<td class="tt"></td>
			<td class="cont">
				<input type="submit" value="提交" class="mybtn mybtn_primary">&nbsp;
				<input type="button" value="重置" class="mybtn mybtn_danger" onclick="location.reload()">
			</td>
			<td class="tip"></td>
		</tr>
	</table>
		
	<span class="formSubmitTip hidden">提交</span>
	<span class="formSubmitingTip hidden">正在提交</span>
	<span class="formSuccessTip hidden">提交成功</span>
	<span class="formFailTip hidden">提交失败</span>
	<span class="formDisabled hidden"></span>

</form>
</div>


		<div style="height:20px;">&nbsp;</div>
	</div>
	
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
	
	<?php if (!empty($tabTitle)) { ?>
	<script>changeTab2('<?php echo ($tabTitle); ?>');</script>
	<?php } ?>
	
</body>
</html>