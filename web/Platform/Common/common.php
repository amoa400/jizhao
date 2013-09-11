<?php
// 加密字符串
function encrypt($s) {
	return md5(sha1($s));
}
	
// 获取时间
function getTime() {
	return time();
}

// 转换成时间
function intToTime($time) {
	return date('Y-m-d H:i:s', $time);
}

// 转换成时间
function timeToInt($time) {
	return strtotime($time);
}

// 前台过滤
function html( $s ) {
	return htmlspecialchars( $s );
}
	
// 获取日期
function getCntDate() {
	return date('Y-m-d', getTime());
}
	
// 元素是否在集合里
function isIn( $data, $arr ) {
	foreach( $arr as $a ) {
		if ( $data == $a ) return true;
	}
	return false;
}
	
// 检车变量是否是日期
function isDate($date, $format) {
	$unixTime = strtotime($date);
	$checkDate = date($format, $unixTime);
	if($checkDate == $date)
		return $date;
	else
		return 0;
}

// 将br转换成\n
function br2nl($text) {    
    return preg_replace('/<br\\s*?\/??>/i', '', $text);   
}

// 递归创建目录
function recursiveMkdir($path, $mode = 0775){
	if (!file_exists($path)) {
		recursiveMkdir(dirname($path), $mode);
		mkdir($path, $mode);
	}
}

// 是否登录
function isLogin($role = 0, $redirect = true) {
	if (empty($_SESSION['login']) || ($role != 0 && $_SESSION['role'] != $role)) {
		if ($redirect) redirect(U('/index/index'));
		return false;
	}
	return true;
}

// 截取字符串
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr")){
            if ($suffix && strlen($str)>$length)
                return mb_substr($str, $start, $length, $charset)."...";
        else
                 return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
            if ($suffix && strlen($str)>$length)
                return iconv_substr($str,$start,$length,$charset)."...";
        else
                return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}