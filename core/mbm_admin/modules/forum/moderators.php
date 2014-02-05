<script language="javascript">
mbmSetContentTitle("Forum moderators");
mbmSetPageTitle('Forum moderators');
show_sub('menu10');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
$q_moderators = "SELECT * FROM ".PREFIX."forum_moderators ORDER BY id,user_id,forum_id";
$r_moderators = $DB->mbm_query($q_moderators);

?>
  <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
    <tr class="list_header">
      <td width="30" align="center">#</td>
      <td>forum</td>
      <td>username</td>
      <td>admin user</td>
      <td>Edit</td>
      <td>Delete</td>
      <td>date_added</td>
      <td>Actions</td>
    </tr>
    <?php
    	for($i=0;$i<$DB->mbm_num_rows($r_moderators);$i++){
	    	echo '<tr>
				      <td width="30" align="center">'.($i+1).'</td>
				      <td>'.$DB->mbm_get_field($DB->mbm_num_rows($r_moderators,$i,'forum_id'),'id','name','forums').'<br />
				      ['.$DB->mbm_num_rows($r_moderators,$i,'comment').']</td>
				      <td>'.$DB2->mbm_get_field($DB->mbm_num_rows($r_moderators,$i,'user_id'),'id','username','users').'</td>
				      <td>'.$DB2->mbm_get_field($DB->mbm_num_rows($r_moderators,$i,'admin_user_id'),'id','username','users').'</td>
				      <td>Edit</td>
				      <td>Delete</td>
				      <td>'.date("Y/m/d",$DB->mbm_num_rows($r_moderators,$i,'date_added')).'</td>
				      <td>edit | delete</td>
		      	</tr>
		      ';
    	}
    ?>
    <tr>
    	<td bgcolor="#F5F5F5"></td>
   	  <td colspan="11" align="right" bgcolor="#F5F5F5"><input type="submit" name="updatePositions" id="updatePositions" value="<?=$lang["forum"]["button_update_position"]?>" /></td>
    </tr>
  </table>
