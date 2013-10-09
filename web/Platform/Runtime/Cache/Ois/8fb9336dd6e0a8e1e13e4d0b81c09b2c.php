<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="面试房间____NAME__在线招聘平台" />
	<title><?php echo ($interview["name"]); ?> - 面试房间 - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/ois/room.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="room">

<div class="header">

	<div class="logo">
		<a href="#"><img src="/images/ois/logo.png"></a>
	</div>

	<div class="toolbar">
		<ul>
			<li class="message">&nbsp;</li>
			<li class="clock">&nbsp;</li>

			<?php if (!empty($rep)) { ?>
			<li class="play"><img src="/images/ois/icon/play.png"></li>
			<li class="prog" onselectstart="return false" oncontextmenu="return false">
				<div class="border corner2">
					<div class="background"></div>
				</div>
			</li>
			<li class="timer">00:00 / 00:00</li>
			<?php } ?>

			<!--<li>
				<img src="/images/ois/icon/message2.png">
				<span class="clock">33分钟53秒</span>
			</li>
			<li><img src="/images/ois/icon/record.png"></li>
			<li><img src="/images/ois/icon/setting.png"></li>
			<li><img src="/images/ois/icon/chat.png"></li>-->
			<?php if ($_SESSION['role'] == 2) { ?>
			<li class="evaluation_on"><img src="/images/ois/icon/evaluation.png"></li>
			<li class="end_t"><img src="/images/ois/icon/end.png"></li>
			<li class="end_ok"><button class="btn btn-danger">确定</button></li>
			<li class="end_no"><button class="btn btn-primary">取消</button></li>
			<?php } ?>		
			
			<!--<a href="/"><li><img src="/images/ois/icon/exit.png"></li></a>-->
		</ul>
		<div class="progTip">00:00</div>
	</div>
	
	<div class="clear"></div>

</div>

<div class="video">
	<?php if ($_SESSION['role'] == 1) { ?>
	<!-- 管理员 -->
	<div class="flash" style="margin:0;">
		<embed src="/flash/ois/receive.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_talent" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<div class="flash">
		<embed src="/flash/ois/receive.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_interviewer" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<?php } else if ($_SESSION['role'] == 3) { ?>
	<!-- 面试者 -->
	<div class="flash" style="margin:0;">
		<embed src="/flash/ois/receive.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_interviewer" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<div class="flash">
		<embed src="/flash/ois/send.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_talent" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<?php } else { ?>
	<!-- 面试官 -->
	<div class="flash" style="margin:0;">
		<embed src="/flash/ois/receive.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_talent" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<div class="flash">
		<embed src="/flash/ois/send.swf?ip=__FMSIP__&flag=it_<?php echo ($interview["interview_id"]); ?>_interviewer" type="application/x-shockwave-flash" width="100%" height="100%" allowFullScreen="true" wmode="transparent" quality="high"></embed>
	</div>
	<div class="flash evaluation">
		<div class="top">
			<span class="item">面试评价</span>
			<span class="item closed evaluation_off"><span class="glyphicon glyphicon-remove"></span></span>
			<div class="clearfix"></div>
		</div>
		<div class="content">
			<textarea placeholder="请填写您的评价..."></textarea>
		</div>
	</div>

	<?php } ?>
</div>

