<? //echo mbmDropDownMenus2(); exit;
$q_last_newsid = "SELECT id FROM ".$DB->prefix."menu_contents WHERE menu_id LIKE '%,409,%' ORDER BY id DESC LIMIT 1";
$r_last_newsid = $DB->mbm_query($q_last_newsid);
$_last_newsid = $DB->mbm_result($r_last_newsid,0);
?>
<link href="templates/most/css/main.css" rel="stylesheet" type="text/css" />
<link href="templates/most/css/menazmn.css" rel="stylesheet" type="text/css" />
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" valign="top"><a href="index.php"><img src="templates/most/images/logo.png" alt="most" height="75" border="0" /></a></td>
        <td width="726" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="35">
            <?=mbmDropDownMenus2()?>
            </td>
          </tr>
          <tr>
            <td height="20" align="right" style="color:#b4b5b6;"><a href="#" style="color:#b4b5b6;">Mongolian</a> | <a href="#" style="color:#b4b5b6;">English</a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?
	if(strlen($_SERVER['QUERY_STRING'])<3){
		echo mbmShowBanner("home_header_".$_SESSION['ln']);
	}else{
		echo mbmShowBannerByMenu("content_header_".$_SESSION['ln']);
	}
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?
  if(strlen($_SERVER['QUERY_STRING'])<3){
  ?>
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" style="text-align:justify;">
        
		<div class="titleHome" onclick="window.location='index.php?module=menu&cmd=content&menu_id=393'" style="cursor:pointer;">Компаний тухай</div>
		<p>МОСТ ПСП компани (Mongolian Online Secured Transactions Payment Service Provider) нь санхүүгийн болон төлбөр тооцооны зах зээл дээр ажилладаг байгууллагууд болон хэрэглэгчдийн зардал чирэгдэлийг хамгийн бага байлгах, аюулгүй ажиллагааг дээд зэргээр хангах, санхүүгийн байгууллагуудын хоорондын мөнгөн гүйлгээг хамгийн оновчтойгоор түргэн шуурхай дамжуулах зэрэг банк, санхүүгийн төлбөр тооцооны транзакц (гүйлгээ)-ийг цахим хэлбэрээр боловсруулах үйл ажиллагааг эрхлэн явуулж байна. 
  </p>
		<p>МОСТ ПСП нь санхүүгийн байгууллага болон иргэдийн мэдээллийн аюулгүй байдал, нууцлалыг хангах зориулалтын шилдэг шийдлүүдийг сорчлон авч ашигладаг ба электрон төлбөр тооцооны үйлчилгээгээр зөвхөн дотоодын зах зээлд төдийгүй дэлхий дахинд “хамгийн” шилдэг нь болох зорилго тавин ажиллаж байна.
		  </p>
		<p align="right"><a href="#">Дэлгэрэнгүй...</a></p>		<?
          mbmShowContentMore(array('','','',''),1358);
		?>
        </td>
        <td width="27" valign="top">&nbsp;</td>
        <td width="293" valign="top">
		<div class="titleHome" onclick="window.location='index.php?module=menu&cmd=content&menu_id=409&id=<?=$_last_newsid?>'" style="cursor:pointer;">Мэдээ, мэдээлэл</div>
		<div id="homeNews">
        <?
        echo  mbmContentNews($GLOBALS['htmls_normal'],mbmShowByLang(array('mn'=>409,'en'=>8888)),2,2);
		?>
        </div>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#ebebeb"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#ebebeb"><div id="HOME3BANNERS">
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="7" valign="top"></td>
        <td width="286" valign="top"><?=mbmShowBanner("home1_".$_SESSION['ln'])?></td>
        <td width="44" valign="top"></td>
        <td width="286" valign="top"><?=mbmShowBanner("home2_".$_SESSION['ln'])?></td>
        <td valign="top" width="44"></td>
        <td width="286" valign="top"><?=mbmShowBanner("home3_".$_SESSION['ln'])?></td>
        <td width="7" valign="top"></td>
      </tr>
    </table></div></td>
  </tr>
  <tr>
    <td bgcolor="#ebebeb">&nbsp;</td>
  </tr>
  <?
  
			$active_top_menu_id = 0;
  }else{
	  ?>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="240" valign="top">
          <?
		  $menuSUB = $DB->mbm_get_field(MENU_ID,'id','sub','menus');
          if($menuSUB == 0){
		  	$leftMenuId = MENU_ID;
			$active_top_menu_id = MENU_ID;
		  }else{
			 
			if($menuSUB == 2){
				$leftMenuId = $DB->mbm_get_field($DB->mbm_get_field(MENU_ID,'id','menu_id','menus'),'id','menu_id','menus');
			}else{
				$leftMenuId = $DB->mbm_get_field(MENU_ID,'id','menu_id','menus');
			}
		  	
			$active_top_menu_id = $leftMenuId ;
			
			if($active_top_menu_id == 0){
				$active_top_menu_id = MENU_ID;
			}
		  } 
		  if($leftMenuId == 0 || MENU_ID==409){
		  	$letfMenuTitle = '';
		  }else{
		  	$letfMenuTitle = $DB->mbm_get_field($leftMenuId,'id','name','menus');
		  }
		  
		  //$letfMenuTitle .= $leftMenuId.'-'.$DB->mbm_get_field(MENU_ID,'id','sub','menus');
		  
		  if(strlen($letfMenuTitle)>2){
		  	echo '<div class="titleLeft" style="cursor:pointer;" ';
				echo ' onclick="window.location=\''.mbmMenuLink($leftMenuId,$DB->mbm_get_field($leftMenuId,'id','link','menus')).'\';"';
			echo '>'.$letfMenuTitle.'</div>';
		  }
		  if(MENU_ID!=409){
		  	 echo  '<div id="LEFTMENU">'.mbmShowMenuById(array('',''),$leftMenuId,'menuLeft',0,1,1).'</div>';
		  }
		  
  		  $leftBanner = '<div style="margin-bottom:40px; margin-top:40px;">'.mbmShowBanner('left1_'.$_SESSION['ln']).'</div>';

         if(MENU_ID!=409){
		 	echo $leftBanner;
		 }
		 ?>
         <div id="homeNews">
         <div class="titleHome" onclick="window.location='index.php?module=menu&cmd=content&menu_id=409&id=<?=$_last_newsid?>'" style="cursor:pointer;">Мэдээ мэдээлэл</div>
         	<?
			echo  mbmContentNews($GLOBALS['htmls_normal'],mbmShowByLang(array('mn'=>409,'en'=>8888)),2,2);
			?>
         </div>
         <?
         if(MENU_ID==409){
		 	echo $leftBanner;
		 }
		 ?>
         <br />
          </td>
          <td width="15" valign="top"></td>
          <td width="1" valign="top" bgcolor="#ebebeb"></td>
          <td width="15" valign="top"></td>
          <td valign="top">
          <div id="mainContentTalbar">
          <?
            if(file_exists(ABS_DIR."modules/".$_GET['module']."/".$_GET['cmd'].".php")){
				mbm_include_file("modules/".$_GET['module']."/".$_GET['cmd'].".php");
			}else{
				mbm_include_file("templates/".TEMPLATE."/home.php");
			}
		?>
          </div>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td headers="90">
    <h3 style="font-family:Tahoma; font-size:13px; font-weight:bold;
 color:#255d36;">Харилцагч байгууллагууд:</h3>
    <? echo mbmShowBanner("logos");?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#ebebeb" height="1"></td>
  </tr>  
	  <?
  }
  ?>
  <tr>
    <td height="46" align="center">
    <?
	echo mbmShowMenuById(array('','','',''),0,'menuFooter',0,0);
	?>
    </td>
  </tr>
  <tr>
    <td height="1" bgcolor="#ebebeb"></td>
  </tr>
  <tr>
    <td height="40" align="center" style="color:#CCC; font-size:11px;"><?=COPYRIGHT?></td>
  </tr>
</table>
<script language="javascript">
<?
$lefmenuSubClass = 'menuleft_selected';
if($menuSUB == 2){
	$lefmenuSubClass .= ' subM';
}
?>
$("#LEFTMENU .menupriavte<?=MENU_ID?>").attr("class","<?=$lefmenuSubClass?>");
active_menu = Array();
active_menu[0] = 0;
active_menu[388] = 1;
active_menu[389] = 2;
active_menu[390] = 3;
active_menu[391] = 4;
active_menu[392] = 5;
function makeTopMenuActive(){
	$("#Menu"+active_menu[<?=$active_top_menu_id?>]+" a:first").addClass("menu_active");
	$("#Menu"+active_menu[<?=$active_top_menu_id?>]+" a:first").css("color","#FFF");
	//alert(<?=$active_top_menu_id?>);
}
makeTopMenuActive();

</script>