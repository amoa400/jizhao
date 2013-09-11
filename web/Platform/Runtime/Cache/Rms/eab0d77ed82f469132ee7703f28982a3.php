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

<link href="/css/manage/page.css" rel="stylesheet" type="text/css">
	
<div id="page">

<div class="page_header">
	<span class="title"><?php echo ($pageTitle); ?></span>
	<span class="close_btn" onclick="window.close()"><img src="/images/icon/close.png"></span>
</div>

<div class="page_content">
	<div class="mytoolbar">
		<a href="<?php echo U('/rms/rms_talent/edit?talent_id='.$talent['talent_id']);?>" target="_blank"><span class="item mybtn mybtn_wide mybtn_primary" style="margin-left:0;">编辑</span></a>
		<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($talent["talent_id"]); ?>号求职者<?php echo ($talent["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('rms/rms_talent/delete?close_window=1&talent_id='.$talent['talent_id']);?>"><span class="item mybtn mybtn_wide mybtn_danger">删除</span></a>
		<span class="item mybtn mybtn_wide mybtn_cancel" onclick="window.close()">关闭</span>
		<span class="item split" md_disabled="1"></span>
		<span class="item mybtn mybtn_wide mybtn_primary" onclick="location.reload()">刷新</span>
	</div>
	
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
	
	<!--
	<div class="information2" style="margin-top:15px;">
		<div class="item">
			<span class="tt">编　　号：</span>
			<?php echo ($talent["talent_id"]); ?>
		</div>
		<div class="item">
			<span class="tt">姓　　名：</span>
			<?php echo ($talent["name"]); ?>
		</div>
		<div class="item">
			<span class="tt">性　　别：</span>
			<?php echo ($talent["gender"]); ?>
		</div>
		<div class="item">
			<span class="tt">年　　龄：</span>
			<?php echo ($talent["age"]); ?>
		</div>
		<div class="item">
			<span class="tt">学　　历：</span>
			<?php echo ($talent["education"]); ?>
		</div>
		<div class="item">
			<span class="tt">职　　位：</span>
			<?php echo ($talent["position"]); ?>
		</div>
		<div class="item">
			<span class="tt">加入时间：</span>
			<?php echo ($talent["join_time"]); ?>
		</div>
		<div class="item">
			<span class="tt">状　　态：</span>
			<?php echo ($talent["status"]); ?>
		</div>
		<div class="item">
			<span class="tt">简　　历：</span>
			<a href="/uploads/<?php echo ($_SESSION["company_id"]); ?>/resume/<?php echo ($talent["talent_id"]); ?>.<?php echo ($talent["resume_extension"]); ?>" target="_blank">点击下载</a>
		</div>
	</div>
	-->
	
</div>


<div class="page_footer">
	即招在线招聘平台（JZhao.cn）
</div>

</div>

<script src="/js/manage/page.js" type="text/javascript" ></script>

	</div>
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
</body>
</html>