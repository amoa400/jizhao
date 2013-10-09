<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="面试房间____NAME__在线招聘平台" />
	<title><?php echo ($pageTitle); ?> - __NAME__</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/global.css" rel="stylesheet" type="text/css">
	<link href="/css/ois/global.css" rel="stylesheet" type="text/css">

	<script src="/js/jquery.min.js" type="text/javascript" ></script>
	<script src="/js/bootstrap.min.js" type="text/javascript" ></script>
</head>

<body>

<div class="ois_container">

<link href="/css/ois/welcome.css" rel="stylesheet" type="text/css">

<div class="header">
	<div class="logo">
		<a href="javascript:void(0)"><img src="/images/ois/logo.png"></a>
	</div>

	<div class="toolbar">
		<ul>
			<li class="talent_<?php echo ($interview["talent_id"]); ?> offline"><span class="glyphicon glyphicon-minus"></span>&nbsp;&nbsp;面试者-<?php echo ($interview["talent_name"]); ?> <span class="status">[离线]</span></li>
			<li class="interviewer_<?php echo ($interview["interviewer_id"]); ?> offline"><span class="glyphicon glyphicon-minus"></span>&nbsp;&nbsp;面试官-<?php echo ($interview["interviewer_name"]); ?> <span class="status">[离线]</span></li>
			<?php if ($_SESSION['role'] == 2) { ?>
			<li><input type="button" value="开始面试" class="start btn btn-success"></li>
			<?php } ?>
		</ul>
	</div>
	
	<div class="clear"></div>
</div>

<embed class="show"  src="http://player.youku.com/player.php/sid/XNjA0NTA5ODgw/v.swf" allowFullScreen="true" quality="high" width="600" height="500" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>

<div class="chat">

	<div class="title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;聊天交流</div>
	<div class="content">
		<div class="item" style="padding-top:10px;">
			<div class="author">系统消息 00:00:00</div>
			<div class="text">欢迎进入[<?php echo ($interview["name"]); ?>]等候房间，面试尚未开始，请您耐心等候。您可以查看左方的欢迎内容，也可以在下面输入文字进行聊天交流。</div>
		</div>
	</div>
	<div class="input">
		<textarea placeholder="输入文字..."></textarea>
		<div class="toolbar">
			<input type="button" value="签到" class="reg btn btn-default">
			<input type="button" value="发送(enter)" class="sub btn btn-default">
		</div>
	</div>

</div>

<script>

	function resetWidthHeight() {
		var bodyWidth = parseInt($('body').css('width'));
		var bodyHeight = parseInt($('body').css('height'));
		var pageWidth = parseInt($('.ois_container').css('width'));
		var pageHeight = parseInt($('.ois_container').css('height'));
		
		$('.show').css('height', pageHeight - 120);
		$('.show').css('width', parseInt(pageWidth * 0.65));
		
		$('.chat').css('height', pageHeight - 120);
		$('.chat').css('width', pageWidth - parseInt($('.show').css('width')) - 22);
		$('.chat .content').css('height', parseInt($('.chat').css('height')) - 167);
		$('.chat .input textarea').css('width', parseInt($('.chat').css('width')) - 10);
	}

	$(window).resize(function(){
		resetWidthHeight();
	});

	resetWidthHeight();


</script>

<script src="/js/ois/socket.io.js" type="text/javascript"></script>

<script>

	var gCompanyId = '<?php echo ($_SESSION["company_id"]); ?>';	// 公司编号
	var gRoomId = '<?php echo ($interview["interview_id"]); ?>';	// 房间编号
	var gRoleId = '<?php echo ($_SESSION["role"]); ?>';				// 角色编号
	var gUserId = '<?php echo ($_SESSION["user_id"]); ?>';			// 用户编号
	var gUserName = '<?php echo ($_SESSION["user_name"]); ?>';		// 用户姓名
	var gSessionId = '<?php echo ($sessionId); ?>';				// 会话编号

	socket = io.connect('__SOCKET_ADDR__');
	
	socket.emit('join', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId}, function() {
			online();
			offline();
		}
	);
	
	$('.start').click(function() {
		socket.emit('start', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId});
	});
	
	socket.on('start', function(data) {
		location.href = '/ois/ois_room/show/id/' + <?php echo ($interview["interview_id"]); ?>;
	});
	
	$('.chat .input .sub').click(function() {
		var data = $('.chat .input textarea').val();
		if (data == '' ) return;
		$('.chat .input textarea').val('');
		socket.emit('chat', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId, user_name : gUserName, cont : data});
	});
	
	$('.chat .input .reg').click(function() {
		var data = '[签到] 我已经到了';
		$('.chat .input textarea').val('');
		socket.emit('chat', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId, user_name : gUserName, cont : data});
	});
	
	socket.on('chat', function(data) {
		var time = new Date(data.time);
		var hour = time.getHours();
		if (hour < 10) hour = '0' + hour;
		var minute = time.getMinutes();
		if (minute < 10) minute = '0' + minute;
		var second = time.getSeconds();
		if (second < 10) second = '0' + second;
		
		var s = '<div class="item"><div class="author">' + data.user_name + ' ' + hour + ':' + minute + ':' + second + '</div><div class="text">' + data.cont + '</div></div>';
		$('.chat .content').append(s);
		$('.chat .content').scrollTop(10000);
	});
	
	socket.on('online', function(data) {
		var obj;
		if (data.role_id == 2) {
			obj = $('.interviewer_' + data.user_id);
			interviewer_times = 5;
		}
		else {
			obj = $('.talent_' + data.user_id);
			talent_times = 5;
		}
		obj.removeClass('offline');
		obj.addClass('online');
		obj.find('.glyphicon').removeClass('glyphicon-minus');
		obj.find('.glyphicon').addClass('glyphicon-ok');
		obj.find('.status').html('[在线]');
	});
	
	function online() {
		socket.emit('online', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId});
		setTimeout('online()', 3000);
	}
	
	var talent_times = 5;
	var interviewer_times = 5;
	function offline() {
		talent_times--;
		interviewer_times--;
		if (talent_times <= 0) {
			var obj = $('.talent_<?php echo ($interview["talent_id"]); ?>');
			obj.removeClass('online');
			obj.addClass('offline');
			obj.find('.glyphicon').removeClass('glyphicon-ok');
			obj.find('.glyphicon').addClass('glyphicon-minus');
			obj.find('.status').html('[离线]');
			talent_times = 5;
		}
		if (interviewer_times <= 0) {
			var obj = $('.interviewer_<?php echo ($interview["interviewer_id"]); ?>');
			obj.removeClass('online');
			obj.addClass('offline');
			obj.find('.glyphicon').removeClass('glyphicon-ok');
			obj.find('.glyphicon').addClass('glyphicon-minus');
			obj.find('.status').html('[离线]');
			interviewer_times = 5;
		}
		setTimeout('offline()', 3000);
	}
	
	$('.chat .input textarea').bind("keydown", function(e) {
		switch (e.which) {
			case 13:
				e.preventDefault();
				$('.chat .input .sub').click();
				break;
		}
	});

</script>


</div>


</body>
</html>