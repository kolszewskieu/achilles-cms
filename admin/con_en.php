<?
exit;
// baza
$serwer = "localhost:3306";
$user = "uszlachetnia_4";
$password = "Nat33ail";
$dbase = "uszlachetnia_3";

// polaczenie do bazy
$link_new = mysql_connect($serwer, $user, $password);
	if (!$link_new) {
		die('Nie można się połączyć z bazą: ' . mysql_error());
	}
	if(!mysql_select_db($dbase, $link_new)){
		echo mysql_error();
	}
mysql_set_charset('utf8');

$sql="select * from produkty_en";
$res=mysql_query($sql,$link_new);
while($row=mysql_fetch_array($res)){
	$zdjecia_arr=explode(",",$row[zdjecia]);
	$zdjecia_arr_n=array();
	foreach($zdjecia_arr as $key => $val){
		if($val)$zdjecia_arr_n[]=$val;
	}
	$_ACT_PROD[$row[id]][zdjecia]=$zdjecia_arr_n;
}

$link_old = mysql_connect('sql.uszlachetnia.nazwa.pl:3307', 'uszlachetnia_2', 'AchillesStara123');
if (!$link_old) {
	die('Nie można się połączyć z bazą: ' . mysql_error());
}
if(!mysql_select_db('uszlachetnia_2', $link_old)){
	echo mysql_error();
}
mysql_set_charset('utf8');

foreach($_ACT_PROD as $key => $val){
	foreach($val[zdjecia] as $zkey => $zval){
		$title="";
		$summary="";
		$sql_old="SELECT title,summary FROM document_en WHERE thumbnail_id='$zval'";
		$res=mysql_query($sql_old,$link_old);
		list($title,$summary)=mysql_fetch_row($res);
		if($title || $summary){
			echo $title.",".$summary." -> actual ".$key."<br>";
			$sql="UPDATE produkty_en SET nazwa='$title', opis='$summary' WHERE id='$key'";
			//echo " -> ".$sql."<br>";
			mysql_query($sql,$link_new);
		}
	}

}