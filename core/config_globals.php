<?

if(!is_dir(ABS_DIR.DIR.'users/'.strtolower($_SESSION['user']['username'])) && (int)($_SESSION['lev'])>0){
	exec("mkdir ".ABS_DIR.DIR.'users/'.strtolower($_SESSION['user']['username']));
	copy(ABS_DIR.DIR.'users/index.html',ABS_DIR.DIR.'users/'.strtolower($_SESSION['user']['username']).'/index.html');
}

switch($_SESSION['lev']){
	case 5:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_upload_filesize', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_width', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_height', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify_subdirectories', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_create_subdirectories', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'recursive', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'chmod_to', false);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'thumbnails_enabled', true);
		$config->setStaticConfigValue ('PG_SPAWFM_DIRECTORIES', array(
																	array(
																  'dir'     => '/images/banners/flash/',
																	'caption' => 'Flash movies', 
																	'params'  => array(
																					'allowed_filetypes' => array('flash')
																					)
																),
									  							array(
																	  'dir'     => '/images/banners/',
																	  'caption' => 'Banner images',
																	  'params'  => array(
																					'default_dir' => true, // set directory as default (optional setting)
																					'allowed_filetypes' => array('images')
																					)
																),
																array(
																	  'dir'     => '/images/news/',
																	  'caption' => 'News',
																	  'params'  => array(
																						 'default_dir' => true, // set directory as default (optional setting)
																						 'allowed_filetypes' => array('images')
																						 )
																	  ),
																array(
																	  'dir'     => '/images/',
																	  'caption' => 'Images',
																	  'params'  => array(
																						 'allowed_filetypes' => array('images')
																						 )
																  	),
																array(
																	  'dir'     => '/users/'.strtolower($_SESSION['user']['username']),
																	  'caption' => strtolower($_SESSION['user']['username']),
																	  'params'  => array(
																				  	'allowed_filetypes' => array('any')
																				 	 )
																	  ) 
																)
															);
	break;
	case 4:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_upload_filesize', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_width', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_height', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify_subdirectories', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_create_subdirectories', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'recursive', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'chmod_to', false);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'thumbnails_enabled', true);
		$config->setStaticConfigValue ('PG_SPAWFM_DIRECTORIES', array(
																	array(
																  'dir'     => '/images/banners/flash/',
																	'caption' => 'Flash movies', 
																	'params'  => array(
																					'allowed_filetypes' => array('flash')
																					)
																),
									  							array(
																	  'dir'     => '/images/banners/',
																	  'caption' => 'Banner images',
																	  'params'  => array(
																					'default_dir' => true, // set directory as default (optional setting)
																					'allowed_filetypes' => array('images')
																					)
																),
																array(
																	  'dir'     => '/images/news/',
																	  'caption' => 'News',
																	  'params'  => array(
																						 'default_dir' => true, // set directory as default (optional setting)
																						 'allowed_filetypes' => array('images')
																						 )
																	  ),
																array(
																	  'dir'     => '/images/',
																	  'caption' => 'Images',
																	  'params'  => array(
																						 'allowed_filetypes' => array('images')
																						 )
																  	),
																array(
																	  'dir'     => '/users/'.strtolower($_SESSION['user']['username']),
																	  'caption' => strtolower($_SESSION['user']['username']),
																	  'params'  => array(
																				  	'allowed_filetypes' => array('images','flash')
																				 	 )
																	  ) 
																)
															);
	break;
	case 3:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_upload_filesize', PHOTOGALLERY_MAX_UPLOAD_FILESIZE);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_width', PHOTOGALLERY_MAX_PHOTO_WIDTH);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_height', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_create_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'recursive', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		$config->setStaticConfigValue('PG_SPAWFM_DIRECTORIES', array(
																	  'dir'     => '/users/'.strtolower($_SESSION['user']['username']),
																	  'caption' => strtolower($_SESSION['user']['username']),
																	  'params'  => array(
																		'allowed_filetypes' => array('images','flash')
																	  )
																  )
															);
	break;
	case 2:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_upload_filesize', PHOTOGALLERY_MAX_UPLOAD_FILESIZE);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_width', PHOTOGALLERY_MAX_PHOTO_WIDTH);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_height', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_create_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'recursive', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		$config->setStaticConfigValue('PG_SPAWFM_DIRECTORIES', array(
																	  'dir'     => '/users/'.strtolower($_SESSION['user']['username']),
																	  'caption' => 'Images',
																	  'params'  => array(
																		'allowed_filetypes' => array('images','flash')
																	  )
																  )
															);
	break;
	case 1:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_upload_filesize', PHOTOGALLERY_MAX_UPLOAD_FILESIZE);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_width', PHOTOGALLERY_MAX_PHOTO_WIDTH);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'max_img_height', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_create_subdirectories', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'recursive', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		$config->setStaticConfigValue('PG_SPAWFM_DIRECTORIES', array(
																	  'dir'     => '/users/'.strtolower($_SESSION['user']['username']),
																	  'caption' => strtolower($_SESSION['user']['username']),
																	  'params'  => array(
																		'allowed_filetypes' => array('images','flash')
																	  )
																  )
															);
	break;
	default:
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 0);
		$config->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 0);
	break;
}

?>