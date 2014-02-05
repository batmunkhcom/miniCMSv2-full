<?
$f = '/home/azmn/public_html/share.az.mn/upload1/suykgm3zcocruw5iv4uf3gqkz5bfzmxecv1vgn4cofnhyzfrgvsgqgg96521pmb5.rar';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=1.rar");
//header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($f));

readfile($f);
?>