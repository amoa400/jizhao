<?php if (!defined('THINK_PATH')) exit();?>

<link href="/css/manage/page.css" rel="stylesheet" type="text/css">
	
<div id="page">

<div class="page_header">
	<span class="title"><?php echo ($pageTitle); ?></span>
	<span class="close_btn" onclick="window.close()"><img src="/images/icon/close.png"></span>
</div>

<style>
	.myform textarea {width:500px;height:80px;}
</style>

<div class="page_content">
	<div class="myform" style="margin-top:0px;">
		<form name="form" action="<?php echo U('/rms/rms_position/editDo');?>" method="post"  enctype="multipart/form-data">
			<div class="item">
				<span class="tt">职位编号：</span>
				<input type="text" value="<?php echo ($position["position_id"]); ?>" disabled="disabled">
				<input name="position_id" type="text" value="<?php echo ($position["position_id"]); ?>" class="hidden">
				<span class="tip"></span>
			</div>
			<div class="item">
				<span class="tt">职位名称：</span>
				<input name="name" type="text" value="<?php echo ($position["name"]); ?>">
				<span class="tip"></span>
			</div>
			<div class="item">
				<span class="tt">职位描述：</span>
				<textarea name="description"><?php echo ($position["description"]); ?></textarea>
				<span class="tip"></span>
			</div>
			<div class="item">
				<span class="tt">职位要求：</span>
				<textarea name="requirement"><?php echo ($position["requirement"]); ?></textarea>
				<span class="tip"></span>
			</div>

			<div class="item">
				<span class="tt">　　　　　</span>
				<input type="submit" value="修改" class="mybtn mybtn_primary">&nbsp;
				<input type="button" value="关闭" class="mybtn mybtn_cancel" onclick="window.close()">
			</div>

			<span class="formSubmitTip hidden">修改</span>
			<span class="formSubmitingTip hidden">正在修改</span>
			<span class="formSuccessTip hidden">修改成功</span>
			<span class="formFailTip hidden">修改失败</span>
			<span class="formDisabled hidden"></span>
		</form>
	</div>
</div>


<div class="page_footer">
	即招在线招聘平台（JZhao.cn）
</div>

</div>

<script src="/js/manage/page.js" type="text/javascript" ></script>