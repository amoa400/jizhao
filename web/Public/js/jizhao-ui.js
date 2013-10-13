/*
	基本类
*/
function JZ_Common() {
	// 变量
	var _this = this;
	
	// 初始化函数
	var init = function() {
		$('#frame').click(blurClick);
	}
	
	// 失焦点击
	var blurClick = function(e) {
		if ($('.jz_popbox').length != 0) {
			var inBox = false;
			if (e.clientX > $('.jz_popbox').offset().left && e.clientX < $('.jz_popbox').offset().left + parseInt($('.jz_popbox').css('width')) && e.clientY > $('.jz_popbox').offset().top && e.clientY < $('.jz_popbox').offset().top + parseInt($('.jz_popbox').css('height')))
				inBox = true;
			if (!inBox) {
				$('.jz_popbox').remove();
			}
		}
		if ($('.jz_popbox_h').length != 0) {
			var inBox = false;
			if (e.clientX > $('.jz_popbox_h').offset().left && e.clientX < $('.jz_popbox_h').offset().left + parseInt($('.jz_popbox_h').css('width')) && e.clientY > $('.jz_popbox_h').offset().top && e.clientY < $('.jz_popbox_h').offset().top + parseInt($('.jz_popbox_h').css('height')))
				inBox = true;
			if (!inBox) {
				$('.jz_popbox_h').hide();
			}
		}
	}
	
	// 关闭
	_this.closePopbox = function() {
		$('.jz_popbox').remove();
		$('.jz_popbox_h').hide();
	}
	
	init();
}

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
		createIcon();
	}
	
	// 触发
	$('.jz_date_picker_t').bind('click focus', function(e) {
		e.cancelBubble = true;
		e.stopPropagation();
		
		inputObj = $(this);
		var date = new Date(parseInt($('[name="' + inputObj.attr('md_name') + '"]').val()) * 1000);
		if (date == 'Invalid Date') date = new Date();
		year = 1900 + date.getYear();
		oYear = year;
		month = 1 + date.getMonth();
		day = date.getDate();
		create();
	});
	
	// 创建DIV
	var create = function() {
		jzCommon.closePopbox();

		var html = '';
		html += '<div class="jz_popbox jz_date_picker" onselectstart="return false"><div class="sel"><div class="prev">&nbsp;<span class="glyphicon glyphicon-chevron-left"></span></div><div class="date"><select class="year">';
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
		$('.jz_date_picker').css('top', inputObj.offset().top + parseInt(inputObj.css('height')) + $('#frame').scrollTop() + 3);
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
	var dayClick = function(e) {
		e.cancelBubble = true;
		e.stopPropagation();
		var s = year;
		if (month < 10) s += '-0' + month;
		else s += '-' + month;
		var d = $(this).html();
		if (d < 10) s += '-0' + d;
		else s += '-' + d;
		inputObj.val(s);
		$('[name="' + inputObj.attr('md_name') + '"]').val(new Date(year, month - 1, d).getTime() / 1000);
		$('.jz_date_picker').remove();
		if (inputObj.attr('md_time') == '1') {
			inputObj.val(s + ' 00:00');
			jzTimePicker.trigger(inputObj, true);
		}
	}

	// 为每个input创建图标
	var createIcon = function() {
		$('.jz_date_picker_icon').remove();
		$('.jz_date_picker_t').each(function() {
			var thisObj = this;
			var span = $('<span></span>');
			span.addClass('jz_date_picker_icon');
			span.addClass('glyphicon');
			span.addClass('glyphicon-calendar');
			span.css('position', 'absolute');
			span.css('color', '#9b9b9b');
			span.css('cursor', 'pointer');
			if ($(this).parent().css('position') == 'static') {
				$(this).parent().css('position', 'relative');
			}
			span.css('left', $(this).offset().left - $(this).parent().offset().left + parseInt($(this).css('width')) - 22);
			span.css('top', $(this).offset().top - $(this).parent().offset().top + parseInt($(this).css('height')) / 2 - 8);
			span.click(function(e) {
				e.cancelBubble = true;
				e.stopPropagation();
				thisObj.click();
			});
			span.appendTo($(this).parent());
		});
	}
	_this.createIcon = createIcon;
	
	init();
}

