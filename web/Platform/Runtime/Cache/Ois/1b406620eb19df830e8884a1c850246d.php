<?php if (!defined('THINK_PATH')) exit();?>
<link href="/css/ois/manage.css" rel="stylesheet" type="text/css">

<div class="controlMenu">
	<ul>
		<a href="<?php echo U('ois/manage/overview');?>">
			<li <?php if ($controlName == '概览') echo "class='active'"; ?>>
				<i class="icon1 <?php if ($controlName == '概览') echo 'icon1_blue'; ?> icon1_overview"></i>&nbsp;&nbsp;&nbsp;概览
			</li>
		</a>
		<a href="<?php echo U('ois/manage/interview');?>">
			<li <?php if ($controlName == '面试管理') echo "class='active'"; ?>>
				<i class="icon1 <?php if ($controlName == '面试管理') echo 'icon1_blue'; ?> icon1_webcam"></i>&nbsp;&nbsp;&nbsp;面试管理
			</li>
		</a>
		<a href="<?php echo U('ois/manage/interviewer');?>">
			<li>
				<i class="icon1 icon1_user1"></i>&nbsp;&nbsp;&nbsp;面试官管理
			</li>
		</a>
		<a href="<?php echo U('ois/manage/interviewee');?>">
			<li>
				<i class="icon1 icon1_user2"></i>&nbsp;&nbsp;&nbsp;求职者管理
			</li>
		</a>
	</ul>
</div>


	<div class="mainContent">
		<div class="mainHeader">
			<span class="title">使用概况</span>
		</div>
		<div class="mainBody">
		</div>
	</div>
	
	<div class="clear"></div>
</div>