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
	<span class="title"><?php echo ($const["title"]); ?>管理</span>
</div>

<div class="mytoolbar mytoolbar_table" style="margin-top:15px;">
	<!-- 新建 -->
	<?php if ($const['toolbar']['create']['on']) { ?>
	<span class="item mybtn mybtn_primary new_tab" md_url="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/create">新建</span>
	<?php } ?>
	<!-- 删除 -->
	<?php if ($const['toolbar']['delete']['on']) { ?>
	<span class="item item_t mybtn mybtn_primary" md_confirm="1" md_op_url_tmp="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/deleteList" md_title="确认删除？" md_content="您即将删除您选中的<?php echo ($const["title"]); ?>，请确认操作！" md_button_text="删除">删除</span>
	<?php } ?>
	<!-- 分割线 -->
	<span class="item split"></span>
	<!-- 刷新 -->
	<span class="item mybtn mybtn_primary" onclick="location.reload()">刷新&nbsp;<span class="glyphicon glyphicon-repeat"></span></span>
	<!-- 筛选 -->
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="1" md_para_nojump="1" onclick="$('.filter').show();$(this).hide();$(this).next().show();">筛选 <i class="glyphicon glyphicon-chevron-down"></i></span>
	<span class="item mybtn mybtn_primary para_set" md_para_name="filter" md_para_value="0" md_para_nojump="1"  onclick="$('.filter').hide();$(this).hide();$(this).prev().show();" style="display:none;">筛选 <i class="glyphicon glyphicon-chevron-up"></i></span>
</div>

<!-- 筛选区 -->
<div class="filter" style="display:none;">
<form class="filter_form para_set_form">
<table>

	<!-- 选择框 -->
	<?php
 $cnt = 0; $flag = false; foreach ($fieldNameAlign as $key => $value) { if (in_array($key, $const['hideFilterField'])) continue; if (!empty($const['specialFilterField'][$key])) continue; if (!empty($selectField[$key])) { $flag = true; $cnt++; if ($cnt % 3 == 1) echo '<tr>'; ?>
		<td class="title"><?php echo ($value); ?>：</td>
		<td class="content">
			<select name="<?php echo ($key); ?>" class="form-control" multiple="multiple">
					<option value="0"  <?php if (empty($_GET[$key])) echo 'selected="selected"'; ?>>不限</option>
				<?php foreach ($selectField[$key] as $key2 => $value2) { ?>
					<option value="<?php echo ($key2); ?>" <?php if (strstr($_GET[$key], $key2 . '|')) echo 'selected="selected"'; ?>><?php echo ($value2); ?></option>
				<?php } ?>
			</select>
		</td>
	<?php
 if ($cnt % 3 == 0) echo '</tr>'; } } while ($cnt % 3 != 0) { echo '<td class="title"></td><td class="content"></td>'; $cnt++; if ($cnt % 3 == 0) echo '</tr>'; } ?>
	
	<!-- 文字框 -->
	<?php
 $cnt = 0; foreach ($fieldNameAlign as $key => $value) { ?>
	<?php
 if (!empty($selectField[$key])) continue; if (in_array($key, $textareaField)) continue; if (in_array($key, $const['hideFilterField'])) continue; if (!empty($const['specialFilterField'][$key])) continue; $cnt++; if ($cnt % 3 == 1) echo '<tr>'; ?>
		<td class="title"><?php echo ($value); ?>：</td>
		<td class="content"><input type="text" name="<?php echo ($key); ?>" class="form-control" value="<?php echo ($_GET[$key]); ?>"></td>
	<?php
 if ($cnt % 3 == 0) echo '</tr>'; } while ($cnt % 3 != 0) { echo '<td class="title"></td><td class="content"></td>'; $cnt++; if ($cnt % 3 == 0) echo '</tr>'; } ?>
	
	<!-- 特殊区 -->
	<?php foreach ($fieldNameAlign as $key => $value) { ?>
	<?php if (!empty($const['specialFilterField'][$key])) { ?>
		<!-- 时间区间 -->
		<?php if ($const['specialFilterField'][$key][0] == 'timeBetween') { ?>
		<tr>
			<td class="title"><?php echo ($value); ?>：</td>
			<td class="content" colspan="5" style="position:relative;">
				<input type="text" name="<?php echo ($key); ?>_s" class="form-control jz_date_picker_t" value="<?php echo $_GET[$key . '_s']; ?>"><span class="glyphicon glyphicon-calendar" style="position:absolute;left:130px;top:20px;color:#9b9b9b;cursor:pointer;" onclick="$(this).prev().click();window.event.cancelBubble = true;window.event.stopPropagation();"></span>&nbsp;
				--&nbsp;
				<input type="text" name="<?php echo ($key); ?>_e" class="form-control jz_date_picker_t" value="<?php echo $_GET[$key . '_e']; ?>"><span class="glyphicon glyphicon-calendar" style="position:absolute;left:310px;top:20px;color:#9b9b9b;cursor:pointer;" onclick="$(this).prev().click();window.event.cancelBubble = true;window.event.stopPropagation();"></span>
			</td>
		</tr>
		<?php } ?>
		<!-- 普通区间 -->
		<?php if ($const['specialFilterField'][$key][0] == 'between') { ?>
		<tr>
			<td class="title"><?php echo ($value); ?>：</td>
			<td class="content" colspan="5" style="position:relative;">
				<input type="text" name="<?php echo ($key); ?>_s" class="form-control" value="<?php echo $_GET[$key . '_s']; ?>">&nbsp;
				--&nbsp;
				<input type="text" name="<?php echo ($key); ?>_e" class="form-control" value="<?php echo $_GET[$key . '_e']; ?>">
			</td>
		</tr>
		<?php } ?>
	<?php }} ?>
	
	<tr>
		<td colspan="6"></td>
	</tr>
	
	<tr>
		<td class="title"></td>
		<td class="content" colspan="5">
			<input class="mybtn mybtn_primary" type="submit" value="筛选">&nbsp;&nbsp;
			<input class="mybtn mybtn_danger" type="button" value="重置" onclick="filterReset()">
		</td>
	</tr>

