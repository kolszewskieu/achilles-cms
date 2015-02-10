<?php

$serwer = "localhost:3306";
$user = "uszlachetnia_4";
$password = "Nat33ail";
$dbase = "uszlachetnia_4";
// polaczenie do bazy
$link = mysql_connect($serwer, $user, $password);
    if (!$link) {
        die('Nie można się połączyć z bazą: ' . mysql_error());
    }
    if(!mysql_select_db($dbase, $link)){
        echo mysql_error();
    }
mysql_set_charset('utf8');

if($_POST['id'])
{
$id=mysql_real_escape_string($_POST['id']);
$delete = "DELETE FROM files WHERE id='$id'";
mysql_query($delete);
}
?>