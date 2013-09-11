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

// ºÚÆÁ¸²¸ÇÆÁÄ»£¨Ëø¶¨ÆÁÄ»£©
function blockScreen() {
	$('.control_menu').append('<div class="block_screen" onclick="removeAllWindow()">&nbsp;</div>');
	$('.block_screen').css('width', parseInt($('.control_menu').css('width')) + 1);
}
function unblockScreen() {
	$('.block_screen').remove();
}
function removeAllWindow() {
	unblockScreen();
	$('.confirm_window').remove();
	$('iframe')[0].contentWindow.removeAllWindow();
}
