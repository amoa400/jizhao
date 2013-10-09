<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo ($pageTitle); ?> - 管理平台 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/jizhao-ui.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/frame.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript"></script>
	<script src="/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/js/jizhao-ui.js" type="text/javascript"></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="frame">

<div class="header">
	<span class="title">编辑求职者 - <?php echo ($talent["name"]); ?></span>
</div>

<div class="myform" style="margin-top:15px;">
	<form name="form" action="<?php echo U('/rms/rms_talent/editDo');?>" method="post"  enctype="multipart/form-data">
		<div class="item">
			<span class="tt">编号：</span>
			<input type="text" value="<?php echo ($talent["talent_id"]); ?>" disabled="disabled">
			<input name="talent_id" type="text" value="<?php echo ($talent["talent_id"]); ?>" class="hidden">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">姓名：</span>
			<input name="name" type="text" value="<?php echo ($talent["name"]); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">性别：</span>
			<select name="gender_id">
				<option value="1" <?php if ($talent['gender_id'] == 1) echo 'selected="selected"'; ?>>男</option>
				<option value="2" <?php if ($talent['gender_id'] == 2) echo 'selected="selected"'; ?>>女</option>
			</select>
		</div>
		<div class="item">
			<span class="tt">年龄：</span>
			<input name="age" type="text" value="<?php echo ($talent["age"]); ?>">
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">学历：</span>
			<select name="education_id">
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
			<select name="position_id">
				<?php foreach($positionList as $position) { ?>
				<option value="<?php echo ($position["position_id"]); ?>" <?php if ($talent['position_id'] == $position['position_id']) echo 'selected="selected"'; ?>><?php echo ($position["name"]); ?></option>
				<?php } ?>
			</select>
			<span class="tip"></span>
		</div>
		<div class="item">
			<span class="tt">简历：</span>
			<input name="resume" type="file" class="hidden">
			<input type="button" class="mybtn mybtn_success upload_btn" style="width:226px;" md_default_value="上传新简历">
			<span class="tip"></span>
		</div>			
		<div class="item">
			<span class="tt">　　　</span>
			上传新简历后会覆盖原简历，并自动解析简历信息
		</div>
		<div class="item">
			<span class="tt">　　　</span>
			<input type="submit" value="修改" class="mybtn mybtn_primary">&nbsp;
			<input type="button" value="重置" class="mybtn mybtn_danger" onclick="location.reload()">&nbsp;
			<!--<input type="button" value="关闭" class="mybtn mybtn_cancel" onclick="closeTab()">-->
		</div>

		<span class="formSubmitTip hidden">修改</span>
		<span class="formSubmitingTip hidden">正在修改</span>
		<span class="formSuccessTip hidden">修改成功</span>
		<span class="formFailTip hidden">修改失败</span>
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