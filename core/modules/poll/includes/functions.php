<?
function mbmShowPoll($id=0,$show_title=0)
{
		global $lang,$DB;
		
		$q_question = "SELECT * FROM ".PREFIX."poll WHERE st='1' ";
		if($id!=0){
			$q_question .= "AND id='".$id."' ";
		}
		$q_question .= "ORDER BY id DESC LIMIT 1";
		$r_question=$DB->mbm_query($q_question);
		$buf .= "<table width='98%' class='poll_tbl' align=center>";
		for($i=0; $i< $DB->mbm_num_rows($r_question); $i++)
		{
			$buf .= '<form';
			if($_GET['module']!='poll'){
				$buf .= ' target="_blank"';
			}
			$buf .= ' action="modules/poll/dovote.php?';
			$buf .= 'id='.$DB->mbm_result($r_question,$i,"id").'" method="post">';
			if($show_title==1){
				$buf .= '<tr align="center" class="poll_title">';
					$buf .= '<td colspan=2>';
					$buf .= stripslashes($DB->mbm_result($r_question,$i,"question_".$_SESSION['ln']));
					$buf .= '</td>';
				$buf .= '</tr>';
			}
					$q_answer="SELECT * FROM ".PREFIX."poll_a WHERE poll_id='";
					$q_answer.=$DB->mbm_result($r_question,$i,"id")."' ORDER BY id";
					$r_answer=$DB->mbm_query($q_answer);
					for($j=0;$j<$DB->mbm_num_rows($r_answer);$j++)
					{
						$buf .= '<tr height=17>';
						$buf .= '<td width=30 align=center>';
						$buf .= '<input type="radio" name="answer" value="'.$DB->mbm_result($r_answer,$j,"id").'" ';
						if($j==0) $buf .= 'checked';
						$buf .= '></td>';
						$buf .= '<td>';
						$buf .= $DB->mbm_result($r_answer,$j,"answer_".$_SESSION['ln']);
						$buf .= '</td>';
						$buf .= '</tr>';
					}
					$buf .= '<tr height="17">';
						$buf .= '<td>&nbsp;</td>';
						$buf .= '<td><input type=submit class="button" value="'.$lang['poll']['vote'].'"></td>';
					$buf .= '</tr>';
				
				$t_result=$DB->mbm_num_rows($DB->mbm_query("SELECT * FROM ".PREFIX."poll_r WHERE poll_id='".$DB->mbm_result($r_question,$i,"id")."'"));
				if($t_result!=0)
				{
					$buf .= '<tr height="17">';
						$buf .= '<td>&nbsp;</td>';
						$buf .= '<td><a href="index.php?module=poll&amp;cmd=view_vote&amp;id='.$DB->mbm_result($r_question,$i,"id").'">'.$lang['poll']['view'];
						$buf .= '</a> (';
						$q_total_answer="SELECT COUNT(*) FROM ".PREFIX."poll_r WHERE poll_a_id IN 
											(SELECT id FROM ".PREFIX."poll_a WHERE
													poll_id=".$DB->mbm_result($r_question,$i,"id").")";
						$total_answer=$DB->mbm_query($q_total_answer);
						
						$buf .= $DB->mbm_result($total_answer,0);
						$buf .= ')</td>';
					$buf .= '</tr>';
				}
			$buf .= '</form>';
			if($i!=($DB->mbm_num_rows($r_question)-1)){
				$buf .= '<tr height=1 bgcolor=#dddddd><td colspan=2></td></tr>';
			}
		}
		$buf .= "</table>";
		return $buf;
	}
?>