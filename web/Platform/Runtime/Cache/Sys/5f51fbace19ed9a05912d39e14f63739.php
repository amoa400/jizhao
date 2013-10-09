<?php if (!defined('THINK_PATH')) exit();?>
<div name="sys" class="control_menu">

	<div name="system" class="item">
		<span class="lv1">
			<i class="icon1 icon1_blue icon1_overview"></i>&nbsp;&nbsp;&nbsp;系统设置
		</span>
		<div class="sub">
			<span name="overview" class="lv2">
				<i class="icon1 icon1_blank"></i>&nbsp;&nbsp;&nbsp;系统概览
			</span>
			<span name="companyInfoEdit" class="lv2">
				<i class="icon1 icon1_blank"></i>&nbsp;&nbsp;&nbsp;公司设置	
			</span>
		</div>
	</div>
	
</div>

<script>
	$(document).ready(function() {
		var hash = window.location.hash;
		if (hash != '') {
			hash[0] = '1';
			var temp = hash.split('#');
			hash = temp[1];
			var name = hash.split('_');
			$('.item[name="'+ name[0] +'"] .lv2[name="' + name[1] + '"]').click();
		}
		else $('.item[name="system"] .lv2[name="overview"]').click();
	});
</script>

	<iframe class="main_frame">
	</iframe>
	
	<div class="clear"></div>
</div>