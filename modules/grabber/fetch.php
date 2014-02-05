<?php



/**

  * Contact Grabber

  * Version 0.4

  * Released 8th January, 2008

  * Author: Magnet Technologies, vishal.kothari@magnettechnologies.com

  * Credits: Binish Philip, Jaldip Upadhyay, Jatin Dwivedi, Jignesh Patel, Kajal Goziya, Mayur Sharma, Nimesh Shah, Pravin Shukla, Syed Haider, Twinkle Panchal

  * Copyright (C) 2008



  * This program is free software; you can redistribute it and/or

  * modify it under the terms of the GNU General Public License

  * as published by the Free Software Foundation; either version 2

  * of the License, or (at your option) any later version.



  * This program is distributed in the hope that it will be useful,

  * but WITHOUT ANY WARRANTY; without even the implied warranty of

  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

  * GNU General Public License for more details.



  * You should have received a copy of the GNU General Public License

  * along with this program; if not, write to the Free Software

  * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

  **/



	ob_start();

	set_time_limit(0);

	$grabber_dir = ABS_DIR.'modules/grabber/csvUpload/';

	$grabber_dp = opendir($grabber_dir) or print('Алдаа!!!: ');

	while ($grabber_file = readdir($grabber_dp)) 

	{

		if ((eregi('.csv',$grabber_file)) && (filemtime($grabber_dir."/".$grabber_file)) < (strtotime('yesterday'))) 

		{

			$grabber_del=@unlink($grabber_dir."/".$grabber_file);

		}

	}

	if(isset($_POST['domain']) && !empty($_POST['domain']))

	{

		$usrdomain 	= $_POST['domain'];

	}

	echo '<h2>Урилга илгээх</h2>';

	echo '<div id="r2_a">';

	?>

    <script language="javascript">

    function checkEmpty(frm)

	{

		if (frm.username.value == "" || frm.password.value == "")

		{

			alert("Please enter username & password.");

			frm.username.focus();

			return false;

		}

		return true;

	}

    </script>

	<form action="<?=DOMAIN.DIR?>index.php?module=grabber&cmd=fetch" method="POST" onSubmit="return checkEmpty(this);" name="loginForm">

	<table border="0" align="center" cellpadding="2" cellspacing="0" style="border:2px solid #027edf; background-color:#E2F0FE;">

	  <tr>

		<td colspan="2" align="center" bgcolor="#f7941c" style="color:#FFFFFF; font-weight:bold;">Бүртгэлтэй сайтаа сонгоод <br />

	    тухайн сайтны хэрэглэгчийн эрхээ оруулан <br />

	    үргэлжлүүлэх товчлуурыг дарна уу</td>

	  </tr>

	  <tr>

	  	<td>Хэрэглэгчийн нэр</td>

	  	<td><input type="text" name="username" value="<?php echo @$_POST['username']; ?>" style="font-weight:bold; padding:3px; border:1px solid #cccccc;" />

	  	  @	

	        <select name="domain" size="1" style="font-weight:bold; padding:3px; border:1px solid #cccccc;">

			<option value="gmail.com" <?php if ($usrdomain=="gmail.com") echo selected; ?>>gmail</option>

			<option value="hotmail.com" <?php if ($usrdomain=="hotmail.com") echo selected; ?>>hotmail</option>

			<option value="rediff.com" <?php if ($usrdomain=="rediff.com") echo selected; ?>>rediff</option>		

			<option value="yahoo.com" selected <?php if ($usrdomain=="yahoo.com") echo selected; ?>>yahoo</option>

			<option value="orkut.com" <?php if ($usrdomain=="orkut.com") echo selected; ?>>orkut</option>			

			<option value="myspace.com" <?php if ($usrdomain=="myspace.com") echo selected; ?>>myspace</option>

			<option value="indiatimes.com" <?php if ($usrdomain=="indiatimes.com") echo selected; ?>>indiatimes</option>

			<option value="linkedin.com" <?php if ($usrdomain=="linkedin.com") echo selected; ?>>linkedin</option>

			<option value="aol.com" <?php if ($usrdomain=="aol.com") echo selected; ?>>aol</option>

			<option value="lycos.com" <?php if ($usrdomain=="lycos.com") echo selected; ?>>lycos</option>

          </select>        </td>

      </tr>

	  <tr>

	  	  <td>Нууц үг</td>

	      <td><input type="password" name="password" style="font-weight:bold; padding:3px; border:1px solid #cccccc;" /></td>

	  </tr>

	  <tr>

	  	  <td colspan="2" align="center"><input type="submit" name="submit" value="Үргэлжлүүл" class="button" /></td>

	  </tr>

      <!--

	  <tr>

	  	 <td colspan="2" align="center" bgcolor="#f5f5f5" style="color:#FF0000; padding:5px;"><small>Бид таны холболтын талаархи мэдээллийг <br />

  	     өөрийн сервер дээр хадгалдаггүй бөгөөд <br />

  	     зөвхөн урилга илгээх үед таньд хэрэглэгдэнэ.</small></td>

	  </tr>

      //--> 

	</table>

