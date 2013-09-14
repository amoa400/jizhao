$('.control_menu .lv1').click(function() {
	if ($(this).parent().children('.sub').css('display') == 'none')
		$(this).parent().children('.sub').slideDown(100);
	else
		$(this).parent().children('.sub').slideUp(100);
});
	
$('.control_menu .lv2').click(function() {
	$('.lv1').removeClass('lv1_active');
	$('.lv2').removeClass('lv2_active');
	$(this).parent().parent().children('.lv1').addClass('lv1_active');
	$(this).addClass('lv2_active');
	var model_name = $(this).parent().parent().parent().attr('name');
	var action_name = $(this).parent().parent().attr('name');
	var func_name = $(this).attr('name');
	$('.main_frame').attr('src', '/' + model_name + '/' + model_name + '_' + action_name + '/' + func_name);
	window.location.hash = action_name + '_' + func_name;
});

function controlMenuClick(action_name, func_name) {
	$('.item[name="' + action_name + '"] .lv2[name="' + func_name + '"]').click();
}


// 表单iframe生成
$(document).ready(function() {
	generateFormIframe();
});
function generateFormIframe(name) {
	$('.myform form').each(function() {
		// 清除
		if (name != null && $(this).attr('name') != name) return;
		$(this).find('input[type="file"]').each(function() {
			$(this).next().val($(this).next().attr('md_default_value'));
		});
		
		$('#form_iframe_' + $(this).attr('name')).remove();
		var iframe = '<iframe id="form_iframe_' + $(this).attr('name') + '" class="hidden"></iframe>';
		$('body').append(iframe);

		// 页面内容
		var iframeHtml = '';
		iframeHtml += '<form id="form" action="' + $(this).attr('action') + '" method="' + $(this).attr('method') + '" enctype="' + $(this).attr('enctype') + '">';
		// 获取file的值
		var inputs = $(this).find('input');
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].name == '' || inputs[i].type != 'file') continue;
			iframeHtml += '<input type="' + inputs[i].type + '" name="' + inputs[i].name + '" ';
			iframeHtml += 'onchange="parent.changeUploadBtn(\'' + $(this).attr('name') + '\', \'' + inputs[i].name + '\', this.value)"';
			if (inputs[i].multiple) iframeHtml += 'multiple="multiple"';
			iframeHtml += '>';
		}
		iframeHtml += '</form>';
		
		$('#form_iframe_' + $(this).attr('name'))[0].contentWindow.document.write(iframeHtml);
	});
}

// 表单点击上传文件
$('.myform .upload_btn').click(function() {
	var formObj = $(this).parent();
	while (formObj[0].tagName != 'FORM') {
		formObj = formObj.parent();
	}
	var formChildren = $('#form_iframe_' + formObj.attr('name'))[0].contentWindow.document.getElementById("form").childNodes;
	for (var i = 0; i < formChildren.length; i++) {
		if (formChildren[i].getAttribute('name') != $(this).prev().attr('name')) continue;
		formChildren[i].click();
		break;
	}
});
function changeUploadBtn(formName, fileBtnName, value) {
	$('.myform form[name="' + formName + '"] input[name="' + fileBtnName + '"]').next().val(value.match(/[^\/\\]*$/)[0]);
}

