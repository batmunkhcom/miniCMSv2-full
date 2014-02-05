<?
	if(isset($_POST['q'])){
		header("Location: ../../index.php?module=search&cmd=search&q=".urlencode($_POST['q']));
	}else{
		header("Location: ../../index.php?module=search&cmd=search");
	}
?>