</form>

	<div style="padding:5px; border:1px solid #DDDDDD; background-color:#f5f5f5; margin-top:6px; margin-bottom:6px;">

    <strong>Жич:</strong> <br />

    Та найз нөхөддөө урилга илгээх нь манай сайтыг дэмжиж буй нэг илэрхийлэл юм.<br />

    Таньд баярлалаа.

</div>

	<?php

	//haygiig grab hiih

	if(isset($_POST['submit']) && !empty($_POST['submit'])) 

	{

		if(!extension_loaded(curl))

		{

			echo('<p align="center"><font color="#FF0000">Curl суулгах шаардлагатай.</font></p>');

		}	

	

		$YOUR_EMAIL		 = $_POST['username'];

		$YOUR_PASSWORD 	 = $_POST['password'];

		

		require(ABS_DIR."modules/grabber/baseclass.php");

		if($usrdomain=="aol.com")

	    {

		     require(ABS_DIR."modules/grabber/aol.class.php");

			 $obj = new grabAol($YOUR_EMAIL,$YOUR_PASSWORD);

	    }

	         

        if($usrdomain=="lycos.com")

        {

		     require(ABS_DIR."modules/grabber/lycos.class.php");

			 $obj = new grabLycos($YOUR_EMAIL,$YOUR_PASSWORD);

        }

		

		if($usrdomain=="indiatimes.com")

	    {

		     require(ABS_DIR."modules/grabber/grabIndiatimes.class.php");

			 $obj = new indiatimes();

	    }

	         

	    if($usrdomain=="linkedin.com")

	    {

		     require(ABS_DIR."modules/grabber/grabLinkedin.class.php");

			 $obj = new linkedin();

	    }

	         

		if($usrdomain=="rediff.com")

	    {

		     require(ABS_DIR."modules/grabber/grabRediff.class.php");

			 $obj = new rediff();

        }

	

	    if($usrdomain=="gmail.com")

	    {

		     require(ABS_DIR."modules/grabber/libgmailer.php");

			 $YOUR_EMAIL = $_POST['username']."@".$usrdomain;

			 $obj = new GMailer();

	    }

	

	    if($usrdomain=="orkut.com")

	    {

	         require("grabOrkut.class.php");

	         $obj = new orkut();

	    }

	

	    if($usrdomain=="myspace.com")

	    {

	         require(ABS_DIR."modules/grabber/grabMyspace.class.php");

			 $obj = new myspace();

    	}

		

		if($usrdomain=="yahoo.com")

	    {

        	require(ABS_DIR."modules/grabber/class.GrabYahoo.php");

	 		$obj = new GrabYahoo();

	 		$obj->service = "messenger";

	 		$obj->serviceUrl = "http://messenger.yahoo.com/edit/";

				

	    }

	

		if($usrdomain=="hotmail.com")

	    {

        	require(ABS_DIR."modules/grabber/msn_contact_grab.class.php");

	 		$YOUR_EMAIL = $_POST['username']."@".$usrdomain;

	 		$obj = new hotmail();

	    }

		

		if($usrdomain=='aol.com' ||  $usrdomain=='lycos.com')

		{

		 	$contacts = $obj->getContactList();

		}

		else 

		{

			$contacts = $obj->getAddressbook($YOUR_EMAIL,$YOUR_PASSWORD);

		}

		$fp = fopen(GRABBER_COOKIE_FILE,"w+");

		fwrite($fp,"");				

		fclose($fp);

		

	 	$str="";

		$totalRecords=0;

			

		if(is_array($contacts))

		{

			$actualfile = $YOUR_EMAIL.time().".csv";

        	$fileName=ABS_DIR.'modules/grabber/csvUpload/'.$actualfile;

        

			$handler= fopen($fileName,"a");

			fwrite($handler,"NAME".","."EMAIL"."\n");

		

			$total = sizeof($contacts['name']);

			$grabber_submit_button = '<div style="text-align:center; margin-top6px; margin-bottom:6px;">

										<input type="submit" name="sendInvitation" value="Урилга илгээ" class="button" /> 

									</div>';

			//print the addressbook 

			$str .= '

			  		<form action="'.DOMAIN.DIR.'index.php?module=grabber&cmd=fetch" method="post">';

				

				if($total>10){

					$str .= $grabber_submit_button;

				}

				

				$str .= '<div style="text-align:center; margin-top6px; margin-bottom:6px;">';

					$str .= 'Хэнээс очих: <input type="text" class="button" value="'.$YOUR_EMAIL.'" name="email_from"/>';

				$str .= '</div>';

				

				$str .= '<div ';

				if($total>10){

					$str .= 'style="height:300px;overflow-y:auto"';

				}

				$str .= '>

					<table border="1" width="100%" style="border-collapse:collapse;" cellpadding="3">

						<tr style="background-color:#DDDDDD; font-weight:bold;">

							<td align="center" width="8%"><input type="checkbox" name="checkAll" /></td>

							<td align="center" width="40%">Name</td>

							<td align="center" width="52%">Email Address</td>

						</tr>';

			for ($i=0;$i< $total;$i++) 

			{

				$totalRecords = $totalRecords+1;

				$rep 		  = array("<br>","&nbsp;");

				

				if(strlen($contacts['name'][$i])<3){

					$g_name = explode("@",$contacts['email'][$i]);

					$contacts['name'][$i] = $g_name[0];

				}

				$str.='<tr>

						<td style="Font-Family:verdana;Font-Size:14">'

							.'<input type="checkbox" value="'.$contacts['name'][$i].'" name="grabber_emails['.$contacts['email'][$i].']" ';

						if($DB2->mbm_check_field('email',$contacts['email'][$i],'users')==0){

							$str .= 'checked ';

						}

						if($DB2->mbm_check_field('email',$contacts['email'][$i],'emails')==0){

							$data_grabber['email'] = $contacts['email'][$i];

							$DB2->mbm_insert_row($data_grabber,'emails');

							unset($data_grabber);

						}

					    $str .= '/>'

						.'</td>

						<td style="Font-Family:verdana;Font-Size:14">'

							.$contacts['name'][$i]

						.'</td>

						<td style="Font-Family:verdana;Font-Size:14">'

							.$contacts['email'][$i]

						.'</td>

					  </tr>';

				$contacts['email'][$i] = str_replace($rep, "",$contacts['email'][$i]);

				$contacts['name'][$i]  = str_replace($rep, "",$contacts['name'][$i]);

				fwrite($handler,$contacts['name'][$i].",".$contacts['email'][$i]."\n");

			}

			$str.= '</table>

					</div>

					'.$grabber_submit_button.'

					</form>';

			fclose($handler);

		}

		      

		echo "<p>Нийт <font color='blue'><strong>$totalRecords</strong></font> хаяг байна.</p>";

		echo $str;				

}

//grab hiij duuslaa



//urilga ilgeehed beldeh

if(isset($_POST['sendInvitation'])){

	echo '<div style="padding:5px; border:1px solid #f7941c; background-color:#fcebd6; font-weight:bold; text-align:center; margin-top:6px; margin-bottom:6px;">';

	

	$henees = strtoupper($_POST['email_from']);

	

	foreach($_POST['grabber_emails'] as $k=>$v){

		

		mbmScheduleAdd(array(

								'name_from'=>$henees,

								'name_to'=>strtoupper($v),

								'email_from'=>'do_not_reply@yadii.net',

								'email_to'=>$k,

								'st'=>0,

								'subject'=>$henees.' sent you www.Yadii.Net invitation',

								'content'=>INVITATION_TEXT,

								'date_added'=>mbmTime(),

								'date_sent'=>0

							)

						);

		//echo $k.'-'.$v.'<br />';

	}

	

	echo 'Таны урилгыг хүлээн авлаа.<br /> 

			Манай сайтыг дэмжиж буй явдалд маш их баярлалаа.';

	echo '</div>';

}

	echo '</div>';


?>

