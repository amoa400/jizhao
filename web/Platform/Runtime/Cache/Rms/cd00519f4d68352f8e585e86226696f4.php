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
	<span class="title">求职者列表</span>
</div>

<div class="mytoolbar mytoolbar_table" style="margin-top:15px;">
	<span class="item item_t mybtn mybtn_primary" style="margin:0;" md_op_url_tmp="<?php echo U('rms/rms_talent/arrangeExam');?>">安排笔试</span>
	<span class="item item_t mybtn mybtn_primary" md_op_url_tmp="<?php echo U('rms/rms_talent/arrangeInterview');?>">安排面试</span>
	<span class="item item_t mybtn mybtn_primary" md_op_url_tmp="<?php echo U('rms/rms_talent/hire');?>">录用</span>
	<span class="item item_t mybtn mybtn_primary" md_op_url_tmp="<?php echo U('rms/rms_talent/eliminate');?>">淘汰</span>
	<span class="item item_t mybtn mybtn_primary" md_id_name="talent_id" md_confirm="1" md_op_url_tmp="<?php echo U('rms/rms_talent/deleteList');?>" md_title="确认删除？" md_content="您即将删除您选中的求职者，请确认操作！" md_button_text="删除">删除</span>
	<span class="item split"></span>
	<span class="item mybtn mybtn_primary" onclick="location.reload()">刷新 <i class="icon-repeat icon-white"></i></span>
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="1" md_para_nojump="1" onclick="$('.filter').show();$(this).hide();$(this).next().show();" <?php if (!empty($_GET['filter'])) echo 'style="display:none;"'; ?>>筛选 <i class="icon-chevron-down icon-white"></i></span>
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="0" md_para_nojump="1"  onclick="$('.filter').hide();$(this).hide();$(this).prev().show();" <?php if (empty($_GET['filter'])) echo 'style="display:none;"'; ?>>筛选 <i class="icon-chevron-up icon-white"></i></span>
	<span class="item split"></span>
	<span class="item mybtn mybtn_primary popbox_t" md_box_id="">新增</span>
	<span class="item mybtn mybtn_primary popbox2_t" md_box_id="multi">批量上传</span>
</div>

