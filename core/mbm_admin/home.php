<?
	function mbmCountTable($tbl,$st=0,$lev=0){
		global $DB,$DB2;
		if($tbl=='users'){
			$obj = $DB2;
			$prefix = USER_DB_PREFIX;
		}else{
			$obj = $DB;
			$prefix = PREFIX;
		}
		$q = "SELECT COUNT(*) FROM ".$prefix.$tbl." WHERE id!=0 ";
		if($st!=2){
			$q .= "AND st='".$st."' ";
		}
		if($lev!=999){
			$q .= "AND lev='".$lev."' ";
		}
		$r = $obj->mbm_query($q);
		
		return $obj->mbm_result($r,0);
	}
?>
<script>
$("#FAQS a").tooltip();
</script>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="33%" valign="top">
    <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
 	 <tr class="list_header" title="asdf jasd">
        <td colspan="2"><?=$lang["admin_home"]["banners"]?></td>
        </tr>
      <tr>
        <td><?=$lang["admin_home"]["active"]?></td>
        <td width="125" align="right"><strong>
          <?=mbmCountTable("banners",1,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["inactive"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("banners",0,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["total"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("banners",2,999)?>
        </strong></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td colspan="2"><?=$lang["admin_home"]["faqs"]?></td>
      </tr>
      <tr>
        <td id="FAQS"><a href="index.php?module=faqs&amp;cmd=new" title="new questions"><?=$lang["admin_home"]["faqs_new"]?></a></td>
        <td width="125" align="right"><strong>
          <?=$DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."faqs WHERE total_updated=0"),0)?>
        </strong></td>
      </tr>
      
      <tr>
        <td><?=$lang["admin_home"]["total"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("faqs",2,999)?>
        </strong></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td colspan="2"><?=$lang["admin_home"]["polls"]?></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["active"]?></td>
        <td width="125" align="right"><strong>
          <?=mbmCountTable("poll",1,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["inactive"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",0,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_0"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,0)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_1"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,1)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_2"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,2)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_3"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,3)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_4"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,4)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_5"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,5)?>
        </strong></td>
      </tr>
      
      <tr>
        <td><?=$lang["admin_home"]["total"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("poll",2,999)?>
        </strong></td>
      </tr>
    </table></td>
    <td width="33%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td colspan="2"><?=$lang["admin_home"]["members"]?></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["active"]?></td>
        <td width="125" align="right"><strong>
          <?=mbmCountTable("users",1,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["inactive"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",0,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_0"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,0)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_1"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,1)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_2"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,2)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_3"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,3)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_4"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,4)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_5"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,5)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["total"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("users",2,999)?>
        </strong></td>
      </tr>
    </table></td>
    <td width="33%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td colspan="2"><?=$lang["admin_home"]["menus"]?></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["active"]?> </td>
        <td width="125" align="right"><strong>
          <?=mbmCountTable("menus",1,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["inactive"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",0,999)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_0"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,0)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_1"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,1)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_2"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,2)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_3"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,3)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_4"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,4)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["level_5"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,5)?>
        </strong></td>
      </tr>
      <tr>
        <td><?=$lang["admin_home"]["total"]?></td>
        <td align="right"><strong>
          <?=mbmCountTable("menus",2,999)?>
        </strong></td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
        <tr class="list_header">
          <td colspan="2"><?=$lang["admin_home"]["menu_contents"]?></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["active"]?></td>
          <td width="125" align="right"><strong>
            <?=mbmCountTable("menu_contents",1,999)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["inactive"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",0,999)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_0"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,0)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_1"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,1)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_2"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,2)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_3"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,3)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_4"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,4)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["level_5"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,5)?>
          </strong></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["total"]?></td>
          <td align="right"><strong>
            <?=mbmCountTable("menu_contents",2,999)?>
          </strong></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
        <tr class="list_header">
          <td colspan="2"><?=$lang["admin_home"]["menu_content_comments"]?></td>
        </tr>
        <tr>
          <td><?=$lang["admin_home"]["total"]?></td>
          <td width="125" align="right"><strong><?=mbmCountTable("menu_content_comments",2,999)?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
