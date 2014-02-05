<style>
#messageLinks a:link, #messageLinks a:visited{
	padding-bottom:3px;
	padding-top:3px;
	display:block;
	padding-left:10px;
	text-decoration: none;
	color:#000;
}
#messageLinks a:hover{
	background-color:#f5f5f5;
	color:#333;
}
</style>
<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{
?>
	<table width="100%" border="0" cellpadding="2">
	  <tr>
	    <td valign="top" width="160">
        	<div id="messageLinks">
            	<?php echo mbmMessageLinks();?>
            </div>
        </td>
	    <td width="10" valign="top">&nbsp;</td>
	    <td valign="top">
        <?
		if(file_exists(ABS_DIR.'modules/message/'.$_GET['c'].'.php')){
			require_once(ABS_DIR.'modules/message/'.$_GET['c'].'.php');
		}else{
			require_once(ABS_DIR.'modules/message/home.php');
		}
		?>
        </td>
      </tr>
</table>
<?
}
?>