var weburl = 'http://'+window.location.host;

// ��ȡobject���Ԫ�ظ���
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
