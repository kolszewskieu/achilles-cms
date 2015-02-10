<?
include 'conf.php';

if($_GET[del_id]){
	unlink($_DIR_CART."/".$_GET[del_id]."/".$_GET[file]);	
	if ($handle = opendir($_DIR_CART."/".$_GET[del_id]."/")) {
		$i=0;
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
			$i++;
			}
		}
		if($i==0){
			$sql="UPDATE produkty_$lang SET karta_format='0' WHERE id='$_GET[del_id]'";
			mysql_query($sql);
		}
		closedir($handle);
	}
}

if($_GET[add]==1){
	$plik_tmp = $_FILES['kart']['tmp_name'];
	if(!is_dir($_DIR_CART."/".$_POST[prod_id])){
		mkdir($_DIR_CART."/".$_POST[prod_id]);
	}
	if(is_uploaded_file($plik_tmp)){	
		$plik_nazwa = str_replace(" ","_",strtolower(Czysc($_FILES['kart']['name'])));
		if(file_exists($_DIR_CART."/".$_POST[prod_id]."/".$plik_nazwa)){
			$plik_nazwa=substr(microtime(),3,4).$plik_nazwa;
		}
		if ($plik_nazwa){
			if(move_uploaded_file($plik_tmp, $_DIR_CART."/".$_POST[prod_id]."/".$plik_nazwa)){
				$sql="UPDATE produkty_$lang SET karta_format='1' WHERE id='$_POST[prod_id]'";
				mysql_query($sql);
			}
		}
	}
}
if($_SERVER[HTTP_REFERER]){
	$url=$_SERVER[HTTP_REFERER];
}else{
	$url="http://www.achilles.pl";
}
Header('Location: '.$url);
?>