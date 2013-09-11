function resizeWindow() {
	var body_width = parseInt($('body').css('width'));
	var body_height = parseInt($('body').css('height'));
	$('.main_body').css('height', body_height - 40);
}

$(window).resize(function() {
	resizeWindow();
});

$(document).ready(function() {
	resizeWindow();
});

