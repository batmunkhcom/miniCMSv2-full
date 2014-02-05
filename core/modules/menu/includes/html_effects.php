<?
function mbmContentScroller(
							$var = array(
								'menu_id'=>0,
								'show_title'=>0,
								'show_content_short'=>0,
								'link'=>0,
								'order_by'=>'id',
								'asc'=>'desc',
								'st'=>0,
								'class'=>'artscroller',
								'scroll_time'=>8000,
								'limit'=>5,
								'variable_name'=>'newsSlider'
							)
							){
	global $DB,$lang;
	
			if($var['menu_id']!=0){
				$query_mid = "menu_id LIKE '%,".$var['menu_id'].",%' AND ";
			}
			$q_newcontents = "SELECT * FROM ".PREFIX."menu_contents 
								WHERE 
									st=".$var['st']." AND 
									lev<='".$_SESSION['lev']."' AND 
									".$query_mid."
									is_video=0 AND 
									is_photo=0 
									ORDER BY ".$var['order_by']." ".$var['asc']."  
									LIMIT ".$var['limit'].";";
			$r_newcontents = $DB->mbm_query($q_newcontents);
			
			
			$scroll_content = '<ul id="newsSlider" type="none">';
			for($i=0;$i<$DB->mbm_num_rows($r_newcontents);$i++){
				$scroll_content .= '<li>';
				if($var['show_title']==1){
					$scroll_content .= '<div id="contentTitle">';
					if($var['link']==0){
						$scroll_content .= $DB->mbm_result($r_newcontents,$i,"title");
					}else{
						$c_mid = explode(',',$DB->mbm_result($r_newcontents,$i,"menu_id"));
						$scroll_content .= '<a href="index.php?module=menu&amp;cmd=content&menu_id='
												.$c_mid[1]
												.'&amp;id='.$DB->mbm_result($r_newcontents,$i,"id").'">'
												.$DB->mbm_result($r_newcontents,$i,"title")
												.'</a>';
					}
					$scroll_content .= '</div>';
				}
				if($var['show_content_short']==1){
					$scroll_content .= $DB->mbm_result($r_newcontents,$i,"content_short");
					if($var['more']==1){
						$scroll_content .= '<div id="contentMoreLink">';
							$scroll_content .= '<a href="index.php?module=menu&amp;cmd=content&menu_id='
													.$c_mid[1]
													.'&amp;id='.$DB->mbm_result($r_newcontents,$i,"id").'">'
													.$lang["main"]["more"]
													.'</a>';
						$scroll_content .= '</div>';
					}
				}
				$scroll_content .= '</li>';
			}
			$scroll_content .= '</ul>
			<script type="text/javascript">
		   $(document).ready(
			function(){
				$(\'#newsSlider\').innerfade({
						animationtype: \'fade\',
						speed: 1000,
						timeout: 8000,
						type: \'random\'
					});
							
						
					});
			</script>
			';
	return $scroll_content;//$buf;
}
?>