/*
	时间选择器
*/
function JZ_TimePicker() {
	// 变量
	var _this = this;
	var inputObj;
	var append;
	var hour;
	var minute;
	
	// 初始化函数
	var init = function() {
		createIcon();
	}
	
	// 触发
	$('.jz_time_picker_t').bind('click focus', function(e) {
		e.cancelBubble = true;
		e.stopPropagation();

		inputObj = $(this);
		append = false;
		create();
	});
	
	// 其他类触发
	_this.trigger = function(obj, ap, da) {
		inputObj = obj;
		if (ap == null) append = false;
		else append = ap;
		create();
	}
	
	// 创建DIV
	var create = function() {
		jzCommon.closePopbox();
		
		// 默认值
		hour = 0;
		minute = 0;
		var date;
		if (parseInt($('[name="' + inputObj.attr('md_name') + '"]').val()) < 86400)
			date = new Date(1381852800000 + parseInt($('[name="' + inputObj.attr('md_name') + '"]').val() * 1000));
		else
			date = new Date(parseInt($('[name="' + inputObj.attr('md_name') + '"]').val() * 1000));
		if (date != 'Invalid Date') {
			hour = date.getHours();
			minute = date.getMinutes();
		}
		if (hour < 10) hour = '0' + hour;
		if (minute < 10) minute = '0' + minute;

		var div = $('<div></div>');
		div.addClass('jz_popbox');
		div.addClass('jz_time_picker');
		div.append('<div class="time"><span class="hour">' + hour + '</span>:<span class="minute">' + minute + '</span></div>');
		div.append('<div class="content"></div>');
		div.appendTo('#frame');
	
		// 调整宽度
		$('.jz_time_picker').css('width', inputObj.css('width'));

		$('.jz_time_picker').css('left', inputObj.offset().left);
		$('.jz_time_picker').css('top', inputObj.offset().top + parseInt(inputObj.css('height')) + $('#frame').scrollTop() + 3);
		
		// 小时点击
		$('.jz_popbox .hour').click(hourClick);
		$('.jz_popbox .minute').click(minuteClick);
		$('.jz_popbox').click(function() {	
			e.cancelBubble = true;
			e.stopPropagation();
		});
		
		$('.jz_popbox .hour').click();
	}
	
	// 小时点击
	var hourClick = function() {
		$('.jz_popbox .time span').removeClass('active');
		$('.jz_popbox .time .hour').addClass('active');
		$('.jz_popbox .content table').remove();
		$('.jz_popbox .content').append('<table></table>');
		for (var i = 0; i < 24; i++) {
			var hour = i;
			if (hour < 10) hour = '0' + i;
			if (i % 4 == 0)
				$('.jz_popbox .content table').append('<tr></tr>');
			$('.jz_popbox .content table tr:last-child').append('<td>' + hour + '</td>');
		}
		$('.jz_popbox td').click(hourSelect);
	}
	
	// 小时选择
	var hourSelect = function() {
		$('.jz_popbox .hour').html($(this).html());
		$('.jz_popbox .minute').click();
	}
	
	// 分钟点击
	var minuteClick = function() {
		$('.jz_popbox .time span').removeClass('active');
		$('.jz_popbox .time .minute').addClass('active');
		$('.jz_popbox .content table').remove();
		$('.jz_popbox .content').append('<table></table>');
		for (var i = 0; i < 60; i++) {
			var minute = i;
			if (minute < 10) minute = '0' + i;
			if (i % 5 == 0)
				$('.jz_popbox .content table').append('<tr></tr>');
			$('.jz_popbox .content table tr:last-child').append('<td>' + minute + '</td>');
		}
		$('.jz_popbox td').click(minuteSelect);
	}
	
	// 分钟选择
	var minuteSelect = function() {
		$('.jz_popbox .minute').html($(this).html());
		if (append) {
			$('[name="' + inputObj.attr('md_name') + '"]').val(parseInt($('[name="' + inputObj.attr('md_name') + '"]').val()) + parseInt($('.jz_popbox .hour').html()) * 3600 + parseInt($('.jz_popbox .minute').html()) * 60);
			inputObj.val(inputObj.val().substr(0, 10) + ' ' + $('.jz_popbox .hour').html() + ':' + $('.jz_popbox .minute').html());
		} else {
			$('[name="' + inputObj.attr('md_name') + '"]').val(parseInt($('.jz_popbox .hour').html()) * 3600 + parseInt($('.jz_popbox .minute').html()) * 60);
			inputObj.val($('.jz_popbox .hour').html() + ':' + $('.jz_popbox .minute').html());
		}
		jzCommon.closePopbox();
	}

	// 为每个input创建图标
	var createIcon = function() {
		$('.jz_time_picker_icon').remove();
		$('.jz_time_picker_t').each(function() {
			var thisObj = this;
			var span = $('<span></span>');
			span.addClass('jz_time_picker_icon');
			span.addClass('glyphicon');
			span.addClass('glyphicon-time');
			span.css('position', 'absolute');
			span.css('color', '#9b9b9b');
			span.css('cursor', 'pointer');
			if ($(this).parent().css('position') == 'static') {
				$(this).parent().css('position', 'relative');
			}
			span.css('left', $(this).offset().left - $(this).parent().offset().left + parseInt($(this).css('width')) - 22);
			span.css('top', $(this).offset().top - $(this).parent().offset().top + parseInt($(this).css('height')) / 2 - 8);
			span.click(function(e) {
				e.cancelBubble = true;
				e.stopPropagation();
				thisObj.click();
			});
			span.appendTo($(this).parent());
		});
	}
	_this.createIcon = createIcon;
	
	init();
}

