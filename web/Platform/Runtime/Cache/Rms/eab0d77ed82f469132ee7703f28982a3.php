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

<style>
	.icon-repeat  {vertical-align:text-bottom;height:16px;width:13px;}
	.icon-remove {vertical-align:text-bottom;height:16px;width:12px;}
</style>

<div class="header">
	<span class="title">查看求职者 - <?php echo ($talent["name"]); ?></span>
</div>

<!--
<div class="mytoolbar" style="margin-top:15px;">
	<a md_url="/rms/rms_talent/edit/talent_id/<?php echo ($talent["talent_id"]); ?>" onclick="changeTab(this)"><span class="item mybtn mybtn_primary" style="margin-left:0;">编辑</span></a>
	<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($talent["talent_id"]); ?>号求职者<?php echo ($talent["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('rms/rms_talent/delete?close_window=1&talent_id='.$talent['talent_id']);?>"><span class="item mybtn mybtn_primary">删除</span></a>
	<span class="item split" md_disabled="1"></span>
	<span class="item mybtn mybtn_primary" onclick="location.reload()">刷新 <i class="icon-repeat icon-white"></i></span>
	<span class="item mybtn mybtn_cancel" onclick="closeTab()">关闭 <i class="icon-remove icon-white"></i></span>
</div>
-->
	
<div class="mytable mytable_left mytable_firstcol mytable_fullborder" style="margin-top:15px;">
	<table>
		<tr>
			<td width="80px">编　　号：</td>
			<td><?php echo ($talent["talent_id"]); ?></td>
		</tr>
		<tr>
			<td>姓　　名：</td>
			<td><?php echo ($talent["name"]); ?></td>
		</tr>
		<tr>
			<td>性　　别：</td>
			<td><?php echo ($talent["gender"]); ?></td>
		</tr>
		<tr>
			<td>年　　龄：</td>
			<td><?php echo ($talent["age"]); ?></td>
		</tr>
		<tr>
			<td>职　　位：</td>
			<td><?php echo ($talent["position"]); ?></td>
		</tr>
		<tr>
			<td>加入时间：</td>
			<td><?php echo ($talent["join_time"]); ?></td>
		</tr>
		<tr>
			<td>状　　态：</td>
			<td><?php echo ($talent["status"]); ?></td>
		</tr>
		<tr>
			<td>简　　历：</td>
			<td><a href="/uploads/<?php echo ($_SESSION["company_id"]); ?>/resume/<?php echo ($talent["talent_id"]); ?>.<?php echo ($talent["resume_extension"]); ?>" target="_blank">点击下载</a></td>
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