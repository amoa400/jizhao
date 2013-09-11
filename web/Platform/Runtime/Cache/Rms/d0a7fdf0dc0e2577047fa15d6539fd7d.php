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
	<span class="title">编辑求职者</span>
</div>

<div class="myform" style="margin-top:20px;">
	<form action="<?php echo U('rms/rms_talent/createEditDo');?>" method="post">
	<?php if (count($talentList) > 1) { ?>
	<div class="item">
		<span class="tt">统一设定职位：</span>
		<select class="setPosition">
			<?php foreach($positionList as $position) { ?>
			<option value="<?php echo ($position["position_id"]); ?>"><?php echo ($position["name"]); ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="item">&nbsp;</div>
	<?php } ?>
	
	<?php foreach($talentList as $talent) { ?>
	
	<input name="talent_id[]" value="<?php echo ($talent["talent_id"]); ?>" class="hidden">	
	
	<div class="item">
		<span class="tt">简历：</span>
		<input value="<?php echo ($talent["talent_id"]); ?> - <?php echo ($talent["resume_name"]); ?>" disabled="disabled">
	</div>
	<div class="item">
		<span class="tt">姓名：</span>
		<input name="name_<?php echo ($talent["talent_id"]); ?>" type="text" value="<?php echo ($talent["name"]); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">性别：</span>
		<select name="gender_id_<?php echo ($talent["talent_id"]); ?>">
			<option value="1" <?php if ($talent['gender_id'] == 1) echo 'selected="selected"'; ?>>男</option>
			<option value="2" <?php if ($talent['gender_id'] == 2) echo 'selected="selected"'; ?>>女</option>
		</select>
	</div>
	<div class="item">
		<span class="tt">年龄：</span>
		<input name="age_<?php echo ($talent["talent_id"]); ?>" type="text" value="<?php echo ($talent["age"]); ?>">
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">学历：</span>
		<select name="education_id_<?php echo ($talent["talent_id"]); ?>">
			<option value="1" <?php if ($talent['education_id'] == 1) echo 'selected="selected"'; ?>>博士</option>
			<option value="2" <?php if ($talent['education_id'] == 2) echo 'selected="selected"'; ?>>硕士</option>
			<option value="3" <?php if ($talent['education_id'] == 3) echo 'selected="selected"'; ?>>本科</option>
			<option value="4" <?php if ($talent['education_id'] == 4) echo 'selected="selected"'; ?>>专科</option>
			<option value="5" <?php if ($talent['education_id'] == 5) echo 'selected="selected"'; ?>>其他</option>
		</select>
		<span class="tip"></span>
	</div>
	<div class="item">
		<span class="tt">职位：</span>
		<select name="position_id_<?php echo ($talent["talent_id"]); ?>">
			<?php foreach($positionList as $position) { ?>
			<option value="<?php echo ($position["position_id"]); ?>" <?php if ($talent['position_id'] == $position['position_id']) echo 'selected="selected"'; ?>><?php echo ($position["name"]); ?></option>
			<?php } ?>
		</select>
		<span class="tip"></span>
	</div>

	<div class="item">&nbsp;</div>
	<?php } ?>
	
	<div class="item">
		<span class="tt">　　　</span>
		<input type="submit" value="提交" class="mybtn mybtn_primary">
	</div>
	
	<span class="formSubmitingTip hidden">正在提交</span>
	<span class="formDisabled hidden"></span>
	
	</form>
</div>

<script>
	$('.myform .setPosition').change(function() {
		$('.myform select[name^="position_id"]').val($(this).val());
	});
</script>


	</div>
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
</body>
</html>