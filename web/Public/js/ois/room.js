// ========================================================================================
// 工具模块（tol）
// ========================================================================================

// *******************************************************************
// 消息（message）（ms）
// *******************************************************************
function tolMsAdd(s, user) {
	if (user == 'admin')
		s = '[系统]&nbsp;' + s;
	$('.header .toolbar .message').html(s);
}

// ========================================================================================
// 插件模块（plg）
// ========================================================================================

// 变量定义
var plgCount = 4;				// 插件数量
var plgName = new Array();		// 插件名称
plgName[0] = 'info';
plgName[1] = 'resume';
plgName[2] = 'code';
plgName[3] = 'whiteboard';

// 插件点击
$('.plugin .navi li').click(function(){
	plgNaviClick($(this).index(), true);
});

// 插件点击
function plgNaviClick(index, sync) {
	$('.plugin .navi li').removeClass('active');
	$('.plugin .navi li:eq(' + index + ')').addClass('active');
	$('.plugin .cont').hide();
	$('.plugin .cont:eq(' + index + ')').show();
	if (sync)
		rtOtherUpdate('plgNaviClick', index);
}
//$('.plugin .navi li:eq(2)').click();

// 清除插件导航内容
function plgNaviIC() {
	$('.plugin .navi li:eq(0)').click();
}

// *******************************************************************
// 代码插件（code）（cd）
// *******************************************************************
var editor = ace.edit("editor");
editor.setTheme("ace/theme/textmate");
editor.getSession().setMode("ace/mode/c_cpp");
editor.getSession().setUseWrapMode(true);
editor.setShowPrintMargin(false);
editor.setFontSize(14);
var plgCdLang = 1;

// 工具栏按钮点击
$('#plgCode .toolbar li').click(function(){
	plgCdToolbarClick($(this).index(), true);
});

// 工具栏按钮点击
function plgCdToolbarClick(index, sync) {
	$('#plgCode .toolbar li').removeClass('active');
	$('#plgCode .toolbar li:eq(' + index + ')').addClass('active');
	$('#plgCode .window').hide();
	switch (index) {
		case 0:
			$('#editor').show();
			break;
		case 1:
			$('#plgCode .compile').show();
			break;
		case 2:
			$('#plgCode .result').show();
			break;
		case 3:
			$('#plgCode .language').show();
			break;
	};
	if (sync) 
		rtOtherUpdate('plgCdToolbarClick', index);
}

// 编译窗口按钮点击
$('#plgCode .compile .toolbar2 input[type=button]').click(function(){
	$('#plgCode .toolbar li:eq(2)').click();
	$('#plgCode .result textarea').val('正在编译运行中，请稍等...');
	rtOtherUpdate('plgCdOutputData', '正在编译运行中，请稍等...');
	var obj = new Object();
	obj.lang = plgCdLang;
	obj.code = editor.getSession().getValue();
	obj.inputData = $('#plgCode .compile textarea').val();
	obj.timeLimit = parseInt($('#plgCode .compile .timeLimit').val());
	obj.memoryLimit = parseInt($('#plgCode .compile .memoryLimit').val());
	rtCompile(obj);
});

// 更换语言
$('#plgCode .language li').click(function(){
	plgCdLanguageChange($(this).index(), true);
});

// 更换语言
function plgCdLanguageChange(index, sync) {
	$('#plgCode .language li').removeClass('active');
	$('#plgCode .language li:eq(' + index + ')').addClass('active');
	plgCdLang = index;
	switch (index) {
		case 0:
		case 1:
			editor.getSession().setMode("ace/mode/c_cpp");
			break;
		case 2:
			editor.getSession().setMode("ace/mode/pascal");
			break;
	}
	$('#plgCode .toolbar li:eq(0)').click();
	if (sync)
		rtOtherUpdate('plgCdLanguageChange', index);
}

// 时间限制更改
$('#plgCode .compile .timeLimit').change(function() {
	rtOtherUpdate('plgCdTimeLimit', $(this).val());
});

// 内存限制更改
$('#plgCode .compile .memoryLimit').change(function() {
	rtOtherUpdate('plgCdMemoryLimit', $(this).val());
});

// 编译运行结果更改
function plgCdResultChange(data) {
	var s = '编译运行完成！\n\n';
	
	var result = new Array('正常结束', '编译错误', '运行时错误', '非法系统调用', '超过时间限制', '超过内存限制', '输出文件过大');
	s += '运行状态：' + result[data.result] + '\n';
	s += '运行时间：' + data.usedTime + 'MS\n';
	s += '使用内存：' + data.usedMemory + 'KB\n\n';
	if (data.result == 0)
		s += '输出数据：\n\n' + data.outputData + '\n';
	else
		s += '错误信息：\n\n' + data.outputData + '\n';
	
	$('#plgCode .result textarea').val(s);
}

