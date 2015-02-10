<? 
function getTime()

{

$a = explode (' ',microtime());

return(double) $a[0] + $a[1];

}

$Start = getTime();

include "../conf.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Achilles CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">	
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
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
      <div class="row-fluid">
        <div class="span12">
<?

if ($_GET[site] != 'pokaz') {

$site = '';

// pobieram, ktore dla danej kategorii sa juz wybrane

$sql = "SELECT zdjecia FROM `kategorie_$cmslang` WHERE `id` = ".$kategoria;
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$aktualne = $row[0];
$tab = explode(',', $aktualne);

$dir = opendir('../img/tmp');
$count_foto = 0;
while(false !== ($file = readdir($dir))) {
	if($file != '.' && $file != '..') {  		
		$count_foto++;
	}
}
 
// ustawiamy ile ma być wyników na 1 strone
$per_page = 300;
 
// obliczamy ilość stron
$pages = ceil($count_foto / $per_page);
 
// aktualna strona - jeśli nie została podana to = 1
// jeśli została podana to filtrujemy ją i rzutujemy na int
$current_page = !isset($_GET['page']) ? 1 : (int)Czysc($_GET['page']);
 
// jeśli ktoś poda stronę mniejszą niż 1 lub większą niż ilość stron to zmieniamy ją na 1
if($current_page < 1 || $current_page > $pages) {
    $current_page = 1;
}
 
// jeśli jest chociaż 1 rekord to wyświetlamy
if($count_foto > 0) {	
	
	echo '<form method="post" action="zdjecia_kategorie.php?site=pokaz&kategoria='.$kategoria.'">';
	echo 'Count: '.$count_foto.'.</div>';
		
	$a = glob('../img/tmp/*.png', GLOB_BRACE);
	for ($it = 0; $it < $count_foto;  $it++) {
		$foto = str_replace("../img/tmp/", "", $a[$it]);
		$foto = str_replace(".png", "", $foto);
		$sel = '';
		$styl = '';		
		for( $iz = 0, $cnt = count($tab); $iz < $cnt; $iz++ ) {  // od 1 numeruje, 0 to foto na glowna, nieedytowalne tu
			if ($tab[$iz] == $foto) { 
				$sel = ' checked';
				$styl = 'background-color:#f44f4f;';							
			}
		}
		echo'<div style="float:left;min-height:250px;padding:1px;'.$styl.'"><h6>'.$foto.'</h6><img class="img-polaroid" width="150" src="'.$a[$it].'" alt="'.$foto.'"><br/><input type="checkbox" name="zdjecia[]" id="zdjecia[]" value="'.$foto.'"'.$sel.'> Insert </div>';	
	}
	
	echo '<input type="submit" value="Save" class="btn btn-block btn-primary"></form>';
} else {
    // jeśli nie ma w ogóle to wyświetlamy komunikat
    echo '<h4>No rekords founded.</h4>';
}


// wyświetlamy stronicowanie
/*if($pages > 0) { 
    echo '<div class="row-fluid"><div class="span12"><div class="pagination pagination-centered"><ul>';
    if($pages < 11) {
        for($i = 1; $i <= $pages; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a> ';
            } else {
                echo '<li><a href="zdjecia.php?page='.$i.'&kategoria='.$kategoria.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="kategorie.php?page=1&kategoria='.$kategoria.'">1</a></li> ';
        echo '<li><a href="kategorie.php?page=2&kategoria='.$kategoria.'">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="zdjecia.php?page='.$i.'&kategoria='.$kategoria.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="zdjecia.php?page='.$i.'&kategoria='.$kategoria.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="zdjecia.php?page='.($pages-1).'&kategoria='.$kategoria.'">'.($pages-1).'</a></li> ';
            echo '<li><a href="zdjecia.php?page='.$pages.'&kategoria='.$kategoria.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="zdjecia.php?page='.$pages.'&kategoria='.$kategoria.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="zdjecia.php?page='.$i.'&kategoria='.$kategoria.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="zdjecia.php?page='.($pages-1).'&kategoria='.$kategoria.'">'.($pages-1).'</a></li> ';
            echo '<li><a href="zdjecia.php?page='.$pages.'&kategoria='.$kategoria.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="zdjecia.php?page=12&kategoria='.$kategoria.'">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}*/

} else {

for($i = 0; $i < count($_POST[zdjecia]); $i++) { 
	$zdjecia .= $_POST[zdjecia][$i].','; 
}
$zdjecia = rtrim($zdjecia, ',');
$sql = "UPDATE `kategorie_$cmslang` SET `zdjecia` = '$zdjecia' WHERE `id` = ".$kategoria;
echo 'Ready.';
$result = mysql_query($sql);
echo '<a href="javascript:window.close();" class="btn btn-block btn-primary">Close</a>';
}


?>
</div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Achilles <? echo date("Y"); ?></p>
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
<?php

//ob_end_flush();

$End = getTime();

echo "Czas = ".number_format(($End - $Start),2)." secs";

?>