/*
	选择名称类
*/
function JZ_NamePicker() {
	var _this = this;
	var data = new Object;
	
	// 初始化函数
	function init() {
		createIcon();
	}
	
	// 触发器点击
	$('.jz_name_picker_t').bind('click focus', function(e) {
		var thisObj = $(this);
		e.cancelBubble = true;
		e.stopPropagation();
		jzCommon.closePopbox();
		
		// 查看数据是否存在
		var url = $(this).attr('md_url');
		if (data[url] == null) {
			$.get(url, {}, 
				function(ret) {
					data[url] = ret;
					thisObj.click();
				}
			);
			return;
		}
		
		// 复制数据
		var dataCnt = new Object();
		dataCnt.length = data[url].length;
		for (var i = 0; i < data[url].length; i++) {
			dataCnt[i] = data[url][i];
			dataCnt[i].flag = false;
		}
		
		// 将结果排序
		var text = $(this).val();
		if (text.length != 0) {
			var index = 0;
			// 1、将前缀相同的排到前面
			for (var i = 0; i < dataCnt.length; i++) {
				if (index > 10) break;
				if (dataCnt[i].name.substr(0, text.length) == text) {
					dataCnt[i].flag = true;
					var t = dataCnt[index];
					dataCnt[index] = dataCnt[i];
					dataCnt[i] = t;
					index++;
				}
			}
			// 2、将名称中含有关键词的放到前面
			for (var i = index; i < dataCnt.length; i++) {
				if (index > 10) break;
				if (dataCnt[i].name.indexOf(text) != -1) {
					dataCnt[i].flag = true;
					var t = dataCnt[index];
					dataCnt[index] = dataCnt[i];
					dataCnt[i] = t;
					index++;
				}
			}
		}

		// 创建div
		var div = $('<div></div>');
		div.addClass('jz_name_picker');
		div.addClass('jz_popbox');
		div.append('<table></table>');
		for (var i = 0; i < dataCnt.length; i++) {
			if (i > 10) break;
			if (text != '' && dataCnt[i].flag != true) break;
			if (dataCnt[i].id != $('[name="' + $(this).attr('md_name') + '"]').val()) 
				div.find('table').append('<tr><td>' + dataCnt[i].id + '</td><td>--</td><td>' + dataCnt[i].name + '</td><td><span class="glyphicon glyphicon-ok"></span></td></tr>');
			else
				div.find('table').append('<tr class="active"><td>' + dataCnt[i].id + '</td><td>--</td><td>' + dataCnt[i].name + '</td><td><span class="glyphicon glyphicon-ok"></span></td></tr>');
		}
		if (text != '' && (dataCnt[0] == null || dataCnt[0].flag != true)) {
			div.find('table').append('<tr md_disabled="disabled"><td style="text-align:center;"><span class="glyphicon glyphicon-remove"></span>&nbsp;未找到相应结果</td></tr>');
		}
		div.appendTo('#frame');
		
		// 调整宽度
		$('.jz_name_picker').css('min-width', $(this).css('width'));
		while (parseInt($('.jz_name_picker td').css('height')) > 40) {
			$('.jz_name_picker').css('width', parseInt($('.jz_name_picker').css('width')) + 20);
		}
		$('.jz_name_picker').css('left', $(this).offset().left);
		$('.jz_name_picker').css('top', $(this).offset().top + parseInt($(this).css('height')) + $('#frame').scrollTop() + 3);
		
		// 点击条目
		$('.jz_name_picker tr').click(function() {
			if ($(this).attr('md_disabled') == 'disabled') return;
			$('[name="' + thisObj.attr('md_name') + '"]').val($(this).find('td:first-child').html());
			thisObj.val($(this).find('td:nth-child(3)').html());
			jzCommon.closePopbox();
		});

	});
	
	// 文本框变化
	$('.jz_name_picker_t').bind('input propertychange', function() {
		$(this).click();
	});

	// 文本框变化（失焦）
	$('.jz_name_picker_t').change(function() {
		var id = $('[name="' + $(this).attr('md_name') + '"]').val();
		if (id != '') {
			for (var i = 0; i < data[$(this).attr('md_url')].length; i++)
			if (data[$(this).attr('md_url')][i].id == id) {
				$(this).val(data[$(this).attr('md_url')][i].name);
				break;
			}
		}
	});	
	
	// 为每个input创建图标
	var createIcon = function() {
		$('.jz_name_picker_icon').remove();
		$('.jz_name_picker_t').each(function() {
			var thisObj = this;
			var span = $('<span></span>');
			span.addClass('jz_name_picker_icon');
			span.addClass('glyphicon');
			span.addClass('glyphicon-list-alt');
			span.css('position', 'absolute');
			span.css('color', '#9b9b9b');
			span.css('cursor', 'pointer');
			if ($(this).parent().css('position') == 'static') {
				$(this).parent().css('position', 'relative');
			}
			span.css('left', $(this).offset().left - $(this).parent().offset().left + parseInt($(this).css('width')) - 22);
			span.css('top', $(this).offset().top - $(this).parent().offset().top + parseInt($(this).css('height')) / 2 - 8);
			span.click(function(e) {
				e.cancelBubble = true;
				e.stopPropagation();
				thisObj.click();
			});	
			span.appendTo($(this).parent());
		});
	}
	_this.createIcon = createIcon;
	
	init();
}