// 清除代码插件所有内容
function plgCdIC() {
	editor.getSession().setValue('');
	editor.moveCursorTo(0, 0);
	$('#plgCode .toolbar li:eq(0)').click();
	$('#plgCode .compile textarea').val('');
	$('#plgCode .compile .timeLimit').val('1000');
	$('#plgCode .compile .memoryLimit').val('65535');
	$('#plgCode .result textarea').val('');
	plgCdLanguageChange(1);
}
 
// *******************************************************************
// 白板插件（whiteboard）（wb）
// *******************************************************************
var plgWbConfig = {
	canvas : $('.whiteboard')[0],
	canvasTemp : $('.whiteboardTemp')[0],
	context : $('.whiteboard')[0].getContext('2d'),
	context2 : $('.whiteboard')[0].getContext('2d'),
	contextTemp : $('.whiteboardTemp')[0].getContext('2d'),
	strokeStyle : '#1d1d1d',
	x : 0,
	y : 0,
	ex : 0,
	ey : 0,
	width : 100,
	height : 100,
	ratio : 3,
	pressure : 1.0,
	state : 0,
	moved : 0,
	canDelete : 0,
}

// 初始化
function plgWbInit() {
	plgWbConfig.canvas.onmousedown = plgWbStartDrawing;
	plgWbConfig.canvas.onblclick = plgWbLiftPen;
	plgWbConfig.canvasTemp.onmousedown = plgWbStartDrawing;
	plgWbConfig.canvasTemp.onblclick = plgWbLiftPen;
	document.documentElement.onmouseup = function(){plgWbLiftPen();};
	plgWbConfig.context.lineCap = 'round';
	plgWbConfig.context.lineJoin = 'round';
	plgWbConfig.contextTemp.lineCap = 'round';
	plgWbConfig.contextTemp.lineJoin = 'round';
}

// 开始画画
function plgWbStartDrawing(e){
	if(e.offsetX){
		plgWbConfig.x = e.offsetX;
		plgWbConfig.y = e.offsetY;
	} else {
		plgWbConfig.x = e.layerX;
		plgWbConfig.y = e.layerY;
	}

	plgWbConfig.canDelete = 0;
	if (plgWbConfig.state <= 1) {
		$('#plgWhiteboard .whiteboardTemp').hide();
		plgWbConfig.context.strokeStyle = plgWbConfig.strokeStyle;
		plgWbConfig.context.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio;
		plgWbConfig.canvas.onmousemove = plgWbDraw;
		var addContent = {
			remoteWidth : plgWbConfig.width,
			remoteHeight : plgWbConfig.height,
			color : plgWbConfig.strokeStyle,
			ratio : plgWbConfig.ratio,
			state : plgWbConfig.state,
			op : 'start'
		};
		rtAddContent('whiteboard', addContent);
	}
	else {
		$('#plgWhiteboard .whiteboardTemp').show();
		plgWbConfig.contextTemp.strokeStyle = plgWbConfig.strokeStyle;
		plgWbConfig.contextTemp.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio;
		plgWbConfig.moved = 0;
		if (plgWbConfig.state == 2)
			plgWbConfig.canvasTemp.onmousemove = plgWbLineTemp;
		if (plgWbConfig.state == 3)
			plgWbConfig.canvasTemp.onmousemove = plgWbRectangleTemp;
		if (plgWbConfig.state == 4)
			plgWbConfig.canvasTemp.onmousemove = plgWbRoundTemp;
		if (plgWbConfig.state == 5)
			plgWbConfig.canvasTemp.onmousemove = plgWbSelectTemp;
	}
}

