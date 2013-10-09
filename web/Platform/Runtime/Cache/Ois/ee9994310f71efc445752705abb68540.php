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
	<span class="title">查看面试 - <?php echo ($interview["name"]); ?></span>
</div>
	
<div class="mytable mytable_left mytable_firstcol mytable_fullborder" style="margin-top:15px;">
	<table>
		<tr>
			<td width="80px">编　　号：</td>
			<td><?php echo ($interview["interview_id"]); ?></td>
		</tr>
		<tr>
			<td>名　　称：</td>
			<td><?php echo ($interview["name"]); ?></td>
		</tr>
		<tr>
			<td>面&nbsp;&nbsp;试&nbsp;&nbsp;者：</td>
			<td><a class="new_tab" md_url="/rms/rms_talent/show/talent_id/<?php echo ($interview["talent_id"]); ?>"><?php echo ($interview["talent_name"]); ?></a></td>
		</tr>
		<tr>
			<td>面&nbsp;&nbsp;试&nbsp;&nbsp;官：</td>
			<td><a class="new_tab" md_url="/ois/ois_interviewer/show/interviewer_id/<?php echo ($interview["interviewer_id"]); ?>"><?php echo ($interview["interviewer_name"]); ?></a></td>
		</tr>
		<tr>
			<td>备　　注：</td>
			<td><?php echo ($interview["remark"]); ?></td>
		</tr>
		<tr>
			<td>开始时间：</td>
			<td><?php echo ($interview["start_time"]); ?></td>
		</tr>
		<tr>
			<td>结束时间：</td>
			<td><?php echo ($interview["end_time"]); ?></td>
		</tr>
		<tr>
			<td>状　　态：</td>
			<td><?php echo ($interview["status"]); ?></td>
		</tr>
		<tr>
			<td>评　　价：</td>
			<td><?php echo ($interview["evaluation"]); ?></td>
		</tr>
	</table>
</div>


		<div style="height:20px;">&nbsp;</div>
	</div>
	
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
	
	<?php if (!empty($tabTitle)) { ?>
	<script>changeTab2('<?php echo ($tabTitle); ?>');</script>
	<?php } ?>
	
</body>
</html>