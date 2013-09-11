// ========================================================
//	注册
// ========================================================

// 注册表单提交
$('#register .registerForm').submit(function(e) {
	$('input[type=text]').removeClass('error');
	$('input[type=password]').removeClass('error');
	$('input[type=submit]').attr('value', '正在注册...')
	$('input[type=submit]').attr('disabled', 'disabled');
	// 提交数据
	var data = new Object();
	data.realname = $('input[name=realname]').val();
	data.email = $('input[name=email]').val();
	data.password = $('input[name=password]').val();
	data.rePassword = $('input[name=rePassword]').val();
	data.phone = $('input[name=phone]').val();
	data.contact_name = $('input[name=contact_name]').val();
	$.ajax({
		url : '/Company/registerDo',
		type : 'POST',
		data : data,
		error : function() {
			alert('无法连接服务器，请稍后再试');
			$('input[type=submit]').attr('value', '立即注册')
			$('input[type=submit]').removeAttr('disabled');
		},
		success : function(data) {
			if (data.error) {
				for (var name in data) {
					if (name == 'error') continue;
					comRegFormTip(name, 'error', data[name]);
				}
				$('input[type=submit]').attr('value', '立即注册')
				$('input[type=submit]').removeAttr('disabled');
			}
			else {
				window.location.href = '/manage';
				$('input[type=submit]').attr('value', '注册成功');
			}
		}
	});
	e.preventDefault();
});

// 表单文本框失焦
$('#register .registerForm input').blur(function(e) {
	var name = $(this).attr('name');
	comRegFormTip(name, 'wait');
	comRegCheckForm(name);
});

// 检测表单元素是否正确
function comRegCheckForm(name) {
	var txt = $('input[name=' + name + ']').val();
	// 公司名称
	if (name == 'realname') {
		if (txt.length == 0 || txt.length > 50)
			comRegFormTip(name, 'error', '公司名称长度不能少于1位多于50位');
		else {
			var data = new Object();
			data.name = name;
			data.data = txt;
			$.ajax({
				url : '/Company/registerCheck',
				type : 'POST',
				data : data,
				success : function(data) {
					if (data.error != null)
						comRegFormTip(name, 'error', data.error);
					else
						comRegFormTip(name, 'success');
				}
			});
		}
	}
	// 电子邮箱
	if (name == 'email') {
		var emailReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		if (txt.length == 0 || txt.length > 40)
			comRegFormTip(name, 'error', '电子邮箱长度不能少于1位多于40位');
		else
		if (!txt.match(emailReg)) {
			comRegFormTip(name, 'error', '电子邮箱格式不正确');
		}
		else {
			var data = new Object();
			data.name = name;
			data.data = txt;
			$.ajax({
				url : '/Company/registerCheck',
				type : 'POST',
				data : data,
				success : function(data) {
					if (data.error != null)
						comRegFormTip(name, 'error', data.error);
					else
						comRegFormTip(name, 'success');
				}
			});
		}
	}
	// 密码
	if (name == 'password') {
		if (txt.length < 6 || txt.length > 20)
			comRegFormTip(name, 'error', '密码长度不能少于6位多于20位');
		else
			comRegFormTip(name, 'success');
	}
	// 重复密码
	if (name == 'rePassword') {
		if (txt.length < 6 || txt.length > 20)
			comRegFormTip(name, 'error', '密码长度不能少于6位多于20位');
		else
		if (txt != $('input[name=password]').val()) {
			comRegFormTip(name, 'error', '两次输入的密码不一致');
		}
		else
			comRegFormTip(name, 'success');
	}
	// 公司电话
	if (name == 'phone') {
		if (txt == '')
			comRegFormTip(name, 'blank');
		else
			comRegFormTip(name, 'success');
	}
	// 联系人
	if (name == 'contact_name') {
		if (txt == '')
			comRegFormTip(name, 'blank');
		else
			comRegFormTip(name, 'success');
	}
}

// 表单元素信息提示
function comRegFormTip(name, status, txt) {
	if (status == 'blank') {
		if (name == 'phone')
			tip = '请填写公司或者组织的电话';
		else
		if (name == 'contact_name')
			tip = '请填写联系人姓名';
	}
	else
	if (status == 'wait') {
		tip = '<i class=\'icon iconWait\'></i>&nbsp;正在验证...';
	}
	else
	if (status == 'error') {
		tip = '<span class=\'error\'><i class=\'icon iconError\'></i>&nbsp;' + txt + '</span>';
	}
	else
	if (status == 'success') {
		tip = '<span class=\'success\'><i class=\'icon iconSuccess\'></i>&nbsp;填写正确</span>';
	}
	$('#register .' + name + ' .tip').html(tip);
}

// ========================================================
//	登录
// ========================================================

// 登录表单提交
$('#register .loginForm').submit(function(e) {
	$('input[type=submit]').attr('value', '正在登录...')
	$('input[type=submit]').attr('disabled', 'disabled');
	// 提交数据
	var data = new Object();
	data.email = $('input[name=email]').val();
	data.password = $('input[name=password]').val();
	$.ajax({
		url : '/Company/loginDo',
		type : 'POST',
		data : data,
		error : function() {
			alert('无法连接服务器，请稍后再试');
			$('input[type=submit]').attr('value', '立即注册')
			$('input[type=submit]').removeAttr('disabled');
		},
		success : function(data) {
			if (data.error) {
				$('input[type=submit]').attr('value', '登录失败！' + data.error);
				$('input[type=submit]').addClass('btn-danger');
				$('input[type=submit]').removeAttr('disabled');
			}
			else {
				window.location.href = '/manage';
				$('input[type=submit]').attr('value', '登录成功');
			}
		}
	});
	e.preventDefault();
});

// 表单文本框聚焦
$('#register .loginForm input').focus(function(e) {
	$('input[type=submit]').attr('value', '立即登录');
	$('input[type=submit]').removeClass('btn-danger');
});

// 表单文本框按键
$('#register .loginForm input').keydown(function(e) {
	$('input[type=submit]').attr('value', '立即登录');
	$('input[type=submit]').removeClass('btn-danger');
});