// 画画中
function plgWbDraw(e){
	var x;
	var y;
	if(e.offsetX) {
		x = e.offsetX;
		y = e.offsetY;
	} else {
		x = e.layerX;
		y = e.layerY;
	}
	
	var addContent = {
		sx : plgWbConfig.x,
		sy : plgWbConfig.y,
		ex : x,
		ey : y,
		state : plgWbConfig.state,
		op : 'draw'
	};
	rtAddContent('whiteboard', addContent);
	
	plgWbConfig.context.beginPath();
	if(plgWbConfig.state == 1) {
		plgWbConfig.context.strokeStyle = '#ffffff';
		plgWbConfig.context.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio * 3;
		plgWbConfig.context.moveTo(plgWbConfig.x, plgWbConfig.y);
		plgWbConfig.context.lineTo(x, y);
		plgWbConfig.context.stroke();
		plgWbConfig.x = x;
		plgWbConfig.y = y;
	} else {
		plgWbConfig.context.moveTo(plgWbConfig.x, plgWbConfig.y);
		plgWbConfig.context.lineTo(x, y);
		plgWbConfig.context.stroke();
		plgWbConfig.x = x;
		plgWbConfig.y = y;
	}
}

// 结束画画
function plgWbLiftPen() {
	if (plgWbConfig.state <= 1) {
		plgWbConfig.canvas.onmousemove = null;
		//var addContent = {
		//	op : 'end'
		//};
		//rtAddContent('whiteboard', addContent);
	}
	else {
		plgWbConfig.canvasTemp.onmousemove = null;
		if (plgWbConfig.state == 2)
			plgWbLine(plgWbConfig.x, plgWbConfig.y, plgWbConfig.ex, plgWbConfig.ey);
		if (plgWbConfig.state == 3)
			plgWbRectangle(plgWbConfig.x, plgWbConfig.y, plgWbConfig.ex, plgWbConfig.ey);
		if (plgWbConfig.state == 4)
			plgWbRound(plgWbConfig.x, plgWbConfig.y, plgWbConfig.ex, plgWbConfig.ey);
		if (plgWbConfig.state == 5) {
			plgWbConfig.canDelete = 1;
		}
		if (plgWbConfig.state != 5)
			plgWbClearTemp();
		plgWbConfig.moved = 0;
	}
}

// 清除
function plgWbClear(width, height, sx, sy) {
	if (width == null || height == null) {
		width = plgWbConfig.width;
		height = plgWbConfig.height;
	}
	if (sx == null || sy == null) {
		sx = 0;
		sy = 0;
	}
	
	var addContent = {
		sx : sx,
		sy : sy,
		width : width,
		height : height,
		remoteWidth : plgWbConfig.width,
		remoteHeight : plgWbConfig.height,
		op : 'clear'
	};
	rtAddContent('whiteboard', addContent);
	
	plgWbConfig.context.clearRect(sx, sy, width, height);
}

// 清除（临时画板）
function plgWbClearTemp(width, height) {
	if (width == null || height == null) {
		width = plgWbConfig.width;
		height = plgWbConfig.height;
	}
	plgWbConfig.contextTemp.clearRect(0, 0, width, height);
}

// 画直线
function plgWbLine(sx, sy, ex, ey) {
	if (!plgWbConfig.moved) return;
	
	var addContent = {
		sx : sx,
		sy : sy,
		ex : ex,
		ey : ey,
		color : plgWbConfig.strokeStyle,
		ratio : plgWbConfig.ratio,
		remoteWidth : plgWbConfig.width,
		remoteHeight : plgWbConfig.height,
		op : 'line'
	};
	rtAddContent('whiteboard', addContent);
	
	plgWbConfig.context.strokeStyle = plgWbConfig.strokeStyle;
	plgWbConfig.context.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio;
	plgWbConfig.context.beginPath();
	plgWbConfig.context.moveTo(sx, sy);
	plgWbConfig.context.lineTo(ex, ey);
	plgWbConfig.context.stroke();
}

// 画直线（临时画板）
function plgWbLineTemp(e) {
	var x;
	var y;
	if(e.offsetX) {
		x = e.offsetX;
		y = e.offsetY;
	} else {
		x = e.layerX;
		y = e.layerY;
	}
	plgWbConfig.ex = x;
	plgWbConfig.ey = y;
	plgWbConfig.contextTemp.beginPath();
	plgWbConfig.contextTemp.moveTo(plgWbConfig.x, plgWbConfig.y);
	plgWbConfig.contextTemp.lineTo(x, y);
	plgWbClearTemp();
	plgWbConfig.contextTemp.stroke();
	plgWbConfig.moved = 1;
}

// 画矩形
function plgWbRectangle(sx, sy, ex, ey) {
	if (!plgWbConfig.moved) return;
	
	var addContent = {
		sx : sx,
		sy : sy,
		ex : ex,
		ey : ey,
		color : plgWbConfig.strokeStyle,
		ratio : plgWbConfig.ratio,
		remoteWidth : plgWbConfig.width,
		remoteHeight : plgWbConfig.height,
		op : 'rectangle'
	};
	rtAddContent('whiteboard', addContent);
	
	plgWbConfig.context.strokeStyle = plgWbConfig.strokeStyle;
	plgWbConfig.context.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio;
	plgWbConfig.context.beginPath();
	plgWbConfig.context.strokeRect(sx, sy, ex - sx, ey - sy);
}