<div class="plugin">
	<div class="navi">
		<ul>
			<li class="active"><i class="glyphicon glyphicon-file"></i>&nbsp;信息</li>
			<li><i class="glyphicon glyphicon-list-alt"></i>&nbsp;简历</li>
			<li><i class="glyphicon glyphicon-th"></i>&nbsp;代码</li>
			<li><i class="glyphicon glyphicon-edit"></i>&nbsp;白板</li>
		</ul>
	</div>

	<div id="plgInfo" class="cont" style="display:block;">
		<ul>
			<li>
				<span class="title">面试名称：</span>
				<span class="content"><?php echo ($interview["name"]); ?></span>
			</li>
			<li>
				<span class="title">开始时间：</span>
				<span class="content"><?php echo ($interview["real_start_time"]); ?></span>
			</li>
			<li>
				<span class="title">面试者：</span>
				<span class="content"><?php echo ($interview["talent_name"]); ?></span>
			</li>
			<li>
				<span class="title">面试官：</span>
				<span class="content"><?php echo ($interview["interviewer_name"]); ?></span>
			</li>
			<li>
				<span class="title">面试备注：</span>
				<span class="content"><?php echo ($interview["remark"]); ?></span>
			</li>
			<li style = "border:none;">
				<span class="title">注意事项：</span>
				<span class="content">
					1、请确保您的面试环境良好，网络、摄像头、麦克风等设备工作正常。<br>
					2、请尽量关闭其他占用网络资源的网页和程序，让面试过程更加流畅。<br>
					3、推荐使用最新版Chrome浏览器，分辨率至少为1024*768。<br>
				</span>
			</li>
		</ul>
	</div>
	
	<div id="plgResume" class="cont" style="overflow:hidden;">
		<iframe src="/user/<?php echo ($_SESSION["company_id"]); ?>/resume/<?php echo ($interview["interview_id"]); ?>.pdf" style="border:0;height:100%;width:100%;"></iframe>
	</div>
	
	<div id="plgCode" class="cont">
		<div id="editor" class="window"></div>
		<div class="toolbar">
			<ul>
				<li class="active">代码编辑</li>
				<li>编译运行</li>
				<li>运行结果</li>
				<li>更换语言</li>
			</ul>
		</div>
		<div class="compile window">
			<textarea placeholder="请输入测试数据..."></textarea>
			<div class="toolbar2">
				<ul>
					<li><span>时间限制(MS)：</span><input class="form-control timeLimit" type="text" value="1000"></li>
					<li><span>空间限制(KB)：</span><input class="form-control memoryLimit" type="text" value="65535"></li>
					<li><span>立即编译运行：</span><input type="button" class="form-control btn btn-default" value="确定"></li>
				</ul>
			</div>
		</div>
		<div class="result window">
			<textarea placeholder="运行结果..."></textarea>
		</div>
		<div class="language window">
			<div class="title">请选择您要使用的语言</div>
			<ul>
				<li>C</li>
				<li class="active">C++</li>
				<li>PASCAL</li>
			</ul>
		</div>
	</div>
	
	<div id="plgWhiteboard" class="cont">
		<div class="toolbar">
			<div class="item">
				<ul>
					<li class="title" style="margin:0;" title="可用的工具">工具<li>
					<li class="plgWbSelect" title="选择"><img src="/images/ois/icon/wb_select.png"></li>
					<li class="plgWbPencil" title="画笔"><img src="/images/ois/icon/wb_pencil.png"></li>
					<li class="plgWbEraser" title="橡皮"><img src="/images/ois/icon/wb_eraser.png"></li>
					<li class="plgWbLine" title="直线"><img src="/images/ois/icon/wb_line.png"></li>
					<li class="plgWbRectangle" title="矩形"><img src="/images/ois/icon/wb_rectangle.png"></li>
					<li class="plgWbRound" title="圆形"><img src="/images/ois/icon/wb_round.png"></li>
					<li class="plgWbClear" title="清除画布"><img src="/images/ois/icon/wb_clear.png"></li>
					<li class="title" title="调节画笔粗细">粗细<li>
					<li class="plgWbThick" title="粗"><img src="/images/ois/icon/wb_thick.png"></li>
					<li class="plgWbThin" title="细"><img src="/images/ois/icon/wb_thin.png"></li>
					<li class="title" title="调节画笔颜色">颜色<li>
					<li class="plgWbBlack" title="黑色"><img src="/images/ois/icon/wb_black.png"></li>
					<li class="plgWbRed" title="红色"><img src="/images/ois/icon/wb_red.png"></li>
					<li class="plgWbYellow" title="黄色"><img src="/images/ois/icon/wb_yellow.png"></li>
					<li class="plgWbBlue" title="蓝色"><img src="/images/ois/icon/wb_blue.png"></li>
				</ul>
			</div>
		</div>
		<canvas class="whiteboard" onselectstart="return false" oncontextmenu="return false"></canvas>
		<canvas class="whiteboardTemp" onselectstart="return false" oncontextmenu="return false"></canvas>
	</div>

