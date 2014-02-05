<?	
	$lang = array();
	include_once("lang_admin.php");
	include_once("lang_auto.php");
	include_once("lang_banner.php");
	include_once("lang_bbcode.php");
	include_once("lang_blog.php");
	include_once("lang_comments.php");
	include_once("lang_country.php");
	include_once("lang_dic.php");
	include_once("lang_faqs.php");
	include_once("lang_forums.php");
	include_once("lang_menu.php");
	include_once("lang_photogallery.php");
	include_once("lang_poll.php");
	include_once("lang_ratings.php");
	include_once("lang_search.php");
	include_once("lang_shopping.php");
	include_once("lang_shoutbox.php");
	include_once("lang_stats.php");
	include_once("lang_users.php");
	include_once("lang_weather.php");
	include_once("lang_web.php");
	#common
	$lang["main"]["Date"] = "Date";
	$lang["main"]["home"] = "Home";
	$lang["main"]["edit"] = "Edit";
	$lang["main"]["delete"] = "Delete";
	$lang["main"]["yes"] = "Yes";
	$lang["main"]["no"] = "No";
	$lang["main"]["more"] = "Read more...";
	$lang["main"]["more_watch_it"] = "watch it";
	$lang["status"][1] = "Active";
	$lang["status"][0] = "Inactive";
	$lang["main"]["level"] = "Level";
	$lang["main"]["status"] = "Status";
	$lang["main"]["pos"] = "Position";
	$lang["main"]["name"] = "Name";
	$lang["main"]["hits"] = "Hits";
	$lang["main"]["comment"] = "Comment";
	$lang['main']['email'] = 'Email';
	$lang['main']['login'] = "Login";
	$lang['main']['admin_area'] = "Administration Area";
	$lang['main']['username'] = "Username";
	$lang['main']['password'] = "Password";
	$lang['main']['date_added'] = "Date added";
	$lang['main']['date_lastupdated'] = "Date lastupdated";
	$lang['main']['total_updated'] = 'Updated';
	$lang['main']['action'] = "Action";
	$lang['main']['update_processed'] = "Updated.";
	$lang['main']['info'] = "Info";
	$lang['main']['send'] = "Send";
	$lang['main']['cancel'] = "Cancel";
	$lang['main']['url'] = 'URL';
	$lang['main']['result'] = 'Result';
	$lang['main']['download'] = 'Download';
	$lang['main']['new'] = 'new';
	$lang['main']['no_content'] = 'No content';
	$lang['main']['file'] = 'File';
	$lang['main']['maximum'] = 'maximum';
	$lang['main']['country'] = 'Country';
	$lang['main']['last_viewed'] = 'Last viewed';
	$lang['main']['tags'] = 'Tag';
	
	$lang['main']['main_info'] = 'Main information';
	$lang['main']['additional_info'] = 'Additional information';
	
	$lang['main']['paging_next'] = 'Next';
	$lang['main']['paging_prev'] = 'Previous';
	
	$lang["main"]["bookmark_success"] = "You can now access to it directly from your BOOKMARK/FAVORITES menu.";
	
	#send to friend
	$lang["main"]["send2friend_title"] = 'Send to friend';
	$lang["main"]["send2friend_email_from"] = 'Your email';
	$lang["main"]["send2friend_email_to"] = "Friend's email";
	$lang["main"]["send2friend_name_from"] = 'Your name';
	
	#RSS
	$lang["main"]["rss_video"] = "RSS Video";
	$lang["main"]["rss_subscribe"] = "Subscribe using any feed reader";
	
	#confirm
	$lang['confirm']['activate_all_users'] = "Do you really want to activate all users? if yes press OK.";
	
	#errors
	$lang["error"]["empty_field"] = "Fill all empty fields";
	$lang["error"]["no_sub_menu"] = "No submenu";
	$lang["error"]["low_level_content"] = "<h1 style=\"color:red;\">Permission denied. </h1> <br />Please login first to access this area. <br />If you don't have username please register. <br />Registration is free.<br /> <a href=\"index.php?module=users&cmd=registration\"><strong>Click here</strong></a> to register.";
	$lang["error"]["link_invalid"] = "Invalid link";
	#successes
	$lang["success"]["delete_success"]="Deleted.";
	
	#confirmation
	$lang["confirm"]["delete"] = "Confirm delete. If you do not want to delete click CANCEL button.";
	
	$lang['settings']['main'] = "Main settings";

	$lang["main"]["years_ago"] = "years ago";
	$lang["main"]["months_ago"] = "months ago";
	$lang["main"]["days_ago"] = "days ago";
	$lang["main"]["hours_ago"] = "hours ago";
	$lang["main"]["minutes_ago"] = "minutes ago";
	$lang["main"]["seconds_ago"] = "seconds ago";
	$lang["main"]["year"] = "years";
	$lang["main"]["years"] = "year";
	$lang["main"]["month"] = "month";
	$lang["main"]["months"] = "months";
	$lang["main"]["day"] = "day";
	$lang["main"]["days"] = "days";
	$lang["main"]["hour"] = "hour";
	$lang["main"]["hours"] = "hours";
	$lang["main"]["minute"] = "minute";
	$lang["main"]["minutes"] = "minutes";
	$lang["main"]["second"] = "second";
	$lang["main"]["seconds"] = "seconds";
	
	$lang["main"]["before_2days"] = "before 2 days";
	$lang["main"]["yesterday"] = "yesterday";
	$lang["main"]["today"] = "today";
	$lang["main"]["tomorrow"] = "tomorrow";
	$lang["main"]["after_2days"] = "after 2 days";
	
	$lang['day']['Monday'] = 'Monday';
	$lang['day']['Tuesday'] = 'Tuesday';
	$lang['day']['Wednesday'] = 'Wednesday';
	$lang['day']['Thursday'] = 'Thursday';
	$lang['day']['Friday'] = 'Friday';
	$lang['day']['Saturday'] = 'Saturday';
	$lang['day']['Sunday'] = 'Sunday';
	
	$lang['month']['Jan'] = "January";
	$lang['month']['Feb'] = "February";
	$lang['month']['Mar'] = "March";
	$lang['month']['Apr'] = "April";
	$lang['month']['May'] = "May";
	$lang['month']['Jun'] = "June";
	$lang['month']['Jul'] = "July";
	$lang['month']['Aug'] = "August";
	$lang['month']['Sep'] = "September";
	$lang['month']['Oct'] = "October";
	$lang['month']['Nov'] = "November";
	$lang['month']['Dec'] = "December";
	
	//video
	$lang["main"]["low_level_add_to_video_playlist"] = "You must login to use playlist";
	$lang["main"]["added_to_video_playlist"] = "Added to playlist.";
	$lang["main"]["select_video_playlist"] = "Choose playlist";
	$lang["main"]["default_video_playlist"] = "Main playlist";
	$lang["main"]["create_video_playlist"] = "Create playlist";
	$lang["main"]["add_video_to_playlist"] = "Add to playlist";
	$lang["main"]["not_added_to_video_playlist"] = "An error occurred while adding.";
	$lang["main"]["already_exists_in_video_playlist"] = "Already added to this playlist.";
?>