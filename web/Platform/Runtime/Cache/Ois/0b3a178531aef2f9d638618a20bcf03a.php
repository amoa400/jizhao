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


<style>
	.myform .item .tt {width:<?php echo ($const["fieldWidth"]); ?>px;}
</style>
	
<div class="header">
	<span class="title">编辑<?php echo ($const["title"]); ?> - <?php echo ($data["name"]); ?></span>
</div>

<div class="myform" style="margin-top:15px;">
	<form name="form" action="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/editDo" method="post">
		<?php foreach ($fieldName as $key => $item) { ?>
		<?php
 if (in_array($key, $const['hideField'])) continue; ?>
		<div class="item">
			<span class="tt"><?php echo ($fieldName[$key]); ?>：</span>
			<?php if (!empty($selectField[$key])) { ?>
			<select name="<?php echo ($key); ?>">
				<?php foreach($selectField[$key] as $key2 => $item2) { ?>
				<option value="<?php echo ($key2); ?>" <?php if ($key2 == $data[$key]) echo 'selected="selected"'; ?>><?php echo ($item2); ?></option>
				<?php } ?>
			</select>
			<?php } else if (in_array($key, $textareaField)) { ?>
			<textarea name="<?php echo ($key); ?>"><?php echo ($data[$key]); ?></textarea>
			<?php } else if (in_array($key, $const['disableField'])) { ?>
			<input type="text" name="<?php echo ($key); ?>" value="<?php echo ($data[$key]); ?>" style="display:none;">
			<input type="text" value="<?php echo ($data[$key]); ?>" disabled="disabled">
			<?php } else { ?>
			<input type="text" name="<?php echo ($key); ?>" value="<?php echo ($data[$key]); ?>">
			<?php } ?>
			<span class="tip"></span>
		</div>
		<?php } ?>
		<div class="item">
			<span class="tt"></span>
			<input type="submit" value="保存" class="mybtn mybtn_primary">&nbsp;
			<input type="button" value="重置" class="mybtn mybtn_danger" onclick="location.reload()">&nbsp;
		</div>
		
		<span class="formSubmitTip hidden">保存</span>
		<span class="formSubmitingTip hidden">正在保存</span>
		<span class="formSuccessTip hidden">保存成功</span>
		<span class="formFailTip hidden">保存失败</span>
		<span class="formDisabled hidden"></span>
		<span class="formForceSubmit hidden"></span>
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