// 画矩形（临时画板）
function plgWbRectangleTemp(e) {
	var x;
	var y;
	if(e.offsetX) {
		x = e.offsetX;
		y = e.offsetY;
	} else {
		x = e.layerX;
		y = e.layerY;
	}
	plgWbConfig.ex = x;
	plgWbConfig.ey = y;
	plgWbConfig.contextTemp.beginPath();
	plgWbClearTemp();
	plgWbConfig.contextTemp.strokeRect(plgWbConfig.x, plgWbConfig.y, x - plgWbConfig.x, y - plgWbConfig.y);
	plgWbConfig.moved = 1;
}

// 画圆形
function plgWbRound(sx, sy, ex, ey) {
	if (!plgWbConfig.moved) return;
	
	var addContent = {
		sx : sx,
		sy : sy,
		ex : ex,
		ey : ey,
		color : plgWbConfig.strokeStyle,
		ratio : plgWbConfig.ratio,
		remoteWidth : plgWbConfig.width,
		remoteHeight : plgWbConfig.height,
		op : 'round'
	};
	rtAddContent('whiteboard', addContent);
	
	var radius = Math.pow((sx - ex) * (sx - ex) + (sy - ey) * (sy - ey), 0.5) / 2;
	var cx = sx + (ex - sx) / 2;
	var cy = sy + (ey - sy) / 2;
	plgWbConfig.context.strokeStyle = plgWbConfig.strokeStyle;
	plgWbConfig.context.lineWidth = plgWbConfig.pressure * plgWbConfig.ratio;
	plgWbConfig.context.beginPath();
	plgWbConfig.context.arc(cx, cy, radius, 0, Math.PI * 2, true);
	plgWbConfig.context.stroke();
}

// 画圆形（临时画板）
function plgWbRoundTemp(e) {
	var x;
	var y;
	if(e.offsetX) {
		x = e.offsetX;
		y = e.offsetY;
	} else {
		x = e.layerX;
		y = e.layerY;
	}
	plgWbConfig.ex = x;
	plgWbConfig.ey = y;
	plgWbClearTemp();
	var radius = Math.pow((plgWbConfig.x - x) * (plgWbConfig.x - x) + (plgWbConfig.y - y) * (plgWbConfig.y - y), 0.5) / 2;
	var cx = plgWbConfig.x + (x - plgWbConfig.x) / 2;
	var cy = plgWbConfig.y + (y - plgWbConfig.y) / 2;
	plgWbConfig.contextTemp.beginPath();
	plgWbConfig.contextTemp.arc(cx, cy, radius, 0, Math.PI * 2, true);
	plgWbConfig.contextTemp.stroke();
	plgWbConfig.moved = 1;
}

// 选择区域（临时画板）
function plgWbSelectTemp(e) {
	var x;
	var y;
	if(e.offsetX) {
		x = e.offsetX
		y = e.offsetY;
	} else {
		x = e.layerX
		y = e.layerY;
	}
	plgWbConfig.ex = x;
	plgWbConfig.ey = y;
	plgWbConfig.contextTemp.beginPath();
	plgWbClearTemp();
	var dashed = new Image();
	dashed.src = '/images/ois/icon/wb_dashed.gif';
	plgWbConfig.contextTemp.strokeStyle = plgWbConfig.contextTemp.createPattern(dashed, 'repeat');
	plgWbConfig.contextTemp.lineWidth = 2.0;
	plgWbConfig.contextTemp.strokeRect(plgWbConfig.x, plgWbConfig.y, x - plgWbConfig.x, y - plgWbConfig.y);
}

// 获取新坐标x
function plgWbGetX(width, remoteWidth, x) {
	return width * x / remoteWidth;
}

// 获取新坐标y
function plgWbGetY(height, remoteHeight, y) {
	return height * y / remoteHeight;
}

