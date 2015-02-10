<?php
include "../conf.php";
if($_GET[typ]){
	$_SESSION['typ_wycena']=$_GET[typ];
}
?>
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
	
	<link rel="stylesheet" href="../css/style.css" <?if($_GET['print']){?>media="print"<?}?> >
	<link rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.23.custom.css">
	<link rel="stylesheet" href="../css/ui.selectmenu.css">
  
	<script src="../js/libs/modernizr-2.5.3.min.js"></script>
	<script src="../js/libs/jquery-1.7.1.min.js"></script>
	<script src="../js/libs/jquery-ui-1.8.23.custom.min.js"></script>
	<script src="../js/libs/jquery-tinyscrollbar.js"></script>
	<!-- <script src="../js/libs/ui.selectmenu.js"></script> -->
	<script src="../js/script.js"></script>
	<script src="js/upload.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">	
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/printmedia.css" media="print">
    
    <style type="text/css">
      body {
        padding-top: 30px;
        padding-bottom: 40px;
		padding-left: 10px;
		padding-right: 10px;
		font-size: 12px;
		<?if($_GET['print']){?>
			font-size: 11px;
			width: 800px;
		<?}?>
      }
      .sidebar-nav {
        padding: 9px 0;
      }
     
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    td    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }

    </style>
  </head>

  <body>
<? 	
	if ($_GET[site] == 'wyloguj') {
		$_SESSION['logged'] = false;
		$_SESSION['admin'] = false;
		$_SESSION['pricing']=false;
		$_SESSION['cmslang'] = false;
		$_SESSION['imie'] = false;
		$_SESSION['user_id'] = -1;
		$_SESSION[] = array();
	}	
