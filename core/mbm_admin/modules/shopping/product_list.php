<script language="javascript">
mbmSetContentTitle("list product");
mbmSetPageTitle('list product');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'st':
			$DB->mbm_query("UPDATE ".PREFIX."shop_products SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
		break;
		case 'lev':
			$DB->mbm_query("UPDATE ".PREFIX."shop_products SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'");
		break;
		case 'delete':
			$DB->mbm_query("DELETE FROM ".PREFIX."shop_products WHERE id='".$_GET['id']."'");
		break;
	}
}
if($DB->mbm_check_field('id',$_GET['cat_id'],'shop_cats')==0){
?>
<form id="catsShop" name="catsShop" method="post" action=""><?=$lang["shopping"]["select_category"]?>
:<br />
  	  <select name="cat_id" size="8" id="cat_id">
  	    <option value="0">
        <?=$lang["shopping"]["set_as_main"]?>
        </option>
        <?=mbmShoppingCatOptions(0)?>
  </select>   
  <p>
    <label>
    <input type="button" name="continue" id="continue" value="Continue" onclick="window.location='index.php?module=shopping&cmd=product_list&cat_id='+document.getElementById('cat_id').value" />
    </label>
</p>
</form>
<?
}
	$q_products = "SELECT * FROM ".PREFIX."shop_products ";
	if($DB->mbm_check_field('id',$_GET['cat_id'],'shop_cats')==1){
		$q_products .= "WHERE cat_ids LIKE '%,".$_GET['cat_id'].",%' ";
		echo '<h2>'.$DB->mbm_get_field($_GET['cat_id'],'id','name','shop_cats').'</h2>';
	}
	$q_products .= "ORDER BY id DESC";
	$r_products = $DB->mbm_query($q_products);
echo  mbmNextPrev('index.php?module=menu&cmd=content_list',$DB->mbm_num_rows($r_contents),START,PER_PAGE);

?>
    <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td width="30" align="center">#</td>
        <td width="85">image</td>
        <td>name</td>
        <td width="100" align="center">type</td>
        <td width="100" align="center">price</td>
        <td width="50" align="center">st</td>
        <td width="50" align="center">lev</td>
        <td width="150" align="center">Action</td>
      </tr>
      <?
	  if((START+PER_PAGE) > $DB->mbm_num_rows($r_products)){
			$end= $DB->mbm_num_rows($r_products);
		}else{
			$end= START+PER_PAGE; 
		}
		for($i=START;$i<$end;$i++){
	  ?>
      <tr>
        <td align="center" bgcolor="#F5F5F5"><strong>
        <?=($i+1)?>
        </strong></td>
        <td bgcolor="#F5F5F5"><?
		echo '<img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
						.$DB->mbm_result($r_products,$i,'image_filetype')
						.'&amp;f='
						.base64_encode($DB->mbm_result($r_products,$i,'image_thumb'))
						.'&w=75'
						.'" />';
			?></td>
        <td bgcolor="#F5F5F5"><?=$DB->mbm_result($r_products,$i,'name')?></td>
        <td align="center" bgcolor="#F5F5F5"><?=$DB->mbm_get_field($DB->mbm_result($r_products,$i,'type_id'),'id','name','shop_types')?></td>
        <td align="center" bgcolor="#F5F5F5"><?=$DB->mbm_result($r_products,$i,'price').'<br >['.$DB->mbm_result($r_products,$i,'price_sale').']'?></td>
        <td align="center" bgcolor="#F5F5F5"><?
    if($DB->mbm_result($r_products,$i,"st")==1){
		$st_con = 'status_1.png'; 
	}else{
		$st_con = 'status_0.png'; 
	}
	echo '<a href="index.php?module=shopping&cmd=product_list&action=st&id='.$DB->mbm_result($r_products,$i,"id").'&st=';
		echo abs(($DB->mbm_result($r_products,$i,"st")%2)-1);
	echo '"';
	echo '<img src="images/icons/'.$st_con.'" border="0" />';
	echo '</a>';
	?></td>
        <td align="center" bgcolor="#F5F5F5"><select class="input" name="lev" 
    		onchange="window.location='index.php?module=shopping&cmd=product_list&action=lev&id=<?=$DB->mbm_result($r_products,$i,"id")?>&lev='+this.value">
    <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB->mbm_result($r_products,$i,"lev")); ?>
    </select></td>
      <td align="center" bgcolor="#F5F5F5"><a href="index.php?module=shopping&amp;cmd=product_edit&amp;cat_id=<?=$_GET['cat_id']?>&amp;id=<?=$DB->mbm_result($r_products,$i,"id")?>">
          <img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" />
        </a>  <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=shopping&amp;cmd=product_list&amp;cat_id=<?=$_GET['cat_id']?>&amp;id=<?=$DB->mbm_result($r_products,$i,"id")?>&amp;action=delete')">
        <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" />
        </a></td>
      </tr>
      <?
      }
	  ?>
</table>
<?
	$qq_extend = '';
	if(isset($_GET['cat_id'])){
		$qq_extend .= '&cat_id='.$_GET['cat_id'];
	}
	echo mbmNextPrev('index.php?module=shopping&cmd=product_list'.$qq_extend ,$DB2->mbm_num_rows($r_products),START, PER_PAGE);
?>