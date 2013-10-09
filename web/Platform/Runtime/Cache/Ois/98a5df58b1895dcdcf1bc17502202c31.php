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
	<span class="title">查看<?php echo ($const["title"]); ?> - <?php echo ($data["name"]); ?></span>
</div>

<div class="mytable mytable_left mytable_firstcol mytable_fullborder" style="margin-top:15px;">
	<table>
		<?php foreach($fieldName as $key => $item) { ?>
		<?php  if (in_array($key, $const['hideField'])) continue; ?>
		<tr>
			<td width="80px"><?php echo ($item); ?>：</td>
			<?php if (!empty($const['linkField'][$key])) { ?>
			<td><a class="new_tab" md_url="<?php echo ($const['linkField'][$key]); ?>"><?php echo ($data[$key]); ?></a></td>
			<?php } else { ?>
			<td><?php echo ($data[$key]); ?></td>
			<?php } ?>
		</tr>
		<?php } ?>
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