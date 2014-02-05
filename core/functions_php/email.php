<?


function mbmSendEmail($from='BATMUNKH Moltov|admin@mng.cc',$to='M.Batmunkh|info@mng.cc',$subject='hi. test',$content='test'){
		
	$from = explode("|",$from);
	$to = explode("|",$to);
	
	$content = 'email: '.$from[0]."\n".$content  ;
	
    $headers .= "From:  ".$from[0]." <".$from[1].">\n";
    $headers .= "X-Sender: <".$from[1].">\n";
    $headers .= "X-Mailer: PHP\n";
    $headers .= "X-Priority: 1\n"; // Уг имэйлийн хэр чухлыг тодорхойлно
    $headers .= "Return-Path: <".$from[1].">\n";  // Алдаа гарсан тохиолдолд буцах имэйл хаяг
    $headers .= "Content-Type: text/html; charset=utf-8\n"; // Charset-ийн тохиргоо
    if(!mail($to[1],$subject,$content,$headers)){
        return 0;
    }else{
        return 1;
    }
	
}
function mbmCheckEmail($email)
{
	if(!eregi("^[a-z]+[a-z0-9_-]*(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.([a-z]+){2,}$", $email))
	{
		return false; // invalid email address
	}
	else{
		return true;
	}
}
?>