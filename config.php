<?

$config['domain'] = "http://www.domain.mn/";
$config['abs_dir'] = "/opt/website/domain.mn/";
$config['dir'] = "";
$config['include_dir'] = "core/"; //relative to abs_dir
$config['include_domain'] = "http://www.domain.mn/core/"; //library domain

$config['db_charset'] = "utf8";
$config['core_db_charset'] = "utf8";

$config['time_zone'] = 0;
$config['server_ip']='202.131.237.43';
$config['exclude_domain_stat'] = 'domain.mn'; //stat module-d referer deer algasah domain. WWW gui bichne.

$config['db_host'] = "localhost";
$config['db_name'] = "";
$config['db_user'] = "m";//.rand(1,26);
$config['db_pass'] = "m";
$config['db_prefix'] = "mbm_";
$config['db_type'] = "mysql";

$config_user['db_host'] = "localhost";
$config_user['db_name'] = "mpw";
$config_user['db_user'] = "m";
$config_user['db_pass'] = "";
$config_user['db_prefix'] = "mbm2_";
$config_user['db_type'] = "mysql";

$config['user_db_prefix'] = $config_user['db_prefix'];

$config['session_db_host'] = "localhost";
$config['session_db_name'] = "mpw";
$config['session_db_user'] = "m";
$config['session_db_pass'] = "m";
$config['session_db_prefix'] = "mbm2_";
$config['session_db_type'] = "mysql";
$config['session_db_table'] = "sessions";
	
$config['cache_dir'] = $config['abs_dir']."cache/";
$config['video_dir'] = "files/videos/"; //video news video storage folder.
$config['photo_dir'] = "files/photos/"; //photo news photo storage folder
$config['gallery_dir'] = "files/galleries/"; //photo gallery photo storage folder
$config['product_dir'] = "files/products/"; //shopping products storage folder
$config['default_lang'] = "mn";
$config['levels'] = 9;
$config['hits_by'] = 1;
$config['currency']='MNT';

//grabber settings start
	$config["grabber_module_dir"] = $config['abs_dir']."modules/grabber";
	
	// Write the path of curl installation
	// example: '/usr/local/bin/curl' (linux)
	$config["grabber_curl_path"] = "/usr/local/bin/curl";
	
	// NOTE: make sure that the 'tmp' folder have write permission.
	
	$config["grabber_error_msg"] =  "<br />Холболт амжилтгүй боллоо";
	$config["grabber_cookie_file"] = $config["grabber_module_dir"]."/cookie.txt";
//grabber settings end

$config['cookie_name'] = 'DOMAIN';
$config['cookie_domain'] = 'domain.mn';

$user_level_types =  array(	
							0=>'Guest',
							1=>'Member',
							2=>'Mod member',
							3=>'Super member',
							4=>'Administrator',
							5=>'Super administrator');
$image_types = array(
						1=>'gif',
						2=>'jpg',
						3=>'png',
						4=>'swf',
						5=>'psd',
						6=>'bmp',
						7=>'tiff1',
						8=>'tiff2',
						9=>'jpc',
						10=>'jp2',
						11=>'jpx',
						12=>'jb2',
						13=>'swc',
						14=>'iff',
						15=>'wbmp',
						16=>'xbm');
$modules_active = array(
						//"blog",
						//"forum",
						"poll",
						//"zurkhai",
						"users",
						"search",
						//"auto",
						"menu",
						"shopping",
						//"cache",
						"music",
						"video",
						"banner",
						"stats",
						"dic",
						"web",
						"faqs",
						"photogallery",
						"phazeddl",
						"shoutbox",
						"ratings",
						"comments");
$modules_permissions = array(
							//"blog"=>3,
							//"forum"=>3,
							"poll"=>3,
							//"zurkhai"=>3,
							"users"=>5,
							"search"=>3,
							"auto"=>5,
							"menu"=>4,
							"shopping"=>4,
							"cache"=>5,
							"music"=>3,
							"video"=>3,
							"banner"=>4,
							"stats"=>0,
							"dic"=>0,
							"web"=>0,
							"faqs"=>0,
							"photogallery"=>0,
							"phazeddl"=>0,
							"shoutbox"=>0,
							"ratings"=>0,
							"comments"=>3,
							"settings"=>4);

foreach($config as $k=>$v){
	define(strtoupper($k),$v);
}

?>