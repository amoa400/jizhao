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
	<span class="title">面试官管理</span>
</div>

<div class="mytoolbar mytoolbar_table" style="margin-top:15px;">
	<span class="item mybtn mybtn_primary new_tab" style="margin:0;" md_tab_name="新增面试" md_url="/ois/ois_interviewer/create">新建</span>
	<span class="item item_t mybtn mybtn_primary" md_confirm="1" md_op_url_tmp="<?php echo U('ois/ois_interviewer/deleteList');?>" md_title="确认删除？" md_content="您即将删除您选中的面试官，请确认操作！" md_button_text="删除">删除</span>
	<span class="item split"></span>
	<span class="item mybtn mybtn_primary" onclick="location.reload()">刷新&nbsp;<span class="glyphicon glyphicon-repeat"></span></span>
</div>

<div class="mytable" style="margin-top:15px;">
	<table>
		<tr class="title">
			<th class="sel"><input class="select_all" type="checkbox"></th>
			<th>编号</th>
			<th>姓名</th>
			<th>邮箱</th>
			<th>手机</th>
			<th>操作</th>
		</tr>
		<?php foreach($interviewerList as $interviewer) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo ($interviewer["interviewer_id"]); ?>"></td>
			<td><?php echo ($interviewer["interviewer_id"]); ?></td>
			<td><a class="new_tab" md_url='/ois/ois_interviewer/show/interviewer_id/<?php echo ($interviewer["interviewer_id"]); ?>'><?php echo ($interviewer["name"]); ?></a></td>
			<td><?php echo ($interviewer["email"]); ?></td>
			<td><?php echo ($interviewer["phone"]); ?></td>
			<td>
				<a class="new_tab" md_url="ois/ois_interviewer/edit/interviewer_id/<?php echo ($interviewer["interviewer_id"]); ?>"><span class="mylabel mylabel_info">编辑</span></a>&nbsp;
				<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($interviewer["interviewer_id"]); ?>号面试官-<?php echo ($interviewer["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('ois/ois_interviewer/delete?interviewer_id='.$interviewer['interviewer_id']);?>"><span class="mylabel mylabel_danger">删除</span></a>&nbsp;
				<a href="javascript:void(0)" class="popbox_t" md_box_id="<?php echo ($interviewer["interviewer_id"]); ?>" md_left="-93" md_top="-6px" md_width="85" md_border_width="3" md_background="#ffffff" md_border_color="#468847" md_btn_height="29"><span class="mylabel mylabel_success">更多</span></a>
				<div class="popbox popbox_<?php echo ($interviewer["interviewer_id"]); ?>">
					<span class="btn_item"><a href="/ois/ois_room/show/id/<?php echo ($interview["interview_id"]); ?>" target="_blank">进入房间</a></span>
					<span class="btn_item">安排面试</span>
					<span class="btn_item">录取</span>
					<span class="btn_item">淘汰</span>
					<span class="btn_item">收藏</span>
					<span class="triangle_right"></span>
				</div>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>

<div class="pager">
	<?php if ($pager['cntPage'] != 1) { ?>
	<span class="para_set" md_para_name="page" md_para_value="<?php echo $pager['cntPage'] - 1; ?>">上一页</span>
	<?php } else { ?>
	<span>上一页</span>
	<?php } ?>
	
	<?php  for ($i = $pager['cntPage'] - 3; $i < $pager['cntPage']; $i++) { if ($i <= 0) continue; ?>
	<span class="para_set" md_para_name="page" md_para_value="<?php echo ($i); ?>"><?php echo ($i); ?></span>
	<?php } ?>
	
	<span class="active"><?php echo ($pager["cntPage"]); ?></span>
	
	<?php  for ($i = $pager['cntPage'] + 1; $i <= $pager['cntPage'] + 3; $i++) { if ($i > $pager['totPage']) break; ?>
	<span class="para_set" md_para_name="page" md_para_value="<?php echo ($i); ?>"><?php echo ($i); ?></span>
	<?php } ?>
	
	<?php if ($pager['cntPage'] != $pager['totPage']) { ?>
	<span class="para_set" md_para_name="page" md_para_value="<?php echo $pager['cntPage'] + 1; ?>">下一页</span>
	<?php } else { ?>
	<span>下一页</span>
	<?php } ?>
</div>

<div class="popbox2 popbox2_create">
	<div class="title">新增面试<span class="close_btn"></span></div>
	<div class="content myform" style="">
		123
	</div>
</div>


		<div style="height:20px;">&nbsp;</div>
	</div>
	
	
	<script src="/js/manage/frame.js" type="text/javascript" ></script>
	
	<?php if (!empty($tabTitle)) { ?>
	<script>changeTab2('<?php echo ($tabTitle); ?>');</script>
	<?php } ?>
	
</body>
</html>