<div class="filter" <?php if (empty($_GET['filter'])) echo 'style="display:none;"'; ?>>
	<form class="filter_form para_set_form">
	<div class="item">
		<div class="title">性别：</div>
		<div class="content">
			<span class="link link_active para_set" md_para_name="gender_id" md_para_value="0">不限</span>
			<span class="link para_set" md_para_name="gender_id" md_para_value="1">男</span>
			<span class="link para_set" md_para_name="gender_id" md_para_value="2">女</span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item" style="margin:0;">
		<div class="title">学历：</div>
		<div class="content">
			<span class="link link_active para_set" md_para_name="education_id" md_para_value="0">不限</span>
			<span class="link para_set" md_para_name="education_id" md_para_value="1">博士</span>
			<span class="link para_set" md_para_name="education_id" md_para_value="2">硕士</span>
			<span class="link para_set" md_para_name="education_id" md_para_value="3">本科</span>
			<span class="link para_set" md_para_name="education_id" md_para_value="4">专科</span>
			<span class="link para_set" md_para_name="education_id" md_para_value="5">其他</span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title">职位：</div>
		<div class="content">
			<span class="link link_active para_set" md_para_name="position_id" md_para_value="0">不限</span>
			<?php foreach($positionList as $position) { ?>
			<span class="link para_set" md_para_name="position_id" md_para_value="<?php echo ($position["position_id"]); ?>"><?php echo ($position["name"]); ?></span>
			<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title">状态：</div>
		<div class="content">
			<span class="link link_active para_set" md_para_name="status_id" md_para_value="0">不限</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="1">未查看</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="2">已查看</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="3">笔试考查</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="4">面试考查</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="5">已录用</span>
			<span class="link para_set" md_para_name="status_id" md_para_value="6">已淘汰</span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="split">&nbsp;</div>
	<div class="item">
		<div class="title input_height">编号：</div>
		<div class="content">
			<span><input name="talent_id" value="<?php echo ($_GET["talent_id"]); ?>" placeholder="XX" style="width:30px"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">姓名：</div>
		<div class="content">
			<span><input name="name" value="<?php echo ($_GET["name"]); ?>" placeholder="请输入求职者姓名" style="width:120px"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">年龄：</div>
		<div class="content">
			<span style="margin-right:5px;"><input name="age_st" value="<?php echo ($_GET["age_st"]); ?>" placeholder="XX" style="width:30px;"></span>
			<span style="margin-right:5px;">-</span>
			<span><input name="age_ed" value="<?php echo ($_GET["age_ed"]); ?>" placeholder="XX" style="width:30px;"></span>
		</div>
		<div class="clear"></div>
	</div>
	<div class="item">
		<div class="title input_height">时间：</div>
		<div class="content">
			<span style="margin-right:5px;"><input name="join_time_st" value="<?php echo ($_GET["join_time_st"]); ?>" placeholder="YYYY-MM-DD" style="width:90px;"></span>
			<span style="margin-right:5px;">-</span>
			<span><input name="join_time_ed" value="<?php echo ($_GET["join_time_ed"]); ?>" placeholder="YYYY-MM-DD" style="width:90px;"></span>
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
			<th>姓名</th>
			<th>性别</th>
			<th>年龄</th>
			<th>学历</th>
			<th>毕业学校</th>
			<th>应聘职位</th>
			<th>加入时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($talentList)): foreach($talentList as $key=>$item): ?><tr>
			<td><input type="checkbox" value="<?php echo ($item["talent_id"]); ?>"></td>
			<td><?php echo ($item["talent_id"]); ?></td>
			<td><a href="<?php echo U('rms/rms_talent/show?talent_id='.$item['talent_id']);?>" target="_blank"><?php echo ($item["name"]); ?></a></td>
			<td><?php echo ($item["gender"]); ?></td>
			<td><?php echo ($item["age"]); ?></td>
			<td><?php echo ($item["education"]); ?></td>
			<td><?php echo ($item["school"]); ?></td>
			<td><a href="<?php echo U('/rms/rms_position/show?position_id='.$item['position_id']);?>" target="_blank"><?php echo ($item["position_name"]); ?></a></td>
			<td><?php echo ($item["join_time"]); ?></td>
			<td><?php echo ($item["status"]); ?></td>
			<td>
				<a href="<?php echo U('rms/rms_talent/edit?talent_id='.$item['talent_id']);?>" target="_blank"><span class="mylabel mylabel_info">编辑</span></a>&nbsp;
				<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($item["talent_id"]); ?>号求职者<?php echo ($item["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('rms/rms_talent/delete?talent_id='.$item['talent_id']);?>"><span class="mylabel mylabel_danger">删除</span></a>&nbsp;
				<a href="javascript:void(0)" class="popbox_t" md_box_id="<?php echo ($item["talent_id"]); ?>" md_left="-93" md_top="-6px" md_width="80" md_border_width="3" md_background="#ffffff" md_border_color="#468847" md_btn_height="29"><span class="mylabel mylabel_success">更多</span></a>
				<div class="popbox popbox_<?php echo ($item["talent_id"]); ?>">
					<span class="btn_item">安排笔试</span>
					<span class="btn_item">安排面试</span>
					<span class="btn_item">录取</span>
					<span class="btn_item">淘汰</span>
					<span class="btn_item">收藏</span>
					<span class="triangle_right"></span>
				</div>
			</td>
		</tr><?php endforeach; endif; ?>
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

<div class="popbox2 popbox2_multi">
	<div class="title">批量上传<span class="close_btn"></span></div>
	<div class="content">
		<div class="information2" style="margin-top:15px;text-align:center;">
			<div class="item myform">
				<form action="<?php echo U('/rms/rms_talent/createDo');?>" method="post" enctype="multipart/form-data">
					<input name="resume[]" type="file" onchange="$(this).submit()" multiple="multiple" class="hidden">
					<input type="button" class="mybtn mybtn_primary submitBtn" style="padding:15px 60px;" onclick="$('input[type=file]').click()" value="上传简历" md_default_value="上传简历">
					<span class="formSubmitingTip hidden">正在上传...</span>
					<span class="formDisabled hidden"></span>
					<span class="formForceSubmit hidden">1</span>
					<span class="formSubmitBtnName hidden">submitBtn</span>
				</form>
			</div>
			<div class="item">
				可批量上传，支持格式：pdf,doc,docx,txt
			</div>
			<div class="item myform">

			</div>
		</div>
	</div>
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