// 表单提交
$('.myform form').submit(function(e) {
	// 初始化
	var thisObj = this;
	if ($(thisObj).find('.formDisabled').length != 0 && $(thisObj).find('.formDisabled').html() != '') {
		e.preventDefault();
		return;
	}
	var submitBtn;
	if ($(thisObj).find('.formSubmitBtnName').length != 0 && $(thisObj).find('.formSubmitBtnName').html() != '') {
		submitBtn = $(thisObj).find('.' + $(thisObj).find('.formSubmitBtnName').html());
	}
	else submitBtn = $(thisObj).find("input[type='submit']");
	if ($(thisObj).find('.formSubmitingTip').length != 0) {
		submitBtn.val($(thisObj).find('.formSubmitingTip').html());
	} else submitBtn.val('正在提交');
	submitBtn.addClass('mybtn_disabled');
	$(thisObj).find('.formDisabled').html('disabled');
	// 终止原来的操作
	if ($(thisObj).find('.formForceSubmit').length != 0 && $(thisObj).find('.formForceSubmit').html() != '') {
		this.submit();
		return;
	}
	e.preventDefault();

	// 清空之前的数据
	var formObj = $('#form_iframe_' + $(thisObj).attr('name'))[0].contentWindow.document.getElementById("form");
	var formChildren = formObj.childNodes;
	var pointer = 0;
	while (pointer < formChildren.length) {
		if (formChildren[pointer].getAttribute('type') != 'file')
			formObj.removeChild(formChildren[pointer]);
		else
			pointer++;
	}
	
	// 获取数据
	var data = new Object();
	// 获取input的值
	var inputs = $(thisObj).find('input');
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].name == '' || inputs[i].type == 'file') continue;
		data[inputs[i].name] = inputs[i].value;
		var inputObj = document.createElement('input');
		inputObj.setAttribute('type', inputs[i].type);
		inputObj.setAttribute('name', inputs[i].name);
		inputObj.setAttribute('value', inputs[i].value);
		formObj.appendChild(inputObj);
	}
	// 获取textarea的值
	var textareas = $(thisObj).find('textarea');
	for (var i = 0; i < textareas.length; i++) {
		if (textareas[i].name == '') continue;
		data[textareas[i].name] = textareas[i].value;
		var textareaObj = document.createElement('textarea');
		textareaObj.setAttribute('name', textareas[i].name);
		textareaObj.innerHTML = textareas[i].value;
		formObj.appendChild(textareaObj);
	}
	// 获取select的值
	var selects = $(thisObj).find('select');
	for (var i = 0; i < selects.length; i++) {
		if (selects[i].name == '') continue;
		data[selects[i].name] = selects[i].value;
		var selectObj = document.createElement('select');
		selectObj.setAttribute('name', selects[i].name);
		selectObj.innerHTML = '<option value="' + selects[i].value + '" selected="selected">' + selects[i].value + '</option>';
		formObj.appendChild(selectObj);
	}

	formObj.submit();
	
	$('#form_iframe_' + $(thisObj).attr('name')).load(function() {
		var resStr = $('#form_iframe_' + $(thisObj).attr('name'))[0].contentWindow.document.body.innerText;
		var res = eval('(' + resStr + ')');
		$(thisObj).find('.tip').removeClass('tip_error');
		$(thisObj).find('.tip').html('');
		if(res.retStatus == 'success') {
			// 成功
			if ($(thisObj).find('.formSuccessTip').length != 0) {
				submitBtn.val($(thisObj).find('.formSuccessTip').html());
			} else submitBtn.val('提交成功');
			submitBtn.addClass('mybtn_success2');
			// 是否跳转
			if (res.jumpUrl != null) {
				location.href = res.jumpUrl;
			}
			if (res.jumpAction != null && res.jumpFunc != null) {
				parent.controlMenuClick(res.jumpAction, res.jumpFunc);
			}
		} else {
			// 失败
			if ($(thisObj).find('.formFailTip').length != 0) {
				submitBtn.val($(thisObj).find('.formFailTip').html());
			} else submitBtn.val('提交失败');
			submitBtn.addClass('mybtn_danger2');
			// 显示失败信息
			for(var name in res.error) {
				var tipObj = $(thisObj).find("[name='" + name + "']").nextAll('.tip');
				tipObj.addClass('tip_error');
				tipObj.html(res.error[name]);
			}
		}
		generateFormIframe($(thisObj).attr('name'));
		// 清除提示按钮
		$(this).delay(3000).queue(function() {
			if ($(thisObj).find('.formSubmitTip').length != 0) {
				submitBtn.val($(thisObj).find('.formSubmitTip').html());
			} else submitBtn.val('提交');
			submitBtn.removeClass('mybtn_disabled');
			submitBtn.removeClass('mybtn_success2');
			submitBtn.removeClass('mybtn_danger2');
			$(thisObj).find('.formDisabled').html('');
		});
	});
	return;
	
	// 原始办法
	
	// 提交数据
	$.ajax({
		type : 'POST',
		url : $(thisObj).attr('action'),
		data : data,
		success : function(res) {

		}
	});
});

// 表格选择
$('.mytable .select_all').click(function() {
	if ($('.mytable .select_all').attr('checked') != null) {
		$('.mytable input[type="checkbox"]').attr('checked', 'checked');
	} else {
		$('.mytable input[type="checkbox"]').removeAttr('checked');
	}
});
$('.mytable input[type="checkbox"]').click(function() {
	if ($(this).attr('class') == 'select_all') return;
	var tot = $('.mytable input[type="checkbox"]').length;
	var unchecked = false;
	for (var i = 0; i < tot; i++) {
		if ($('.mytable input[type="checkbox"]:eq(' + i + ')').attr('class') == 'select_all') continue;
		if ($('.mytable input[type="checkbox"]:eq(' + i + ')').attr('checked') == null)
			unchecked = true;
	}
	if (unchecked == false)
		$('.mytable .select_all').attr('checked', 'checked');
	else
		$('.mytable .select_all').removeAttr('checked');
});

// 工具栏按钮点击
$('.mytoolbar_table .item_t').click(function() {
	// 取消点击操作
	if ($(this).attr('md_disabled') != null) {
		return;
	}
	// 重新定义点击操作
	if ($(this).attr('md_click_func') != null) {
		eval($(this).attr('md_click_func'));
		return;
	}

	var tot = $('.mytable input[type="checkbox"]').length;
	var idList = '';
	for (var i = 0; i < tot; i++) {
		if ($('.mytable input[type="checkbox"]:eq(' + i + ')').attr('class') == 'select_all') continue;
		if ($('.mytable input[type="checkbox"]:eq(' + i + ')').attr('checked') != null) {
			idList += $('.mytable input[type="checkbox"]:eq(' + i + ')').val() + '|';
		}
	}
	if (idList == '') return;
	$(this).attr('md_op_url', $(this).attr('md_op_url_tmp') + '/id_list/' + idList);
	if ($(this).attr('md_confirm') != null) {
		openConfirmWindow(this);
	} else {
		location.href = $(this).attr('md_op_url');
	}
});

