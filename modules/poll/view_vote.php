<?
	echo '<h2>Санал асуулга</h2>';
	
	//vote ugsnii daraa hevelne
	if(isset($_SESSION['voted']) && $_SESSION['voted']==1){
		echo '<div id="query_result">Санал өгсөнд баярлалаа. Таны санлыг хүлээн авлаа.</div>';
	}
	unset($_SESSION['voted']);
	
	$q_vanswers= "SELECT * FROM ".PREFIX."poll_a WHERE poll_id='".$_GET['id']."'";
	$r_vanswers= $DB->mbm_query($q_vanswers);
	
	$q_total_result= "SELECT * FROM ".PREFIX."poll_r WHERE poll_id='".$_GET['id']."'";
	$r_total_result= $DB->mbm_query($q_total_result);
	$total_result= $DB->mbm_num_rows($r_total_result);
	echo '<table width="180" cellpadding="3" 
					style="background-color:#f5f5f5;
							float:right;
							border:1px solid #DDDDDD;
							margin-top:30px;">
		  	<tr>
			  <td><strong>'.$lang['poll']['last_5_polls'].'</strong><br /><br />';
			  
		$q_polls= "SELECT * FROM ".PREFIX."poll WHERE st=1 ORDER BY id DESC LIMIT 5";
		$r_polls= $DB->mbm_query($q_polls);
		for($j=0; $j< $DB->mbm_num_rows($r_polls); $j++){
			echo ($j+1).'. ';
			echo '<a href="index.php?module=poll&cmd=view_vote&id='.$DB->mbm_result($r_polls,$j,"id").'">'
				 .$DB->mbm_result($r_polls,$j,"question_".$_SESSION['ln']).'</a><br /><br />';
		}
	echo '	  </td>
			</tr>
		  </table>';
	echo '<h2>';
	echo stripslashes($DB->mbm_get_field($_GET['id'],"id", 'question_'.$_SESSION['ln'], 'poll'));
	echo '</h2>';
	
	
	echo '<div style="float:left">';
		echo mbmShowPoll($_GET['id']);
		
		echo '<br /><br />';
		
		echo $lang['poll']['total_votes'].' : <strong>'.$total_result.'</strong>';
		echo '<blockquote><p>';
		for($i=0;$i< $DB->mbm_num_rows($r_vanswers); $i++)
		{
			$q_total_answer="SELECT id FROM ".PREFIX."poll_r WHERE poll_a_id='".$DB->mbm_result($r_vanswers,$i,"id")."'";
			$total_answer=$DB->mbm_num_rows($DB->mbm_query($q_total_answer));
			echo '<b><span class="cc">';
			echo $DB->mbm_result($r_vanswers,$i,"answer_".$_SESSION['ln']);
			echo '</span></b>';
			if($total_result!=0)
			{
				$k=1;
				$n=ceil(($total_answer*100)/$total_result);
				for($j=1;$j<=($n*3);$j++)
				{
					$k++;
				}
				
				echo mbmPercent($total_answer,$total_result);
				//echo '<img height="10" src="modules/poll/gr.gif" width="'.$k.'" align=absmiddle />';
				//echo '</span> (<b>'.$total_answer.'</b> : '.number_format((($total_answer*100)/$total_result),2).'%)<br /><br />';
			}else{
				echo '';
			}
			echo '<br />';
		}
		echo '</p></blockquote>';
	echo '</div><br clear="both" />';
	echo mBmCommentsForm("poll_".$_GET['id'],45,30);
?>