/*
	弹出框
*/
function JZ_Popover() {
	// 变量
	var _this = this;
	
	// 初始化函数
	var init = function() {
	}
	
	// 触发
	$('.jz_popover_t').click(function(e) {
		e.cancelBubble = true;
		e.stopPropagation();
		jzCommon.closePopbox();
		
		var box = $('.' + $(this).attr('md_class'));
		box.addClass('jz_popbox_h');
		box.css('position', 'absolute');
		box.css('top', '0');
		box.css('left', '0');
		box.show();
		box.append('<span class="triangle_right"></span>');
		box.append('<span class="triangle_right2"></span>');
		
		if ($(this).attr('md_direction') == 'left') {
			box.css('left', $(this).offset().left - parseInt(box.css('width')) - 11);
			box.css('top', $(this).offset().top + $('#frame').scrollTop() - parseInt(box.css('height')) / 2 + parseInt($(this).css('height')) / 2 + 2);	
			box.find('.triangle_right').css('left', parseInt(box.css('width')) - 2);
			box.find('.triangle_right2').css('left', parseInt(box.css('width')) - 3);	
			box.find('.triangle_right').css('top', parseInt(box.css('height')) / 2 - parseInt($(this).css('height')) / 2 - 2);
			box.find('.triangle_right2').css('top', parseInt(box.css('height')) / 2 - parseInt($(this).css('height')) / 2 - 2);
		}
	});
	
	// 触发
	$('.jz_popover .item a').click(function(e) {
		$('.jz_popover').hide();
	});
	
	init();
}

/*
	触发所有类
*/
$('body').ready(function() {
	window.jzCommon = new JZ_Common();
	window.jzDatePicker = new JZ_DatePicker();
	window.jzTimePicker = new JZ_TimePicker();
	window.jzNamePicker = new JZ_NamePicker();
	window.jzPopover = new JZ_Popover();
});