// 重绘
function plgWbReDraw(obj) {
	if (obj.op == 'start') {
		plgWbConfig.remoteWidth = obj.remoteWidth;
		plgWbConfig.remoteHeight = obj.remoteHeight;
		plgWbConfig.remoteRatio = obj.ratio;
		plgWbConfig.context2.strokeStyle = obj.color;
		plgWbConfig.context2.lineWidth = obj.ratio;
	} 
	else
	if (obj.op == 'draw') {
		obj.sx = plgWbGetX(plgWbConfig.width, plgWbConfig.remoteWidth, obj.sx);
		obj.sy = plgWbGetY(plgWbConfig.height, plgWbConfig.remoteHeight, obj.sy);
		obj.ex = plgWbGetX(plgWbConfig.width, plgWbConfig.remoteWidth, obj.ex);
		obj.ey = plgWbGetY(plgWbConfig.height, plgWbConfig.remoteHeight, obj.ey);
		plgWbConfig.context2.beginPath();
		if(obj.state == 1) {
			plgWbConfig.context2.strokeStyle = '#ffffff';
			plgWbConfig.context2.lineWidth = plgWbConfig.remoteRatio * 3;
			plgWbConfig.context2.moveTo(obj.sx, obj.sy);
			plgWbConfig.context2.lineTo(obj.ex, obj.ey);
			plgWbConfig.context2.stroke();
		} else {
			plgWbConfig.context2.moveTo(obj.sx, obj.sy);
			plgWbConfig.context2.lineTo(obj.ex, obj.ey);
			plgWbConfig.context2.stroke();
		}
	}
	else 
	if (obj.op == 'end') {
	}
	else 
	if (obj.op == 'clear') {
		obj.sx = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.sx);
		obj.sy = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.sy);
		obj.width = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.width);
		obj.height = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.height);
		plgWbConfig.context2.clearRect(obj.sx, obj.sy, obj.width, obj.height);
	}
	else 
	if (obj.op == 'line') {
		obj.sx = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.sx);
		obj.sy = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.sy);
		obj.ex = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.ex);
		obj.ey = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.ey);
		plgWbConfig.context2.strokeStyle = obj.color;
		plgWbConfig.context2.lineWidth = obj.ratio;
		plgWbConfig.context2.beginPath();
		plgWbConfig.context2.moveTo(obj.sx, obj.sy);
		plgWbConfig.context2.lineTo(obj.ex, obj.ey);
		plgWbConfig.context2.stroke();
	}
	else
	if (obj.op == 'rectangle') {
		obj.sx = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.sx);
		obj.sy = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.sy);
		obj.ex = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.ex);
		obj.ey = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.ey);
		plgWbConfig.context2.strokeStyle = obj.color;
		plgWbConfig.context2.lineWidth = obj.ratio;
		plgWbConfig.context2.beginPath();
		plgWbConfig.context2.strokeRect(obj.sx, obj.sy, obj.ex - obj.sx, obj.ey - obj.sy);
	}
	else 
	if (obj.op == 'round') {
		obj.sx = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.sx);
		obj.sy = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.sy);
		obj.ex = plgWbGetX(plgWbConfig.width, obj.remoteWidth, obj.ex);
		obj.ey = plgWbGetY(plgWbConfig.height, obj.remoteHeight, obj.ey);
		var radius = Math.pow((obj.sx - obj.ex) * (obj.sx - obj.ex) + (obj.sy - obj.ey) * (obj.sy - obj.ey), 0.5) / 2;
		var cx = obj.sx + (obj.ex - obj.sx) / 2;
		var cy = obj.sy + (obj.ey - obj.sy) / 2;
		plgWbConfig.context2.strokeStyle = obj.color;
		plgWbConfig.context2.lineWidth = obj.ratio;
		plgWbConfig.context2.beginPath();
		plgWbConfig.context2.arc(cx, cy, radius, 0, Math.PI * 2, true);
		plgWbConfig.context2.closePath();
		plgWbConfig.context2.stroke();
	}
}

