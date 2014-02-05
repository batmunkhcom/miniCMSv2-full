<style>
.msg_input{
	width:200px;
	padding:3px;
}
.msg_textarea{
	width:200px;
	height:150px;
	padding:3px;
}
.msg_button{
	padding-left:20px;
	padding-right:20px;
	line-height:25px;
	height:25px;
}
#query_result{
	color:#FFF;
	border:1px solid #FFF;
}
</style>
<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{
?>
<h1>Send message to an user</h1>
<?
	if(isset($_POST['sendMsg'])){
		if($DB2->mbm_check_field('username',$_POST['to_user'],'users') == 0){
			$result_txt = 'No such user found';
		}elseif($_POST['subject'] == ''){
			$result_txt = 'Please enter subject.';
		}else{
			$data['box'] = SENTBOX;
			$data['st'] = 1;
			$data['from_uid'] = $_SESSION['user_id'];
			$data['to_uid'] = $DB2->mbm_get_field($_POST['to_user'],'username','id','users');
			$data['is_deleted'] = 0;
			$data['is_replied'] = 0;
			$data['is_draft'] = 0;
			$data['priority'] = $_POST['priority'];
			$data['is_all'] = 0;
			$data['lev'] = 0;
			$data['subject'] = addslashes($_POST['subject']);
			$data['content'] = addslashes($_POST['content']);
			$data['date_added'] = mbmTime();
			if($DB->mbm_insert_row($data,'messages') == 1){
				$result_txt = 'Message has been sent.';
				$b = 1;
			}else{
				$result_txt = 'Error occurred. Please try again.';
			}
		}
		
		echo mbmError($result_txt);
	}
	if($b!=1){
	?>
	<form name="form1" method="post" action="">
	  <table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
		  <td width="100">To</td>
		  <td><input type="text" name="to_user" id="to_user" class="msg_input"></td>
		</tr>
		<tr>
		  <td width="100">Priority</td>
		  <td>
          	<select name="priority" id="priority">
            	<?php
                foreach($GLOBALS['msg_priority'] as  $k=>$v){
					echo '<option value="'.$k.'">'.$v.'</option>';
				}
				?>
            </select>
          </td>
		</tr>
		<tr>
		  <td>Subject</td>
		  <td><input type="text" name="subject" id="subject" class="msg_input"></td>
		</tr>
		<tr>
		  <td>Content</td>
		  <td><textarea name="content" id="content" class="msg_textarea"></textarea></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="submit" name="sendMsg" id="sendMsg" value="Submit" class="msg_button"></td>
		</tr>
	  </table>
	</form>
	<?
	}
}
?>
