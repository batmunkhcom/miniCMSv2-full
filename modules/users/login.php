<h2>Та бизнесийн сүлжээнд элсэж өөрийн бизнесийг амжилттай явуулахыг хүсвэл <a href="http://biznetwork.mn/join/invited_by/batmunkh" target="_blank">энд дарж</a> нэгдээрээ. Одоогоор 9000 шахам бизнесийнхэн бүртгүүлээд байна.</h2>
<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
switch($_GET['login']){
	case '1':
		$login_result_txt = 'Success';
	break;
	case 'not_activated':
		$login_result_txt = 'please activate your account first';
	break;
	case 'user_disabled':
		$login_result_txt = 'You account has been suspended. please contact to administrators';
	break;
	case 'invalid_login':
		$login_result_txt = 'Please check your login.';
	break;
}
echo '<div id="query_result">'.$login_result_txt.'</div>';
?>