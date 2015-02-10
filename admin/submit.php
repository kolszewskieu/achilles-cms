<?php // You need to add server side validation and better error handling here
// baza
$serwer = "localhost:3306";
$user = "uszlachetnia_4";
$password = "Nat33ail";
$dbase = "uszlachetnia_4";

array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
); 
//$_DIR_IMG="/home/chroot/webmaster/site_new/img/".$cmslang;

// polaczenie do bazy
$link = mysql_connect($serwer, $user, $password);
    if (!$link) {
        die('Nie można się połączyć z bazą: ' . mysql_error());
    }
    if(!mysql_select_db($dbase, $link)){
        echo mysql_error();
    }
mysql_set_charset('utf8');

function storefile($file) {
  
    $sql = "INSERT INTO files (name, size, type, id_calculation) VALUES ('{$file['name']}', '{$file['size']}', '{$file['type']}', '".$_GET[wycena_id]."')";
    if(mysql_query($sql)) 
        return true;
    else 
    return false;
}
$data = array();
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        die();
    }
if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

	$uploaddir = './uploads/';
	foreach($_FILES as $file)
	{
		if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
		{
			$files[] = $uploaddir .$file['name'];
            if (!storefile($file)) {
                $err = mysql_error();
                $error = true;
                }
		}
		else
		{
		    $err = $file['error'];
		    $error = true;
		}
	}
	$data = ($error) ? array('error' => $err) : array('files' => $files);
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);

?>