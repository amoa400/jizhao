/*
	日历选择器
*/
function JZ_DatePicker() {
	// 变量
	var _this = this;
	var year;
	var month;
	var day;
	var oYear;
	var inputObj;
	
	// 初始化函数
	var init = function() {
		// 点击其他地方关闭窗口
		$('#frame').click(blurClick);
	}
	
	// 触发
	$('.jz_date_picker_t').click(function(e) {
		e.cancelBubble = true;
		e.stopPropagation();
		
		inputObj = $(this);
		var date = new Date();
		if (inputObj.val() != '') {
			var arr = inputObj.val().split('-');
			if (new Date(arr[0], arr[1] - 1, arr[2]) != 'Invalid Date')
				date = new Date(arr[0], arr[1] - 1, arr[2]);
		}
		year = 1900 + date.getYear();
		oYear = year;
		month = 1 + date.getMonth();
		day = date.getDate();
		create();
	});
	
	// 创建DIV
	var create = function() {
		$('.jz_date_picker').remove();

		var html = '';
		html += '<div id="ttt" class="jz_date_picker" onselectstart="return false"><div class="sel"><div class="prev">&nbsp;<span class="glyphicon glyphicon-chevron-left"></span></div><div class="date"><select class="year">';
		// 年份
		for (var i = oYear - 3; i <= oYear + 3; i++)
		if (i != year)
			html += '<option value="' + i + '">' + i + '年</option>';
		else
			html += '<option value="' + i + '" selected="selected">' + i + '年</option>';
		html += '</select>&nbsp;&nbsp;<select class="month">';
		// 月份
		for (var i = 1; i <= 12; i++)
		if (i != month)
			html += '<option value="' + i + '">' + i + '月</option>';
		else
			html += '<option value="' + i + '" selected="selected">' + i + '月</option>';
		html += '</select></div><div class="next"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;</div><div class="clear"></div></div>';
		html += '<div class="week"><table><tr class="title"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>';
		// 天数
		var totDay = 31;
		if (month == '4' || month == '6' || month == '9' || month == '11') totDay = 30;
		if (month == 2) {
			if ((year % 4 == 0 && year % 100 != 0) || (year % 400 == 0)) totDay = 29;
			else totDay = 28;
		}
		if (day > totDay) day == totDay;
  		var week = 0;
		for (var i = 1; i <= totDay; i++) {
			if (week == 0) html += '<tr class="content">';
			while (new Date(year, month - 1, i).getDay() != week) {
				html += '<td></td>';
				week = (week + 1) % 7;
			}
			if (day == i)
				html += '<td><span class="cnt">' + i + '</span></td>';
			else
				html += '<td><span>' + i + '</span></td>';
			if (week == 6) html += '</tr>';
			week = (week + 1) % 7;
		}
		html += '</table></div></div>';
		
		$('#frame').append(html);
		$('.jz_date_picker').css('left', inputObj.offset().left);
		$('.jz_date_picker').css('top', inputObj.offset().top + parseInt(inputObj.css('height')) + $('#frame').scrollTop() + 2);
		$('.jz_date_picker .prev').click(prevClick);
		$('.jz_date_picker .next').click(nextClick);
		$('.jz_date_picker .year').change(yearChange);
		$('.jz_date_picker .month').change(monthChange);
		$('.jz_date_picker .week .content span').click(dayClick);
	}
	
	// 上一月
	var prevClick = function() {
		month--;
		if (month == 0) {
			year--;
			month = 12;
			if (year < oYear - 3) {
				year++;
				month = 1;
			}
		}
		create();
	}
	
	// 下一月
	var nextClick = function() {
		month++;
		if (month == 13) {
			year++;
			month = 1;
			if (year > oYear + 3) {
				year--;
				month = 12;
			}
		}
		create();
	}
	
	// 年份变化
	var yearChange = function() {
		year = $(this).val();
		create();
	}
	
	// 月份变化
	var monthChange = function() {
		month = $(this).val();
		create();
	}
	
	// 日期点击
	var dayClick = function() {
		var s = year;
		if (month < 10) s += '-0' + month;
		else s += '-' + month;
		var d = $(this).html();
		if (d < 10) s += '-0' + d;
		else s += '-' + d;
		inputObj.val(s);
		$('.jz_date_picker').remove();
	}
	
	// 失焦点击
	var blurClick = function(e) {
		if ($('.jz_date_picker').length == 0) return;
		var inBox = false;
		if (e.clientX > $('.jz_date_picker').offset().left && e.clientX < $('.jz_date_picker').offset().left + parseInt($('.jz_date_picker').css('width')) && e.clientY > $('.jz_date_picker').offset().top && e.clientY < $('.jz_date_picker').offset().top + parseInt($('.jz_date_picker').css('height')))
			inBox = true;
		if (!inBox) {
			$('.jz_date_picker').remove();
		}
	}
	
	init();
}

/*
	触发所有类
*/
$('body').ready(function() {
	JZ_DatePicker();
});