// 监听工具栏
$('#plgWhiteboard .toolbar li').click(function(){
	plgWbClearTemp();
	plgWbConfig.canDelete = 0;

	var name = $(this).attr('class');
	if (name == 'plgWbSelect') {
		plgWbConfig.state = 5;
		$('#plgWhiteboard canvas').css('cursor', 'crosshair');
	} else
	if (name == 'plgWbPencil') {
		plgWbConfig.state = 0;
		$('#plgWhiteboard canvas').css('cursor', 'url(/images/ois/icon/wb_pencil.cur),auto');
	} else
	if (name == 'plgWbEraser') {
		plgWbConfig.state = 1;
		$('#plgWhiteboard canvas').css('cursor', 'url(/images/ois/icon/wb_eraser.cur),auto');
	} else
	if (name == 'plgWbLine') {
		plgWbConfig.state = 2;
		$('#plgWhiteboard canvas').css('cursor', 'crosshair');
	} else
	if (name == 'plgWbRectangle') {
		plgWbConfig.state = 3;
		$('#plgWhiteboard canvas').css('cursor', 'crosshair');
	} else
	if (name == 'plgWbRound') {
		plgWbConfig.state = 4;
		$('#plgWhiteboard canvas').css('cursor', 'crosshair');
	} else
	if (name == 'plgWbClear') {
		plgWbClear();
	} else
	if (name == 'plgWbThick') {
		plgWbConfig.ratio = 5;
	} else
	if (name == 'plgWbThin') {
		plgWbConfig.ratio = 3;
	} else
	if (name == 'plgWbBlack') {
		plgWbConfig.strokeStyle = '#1d1d1d';
	} else
	if (name == 'plgWbRed') {
		plgWbConfig.strokeStyle = '#cd0000';
	} else
	if (name == 'plgWbYellow') {
		plgWbConfig.strokeStyle = '#eac100';
	} else
	if (name == 'plgWbBlue') {
		plgWbConfig.strokeStyle = '#0066ff';
	}
});

// 监听画布
$('#plgWhiteboard .whiteboard').bind("mousedown", function(e) {
	e.preventDefault();
	return false;
});
$('#plgWhiteboard .whiteboardTemp').bind("mousedown", function(e) {
	e.preventDefault();
	return false;
});

// 清除画板所有内容
function plgWbIC() {
	plgWbClear();
	plgWbClearTemp();
}

// *******************************************************************
// 时间插件（time）（time）
// *******************************************************************

var plgTimeTotTime = 0;
function plgTimeSet(time) {
	plgTimeTotTime = time;
}

function plgTimeUpdate() {
	var s = '[时间] ';
	var tmpTime = plgTimeTotTime;
	if (plgTimeTotTime < 0) {
		s += '还剩';
		tmpTime = -plgTimeTotTime;
	}
	
	var hour = Math.floor(tmpTime / 3600);
	var minute = Math.floor((tmpTime - hour * 3600) / 60);
	var second = tmpTime - hour * 3600 - minute * 60;
	
	if (hour != 0) s += hour + '小时';
	if (minute < 10) minute = '0' + minute;
	if (hour != 0 || minute != 0) s += minute + '分';
	if (second < 10) second = '0' + second;
	s += second + '秒';
	$('.header .toolbar .clock').html(s);
	plgTimeTotTime++;
	setTimeout('plgTimeUpdate()', 1000);
}

// ========================================================================================
//	即时通信模块（rt）
// ========================================================================================

// 变量定义
var rtCont = new Array();		// 更新内容容器
var rtContCount = 5;			// 更新内容容器数量
var rtContPointer = 0;			// 更新内容容器指针
var rtLastCont = new Array();	// 上次更新的内容
rtLastCont['code'] = '';
rtLastCont['inputData'] = '';
var rtVersion = new Array();
for (var i = 0; i < rtContCount; i++) {
	rtCont[i] = new Object();
}
var rtFirstConnect = 1;			// 初次连接
var rtGettingData = 0;			// 获取数据中
var rtReGettingData = 0;		// 重新获取数据中
var rtReGettingProcess = 0;		// 重新获取数据的进度


// 连接服务器
var rtSocket;
if (gMode == 0) {
	tolMsAdd('正在连接服务器...', 'admin');
	rtSocket = io.connect(socketAddr);
}
else {
	rtSocket = io.connect();
}

// 发送消息
function rtEmit(name, data) {
	if (gMode != 0) return;
	var obj = new Object();
	obj.company_id = gCompanyId;
	obj.room_id = gRoomId;
	obj.role_id = gRoleId;
	obj.user_id = gUserId;
	obj.session_id = gSessionId;
	obj.cont = data;
	rtSocket.emit(name, obj);
}