// 弹出确认窗口
$('.open_confirm_window').click(function() {
	openConfirmWindow(this);
});
function openConfirmWindow(thisObj) {
	var html = '';
	html += '<div class="confirm_window">';
	html += '<div class="title">' + $(thisObj).attr('md_title') + '</div>';
	html += '<div class="content">' + $(thisObj).attr('md_content') + '</div>';
	html += '<div class="buttons"><span class="mybtn mybtn_cancel" onclick="closeConfirmWindow(this)">取消</span>&nbsp;&nbsp;';
	// 按钮
	html += '<a ';
	html += 'href="' + $(thisObj).attr('md_op_url') + '" onclick="closeConfirmWindow(this)"';
	html += '><span class="mybtn ';
	if ($(thisObj).attr('md_button_class') != null)
		html += $(thisObj).attr('md_button_class');
	else
		html += 'mybtn_primary';
	html += '">';
	if ($(thisObj).attr('md_button_text') != null)
		html += $(thisObj).attr('md_button_text');
	else
		html += '确认';
	html += '</span></a></div>';
	
	html += '</div>';

	$('body').append(html);
	blockScreen();
}
function closeConfirmWindow(thisObj) {
	unblockScreen();
	var obj = $(thisObj);
	while (obj.attr('class') != 'confirm_window') {
		obj = obj.parent();
	}
	obj.remove();
}

// 黑屏覆盖屏幕（锁定屏幕）
function blockScreen() {
	$('body').append('<div class="block_screen" onclick="removeAllWindow()" style="height:' + $('body').css('height') + '">&nbsp;</div>');
}
function unblockScreen() {
	$('.block_screen').remove();
}
function removeAllWindow() {
	unblockScreen();
	$('.confirm_window').remove();
	$('.popbox2').toggle();
}

// 页面参数设置
var url_addr = "";
var url_paras = new Array();
$(document).ready(function() {
	var paras = location.href.split('/');	
	url_addr = "http://" + paras[2] + '/' + paras[3] + '/' + paras[4] + '/' + paras[5];
	for (var i = 6; i < paras.length; i += 2)
		url_paras[paras[i]] = paras[i+1];
	filterHighlight();
});
$('.para_set').click(function() {
	url_paras[$(this).attr('md_para_name')] = $(this).attr('md_para_value');
	if ($(this).attr('md_para_nojump') == 1) return;
	if ($(this).attr('md_para_name') != 'page') url_paras['page'] = 1;
	paraUrlJump();
});
$('.para_set_form').submit(function(e) {
	e.preventDefault();
	// 获取input的值
	var inputs = $(this).find('input');
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].name == '') continue;
		url_paras[inputs[i].name] = inputs[i].value;
	}
	paraUrlJump();
});
function paraUrlJump() {
	var addr = url_addr;
	for (var i in url_paras) {
		if (url_paras[i] == null) continue;
		if (url_paras[i] == 0) continue;
		if (url_paras[i] == '') continue;
		addr += '/' + i + '/' + url_paras[i];
	}
	location.href = addr;
}

// 过滤器高亮
function filterHighlight(){
	for (var i in url_paras) {
		$('.filter .item span[md_para_name="' + i + '"]').removeClass('link_active');
		$('.filter .item span[md_para_name="' + i + '"][md_para_value="' + url_paras[i] + '"]').addClass('link_active');
	}
}

// 弹出框
$('.popbox_t').click(function() {
	var boxObj = $('.popbox_' + $(this).attr('md_box_id'));
	if ($(this).attr('md_left') != null)
		boxObj.css('left', $(this).offset().left + parseInt($(this).attr('md_left')) + 'px');
	if ($(this).attr('md_left') != null)
		boxObj.css('top', $(this).offset().top + parseInt($(this).attr('md_top')) + 'px');
	if ($(this).attr('md_background') != null) {
		boxObj.css('background', $(this).attr('md_background'));
	}
	if ($(this).attr('md_border_width') != null) {
		boxObj.css('border-width', $(this).attr('md_border_width') + 'px');
	}
	if ($(this).attr('md_border_color') != null) {
		boxObj.css('border-color', $(this).attr('md_border_color'));
		boxObj.find('.btn_item').css('border-color', $(this).attr('md_border_color'));
	}
	if ($(this).attr('md_width') != null)
		boxObj.css('width', $(this).attr('md_width') + 'px');
	if ($(this).attr('md_btn_height') != null) {
		boxObj.find('.btn_item').css('height', $(this).attr('md_btn_height') + 'px');
		boxObj.find('.btn_item').css('line-height', $(this).attr('md_btn_height') + 'px');
	}
	boxObj.toggle();
});

// 弹出框2
$('.popbox2_t').click(function() {
	blockScreen();
	var boxObj = $('.popbox2_' + $(this).attr('md_box_id'));
	boxObj.toggle();
});
$('.popbox2 .close_btn').click(function() {
	removeAllWindow();
});