<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="errorMain">Please login first.</div>';
}else{
	$q_user_profile = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$_SESSION['user_id']."'";
	$r_user_profile = $DB2->mbm_query($q_user_profile);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="5">
  <tr class="tblHeader">
    <td colspan="2">Personal Information</td>
    <td colspan="2">Additional information</td>
  </tr>
  <tr>
    <td width="25%" valign="top" bgcolor="#F5F5F5">Firstname: </td>
    <td width="25%" valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"firstname")?>
    </strong></td>
    <td width="25%" valign="top" bgcolor="#F5F5F5">Registered:</td>
    <td width="25%" valign="top" bgcolor="#F5F5F5"><strong>
      <?=date("Y/m/d H:i:s",$DB2->mbm_result($r_user_profile,0,"date_added"))?>
      <br />
    </strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Lastname: </td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"lastname")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">Date last login:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=date("Y/m/d H:i:s",$DB2->mbm_result($r_user_profile,0,"date_lastlogin"))?>
    </strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Gender: </td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"gender")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">Ip las login:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"ip_lastlogin")?>
    </strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Birthday:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"birthday")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Phone:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"phone")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Mobile:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"mobile")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Fax:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"fax")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Email:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"email")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Website:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"website")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Occupation:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"occupation")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">City:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"city")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">Country:</td>
    <td valign="top" bgcolor="#F5F5F5"><strong>
      <?=$DB2->mbm_result($r_user_profile,0,"country")?>
    </strong></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
</table>
<?
}
?>
