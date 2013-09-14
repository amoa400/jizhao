<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="description" content="管理平台 - __NAME__" />
	<title><?php echo ($pageTitle); ?> - 管理平台 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/manage/global.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="/js/global.js" type="text/javascript" ></script>
</head>

<body>

<div id="header">
	<div class="logo">
		<a href="<?php echo U('/manage/');?>"><img src="/images/logo.png"></a>
	</div>
	<div class="naviRight">
		<ul>
			<li><?php echo (session('user_name')); ?></li>
			<li><?php echo (session('company_name')); ?></li>
			<li>帮助</li>
			<a href="<?php echo U('/home/company/logout');?>"><li style="border:0;">退出</li></a>
		</ul>
	</div>
	<div class="clear"></div>
</div>

<link href="/css/manage/product.css" rel="stylesheet" type="text/css">

<div id="product">



<div class="control_menu">
	<a href="<?php echo U('rms/rms_talent/showList');?>" class="item <?php if ($pageTitle == '求职者管理') echo 'item_active'; ?>"><i class="icon1 icon1_blue icon1_user1"></i>&nbsp;&nbsp;&nbsp;求职者管理</a>
	<a href="<?php echo U('rms/rms_position/showList');?>" class="item <?php if ($pageTitle == '职位管理') echo 'item_active'; ?>"><i class="icon1 icon1_blue icon1_user1"></i>&nbsp;&nbsp;&nbsp;职位管理</a>
</div>

<div class="main_body">
<div class="main_body2">

<style>
	.icon-repeat  {vertical-align:text-bottom;height:16px;width:13px;}
	.icon-chevron-up {vertical-align:text-bottom;height:16px;width:12px;}
	.icon-chevron-down {vertical-align:text-bottom;height:16px;width:12px;}
</style>

<div class="head">
	<span class="title">职位列表</span>
</div>

<div class="mytoolbar mytoolbar_table" style="margin-top:15px;">
	<span class="item mybtn mybtn_primary" style="margin:0;" md_op_url_tmp="<?php echo U('rms/rms_position/publish');?>">发布</span>
	<span class="item mybtn mybtn_primary" md_op_url_tmp="<?php echo U('rms/rms_position/end');?>">结束</span>
	<span class="item mybtn mybtn_primary" md_id_name="talent_id" md_confirm="1" md_op_url_tmp="<?php echo U('rms/rms_position/deleteList');?>" md_title="确认删除？" md_content="您即将删除您选中的求职者，请确认操作！" md_button_text="删除">删除</span>
	<span class="item split" md_disabled="1"></span>
	<span class="item mybtn mybtn_primary" md_click_func="location.reload()">刷新 <i class="icon-repeat icon-white"></i></span>
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="1" md_para_nojump="1" md_click_func="$('.filter').show();$(this).hide();$(this).next().show();" <?php if (!empty($_GET['filter'])) echo 'style="display:none;"'; ?>>筛选 <i class="icon-chevron-down icon-white"></i></span>
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="0" md_para_nojump="1"  md_click_func="$('.filter').hide();$(this).hide();$(this).prev().show();" <?php if (empty($_GET['filter'])) echo 'style="display:none;"'; ?>>筛选 <i class="icon-chevron-up icon-white"></i></span>
</div>

<div class="filter" <?php if (empty($_GET['filter'])) echo 'style="display:none;"'; ?>>
	<form class="filter_form para_set_form">
	<div class="item">
		<div class="title">状态：</div>
		<div class="content">
			<span class="link link_active para_set" md_para_name="status_id" md_para_value="0">不限</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="1">未发布</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="2">已发布</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="3">已结束</span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="split">&nbsp;</div>
	<div class="item">
		<div class="title input_height">编号：</div>
		<div class="content">
			<span><input name="position_id" value="<?php echo ($_GET["position_id"]); ?>" placeholder="XX" style="width:30px"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">名称：</div>
		<div class="content">
			<span><input name="name" value="<?php echo ($_GET["name"]); ?>" placeholder="请输入职位名称" style="width:120px"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">人数：</div>
		<div class="content">
			<span style="margin-right:5px;"><input name="enrollment_st" value="<?php echo ($_GET["enrollment_st"]); ?>" placeholder="XX" style="width:20px;"></span>
			<span style="margin-right:5px;">-</span>
			<span><input name="enrollment_ed" value="<?php echo ($_GET["enrollment_ed"]); ?>" placeholder="XX" style="width:20px;"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">　　　</div>
		<div class="content">
			<span><input class="mybtn mybtn_success" type="submit" value="筛选"></span>
		</div>
		<div class="clear"></div>
	</div>
	</form>
</div>

<div class="mytable" style="margin-top:15px;">
	<table>
		<tr class="title">
			<th class="sel"><input class="select_all" type="checkbox"></th>
			<th>编号</th>
			<th width="15%">职位名称</th>
			<th width="30%">职位描述</th>
			<th>报名人数</th>
			<th>创建时间</th>
			<th>状态</th>
			<th style="min-width:140px">操作</th>
		</tr>
		<?php foreach($positionList as $position) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo ($position["position_id"]); ?>"></td>
			<td><?php echo ($position["position_id"]); ?></td>
			<td><?php echo ($position["name"]); ?></td>
			<td class="left"><?php echo ($position["description"]); ?></td>
			<td><?php echo ($position["enrollment"]); ?></td>
			<td><?php echo ($position["create_time"]); ?></td>
			<td><?php echo ($position["status"]); ?></td>
			<td>
				<a href="#"><a href="<?php echo U('/rms/rms_position/show?position_id='.$position['position_id']);?>" target="_blank"><span class="mylabel mylabel_success">查看</span></a>&nbsp;
				<a href="<?php echo U('rms/rms_position/edit?position_id='.$position['position_id']);?>" target="_blank"><span class="mylabel mylabel_info">编辑</span></a>&nbsp;
				<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($position["position_id"]); ?>号职位<?php echo ($position["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('rms/rms_position/delete?position_id='.$position['position_id']);?>"><span class="mylabel mylabel_danger">删除</span></a>
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

	
	</div>
	</div>
	
	<div class="clear"></div>
</div>

<script src="/js/manage/product.js" type="text/javascript" ></script>


<div class="grey"></div>

<script src="/js/manage/global.js" type="text/javascript" ></script>

</body>
</html>