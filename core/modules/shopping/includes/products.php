<?
	function mbmShoppingProducts2($cat_id=0,$is_digital=0,$order_by='id',$asc='desc', $limit=20,$cols=2, $show_more_button=1){
		global $DB,$lang;
		
		$q = "SELECT * FROM ".PREFIX."shop_products WHERE st=1 AND lev<='".$_SESSION['lev']."' ";
		if($cat_id!=0){
			$q .= "AND cat_ids LIKE '%,".$cat_id.",%' ";
		}
		$q .= "ORDER BY ".$order_by." ".$asc." ";
		if($limit!=0){
			$q .= "LIMIT ".$limit;
		}
		$r = $DB->mbm_query($q);
		
		$buf = '<table width="100%" border="0" cellspacing="3" cellpadding="0"><tr>';
		
		if($cat_id==0){
			$per_page = PER_PAGE;
		}else{
			$per_page = $DB->mbm_get_field($cat_id,'id','per_page','shop_cats');
		}
		if((START+$per_page) > $DB->mbm_num_rows($r)){
			$end= $DB->mbm_num_rows($r);
		}else{
			$end= START+$per_page; 
		}
		if(strlen($_SERVER['QUERY_STRING'])<3 && $cols == 2){
			$end = 40;
		}
		if($DB->mbm_num_rows($r) < 40 ){
			$end = $DB->mbm_num_rows($r);
		}
		for($i=START;$i<$end;$i++){
			$cell_width = floor((100/2)/$cols);
			$buf .= '<td width="'.$cell_width.'%" align="center" valign="top">';
			
			$more_link = ''.DOMAIN.DIR.'index.php?module=shopping&cmd=products&cat_id=';
			if($cat_id==0){
				$more_link .= mbmShoppingSelectOneCatId($DB->mbm_result($r,$i,'cat_ids'));
			}else{
				$more_link .= $cat_id;
			}
			$more_link .= '&id='.$DB->mbm_result($r,$i,'id').'';
			
			$buf .= '<a href="'.$more_link.'">';
				$buf .= '<img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
						.$DB->mbm_result($r,$i,'image_filetype')
						.'&amp;f='
						.base64_encode($DB->mbm_result($r,$i,'image_thumb'))
						.'&w=100&h=100'
						.'" class="productThumb" />';
			$buf .='</a></td>';
			$buf .= '<td width="'.$cell_width.'%" valign="top">';
				$buf .= '<div class="productTitle">'.$DB->mbm_result($r,$i,'name').'</div>';
				$buf .= '<div class="productContentShort">';
				$buf .= mbmCleanUpHTML($DB->mbm_result($r,$i,'content_short'));
				$buf .= '</div>';
				$buf .= '<div><small>Барааны дугаар:</small> ';
					$buf .= '<strong>'.$DB->mbm_result($r,$i,'id').'</strong>';
				$buf .= '</div>';
				if($DB->mbm_result($r,$i,'type_id')!=0){
					$buf .= '<div class="productType">';
						$buf .= $DB->mbm_get_field($DB->mbm_result($r,$i,'type_id'),'id','name','shop_types');
					$buf .= '</div>';
				}
				$buf .= '<small>Үнэ:</small> <div class="productPrice">';
					if(($DB->mbm_result($r,$i,'price_sale')*1)==0){
						$buf .= $DB->mbm_result($r,$i,'price').' '.CURRENCY;
					}else{
						$buf .= '<div style="text-decoration:line-through;font-size:9px;font-weight:normal;">'.$DB->mbm_result($r,$i,'price').' '.CURRENCY.'</div>';
						$buf .= $DB->mbm_result($r,$i,'price_sale').' '.CURRENCY;
					}
				$buf .= '</div>';
				if($show_more_button==1){
					$buf .= '<div id="productMoreLink">';
						$buf .= '<a href="'.$more_link.'" class="productMoreLink">'.$lang['main']['more'].'</a>';
					$buf .= '</div>';
				}
			$buf .= '</td>';
			if((($i+1)%$cols)==0){
				$buf .= '</tr><tr><td height="20" colspan="4"></td></tr>';
				$buf .= '</tr><tr>';
			}
		}
		$buf .= '</tr></table>';
		$buf .= mbmNextPrev('index.php?module=shopping&cmd=products&cat_id='.$cat_id,$DB->mbm_num_rows($r),START,$per_page);
		return $buf;
	}
	function mbmShoppingProductInfo($id=0){
		global $DB,$lang;
		
		$q = "SELECT * FROM ".PREFIX."shop_products WHERE id='".$id."'";
		$r = $DB->mbm_query($q);
		
		$buf = '';
		
		if($DB->mbm_num_rows($r)==1){
			$buf .= '<table width="100%" border="0" cellspacing="3" cellpadding="0"><tr>';
				$buf .= '<td width="260" align="center" valign="top">';
				$buf .= '<a href="img.php?type='
						.$DB->mbm_result($r,$i,'image_filetype')
						.'&amp;f='
						.base64_encode($DB->mbm_result($r,$i,'image_thumb'))
						.'&w=500'
						.'" target="_blank"><img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
						.$DB->mbm_result($r,$i,'image_filetype')
						.'&amp;f='
						.base64_encode($DB->mbm_result($r,$i,'image_thumb'))
						.'&w=250&h=250'
						.'" />';
				$buf .='</a><br />'.$lang["main"]["hits"].': '.$DB->mbm_result($r,$i,'hits').'</td>';
				$buf .= '<td >';
					$buf .= '<div class="productTitle">'.$DB->mbm_result($r,$i,'name').'</div>';
					$buf .= '<div class="productContentShort">';
					$buf .= mbmCleanUpHTML($DB->mbm_result($r,$i,'content_short'));
					$buf .= '</div>';
					$buf .= '<div><small>Барааны дугаар:</small> ';
					$buf .= '<strong>'.$DB->mbm_result($r,$i,'id').'</strong></div>';
					
					if($DB->mbm_result($r,$i,'type_id')!=0){
						$buf .= '<div class="productType">';
							$buf .= $DB->mbm_get_field($DB->mbm_result($r,$i,'type_id'),'id','name','shop_types');
						$buf .= '</div>';
					}
					$buf .= '<small>Price:</small><div class="productPrice">';
						if(($DB->mbm_result($r,$i,'price_sale')*1)==0){
							$buf .= $DB->mbm_result($r,$i,'price').' '.CURRENCY;
						}else{
							$buf .= '<div style="text-decoration:line-through;font-size:9px;font-weight:normal;">'.$DB->mbm_result($r,$i,'price').' '.CURRENCY.'</div>';
							$buf .= $DB->mbm_result($r,$i,'price_sale').' '.CURRENCY;
						}
					$buf .= '</div>';
					$buf .= '<br /><br />';
					$buf .= mbmRating('shop_'.$id);
				$buf .= '</td>';
			$buf .= '</tr></table><br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						';
			$buf .= $DB->mbm_result($r,$i,'content_more');
			$DB->mbm_query("UPDATE ".PREFIX."shop_products SET hits=hits+".HITS_BY." WHERE id='".$DB->mbm_result($r,$i,'id')."'");
			$buf .= mBmCommentsForm("shop_".$DB->mbm_result($r,$i,'id'),45,30);
		}
		return $buf;
	}
?>