if(!$_GET['print']){
?>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">         
          <a class="brand" href="/admin/">Achilles</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
            <? if ($_SESSION['admin']) { ?>
              User: <a href="#" class="navbar-link"><? echo $_SESSION['imie']; ?></a> / <a href="/admin/index.php?site=wyloguj" class="navbar-link">Log out</a>
            <? } ?>
            </p>
			<?
			if($_SESSION[admin] != 'not' && $_SESSION[admin]){
				?>
				<ul class="nav">
				<?
				$lang_cms = explode(',', $_SESSION['admin']);         
				foreach ($lang_cms as $value)       {    	
				?>
				  <li>
					<a href="/admin/?cmslang=<? echo $value; ?>">
					<img src="/img/flags/<? echo $value; ?>.png" width="25" class="img-rounded"/>
					</a>
				  </li>
				 <? }?>              
				</ul>
			<?}?>
          </div><!--/.nav-collapse --><? 
if (($_GET[site] == 'zaloguj') || ($_GET[site] == 'wyloguj')) {
	echo '</div>
      </div>
    </div>';
	include "zaloguj.php";
} else {
	CzyZalogowanyAdmin();
	$sql = "SELECT count(id) FROM `uzytkownicy` WHERE (`aktywne` = 'no' AND `jezyk` IN ('$in'))"; //zlicze ile nieaktywnych userow
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$count_active = $row[0];
	?>
	<ul class="nav">
	<?
	if($_SESSION[admin] != 'not'){
		?>
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		Editing <img src="/img/flags/<? echo $cmslang; ?>.png" width="20" />
		<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li <? if ($_GET[site]=='kategorie') echo 'class="active"'?>><a href="index.php?site=kategorie&page=1">Categories</a></li>
			<li <? if ($_GET[site]=='branze') echo 'class="active"'?>><a href="index.php?site=branze&page=1">Trades</a></li>
			<li <? if ($_GET[site]=='cechy') echo 'class="active"'?>><a href="index.php?site=cechy&page=1">Features</a></li>
			<li <? if ($_GET[site]=='produkty') echo 'class="active"'?>><a href="index.php?site=produkty&page=1">Products</a></li>
			<?//if($_SESSION[user_id]=="2" || $_SESSION[user_id]=="90"){?>
			<li <? if ($_GET[site]=='seo_tags') echo 'class="active"'?>><a href="index.php?site=seo_tags&page=1">SEO Tags</a></li>
			<?//}?>
		</ul>
		</li>
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		Adding <img src="/img/flags/<? echo $cmslang; ?>.png" width="20"/>
		<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li <? if ($_GET[site]=='dodaj_produkt') echo 'class="active"'?>><a href="index.php?site=dodaj_produkt">Add product</a></li>
			<li <? if ($_GET[site]=='dodaj_kategorie') echo 'class="active"'?>><a href="index.php?site=dodaj_kategorie">Add category</a></li>
			<li <? if ($_GET[site]=='dodaj_branze') echo 'class="active"'?>><a href="index.php?site=dodaj_branze">Add trade</a></li>
			<li <? if ($_GET[site]=='dodaj_ceche') echo 'class="active"'?>><a href="index.php?site=dodaj_ceche">Add feature</a></li>
			<li <? if ($_GET[site]=='dodaj_zdjecie') echo 'class="active"'?>><a href="index.php?site=dodaj_zdjecie">Add photo</a></li>        
		</ul>
		</li>    
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		Users
		<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li <? if ($_GET[site]=='userzy') echo 'class="active"'?>><a href="index.php?site=userzy&page=1">Edit users</a></li>
			<li <? if ($_GET[site]=='aktywacja') echo 'class="active"'?>><a href="index.php?site=aktywacja">Activate users <? if ($count_active != '0') echo '('.$count_active.')';?></a></li>  
		</ul>
		</li>
	<?}?>
		<?
	if($_SESSION[pricing] == 'full' || $_SESSION[pricing] == 'yes'){?>
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Pricing<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li <? if ($_GET[site]=='pricing' && $_GET[action]=='new') echo 'class="active"'?>><a href="index.php?site=pricing&action=new">New Pricing</a></li>
			<li <? if ($_GET[site]=='pricing_box') echo 'class="active"'?>><a href="index.php?site=pricing_box">New Pricing Box</a></li>
			<li <? if ($_GET[site]=='pricing_cbox') echo 'class="active"'?>><a href="index.php?site=pricing_cbox">New Pricing CBox</a></li>
			<li <? if ($_GET[site]=='pricing_list' && $_GET[action]=='list') echo 'class="active"'?>><a href="index.php?site=pricing_list&action=list">Pricing List</a></li>  
		</ul>
		</li>
	<?}?>
	<?
	if($_SESSION[pricing] == 'full'){?>
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		Pricing Config
		<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
		<?
		$_MENU_SLOWNIKI=array(
		"?site=wyceny_produkty"=>"Produkty",
		"?site=wyceny_formaty"=>"Formaty tektury",
		"?site=wyceny_formaty_oklejka"=>"Formaty oklejka",
		"?site=wyceny_formaty_wklejka"=>"Formaty wklejka",
		"?site=wyceny_folie"=>"Typy folii",
		"?site=wyceny_folia_oklejka"=>"Folia oklejka",
		"?site=wyceny_folia_wklejka"=>"Folia wklejka",
		"?site=wyceny_lakierowanie"=>"Lakierowanie",
		"?site=wyceny_druk_oklejka"=>"Druk oklejka",
		"?site=wyceny_druk_wklejka"=>"Druk wklejka",
		"?site=wyceny_mechanizmy"=>"Mechanizmy",
		"?site=wyceny_elementy"=>"Elementy stałe",
		"?site=wyceny_dodatki"=>"Dodatkowe elementy",
		"?site=wyceny_odpady"=>"Odpady",
		"?site=wyceny_konfiguracja"=>"Konfiguracja",
        "?site=wyceny_druk_arkusze"=>"Ceny Druku");
		$file=str_replace("/admin/","",$_SERVER[PHP_SELF]);
		
		foreach($_MENU_SLOWNIKI as $key => $val){
		?>
			<li <? if ("?site=".$_GET[site] == $key) echo 'class="active"'?>><a href="<?=$key?>"><?=$val?></a></li>
		<?}?>
		</ul>
		</li>
	<?}?>
    </ul>
	</div>
    </div>
    </div>
<?}?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">		
		  <div class="row-fluid">
            <div class="span12">
<? 
}
	switch ($_GET[site]) {		
		case "kategorie":		
			echo '<h3>Categories - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "kategorie.php";
		  	break;
		case "subkategorie":		
			echo '<h3>Sub Categories - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "subkategorie.php";
		  	break;
		case "branze":
			echo '<h3>Trades - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "branze.php";
			break;
		case "cechy":
			echo '<h3>Features - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "cechy.php";
			break;
		case "produkty":			
			echo '<h3>Products - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "produkty.php";
			break;
		case "seo_tags":			
			echo '<h3>SEO Tags - page: '.$page.'</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "seo_tags.php";
			break;
		case "dodaj_produkt":
			echo '<h3>Add product</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "dodaj_produkt.php";
			break;
		case "dodaj_kategorie":
			echo '<h3>Add category</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "dodaj_kategorie.php";
			break;
		case "dodaj_branze":
			echo '<h3>Add trade</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "dodaj_branze.php";
			break;
		case "dodaj_ceche":
			echo '<h3>Add feature</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "dodaj_ceche.php";
			break;
		case "dodaj_zdjecie":
			echo '<h3>Add photo</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "dodaj_zdjecie.php";
			break;
		case "userzy":
			echo '<h3>Users</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "uzytkownicy.php";
			break;
		case "aktywacja":
			echo '<h3>Inactive users</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "aktywuj_uzytkownikow.php";
			break;
		case "gallery":
			echo '<h3>Photo Gallery</h3>
				</div><!--/span-->
				</div><!--/row-->';
			include "photo_gallery.php";
			break;
		case "pricing":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny.php";
			break;
		case "pricing_box":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_pudelka.php";
			break;
		case "pricing_cbox":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_cbox.php";
			break;
		case "wyceny_tektura":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_tektura.php";
			break;
		case "pricing_list":
			echo '</div><!--/span-->
				</div><!--/row-->';
			$sql="SELECT id,imie,nazwisko FROM uzytkownicy ";
			$result = mysql_query($sql);
			while($row = mysql_fetch_assoc($result)){
				$_USERS_LIST[$row[id]]=$row[imie]." ".$row[nazwisko];
				$_USERS_LIST_IMIE[$row[id]]=$row[imie];
				//." ".substr($row[nazwisko],0,1).".";
			}		
			include "wyceny_lista.php";
			break;
		case "wyceny_produkty":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_produkty.php";
			break;
		case "wyceny_formaty":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_formaty.php";
			break;
		case "wyceny_formaty_oklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_formaty_oklejka.php";
			break;
		case "wyceny_formaty_wklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_formaty_wklejka.php";
			break;
		case "wyceny_folie":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_folie.php";
			break;
		case "wyceny_folia_oklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_folia_oklejka.php";
			break;
		case "wyceny_folia_wklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_folia_wklejka.php";
			break;
		case "wyceny_lakierowanie":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_lakierowanie.php";
			break;
		case "wyceny_druk_oklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_druk_oklejka.php";
			break;
		case "wyceny_druk_wklejka":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_druk_wklejka.php";
			break;
        case "wyceny_druk_arkusze":
            echo '</div><!--/span-->
                </div><!--/row-->';
            include "wyceny_druk_arkusze.php";
            break;
		case "wyceny_mechanizmy":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_mechanizmy.php";
			break;
		case "wyceny_elementy":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_elementy.php";
			break;
		case "wyceny_dodatki":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_dodatki.php";
			break;
		case "wyceny_odpady":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_odpady.php";
			break;
		case "wyceny_konfiguracja":
			echo '</div><!--/span-->
				</div><!--/row-->';
			include "wyceny_konfiguracja.php";
			break;
		default:
			echo '<h1>CMS</h1>';				
			break;
	}
?>
        </div><!--/span-->
      </div><!--/row-->
		
      <hr>

      <footer>
        <p>&copy; Achilles <? echo date("Y"); ?></p>
      </footer>

    </div>
    <!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
 //<!--
   $(document).ready(function(){ 
 
    
   }); 
   function popup(url) 
   {
     window.open(url,'','width=800,height=600,scrollbars=yes,menubar=no');
   }
 //-->
 </script>
  </body>
</html>
<?php

//ob_end_flush();

$End = getTime();

//echo "Czas = ".number_format(($End - $Start),2)." secs";

?>
