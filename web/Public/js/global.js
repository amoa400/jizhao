var weburl = 'http://'+window.location.host;

// 获取object里的元素个数
function object_count(o){
	var t = typeof o;
	if(t == 'string') {
		return o.length;
	} else 
	if(t == 'object') {
		var n = 0;
		for(var i in o) {
			n++;
		}
		return n;
	}
	return false;
}