</table>
</form>
</div>

<div class="mytable" style="margin-top:15px;">
	<table>
		<tr class="title">
			<th class="sel"><input class="select_all" type="checkbox"></th>
			
			<?php foreach($const['showField'] as $value) { ?>
			<th><?php echo ($fieldName[$value]); ?></th>
			<?php } ?>
			<th style="width:160px;">更多</th>
		</tr>
		
		<!-- 内容为空 -->
		<?php if (empty($dataList)) { ?>
		<tr style="height:80px;">
			<td colspan="<?php echo count($const['showField']) + 2; ?>">
				没有找到您所需要的信息，
				<!-- 新建 -->
				<?php if ($const['toolbar']['create']['on']) { ?>
				<a href="javascript:void(0)" class="new_tab" md_url="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/create">点击此处添加</a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		
		<!-- 显示内容 -->
		<?php foreach($dataList as $data) { ?>
		<?php
 $idField = $const['action'] . '_id'; $id = $data[$idField]; ?>
		<tr>
			<td><input type="checkbox" value="<?php echo ($id); ?>"></td>

			<?php foreach($const['showField'] as $value) { ?>
			<?php if (empty($data['linkField'][$value])) { ?>
			<td><?php echo ($data[$value]); ?></td>
			<?php } else { ?>
			<td><a class="new_tab" md_url="<?php echo ($data['linkField'][$value]); ?>"><?php echo ($data[$value]); ?></a></td>
			<?php } ?>
			<?php } ?>
			
			<td>
				<!-- 编辑 -->
				<a class="new_tab" md_url="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/edit/<?php echo ($idField); ?>/<?php echo ($id); ?>"><span class="mylabel mylabel_info">编辑</span></a>&nbsp;
				<!-- 删除 -->
				<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($id); ?>号<?php echo ($const["title"]); ?>-<?php echo ($data["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="/<?php echo ($const["group"]); ?>/<?php echo ($const["group"]); ?>_<?php echo ($const["action"]); ?>/delete/<?php echo ($idField); ?>/<?php echo ($id); ?>"><span class="mylabel mylabel_danger">删除</span></a>&nbsp;
				<!-- 更多 -->
				<a href="javascript:void(0)" class="popbox_t" md_box_id="<?php echo ($id); ?>" md_left="-103" md_top="-6px" md_border_width="3" md_background="#ffffff" md_border_color="#468847" md_btn_padding_left="10" md_btn_padding_top="5"><span class="mylabel mylabel_success">更多</span></a>
				<!-- 更多面板 -->
				<div class="popbox popbox_<?php echo ($id); ?>">
					<?php foreach($const['moreList'] as $more) { ?>
					<span class="btn_item"><a href="/ois/ois_room/show/id/<?php echo ($interview["interview_id"]); ?>" target="_blank"><?php echo ($more[0]); ?></a></span>
					<?php } ?>
					<span class="triangle_right"></span>
				</div>
			</td>
			
		</tr>
		<?php } ?>
	</table>
</div>

<?php if (!empty($pager['totPage'])) { ?>
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
<?php } ?>


		<div style="height:20px;">&nbsp;</div>
	</div>

	<script src="/js/manage/frame.js" type="text/javascript" ></script>
	
	<?php if (!empty($tabTitle)) { ?>
	<script>changeTab2('<?php echo ($tabTitle); ?>');</script>
	<?php } ?>
	
</body>
</html>