<?
if($_SERVER[SCRIPT_NAME]!="/admin/index.php"){
	Header("Location: /admin/?site=".str_replace(array("/admin/",".php"),"",$_SERVER[SCRIPT_NAME]));
	//echo "<hr>".str_replace(array("/admin/",".php"),"",$_SERVER[SCRIPT_NAME]);
}
include('samples/Header.php');
//require_once 'PhpWord/Autoloader.php';
//\PhpOffice\PhpWord\Autoloader::register();
// baza
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


// wczytuje ceny z bazy
$sql="SELECT * FROM ceny_stale";
$res=mysql_query($sql);
while($dane=mysql_fetch_array($res)){
	if($dane[material]=="tektura"){
		//$_CONF["cena_tektura_tona"]=$dane[cena];
		//$_CONF["waluta_tektura_tona"]=$dane[waluta];
		$_CONF["cena_tektura_tona"]["$dane[typ]"]=$dane[cena];
		$_CONF["waluta_tektura_tona"]["$dane[typ]"]=$dane[waluta];
	}
	if($dane[material]=="papier"){
		//$_CONF["cena_papier_tona"]=$dane[cena];
		//$_CONF["waluta_papier_tona"]=$dane[waluta];
		$_CONF["cena_papier_tona"]["$dane[typ]"]=$dane[cena];
		$_CONF["waluta_papier_tona"]["$dane[typ]"]=$dane[waluta];
	}
}

// wczytuje kursy z bazy
$sql="SELECT * FROM kursy";
$res=mysql_query($sql);
while($dane=mysql_fetch_array($res)){
	$_KURS_CONF[$dane[waluta]]=$dane[kurs];
}
$_KURS_CONF["eur/pln"]=round(1/$_KURS_CONF["pln/eur"],2);
$_KURS_CONF["usd/pln"]=round(1/$_KURS_CONF["pln/usd"],2);
$_KURS_CONF["usd/eur"]=round(1/$_KURS_CONF["eur/usd"],2);
$_KURS_CONF["pln/pln"]="1";
$_KURS_CONF["eur/eur"]="1";

//print_r($_KURS_CONF);


$_CONF_LISTA[1]="Tektura";
$_CONF_LISTA[2]="Papier oklejka";
$_CONF_LISTA[3]="Papier wklejka";
$_CONF_LISTA[4]="Druk oklejka";
$_CONF_LISTA[5]="Druk wklejka";
$_CONF_LISTA[6]="Folia oklejka";
$_CONF_LISTA[7]="Folia wklejka";
$_CONF_LISTA[8]="Lakierowanie oklejka";
$_CONF_LISTA[9]="Lakierowanie wklejka";
$_CONF_LISTA[10]="Mechanizmy";
//$_CONF_LISTA[11]="Tektura";
//$_CONF_LISTA[12]="Tektura";
$_CONF_LISTA[100]="Nity";

function select_typ($name="typ",$no_show="",$auto="1",$select_start="0"){
	//if(!$name)$name="typ";
	?>
	<select name="<?=$name;?>" 
	<?if($auto==1){?> onChange="document.forms['wycena'].submit()"<?}?>	>
	<?
	if($select_start==1){
		echo "<option value='' ";
			if($_GET[typ]==""){echo " selected ";}
			echo " value=''>--- wybierz ----</option>";
	}
	
	//$sql="SELECT DISTINCT typ FROM format_tektura WHERE del='0' ORDER BY typ";
	$sql="SELECT id as typ,nazwa,nazwa_en,nazwa_de FROM produkty WHERE del='0'";
	if($no_show)$sql.=" AND id!='".$no_show."'";
	$res=mysql_query($sql);
		while($dane=mysql_fetch_array($res)){
			if(!$_GET[typ]){
				if($_SESSION['typ_wycena']){
					$_GET[typ]=$_SESSION['typ_wycena'];
				}else{
					$_GET[typ]=$dane[typ];
				}
			}
			echo "<option ";
			if($_GET[typ]==$dane[typ]){echo " selected ";}
			echo " value='".$dane[typ]."'>".$dane[nazwa]." (".$dane[nazwa_en].",".$dane[nazwa_de].")</option>";
		}
	?>
	</select>
<?
}

