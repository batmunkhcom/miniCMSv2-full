<h2>Бүтээгдэхүүний жагсаалт</h2>
<?
if(isset($_GET['cat_id']) && $_GET['cat_id']!=''){
	if(!isset($_GET['id'])){
		echo mbmShoppingProducts2($_GET['cat_id'],0,'id','desc',0);
	}elseif($DB->mbm_check_field('id',$_GET['id'],'shop_products')==1){
		echo mbmShoppingProductInfo($_GET['id']);
	}else{
		echo 'no such product';
	}
}
?>