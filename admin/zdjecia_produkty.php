<? 
include "../conf.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Achilles CMS - migration images</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">	
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
	

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.23.custom.css">
	<link rel="stylesheet" href="../css/ui.selectmenu.css">
  
	<script src="../js/libs/modernizr-2.5.3.min.js"></script>
	<script src="../js/libs/jquery-1.7.1.min.js"></script>
	<script src="../js/libs/jquery-ui-1.8.23.custom.min.js"></script>
	<script src="../js/libs/jquery-tinyscrollbar.js"></script>
	<script src="../js/libs/ui.selectmenu.js"></script>
	<!--<script src="../js/script.js"></script>-->
	<link href="css/bootstrap.css" rel="stylesheet">	

  </head>

  <body>
  <div class="container-fluid">
<?
CzyZalogowanyAdmin();

if($_GET[produkt]){$id=$_GET[produkt];$tab="produkty";}
if($_GET[kategoria]){$id=$_GET[kategoria];$tab="kategorie";}

if($_GET[add]){
	$zdjecia_new=str_replace(".png","",$_GET[add]);
	$sql = "SELECT zdjecia FROM `".$tab."_".$cmslang."` WHERE `id` = ".$id." AND zdjecia NOT LIKE '%,$zdjecia_new,%'";
	$result = mysql_query($sql);
	list($zdjecia) = mysql_fetch_row($result);
	if($zdjecia){$zdjecia_add=$zdjecia.$zdjecia_new.",";
	}else{
		$zdjecia_add=",".$zdjecia_new.",";
	}
	$sql="UPDATE ".$tab."_".$cmslang." SET zdjecia='$zdjecia_add' WHERE id = ".$id;
	if(mysql_query($sql)){
	?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>File added successfully!</strong>
		</div>
	<?
	}else{
	?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>Problem with adding file</strong>
		</div>
	<?
	}
}

if($_GET[disconect]){
	$zdjecia_new=str_replace(".png","",$_GET[disconect]);
	$sql = "SELECT zdjecia FROM `".$tab."_".$cmslang."` WHERE `id` = ".$id." AND zdjecia LIKE '%,$zdjecia_new,%'";
	$result = mysql_query($sql);
	list($zdjecia) = mysql_fetch_row($result);
	if($zdjecia){
		$zdjecia_add=str_replace(",".$zdjecia_new.",",",",$zdjecia);
		if($zdjecia_add==",")$zdjecia_add="";
		$sql="UPDATE ".$tab."_".$cmslang." SET zdjecia='$zdjecia_add' WHERE id = ".$id;
		if(mysql_query($sql)){
		?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>File disconect successfully!</strong>
			</div>
		<?
		}else{
		?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Problem with disconecting file</strong>
			</div>
		<?
		}
	}
}


include('photo_gallery.php');

// pobieram, ktore dla danej kategorii sa juz wybrane
if($_GET[produkt]){
	$sql = "SELECT nazwa,zdjecia FROM `produkty_".$cmslang."` WHERE `id` = ".$_GET[produkt];
	echo "<h3>Files for product: ";
	$type_action_a=array("del_from_product");
	$type_action_b=array("add_to_product");
}
if($_GET[kategoria]){
	$sql = "SELECT nazwa,zdjecia FROM `kategorie_".$cmslang."` WHERE `id` = ".$_GET[kategoria];
	echo "<h3>Files for category: ";
	$type_action_a=array("del_from_category");
	$type_action_b=array("add_to_category");
}
$result = mysql_query($sql);
list($nazwa,$zdjecia) = mysql_fetch_row($result);
$tab = explode(',', $zdjecia);
$tab_prod=array();
foreach($tab as $key => $val){
	if($val){
		$tab_prod[]=$val.".png";
	}
}
foreach (glob($_DIR_IMG."/*.png") as $filename){
	if(!in_array(basename($filename),$tab_prod)){
		$files_list[filectime($filename)."_".$filename]=basename($filename); // or just $filename
	}
}
krsort($files_list);
$count_foto=count($files_list);

?>
<?=$nazwa?></h3>
<div class="row-fluid">
	<?show_photos($tab_prod,"file_prod_page",$_GET[file_prod_page],"6",$type_action_a);?>
</div>

<h3>Other files (<?=$count_foto?>)</h3>
<div class="row-fluid">
	<?show_photos($files_list,"file_page",$_GET[file_page],"30",$type_action_b);?>
</div>
<hr>
<footer>
<p>&copy; Company 2012</p>
</footer>

</div><!--/.fluid-container-->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>

</body>
</html>