function select_drukarnie($name="typ",$no_show="",$auto="1",$select_start="0"){
    //if(!$name)$name="typ";
    ?>
    <select name="<?=$name;?>" 
    <?if($auto==1){?> onChange="document.forms['wycena'].submit()"<?}?> >
    <?
    if($select_start==1){
        echo "<option value='' ";
            if($_GET[typ]==""){echo " selected ";}
            echo " value=''>--- wybierz ----</option>";
    }
    
    //$sql="SELECT DISTINCT typ FROM format_tektura WHERE del='0' ORDER BY typ";
    $sql="SELECT id, name, local FROM drukarnie WHERE del='0'";
    if($no_show)$sql.=" AND id!='".$no_show."'";
    $res=mysql_query($sql);
        while($dane=mysql_fetch_array($res)){
            if(!$_GET[typ]){
                if($_SESSION['typ_wycena']){
                    $_GET[typ]=$_SESSION['typ_wycena'];
                }else{
                    $_GET[typ]=$dane[typ];
                }
            }
            echo "<option ";
            if($_GET[typ]==$dane[id]){echo " selected ";}
            echo " value='".$dane[id]."'>".$dane[name]." (".!$dane[local]." )</option>";
        }
    ?>
    </select>
<?
}

function calculate_transport($quantity="0"){
$transport = 200;
$transport = ($quantity >= 2500) ? 400 : $transport;
$transport = ($quantity >= 5000) ? 600 : $transport;
$transport = ($quantity >= 7000) ? 800 : $transport;
$transport = ($quantity >= 9000) ? 1000 : $transport;
return $transport;
}
/**
 * Kalkulacja Kosztu druku - standard
 */
function calculate_print($print_type, $sheetsize, $sheets, $printhouse){
    $sql="SELECT id_printhouse, print_type, sheetsize, price_range, price, currency, name, local, standard FROM druk_zakres JOIN drukarnie ON id_printhouse = drukarnie.id ";
    //$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
    $sql.="WHERE print_type='$print_type' AND ";
    $sql.="sheetsize ='$sheetsize' AND id_printhouse='$printhouse' AND ";
    $sql.="$sheets<=price_range ORDER BY price_range";
    //$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
    $sql.=" LIMIT 0,1";
    $result=list($id, $print_type, $sheetsize, $price_range, $price, $currency, $name, $local, $standard)=mysql_fetch_row(mysql_query($sql));
    $cost = $price*$sheets;
    return array('print_type' => $print_type, 'name' => $name, 'cost'=>$cost, 'currency'=>$currency);
}

/**
 * Kalkulacja Kosztu druku - niestandardowo
 */
function calculate_toolprint($print_type, $sheetsize, $sheets, $printhouse){
    $sql="SELECT id_printhouse, print_type, sheetsize, price_range, base_price, base_include, add_price, currency, name, local, standard FROM druk_narzedzie JOIN drukarnie ON id_printhouse = drukarnie.id ";
    //$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
    $sql.="WHERE print_type='$print_type' AND ";
    $sql.="sheetsize ='$sheetsize' AND id_printhouse='$printhouse' AND ";
    $sql.="$sheets<=price_range ORDER BY price_range";
    //$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
    $sql.=" LIMIT 0,1";
    $result=list($id, $print_type, $sheetsize, $price_range, $base_price, $base_include, $add_price, $currency, $name, $local, $standard)=mysql_fetch_row(mysql_query($sql));
    
    $cost = $base_price + ($sheets -$base_include) * $add_price;
    //$cost = number_format($price*$sheets, 3);
    return array('print_type' => $print_type, 'name' => $name, 'cost'=>$cost, 'currency'=>$currency);
}

function calculate_suggested_price($sum_pl, $sum_eur, $eur){
    $result=array();
    $sql="SELECT cena as cena_sugerowana, percent, markup FROM cena_sugerowana WHERE 
          (szt_od<$_GET[liczba] AND szt_do>$_GET[liczba]) OR (szt_od<$_GET[liczba] AND szt_do=0)
          AND typ='$_GET[typ]'";
    
    list($cena_sugerowana, $percent, $markup_rate)=mysql_fetch_row(mysql_query($sql));
    if ($percent==1){
        $markup_pl = $sum_pl*$cena_sugerowana/100;
        $markup_eur = $sum_eur*$cena_sugerowana/100;
        if ($markup_pl<$markup_rate){
        $markup_pl =$markup_rate;
        $markup_eur = $markup_rate*$eur;
        }
        $result[0] = $sum_pl+$markup_pl;
        $result[1] = $sum_eur+$markup_eur;
    } else {
        $result[0] = $sum_pl*$cena_sugerowana;
        $result[1] = $sum_eur*$cena_sugerowana;
    }
    
    return $result;
}

