// 大小调整
$(document).ready(function() {
	$('.tab_list').css('height', parseInt($(window).height()) - parseInt($('#header').css('height')));
	$('.frame_list').css('height', parseInt($('.tab_list').height()));
});

// 标签操作
var tabHistory = new Array();
$(document).ready(function() {
	var hash = window.location.hash;
	if (hash != '') {
		hash = hash.split('#');
		hash = hash[1];
	}
	if (hash != '') {
		if ($('.tab_list .item[md_hash="' + hash + '"]').length != 0)
			$('.tab_list .item[md_hash="' + hash + '"]').click();
		else 
			$('.tab_list .item:first').click();
	}
	else 
		$('.tab_list .item:first').click();
});
// 点击tab
$('.tab_list .item').click(function() {
	if ($(this).attr('class') == 'split') return;
	clickTab(this);
});
function clickTab(thisObj) {
	for (var i = 0; i < tabHistory.length; i++)
	if (tabHistory[i] == $(thisObj).attr('md_hash')) {
		tabHistory.splice(i, 1);
		break;
	}
	tabHistory.push($(thisObj).attr('md_hash'));

	$('.tab_list .item').removeClass('active');
	$(thisObj).addClass('active');
	$('.frame_list iframe').hide();

	window.location.hash = $(thisObj).attr('md_hash');
	if ($('.frame_list iframe[md_hash="' + $(thisObj).attr('md_hash') + '"]').length == 0) {
		var frame = $('<iframe></iframe>');
		frame.attr('md_hash', $(thisObj).attr('md_hash'));
		frame.attr('src', $.base64.atob($(thisObj).attr('md_hash')));
		frame.appendTo('.frame_list');
	} else {
		$('.frame_list iframe[md_hash="' + $(thisObj).attr('md_hash') + '"]').show();
	}
}
// 创建新tab
function createTab(name, url) {
	var hash = $.base64.btoa(url);
	if ($('.tab_list .item[md_hash="' + hash + '"]').length != 0) {
		$('.tab_list .item[md_hash="' + hash + '"]').click();
		return;
	}
	
	$('.tab_list .split').css('display', 'block');
	var div = $('<div></div>')
	div.attr('class', 'item');
	div.attr('md_hash', hash);
	if (name == null || name == '')
		div.html('<i class="icon1 icon1_blue icon1_overview"></i><span class="name">新标签</span><span class="close_btn">x</span>');
	else
		div.html('<i class="icon1 icon1_blue icon1_overview"></i><span class="name">' + name + '</span>');
	div.appendTo('.tab_list');
	clickTab(div);
	div.click(function() {
		clickTab(div);
	});
	div.find('.close_btn').click(function() {
		closeTab($(this).parent().attr('md_hash'));
	});
}
// 关闭tab
function closeTab(hash) {
	for (var i = 0; i < tabHistory.length; i++)
	if (tabHistory[i] == hash) {
		tabHistory.splice(i, 1);
		break;
	}

	$('.tab_list .item[md_hash="' + hash + '"]').remove();
	$('iframe[md_hash="' + hash + '"]').remove();
	$('.tab_list .item[md_hash="' + tabHistory[tabHistory.length - 1] + '"]').click();
}
function closeTabFromChild(obj) {
	$('iframe').each(function() {
		if ($(this)[0].contentWindow == obj) {
			closeTab($(this).attr('md_hash'));
		}
	});
}
$('.tab_list .item .close_btn').click(function() {
	closeTab($(this).parent().attr('md_hash'));
});
// 更改tab
function changeTab(hash, name, url) {
	if (url != null && url != '') {
		var newHash = $.base64.btoa(url);
		if ($('.tab_list .item[md_hash="' + newHash + '"]').length != 0) {
			$('.tab_list .item[md_hash="' + newHash + '"]').click();
			return;
		}
		
		for (var i = 0; i < tabHistory.length; i++)
		if (tabHistory[i] == hash) {
			tabHistory.splice(i, 1);
			break;
		}
		$('.tab_list .item[md_hash="' + hash + '"]').attr('md_hash', newHash);
		$('iframe[md_hash="' + hash + '"]').attr('md_hash', newHash);
	} else {
		newHash = hash;
	}

	if (name != null && name != '')
		$('.tab_list .item[md_hash="' + newHash + '"] .name').html(name);
	if (url != null && url != '')
		$('iframe[md_hash="' + newHash + '"]').attr('src', url);
}
function changeTabFromChild(obj, name, url) {
	$('iframe').each(function() {
		if ($(this)[0].contentWindow == obj) {
			changeTab($(this).attr('md_hash'), name, url);
		}
	});
}

// 黑屏覆盖屏幕（锁定屏幕）
function blockScreen() {
	$('.tab_list').append('<div class="block_screen" onclick="removeAllWindow()" style="height:' + $('.tab_list').css('height') + '">&nbsp;</div>');
	$('.tab_list .block_screen').css('top', $('#header').css('height'));
	$('.tab_list .block_screen').css('position', 'fixed');
	$('.tab_list .block_screen').css('width', parseInt($('.tab_list').css('width')) + 1);
}
function unblockScreen() {
	$('.tab_list .block_screen').remove();
}
function removeAllWindow() {
	unblockScreen();
	$('iframe').each(function() {
		$(this)[0].contentWindow.removeAllWindow();
	});
}