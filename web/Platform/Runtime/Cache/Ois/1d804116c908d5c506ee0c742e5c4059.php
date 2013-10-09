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
	
	<div class="clear"></div>
</div>

<div class="login">



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

<script src="/js/ois/socket.io.js" type="text/javascript" ></script>

<script>

	var gCompanyId = '<?php echo ($_SESSION["company_id"]); ?>';	// 房间编号
	var gRoomId = '<?php echo ($interview["interview_id"]); ?>';	// 房间编号
	var gUserId = '<?php echo ($_SESSION["user_id"]); ?>';			// 用户编号
	var gUserName = '李明';							// 用户姓名
	var gSessionId = '<?php echo ($sessionId); ?>';				// 会话编号
	var gMode = 0;									// 模式

	socket = io.connect('__SOCKET_ADDR__');
	socket.emit('join', {company_id : gCompanyId, room_id : gRoomId, user_id : gUserId, session_id : gSessionId});
	
	$('.chat .input .sub').click(function() {
		var data = $('.chat .input textarea').val();
		if (data == '' ) return;
		$('.chat .input textarea').val('');
		socket.emit('chat', {company_id : gCompanyId, room_id : gRoomId, user_id : gUserId, session_id : gSessionId, user_name : gUserName, cont : data});
	});
	
	$('.chat .input .reg').click(function() {
		var data = '[签到] 我已经到了';
		$('.chat .input textarea').val('');
		socket.emit('chat', {company_id : gCompanyId, room_id : gRoomId, user_id : gUserId, session_id : gSessionId, user_name : gUserName, cont : data});
	});
	
	socket.on('chat', function(data) {
		var time = new Date(data.time);
		var hour = time.getHours();
		if (hour < 10) hour = '0' + hour;
		var minute = time.getMinutes();
		if (minute < 10) minute = '0' + minute;
		
		var s = '<div class="item"><div class="author">' + data.user_name + ' ' + hour + ':' + minute + '</div><div class="text">' + data.cont + '</div></div>';
		$('.chat .content').append(s);
		$('.chat .content').scrollTop(10000);
	});
	
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