function calculate_binders_transport($boxes){
    $result = ceil($boxes/20) * 100;
    return $result;
}
function copy_in_table($table,$typ_from,$typ_to,$id_copy=array()){
	global $alert, $alert_ok;
	$sql="SELECT * FROM $table WHERE typ=$typ_from";
	if($id_copy){
		$sql.=" AND id IN (".implode(",",$id_copy).")";
	}
	$res=mysql_query($sql);
		while($dane=mysql_fetch_assoc($res)){
			$copy_from[$dane[id]]=$dane;
		}
	foreach($copy_from as $key => $val){
		$sql_in="INSERT INTO ".$table." ";
		$sql_values="";
		$sql_var="";
		$i=0;
		foreach($val as $inkey => $inval){
			if($inkey!="id" && $inkey!="typ"){
				if($i>0){
					$sql_values.=",";
					$sql_var.=",";
				}
				$sql_values.="".$inkey."";
				$sql_var.="'".$inval."'";
				$i++;
			}
		}
		$sql_values.=",typ";
		$sql_var.=",'".$typ_to."'";
		$sql_in.="(".$sql_values.") VALUES (".$sql_var.");";
		//echo $sql_in."<br>";
		if(!mysql_query($sql_in)){
			$alert.="Kopiowanie $tabela nie powiodło się <br/>".mysql_error();
		}else{
			$ok=1;
		}
	}
	if($ok==1){
		$alert_ok.="Kopiowanie w tabeli $tabela powiodło się.";
	}
}

function select_typ_folie(){
	?>
	<select name="typ_folie" onChange="document.forms['wycena'].submit()">
	<?
	//$sql="SELECT DISTINCT typ FROM format_tektura WHERE del='0' ORDER BY typ";
	$sql="SELECT id as typ,nazwa,nazwa_en,nazwa_de FROM folie WHERE del='0'";
	$res=mysql_query($sql);
		while($dane=mysql_fetch_array($res)){
			if(!$_GET[typ_folie])$_GET[typ_folie]=$dane[typ];
			echo "<option ";
			if($_GET[typ_folie]==$dane[typ]){echo " selected ";}
			echo " value='".$dane[typ]."'>".$dane[nazwa]." (".$dane[nazwa_en].",".$dane[nazwa_de].")</option>";
		}
	?>
	</select>
<?
}

include("wyceny_lang.php");
function SL($t,$lang){
	global $_TRAN;
	
	if(!$lang)$lang="_pl";
	echo $_TRAN[$lang][$t];
}

//aktualizacja walut
	$sql="SELECT  waluta FROM kursy WHERE aktualizacja < '".date("Y-m-d")." 00:00:00' ";
	$res=mysql_query($sql);
	$ile=mysql_num_rows($res);
	if($ile>0){
		$url = 'http://www.nbp.pl/kursy/xml/LastA.xml';
		$xml = @simplexml_load_file($url);
		$count = count($xml->pozycja);
		for ($i = 0; $i < $count;  $i++){
			$kod_waluty=$xml->pozycja[$i]->kod_waluty;
			if($kod_waluty == "EUR"){
				$kurs_sredni=round(str_replace(",",".",$xml->pozycja[$i]->kurs_sredni),2);
				$przelicznik=$xml->pozycja[$i]->przelicznik;
				$kurs=$kurs_sredni/$przelicznik;
				$_KURS_NBP["pln/eur"]=$kurs;
			}	
			if($kod_waluty == "USD"){
				$kurs_sredni=round(str_replace(",",".",$xml->pozycja[$i]->kurs_sredni),2);
				$przelicznik=$xml->pozycja[$i]->przelicznik;
				$kurs=$kurs_sredni/$przelicznik;
				$_KURS_NBP["pln/usd"]=$kurs;
			}
		}
		$_KURS_NBP["eur/usd"]=round($_KURS_NBP["pln/usd"]/$_KURS_NBP["pln/eur"],2);
		$_KURS_NBP["usd/eur"]=round($_KURS_NBP["pln/eur"]/$_KURS_NBP["pln/usd"],2);
		foreach($_KURS_NBP as $key => $val){
			if($val>0){
				$sql="UPDATE kursy SET ";
				$sql.="kurs='$val',aktualizacja='".date("Y-m-d H:i:s")."' ";
				$sql.=" WHERE waluta='$key'";
				if(!mysql_query($sql)){
					$alert="Aktualizacja kursu $key nie powiodła się <br/>".mysql_error()."<br/>".$sql;
				}else{
					$alert_ok.="<br/>Kurs $key zaktualizowany.";
				}
			}else{
				$alert="Pobranie kursu $key nie powiodło się <br/>".mysql_error()."<br/>".$sql;
			}
		}
	}
/*
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
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.23.custom.css">
	<link rel="stylesheet" href="../css/ui.selectmenu.css">
  
	<script src="../js/libs/modernizr-2.5.3.min.js"></script>
	<script src="../js/libs/jquery-1.7.1.min.js"></script>
	<script src="../js/libs/jquery-ui-1.8.23.custom.min.js"></script>
	<script src="../js/libs/jquery-tinyscrollbar.js"></script>
	<script src="../js/libs/ui.selectmenu.js"></script>
	<script src="../js/script.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Achilles wyceny</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
            </p>
            <!--ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
*/
?>