// 监听事件
rtSocket.on('connect', function() {
	if (gMode != 0) return;
	rtGettingData = 1;
	tolMsAdd('连接成功', 'admin');
	joinRoom();
});
rtSocket.on('reconnect', function() {
	if (gMode != 0) return;
	tolMsAdd('连接成功', 'admin');
	rtReGet();
});
rtSocket.on('disconnect', function() {
	if (gMode != 0) return;
	rtGettingData = 1;
	tolMsAdd('连接失败', 'admin');
	rtSocket.socket.reconnect();
});
rtSocket.on('reconnecting', function() {
	if (gMode != 0) return;
	tolMsAdd('重新连接中，若长时间无响应请刷新页面', 'admin');
});
rtSocket.on('reconnect_failed', function() {
	if (gMode != 0) return;
	tolMsAdd('连接失败，请刷新页面', 'admin');
});
rtSocket.on('notAvailable', function() {
	if (gMode != 0) return;
	tolMsAdd('服务器初始化中...', 'admin');
	setTimeout('joinRoom()', 3000);
});
function joinRoom() {
	rtSocket.emit('join', {company_id : gCompanyId, room_id : gRoomId, role_id : gRoleId, user_id : gUserId, session_id : gSessionId}, function() {
		rtReGet();
		if (rtFirstConnect == 1) {
			rtFirstConnect = 0;
			rtSubmit();
			rtUpdate();
			evaluationSubmit();
		}
		rtGetTime();
		plgTimeUpdate();
	});
}

// 间隔提交数据
function rtSubmit() {
	if (gMode != 0) return;
	if (!rtGettingData) {
		var cnt = rtContPointer;
		rtContPointer = (rtContPointer + 1) % rtContCount;
		if (rtCont[cnt]['updated'] == 1) {
			delete rtCont[cnt]['updated'];
			rtEmit('pluginUpdate', rtCont[cnt]);
			rtCont[cnt] = new Object();
		}
	}
	setTimeout('rtSubmit()', 100);
}

// 间隔更新数据
function rtUpdate() {
	if (gMode != 0) return;
	for (var i = 0; i < plgCount; i++) {
		// 代码编辑器
		if (plgName[i] == 'code') {
			if (rtGettingData) continue;
			// 代码框
			var cont = editor.getSession().getValue();
			if (cont != rtLastCont['code']) {
				rtLastCont['code'] = cont;
				rtCont[rtContPointer]['updated'] = 1;
				rtCont[rtContPointer]['code'] = new Object();
				rtCont[rtContPointer]['code']['content'] = cont;
			}
			// 输入数据
			cont = $('#plgCode .compile textarea').val();			
			if (cont != rtLastCont['inputData']) {
				rtLastCont['inputData'] = cont;
				rtOtherUpdate('plgCdInputData', cont);
			}
		}
	}
	setTimeout('rtUpdate()', 100);
}
//  加入新数据
function rtAddContent(name, content) {
	if (gMode != 0) return;
	var cnt = rtContPointer;
	rtCont[cnt]['updated'] = 1;
	if (rtCont[cnt][name] == null) {
		rtCont[cnt][name] = new Object();
		rtCont[cnt][name]['count'] = 0;
	}
	var count = rtCont[cnt][name]['count'];
	rtCont[cnt][name][count] = content;
	rtCont[cnt][name]['count']++;
}

// 重新获取所有数据
function rtReGet() {
	if (rtReGettingData) return;
	rtReGettingData = 1;
	var obj = new Object();
	for (var i = 0; i < plgCount; i++) {
		if (rtVersion[plgName[i]] == null)
			rtVersion[plgName[i]] = 0;
		obj[plgName[i]] = rtVersion[plgName[i]];
	}
	rtEmit('reget', obj);
}

// 重新接收所有数据
rtSocket.on('reget', function (data) {
	if (data.code != null && data.code[0] != null) {
		var obj = new Object();
		obj.code = new Object();
		obj.code.version = data.code[0].cont_id;
		obj.code.content = eval('(' + data.code[0].content + ')').content;
		rtPluginUpdate(obj);
	}
	if (data.whiteboard != null) {
		for (var i = 0; i < data.whiteboard.length; i++ ) {
			var obj = new Object();
			obj.whiteboard = new Object();
			obj.whiteboard = eval('(' + data.whiteboard[i].content + ')');
			obj.whiteboard.version = data.whiteboard[i].cont_id;
			rtPluginUpdate(obj);
		}
	}
	if (data.evaluation != null) {
		$('.evaluation textarea').val(data.evaluation);
		return;
	}
	rtReGettingProcess++;
	if (rtReGettingProcess == plgCount) {
		rtReGettingProcess = 0;
		rtReGettingData = 0;
		rtGettingData = 0;
	}
});

// 接收插件更新数据
rtSocket.on('pluginUpdate', function (data) {
	if (data.user_id == gUserId) return;
	rtPluginUpdate(data);
});

