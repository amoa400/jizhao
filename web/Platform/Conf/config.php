<?php
return array(
	// 数据库
	'DB_HOST'	=> 	'localhost',	// 数据库地址
	'DB_NAME'	=>	'jzhao', 		// 数据库名称
	'DB_USER'	=>	'root',			// 数据库用户名
	'DB_PWD'	=>	'123',			// 数据库密码
	'DB_PORT'	=>	'3306',			// 数据库端口
	'DB_PREFIX' => 	'jz_',			// 数据库前缀
	
	// 模版
	'TMPL_L_DELIM'	=>	'<{',		// 模版变量前缀
	'TMPL_R_DELIM'	=>	'}>',		// 模版变量后缀
	
	// 分组
	'APP_GROUP_LIST'	=>	'Home,Base,Manage,SYS,RMS,OIS',		// 分组列表
	'DEFAULT_GROUP'		=>	'Home',								// 默认分组
	
	// 模板常量
	'TMPL_PARSE_STRING'	=>	array(
		'__ROOT__'			=>		'http://jzhao.cn',			// 网站地址
		'__NAME__'			=>		'即招',						// 网站名字
		'__PHONE__'			=>		'400-820-8820',				// 网站电话
		'__FMSIP__'			=>		'192.168.0.100',			// FMS服务器IP地址
		'__SOCKET_ADDR__'	=>		'192.168.0.100:3001',		// NODEJS服务地址
	),
	
	// 其他
	'URL_MODEL'				=>	'2',		// 路由模式
	'SHOW_PAGE_TRACE'		=>	false,		// 显示调试信息
	'URL_CASE_INSENSITIVE'	=>	true,		// 路由统一小写
	'URL_HTML_SUFFIX'	 	=>  '',			// URL后缀
);
?>