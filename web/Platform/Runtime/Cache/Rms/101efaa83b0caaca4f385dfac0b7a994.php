<?php if (!defined('THINK_PATH')) exit();?>

<div class="page_content">
	<div class="mytoolbar">
		<a href="<?php echo U('/rms/rms_position/edit?position_id='.$position['position_id']);?>" target="_blank"><span class="item mybtn mybtn_wide mybtn_primary" style="margin-left:0;">编辑</span></a>
		<a href="javascript:void(0)" class="open_confirm_window" md_title="确认删除？" md_content="您即将删除<span class='danger'><?php echo ($position["position_id"]); ?>号职位<?php echo ($position["name"]); ?></span>，请确认操作！" md_button_text="删除" md_button_class="mybtn_danger" md_op_url="<?php echo U('rms/rms_position/delete?close_window=1&position_id='.$position['position_id']);?>"><span class="item mybtn mybtn_wide mybtn_danger">删除</span></a>
		<span class="item mybtn mybtn_wide mybtn_cancel" onclick="window.close()">关闭</span>
		<span class="item split" md_disabled="1"></span>
		<span class="item mybtn mybtn_wide mybtn_primary" onclick="location.reload()">刷新</span>
	</div>
	
	<div class="mytable mytable_left mytable_firstcol mytable_fullborder" style="margin-top:15px;">
		<table>
			<tr>
				<td width="80px">编　　号：</td>
				<td><?php echo ($position["position_id"]); ?></td>
			</tr>
			<tr>
				<td>职位名称：</td>
				<td><?php echo ($position["name"]); ?></td>
			</tr>
			<tr>
				<td>职位描述：</td>
				<td><?php echo ($position["description"]); ?></td>
			</tr>
			<tr>
				<td>职位要求：</td>
				<td><?php echo ($position["requirement"]); ?></td>
			</tr>
			<tr>
				<td>创建时间：</td>
				<td><?php echo ($position["create_time"]); ?></td>
			</tr>
			<tr>
				<td>状　　态：</td>
				<td><?php echo ($position["status"]); ?></td>
			</tr>
			<tr>
				<td>求职人数：</td>
				<td><?php echo ($position["enrollment"]); ?></td>
			</tr>
			<tr>
				<td>求职人员：</td>
				<td>TODO</td>
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