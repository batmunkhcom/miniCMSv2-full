<link href="templates/shareaz_cgi/css/main.css" rel="stylesheet" type="text/css" />

<link href="templates/shareaz_cgi/css/shareaz.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6888346-13");
pageTracker._trackPageview();
} catch(err) {}</script>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="templates/shareaz_cgi/images/top.jpg" alt="share" width="954" height="12" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td width="150"><a href="index.php"><img src="templates/shareaz_cgi/images/title1.gif" alt="share" width="139" height="36" vspace="5" border="0" /></a></td>
        <td><table width="704" border="0" align="right" cellpadding="0" cellspacing="1">
          <tr>
            <td width="88" height="18" class="menu_top"><a href="index.php">Нүүр</a></td>
            <td width="88" class="menu_top"><a href="http://www.yadii.net" target="_blank">Видео</a></td>
            <td width="88" class="menu_top"><a href="http://shop.az.mn" target="_blank">Худалдаа</a></td>
            <td width="88" class="menu_top"><a href="http://www.pms.mn" target="_blank">PMS</a></td>
            <td width="88" class="menu_top"><a href="http://www.unegui.com" target="_blank">ВАРЕЗ</a></td>
            <td width="88" class="menu_top"><a href="http://www.unegui.net" target="_blank">ХОЛБООС</a></td>
            <td width="88" class="menu_top"><a href="http://php.az.mn" target="_blank">PHP</a></td>
            <td width="88" class="menu_top"><a href="http://mobile.az.mn" target="_blank">ГАР УТАС</a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#a4c0dc"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td bgcolor="#002a5e" style="padding:5px; background-image:url(templates/shareaz_cgi/images/content_bg.jpg); background-repeat:repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#e1eaf6" style="border:1px solid #a4c0dc;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:95px; border:1px solid #FFFFFF;">
            <tr>
              <td align="center"><img src="templates/shareaz_cgi/images/azsuljee.gif" alt="share" width="111" height="53" /></td>
              <td width="150" align="center">
              <div class="top_link_border">
              	<div class="top_link"><a href="index.php" class="topmenu">Файл хуулах</a>
              	  <br />
              	  Файл байрлуулах</div>
              </div>              </td>
              <td width="5" align="center"></td>
              <td width="150" align="center">
              <div class="top_link_border">
              	<div class="top_link"><a href="index.php?module=fileshare&amp;cmd=myfiles" class="topmenu">Миний файлууд</a><br />
              	Таны оруулсан <br />
              	файлын жагсаалт</div>
              </div></td>
              <td width="5" align="center"></td>
              <td width="150" align="center">
              <div class="top_link_border">
              	<div class="top_link"><a href="index.php?module=menu&amp;cmd=content&amp;menu_id=389" class="topmenu">Тусламж</a><br />
              	Файл оруулах,<br />
              	татаж авах талаар</div>
              </div></td>
              <td width="5" align="center"></td>
              <td width="150" align="center">
              <div class="top_link_border">
              	<div class="top_link"><a href="index.php?module=menu&amp;cmd=content&amp;menu_id=390" class="topmenu">Үйлчилгээний нөхцөл</a><br />
              	Сайтыг ашиглахаас өмнө заавал унш</div>
              </div></td>
              <td width="5" align="center"></td>
              <td width="150" align="center">
              <div class="top_link_border">
              	<div class="top_link"><a href="#" class="topmenu">Хамтран ажиллах</a><br />
              	Сурталчилгаа байрлуулах,<br />
              	холбоо тогтоох</div>
              </div></td>
              <td width="5"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="5"></td>
        </tr>

        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding:5px; color:#F00; font-weight:bold; text-decoration:blink;">&nbsp;
          <!--
          Татсан файл эвдэрч байгаа асуудлыг засварлаж байна. Засаж дууссаны дараа энэ бичиг алга болох болно!!!!!!!!!
          //-->
          </td>
        </tr>
        <tr>

          <td bgcolor="#FFFFFF" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td width="250" valign="top" style="padding:5px; border:#DDDDDD; background-color:#eeeeee;"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                 <?

                 if($_GET['cmd']!='search'){

				?>

                   <tr>

                    <td class="userPanelTitle" style="background-color:#c5ddff">Файл хайх</td>

                  </tr>

				 <tr>

                    <td height="30" align="center"><form id="form1" name="form1" method="post" action="" onsubmit="window.location='index.php?module=fileshare&cmd=search&q='+this.q.value;return false;">

    <input name="q" type="text" id="q" size="25" />

  <input type="submit" name="button" id="button" value="Хайх" />

                    </form></td>

                  </tr>

                   <tr>

                    <td><hr size="1" /></td>

                  </tr>

                   <tr>

                    <td>&nbsp;</td>

                  </tr>

				<?

				}

				 ?>

                 <tr>

                    <td><?

            echo mbmUserPanel($_SESSION['user_id'],array('','','<div style="padding-left:10px;padding-bottom:4px;margin-bottom:3px;border-bottom:1px solid #3c5995;">','</div>'));

			?></td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td align="center" style="color:#F00">Та www.yadii.net, www.unegui.com сайтын нэвтрэх эрхээ ашиглаж болно.</td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                  </tr>

                 

                 <!--//-->

                  <tr>

                    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">

                      <tr>

                        <td width="50%"><?=mbmShowBanner('left_1')?></td>

                        <td width="50%" align="right"><?=mbmShowBanner('left_2')?></td>

                      </tr>

                    </table></td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td><?

                    $q_last_files = "SELECT * FROM ".PREFIX."fileshare ORDER BY session_time DESC LIMIT 20";

					$r_last_files = "";

					?></td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                  </tr>  <tr>

                    <td><?

                    $rand_weather = rand(1,43);

					if($rand_weather<10){

						$rand_weather = '0'.$rand_weather;

					}

					echo '<script src="http://weather.az.mn/share.php?c=MGXX00'.$rand_weather.'"></script>';

					?></td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td>

                    <?

					$q_dl_stat = "SELECT dl,id FROM ".PREFIX."stat_daily WHERE `y`='".date("Y")."' AND `m`='".date("m")."' AND `d`='".date("d")."'";

					$r_dl_stat = $DB->mbm_query($q_dl_stat);

					
					$uchdur = $DB->mbm_get_field(($DB->mbm_result($r_dl_stat,0,1)-1),'id','dl','stat_daily');
					$urjdar = $DB->mbm_get_field(($DB->mbm_result($r_dl_stat,0,1)-2),'id','dl','stat_daily');
					echo 'Өнөөдөр файл таталт: <strong>'.($DB->mbm_result($r_dl_stat,0,0)).'</strong><br />';

					echo 'Өчигдөр файл таталт: <strong>'.$uchdur.substr($uchdur,0,0).'</strong><br />';

					echo 'Уржигдар файл таталт: <strong>'.$urjdar.substr($urjdar,1,0).'</strong><br />';

					?>

                    Нийт файл таталт: <strong><?=mbmFileshareSumStats('downloaded')?></strong><br />

                    Нийт файл хандалт: <strong><?=mbmFileshareSumStats('hits')?></strong><br />

					</td>

                  </tr>

                </table></td>

              <td width="5" valign="top"></td>

              <td valign="top">

              <div style="padding:5px; border:1px solid #F00; background-color:#FFC6C6; display:none; text-align:center; margin-bottom:12px;">

              Туршилтын хугацаанд бүх хэрэглэгч хамгийн ихдээ 512КВ хурдаар файл татаж <br />

              татагдаагүй файлыг 14 хоног хадгалах боломжтой. </div>

                 <?

					$buf_actions = '<div id="error">';

					switch($_GET['action']){

						case 'delete':

							$buf_actions .=  'Файлыг устгав.';

						break;

						case 'error':

							$buf_actions .=  'Файл олдсонгүй.';

						break;

					}

					$buf_actions .= '</div>';

					

					

					if(strlen($_SERVER['QUERY_STRING'])<4){

						mbm_include_file("templates/".TEMPLATE."/home.php");

					}elseif(file_exists(ABS_DIR."modules/".$_GET['module']."/".$_GET['cmd'].".php")){

						mbm_include_file("modules/".$_GET['module']."/".$_GET['cmd'].".php");

					}else{

						if(isset($_GET['k'])){

							if($DB->mbm_check_field('key',$_GET['k'],'fileshare')==1){

								mbm_include_file("modules/fileshare/dl.php");

							}else{

								echo mbmError('Файл олдсонгүй...');

							}

						}else{

							

							if(isset($_GET['action'])){

								mbmError( $buf_actions);

							}

					

					  }

					}

					  ?> 

             <div style="margin-top:20px;">

             <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td width="260" align="center"><?=mbmShowBanner('dl_1')?></td>

                <td width="260" align="center"><?=mbmShowBanner('dl_2')?></td>

                <?

                if($_GET['cmd']!='search'){

                    echo '<td align="center">'.mbmShowBanner('dl_3').'</td>';	

                }

                ?>

              </tr>

              <tr>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

              </tr>

             </table>

             </div>

             <div style="margin-top:12px;">

             <table width="100%" border="0" cellspacing="2" cellpadding="0">

 			<?

            if(strlen($_SERVER['QUERY_STRING'])<5){

			?>

			 <tr>

                <td height="25" style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Их татагдсан</td>

                <td style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Дөнгөж татагдсан</td>

                <td style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Дурын файлууд</td>

              </tr>

              <tr>

                <td bgcolor="#FFF2FF" style="padding:5px; line-height:17px;"><?=mbmFileshareFilelist(array(

                                                      'order_by'=>'downloaded',

                                                      'asc'=>'desc',

                                                      'user_id'=>0,

                                                      'lev'=>0,

                                                      'st'=>1,

                                                      'copyright'=>0,

                                                      'limit'=>20,

                                                      'html_0'=>'',

                                                      'html_1'=>'<br />',

                                                      'class'=>'newfiles',

                                                      'show_downloads'=>1))?></td>

                <td bgcolor="#F4FFFB" style="padding:5px; line-height:17px;"><?=mbmFileshareFilelist(array(

                                                      'order_by'=>'session_time',

                                                      'asc'=>'desc',

                                                      'user_id'=>0,

                                                      'lev'=>0,

                                                      'st'=>1,

                                                      'copyright'=>0,

                                                      'limit'=>20,

                                                      'html_0'=>'',

                                                      'html_1'=>'<br />',

                                                      'class'=>'newfiles'))?></td>

                <td bgcolor="#FEFFF2" style="padding:5px; line-height:17px;">

                  <?=mbmFileshareFilelist(array(

											  'order_by'=>'RAND()',

											  'asc'=>'',

											  'user_id'=>0,

											  'lev'=>0,

											  'st'=>1,

											  'copyright'=>0,

											  'limit'=>20,

											  'html_0'=>'',

											  'html_1'=>'<br />',

											  'is_private'=>0,

											  'class'=>'newfiles'))?>

               </td>

              </tr>

              <tr>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

              </tr>

			<?

			}

			?>

             </table>

             </div>

             </td>

            </tr>

          </table>

          

             <div style="margin-top:12px; text-align:center; display:block;">

             <script type="text/javascript"><!--

				google_ad_client = "pub-3377050199087606";

				/* 728x90, created 12/16/07 */

				google_ad_slot = "0477445965";

				google_ad_width = 728;

				google_ad_height = 90;

				//-->

				</script>

				<script type="text/javascript"

				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">

				</script>

             </div>

          </td>

        </tr>

      </table>

      <div style="margin-top:5px; margin-bottom:5px; padding:5px; color:#FFFFFF;">
        <?
        include(INCLUDE_DIR.'aznet.php');
		?>
      </div>
    </td>
  </tr>
  <tr>
    <td height="60" align="center" bgcolor="#E2EAF7"><?
    echo mbmStatImage().COPYRIGHT;
	?></td>
  </tr>
  <tr>
    <td><img src="templates/shareaz_cgi/images/footer.jpg" alt="file share" width="953" height="11" /></td>
  </tr>
</table>
