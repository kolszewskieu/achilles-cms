<?
//print_r($_GET);
$url="http://".$_SERVER[HTTP_HOST]."/img/".$_GET[lang]."/".$_GET[img].".png";
//echo $url;
header('Location: '.$url);
?>