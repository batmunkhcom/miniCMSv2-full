<?php
if(isset($_POST['postit'])){
	
	if(is_array($_POST['massSelection'])){
		
		$q_ext = '';
		foreach($_POST['massSelection'] as $k=>$v){
			$q_ext .= "id='".$k."' OR ";
		}
		$q_ext = rtrim($q_ext, " OR ");
		
		if(isset($_POST['Delete'])){
			switch( $_GET['c']){
				case 'trash':
					$q_msg = "DELETE FROM ".$DB->prefix."messages WHERE ";
				break;
				default:
					$q_msg = "UPDATE ".$DB->prefix."messages SET box='".TRASHBOX."',is_deleted=1 WHERE ";
				break;
			}
		}
		if(isset($_POST['MarkAsRead'])){
			$q_msg = "UPDATE ".$DB->prefix."messages SET is_read=1 WHERE ";
		}
		if(isset($_POST['MarkAsUnread'])){
			$q_msg = "UPDATE ".$DB->prefix."messages SET is_read=0 WHERE ";
		}
		$q_msg .= $q_ext;
		$DB->mbm_query($q_msg);
		$result_txt = 'Command has been executed.';
	}else{
		$result_txt = 'Please select at least one message.';
	}
	echo mbmError($result_txt);
}else{
?><form action="" method="post" name="MSG">
    <table border="1" width="100%" cellpadding="3" cellspacing="2" style="border-collapse:collapse; font-size:10px; ">
      <tr height="25" align="center" bgcolor="#333" style="color:#FFF;">
          <td align="center" width="40">-
          </td>
          <th width="80">From</th>
          <th width="80">To</th>
          <th>Subject</th>
          <th width="50">Priority</th>
          <th width="130">Date</th>
      </tr>
	  <?
	if(is_array($posts)):
		foreach ($posts as $post): ?>
		  <tr 
          style="cursor:pointer;
          		background-color:<?php echo $GLOBALS['msg_priority_color'][$post['priority']]?>;
                <?php
                if($post['is_read'] == 0){
					echo 'font-weight:bold;';
				}
				?>"
                onclick="window.location='index.php?module=message&cmd=box&c=read&id=<?=$post['id']?>'"
                >
			  <td align="center"><input type="checkbox" name="massSelection[<?=$post['id']?>]"  value="1" id="MSG_<?=$post['id']?>"></td>
			  <td><?php echo $DB2->mbm_get_field($post['from_uid'],'id','username','users'); ?></td>
			  <td><?php echo  $DB2->mbm_get_field($post['to_uid'],'id','username','users');?></td>
			  <td><?php echo $post['subject'] ?></td>
			  <td align="center"><?php echo $GLOBALS['msg_priority'][$post['priority']]; ?></td>
			  <td align="center"><?php echo date("Y/m/d H:i:s",$post['date_added']) ?></td>
		  </tr>
          <tr>
          	<td onclick="$('#msg_<?=$post['id']?>').toggle();" style="display:none; padding:5px;" colspan="20" id="msg_<?=$post['id']?>">
				<?=$post['content']?>
            </td>
          </tr>
		<?php endforeach;
	endif;
?> <tr height="25" bgcolor="#333" style="color:#FFF;" valign="top">
          <td colspan="3">
          	<span onclick="toggleAll(1)" style="cursor:pointer;"> 
            	- Select all messages
            </span><br />
          	<span onclick="toggleAll(0)" style="cursor:pointer;"> 
            	- Unselect all messages
            </span>
            </td>
          <td colspan="3">
            <input type="submit" name="Delete" value="Delete selected messages" />
            <input type="submit" name="MarkAsRead" value="Mark as read" />
            <input type="submit" name="MarkAsUnread" value="Mark as unread" />
            <input type="hidden" name="postit" value="" />
            
          </td>
      </tr>
    </table>
</form>
<script>
function toggleAll(val){
	var c = document.getElementsByTagName("input");
	  for(var i=0;i<c.length;i++)
	  {
		if(c[i].type=="checkbox")
		{
			if(val==0) c[i].checked=false;
			else if(val==1) c[i].checked=true;
			else if(val==2){
				if(c[i].checked==false) c[i].checked = true;
				else c[i].checked = false;
			}
		}
	  }
}
</script>
<?
}
?>