// 接收插件更新数据
function rtPluginUpdate(data) {
	// 代码编辑器
	if (data.code != null) {
		rtLastCont['code'] = data.code.content;
		var cursor = editor.getCursorPosition();
		editor.getSession().setValue(data.code.content);
		editor.moveCursorTo(cursor.row, cursor.column);
		rtVersion['code'] = data.code.version;
	}
	// 白板
	if (data.whiteboard != null) {
		var count = data.whiteboard.count;
		for (var i = 0; i < count; i++) {
			plgWbReDraw(data.whiteboard[i]);
		}
		rtVersion['whiteboard'] = data.whiteboard.version;
	}
	// 其他
	if (data.other != null) {
		var count = data.other.count;
		for (var i = 0; i < count; i++) {
			var obj = data.other[i];
			// 代码编辑器编译语言切换
			if (obj.name == 'plgCdLanguageChange') {
				plgCdLanguageChange(obj.data, false);
			} else
			// 代码编辑器工具栏点击
			if (obj.name == 'plgCdToolbarClick') {
				plgCdToolbarClick(obj.data, false);
			} else
			// 代码编辑器输入数据
			if (obj.name == 'plgCdInputData') {
				rtLastCont['inputData'] = obj.data;
				$('#plgCode .compile textarea').val(obj.data);
			} else
			// 代码编辑器输出数据
			if (obj.name == 'plgCdOutputData') {
				$('#plgCode .result textarea').val(obj.data);
			} else
			// 代码编辑器时间更改
			if (obj.name == 'plgCdTimeLimit') {
				$('#plgCode .compile .timeLimit').val(obj.data);
			} else
			// 代码编辑器内存更改
			if (obj.name == 'plgCdMemoryLimit') {
				$('#plgCode .compile .memoryLimit').val(obj.data);
			} else
			// 代码编辑器编译运行完成
			if (obj.name == 'plgCdCompile') {
				plgCdResultChange(obj.data);
			} else
			// 导航栏点击
			if (obj.name == 'plgNaviClick') {
				plgNaviClick(obj.data, false);
			}
		}
	}
}

// 错误信息
rtSocket.on('error', function(data) {
	if (data == '')
		data = '连接失败';
	tolMsAdd(data, 'admin');
});

// 编译运行
function rtCompile(data) {
	rtEmit('compile', data);
}

// 编译运行
rtSocket.on('compile', function(data) {
	plgCdResultChange(data);
});

// 其他插件内容更新
function rtOtherUpdate(name, data) {
	var obj = new Object();
	obj.name = name;
	obj.data = data;
	rtAddContent('other', obj);
}

// 获取时间
function rtGetTime() {
	rtEmit('getTime');
	setTimeout('rtGetTime()', 60000);
}

// 获取时间
rtSocket.on('getTime', function(data) {
	plgTimeSet(data);
});

// 结束面试
$('.header .toolbar .end_t').click(function() {
	$('.header .toolbar .end_ok').toggle();
	$('.header .toolbar .end_no').toggle();
});
$('.header .toolbar .end_no').click(function() {
	$('.header .toolbar .end_ok').hide();
	$('.header .toolbar .end_no').hide();
});
$('.header .toolbar .end_ok').click(function() {
	rtEmit('end', '');
});
rtSocket.on('end', function(data) {
	$(window).unbind('beforeunload');
	location.href = '/ois/ois_room/evaluation/id/' + gRoomId;
});

// 评价自动保存
var lastEvaluation = '';
function evaluationSubmit() {
	var s = $('.evaluation textarea').val();
	if (s != lastEvaluation) {
		lastEvaluation = s;
		rtEmit('evaluation', s);
	}
	setTimeout('evaluationSubmit()', 5000);
}


// ========================================================================================
// 全局操作
// ========================================================================================
$('body').bind("keydown", function(e) {
	switch (e.which) {
		// backspace
		case 8:
			//e.preventDefault();
			break;
		// delete
		case 46:
			if (plgWbConfig.canDelete) {
				plgWbClear(plgWbConfig.ex - plgWbConfig.x, plgWbConfig.ey - plgWbConfig.y, plgWbConfig.x, plgWbConfig.y);	plgWbClearTemp();
				plgWbConfig.canDelete = 0;
			}
			break;
	}
});

$(window).bind("beforeunload",function() {
	return '确认离开面试房间？';
});

$('.evaluation_on').click(function() {
	$('.evaluation').toggle();
});
$('.evaluation_off').click(function() {
	$('.evaluation').hide();
});


$(window).resize(function(){
	resetWidthHeight();
});	

resetWidthHeight();
plgWbInit();