</div>

<div class="clear"></div>

</div>

<script>


function resetWidthHeight() {
	var bodyWidth = parseInt($('body').css('width'));
	var bodyHeight = parseInt($('body').css('height'));
	
	// room
	var roomWidth = parseInt($('#room').css('width'));
	var roomHeight = parseInt($('#room').css('height'))
	
	// header
	
	// video
	$('.flash').css('height', parseInt((bodyHeight - 130) / 2)); // TODO
	var flashHeight = parseInt($('.flash').css('Height'));
	$('.video').css('width', parseInt(flashHeight * 320 / 240));
	var videoWidth = parseInt($('.video').css('width'));
	var videoHeight = parseInt($('.video').css('height'));

	// plugin
	$('.plugin').css('width', roomWidth - videoWidth - 22 - 1); // WHY -1 TODO
	$('.plugin').css('height', videoHeight);
	var pluginWidth = parseInt($('.plugin').css('width'));
	var pluginHeight = parseInt($('.plugin').css('height'));
	$('.plugin .cont').css('height', pluginHeight - 35);
	$('.plugin .navi li').css('width', parseInt(parseInt($('.plugin .navi').css('width')) / plgCount));
	$('.plugin .navi li:last-child').css('width', parseInt($('.plugin .navi').css('width')) - parseInt($('.plugin .navi li').css('width')) * (plgCount - 1));

	var plgContWidth = pluginWidth;
	var plgContHeight = pluginHeight - 35;
	
	// plugin -- editor
	$('#plgCode .compile textarea').css('width', plgContWidth);
	$('#plgCode .compile textarea').css('height', plgContHeight - 45);
	$('#plgCode .result textarea').css('width', plgContWidth);
	$('#plgCode .result textarea').css('height', plgContHeight);
	editor.resize();
	
	// plugin -- whiteboard
	$('#plgWhiteboard .whiteboard').attr('width', plgContWidth);
	$('#plgWhiteboard .whiteboard').attr('height', plgContHeight);
	$('#plgWhiteboard .whiteboardTemp').attr('width', plgContWidth);
	$('#plgWhiteboard .whiteboardTemp').attr('height', plgContHeight);
	plgWbConfig.width = plgContWidth;
	plgWbConfig.height = plgContHeight;
	
	// evaluation
	$('.evaluation').css('width', videoWidth);
	$('.evaluation .content').css('height', flashHeight - 42);
	$('.evaluation').css('top', flashHeight);
}

</script>

<script>
// ========================================================================================
//	全局模块（g）
// ========================================================================================
var gCompanyId = '<?php echo ($_SESSION["company_id"]); ?>';	// 公司编号
var gRoomId = '<?php echo ($interview["interview_id"]); ?>';	// 房间编号
var gRoleId = '<?php echo ($_SESSION["role"]); ?>';				// 角色编号
var gUserId = '<?php echo ($_SESSION["user_id"]); ?>';			// 用户编号
var gSessionId = '<?php echo ($sessionId); ?>';				// 会话编号
var gMode = 0;									// 模式
var socketAddr = '__SOCKET_ADDR__';				// NODEJS地址
</script>

<script src="/js/jquery.min.js" type="text/javascript" ></script>
<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="/js/jquery-ui.min.js" type="text/javascript" ></script>
<script src="/js/ois/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/ois/socket.io.js"></script>
<script src="/js/ois/room.js" type="text/javascript" ></script>

<script>
	$('body').ready(function() {
		$('.draggable').draggable();
		$('.resizable').resizable();
	});
</script>

<?php if (!empty($rep)) { ?>
<script src="/js/ois/rep.js" type="text/javascript" ></script>
<?php } ?>

</body>
</html>