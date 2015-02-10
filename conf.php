<?
session_start();
ob_start(); 

error_reporting(0);

/** if($_SERVER[HTTP_HOST]=='achilles.pl' && $_SERVER[HTTP_HOST]!='www2.achilles.pl'){
    header("Location: http://www.achilles.pl");
    //$_GET[lang]="pl";
}
if($_SERVER[HTTP_HOST]=='achilles.pl' && $_SERVER[HTTP_HOST]!='www2.achilles.pl'){
    header("Location: http://www.achilles.pl");
}
if($_SERVER[HTTP_HOST]=='achillesnordic.se'){
    header("Location: http://www.achillesnordic.se");
	$_GET[lang]="se";
}
if($_SERVER[HTTP_HOST]=='no.achillesnordic.se'){
    header("Location: http://norsk.achillesnordic.se");
}
if($_SERVER[HTTP_HOST]=='www.achilles.pl' || $_SERVER[HTTP_HOST]=='www2.achilles.pl')
$_GET[lang]="pl";
if($_SERVER[HTTP_HOST]=='en.achilles.pl')$_GET[lang]="en";
if($_SERVER[HTTP_HOST]=='www.achillesnordic.se')$_GET[lang]="se";
if($_SERVER[HTTP_HOST]=='norsk.achillesnordic.se')$_GET[lang]="no"; **/
$_GET[lang]="pl";
// skrocenie nazw i wyczyszczenie
$kategoria = $_GET[kategoria];
$branza = $_GET[branza];
$produkt = $_GET[produkt];
$action = $_GET[action];
$sort = $_GET[sort];
$id = $_GET[id]; // kategorie
$idb = $_GET[idb]; // branze
$page = $_GET[page];
$site = $_GET[site];
$cecha = $_GET[cecha];
$user = $_GET[user];	

function MakeCase($text) {
	global $page;
	global $text_produkty;
	global $text_prototypy;
	global $text_uszlachetnianie;
	global $text_nasze_realizacje;
	global $text_o_firmie;
	global $text_zapytaj;
	global $text_polityka_prywatnosci;
	global $text_regulamin_serwisu;
	global $text_nasi_klienci;
	global $text_kontakt;
	global $text_nie_pamietam;
	global $text_strefa_klienta;
	$array_lang = array ('en','se','no','pl');
	if($page){
	    foreach ($array_lang as $value) {
	    	if ($page == LadneURLe(${$text}[$value])) {
	    		$_SESSION['lang'] = $value;
	    		$foo = LadneURLe(${$text}[$value]);
	    	}
	    }
	}
	return $foo;
	return $_SESSION['lang'];
}

$case_produkty = MakeCase(text_produkty);
$case_prototypy = MakeCase(text_prototypy);
$case_uszlachetnianie = MakeCase(text_uszlachetnianie);
$case_nasze_realizacje = MakeCase(text_nasze_realizacje);
$case_o_firmie = MakeCase(text_o_firmie);
$case_zapytaj = MakeCase(text_zapytaj);
$case_polityka_prywatnosci = MakeCase($text_polityka_prywatnosci);
$case_regulamin_serwisu = MakeCase($text_regulamin_serwisu);
$case_nasi_klienci = MakeCase($text_nasi_klienci);
$case_kontakt = MakeCase($text_kontakt);
$case_nie_pamietam = MakeCase($text_nie_pamietam);
$case_strefa_klienta = MakeCase($text_strefa_klienta);

// ustawienie jezyka
if (isset($_GET[lang])) {
	$_SESSION['lang'] = $_GET[lang];  // wstaw pobrany jezyk
}
$lang = $_SESSION['lang']; // skrocenie nazwy

// ustawienie jezykow w CMS
//if (isset($_GET[cmslang])) {
	$lang_cms = explode(',', $_SESSION['admin']);
	if (in_array($_GET[cmslang], $lang_cms)) $_SESSION['cmslang'] = $_GET[cmslang];  // wstaw pobrany jezyk jesli ma uprawnienia
	//echo 'l '.$lang_cms[0];
//}
if (!isset($_SESSION['cmslang'])) {  // jak nie wybrany to domyslnie pierwszy z dostepnych
	$lang_cms = explode(',', $_SESSION['admin']);	
	$_SESSION['cmslang'] = $lang_cms[0];
}
$cmslang = $_SESSION['cmslang']; // skrocenie nazwy

// baza
$serwer = "localhost:3306";
$user = "uszlachetnia_4";
$password = "Nat33ail";
$dbase = "uszlachetnia_3";
//$serwer = "localhost";
//$user = "achilles_db";
//$password = "achilles_db_123";
//$dbase = "achilles_new";


//katalog obrazków
$_DIR_IMG="../img/".$cmslang;
//$_DIR_IMG="/home/chroot/webmaster/site_new/img/".$cmslang;

//katalog kart formatowych
$_DIR_CART=$_SERVER[DOCUMENT_ROOT]."/karty_formatowe_".$lang;
$_DIR_CART_WWW="/karty_formatowe_".$lang;

// mail do wysylania zapytan i zamowien
$to = 'k.olszewski@achilles.pl';
$to_admin = 'k.olszewski@achilles.pl';
//$to_admin = 'marketing@achilles.pl';

// polaczenie do bazy
$link = mysql_connect($serwer, $user, $password);
	if (!$link) {
		die('Nie można się połączyć z bazą: ' . mysql_error());
	}
	if(!mysql_select_db($dbase, $link)){
		echo mysql_error();
	}
mysql_set_charset('utf8');
 
// czyszczenie wpisanego tekstu
function Czysc($text) {
	// slashe usuwanie
    if(get_magic_quotes_gpc()) {
        $text = stripslashes($text);
    }						
    $text = trim($text); // usuwanie bialych znakow
    $text = mysql_real_escape_string($text); // sql injection
    $text = htmlspecialchars($text); // usuwanie html
    return $text;
}
 
// koduj haslo
function KodujHaslo($password) {
    //return $password;
	return sha1(md5($password).'#!%Rgd64');
}
// logowanie admina
function CzyZalogowanyAdmin() {
    if(!$_SESSION['admin']) {
		$sourc_url=$_SERVER[REQUEST_URI];
		if(strpos($sourc_url,"pricing") === false){
		    header ('location: /admin/index.php?site=zaloguj&src='.urldecode($sourc_url));
			exit;
		}else{
			header ('location: /admin/index.php?site=zaloguj&src='.urldecode("/admin/index.php?site=pricing_list&action=list"));
			exit;
		}		
    }
}
if(!isset($_SESSION['admin'])) {
	$_SESSION['admin'] = false;	
	$_SESSION['imie'] = false;
	$_SESSION['cmslang'] = false;
}
// do cmsa
//$lang_cms = array ('pl', 'en', 'se', 'no');
// dodac if admin=norwegia $lang_cms = array ('se', 'no');

// funkcja na pobranie danych usera
function PobierzDane($user_id = -1) {
    // jeśli nie podamy id usera to podstawiamy id aktualnie zalogowanego
    if($user_id == -1) {
        $user_id = $_SESSION['user_id'];
    }
    $result = mysql_query("SELECT * FROM `uzytkownicy` WHERE `id` = '{$user_id}' LIMIT 1");
    if(mysql_num_rows($result) == 0) {
        return false;
    }
    return mysql_fetch_assoc($result);
}

// jeśli nie ma jeszcze sesji "logged" i "user_id" to wypełniamy je domyślnymi danymi
if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;	
}

if ($_SESSION['logged']) {
	$_SESSION['logowanie'] = '0,1';			
} else {
	$_SESSION['logowanie'] = '0';
}
	
//wyciecie p-literek i odstepow
	function LadneURLe($string) {
		$in = array('/ą/', '/Ą/', '/ć/', '/Ć/', '/ę/', '/Ę/', '/ł/', '/Ł/', '/ń/', '/Ń/', '/ó/', '/Ó/', '/ś/', '/Ś/', '/ź/', '/Ź/', '/ż/', '/Ż/', '/ø/', '/ö/', '/ä/', '/å/', '/Å/','/Ä/');
		$out = array('a', 'A', 'c', 'C', 'e', 'E', 'l', 'L', 'n', 'N', 'o', 'O', 's', 'S', 'z', 'Z', 'z', 'Z', 'o', 'o', 'a', 'a', 'a');
		$string = preg_replace($in, $out, $string);
		$string = strtr($string, 'ˇ¦¬±¶Ľ','ASZasz');
		$string = preg_replace("'[[:punct:][:space:]]'",'-',$string);
		$string = str_replace('---', '-', $string);
		$string = strtolower($string);
		return $string;
	}

// if (!isset($kategoria) && (($_GET[page]=='home') || ($_GET[page]==''))) { $kategoria = 1; } // wersja z wymuszeniem 1 kategorii tylko na glownej
		
	if (!isset($kategoria)) { // jesli nie wybrana kategoria
		if ($page == (LadneURLe($text_strefa_klienta[$lang]))) { // w strefie klienta
			$kategoria = LadneURLe($text_dane_podstawowe[$lang]);
		} else {// jesli nie wybrana kategoria, to domyslnie 1, chyba ze strona glowna to nic
				$kategoria = 1;				
		}
	}

	if ($_GET[page]!='' && !isset($id))	$id=1; // jesli nie wybrana kategoria, a strona inna niz glowna to id = 1	

// menu kategorii	
	function MenuKategorie ($page = 'home') {
	global $kategoria;
	global $id;	
	global $lang;
	global $text_produkty;	
		$sql = "select id,nazwa from `kategorie_$lang` where widocznosc='yes' ORDER BY prio";		
		$result = mysql_query($sql);
		while ($row_kateg = mysql_fetch_assoc($result)) {			
			if ($row_kateg['id'] == $id) { 
				$class = ' class="selected"'; 
			}					
			//$nazwa = 'nazwa_'.$lang;			
			$nazwa_kategorii = LadneURLe($row_kateg[nazwa]);
			if ($row_kateg['id']==25) $class = ' class="new"';
			//echo '<li><a'.$class.' href="index.php?page='.$page.'&kategoria='.$nazwa_kategorii.'&id='.$row_kateg[id].'">'.$row_kateg[$nazwa].'</a></li>';
			echo '<li><a'.$class.' href="/'.$page.'/'.$nazwa_kategorii.','.$row_kateg[id].'.html">'.$row_kateg[nazwa].'</a></li>';
			$class = '';			
		}
	}
	
// menu branz	
	function MenuBranze ($page = 'prototypy', $id) {
	global $branza;
	global $lang;
	global $kategoria;
	global $nazwa_kategorii;
	global $idb;
		$sql = "SELECT id,nazwa from `branze_$lang` where widocznosc='yes'";		
		$result = mysql_query($sql);
		while ($row_branz = mysql_fetch_assoc($result)) {	
			$sql = "SELECT id FROM produkty_".$lang." WHERE (kategoria='$id' AND branza='$row_branz[id]')";			
			$result2 = mysql_query($sql);
			$row = mysql_num_rows($result2);
			//$nazwa = 'nazwa_'.$lang;
			$nazwa_branzy = LadneURLe($row_branz[nazwa]);			
			if ($row_branz['id'] == $idb) {
				$class = ' selected="selected"';
			}
			if ($row != 0) {
				echo '<option'.$class.' value="/'.$page.'/'.$kategoria.','.$id.'/'.$nazwa_branzy.','.$row_branz[id].'.html">'.$row_branz[nazwa].'</option>';			
				$class = '';
			}
		}
	}
	
// menu w panelu klienta	
	function MenuStrefa () {
	global $kategoria;
	global $lang;
	global $text_dane_podstawowe;
	global $text_dane_adresowe;
	global $text_realizacje;
	global $text_zmien_dane;
	global $text_wyloguj;
	global $text_edytuj;
	global $text_strefa_klienta;
	$text_strefa_klienta[$lang] = LadneURLe($text_strefa_klienta[$lang]);	
	
	echo '<nav class="box tabs staticUrls">
                    <ul>
                        <li>
                            <a ';
	if ($kategoria == (LadneURLe($text_dane_podstawowe[$lang]))) echo 'class="selected" '; 
	echo 'href="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_dane_podstawowe[$lang]).'.html">
                                '.ucfirst($text_dane_podstawowe[$lang]).'
                            </a>
                        </li>                                               
                        <li>
                            <a ';
	if ($kategoria == (LadneURLe($text_dane_adresowe[$lang]))) echo 'class="selected" '; 
	echo 'href="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_dane_adresowe[$lang]).'.html">
                                '.ucfirst($text_dane_adresowe[$lang]).'
                            </a>
                        </li>
						<!--li>
                            <a ';
	if ($kategoria == (LadneURLe($text_realizacje[$lang])))  echo 'class="selected" '; 
	echo 'href="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_realizacje[$lang]).'.html">
                                '.ucfirst($text_realizacje[$lang]).'
                            </a>
                        </li--> 
						<li>
                            <a ';
	if ($kategoria == (LadneURLe($text_edytuj[$lang])))  echo 'class="selected" '; 
	echo 'href="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_edytuj[$lang]).'.html">
                                '.$text_zmien_dane[$lang].'
                            </a>
                        </li> 
			<li>
                            <a href="https://www.achilles.pl:7999/zone/logowanie" target="_blank">FTP</a>
                        </li>
			<li>
                            <a href="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_wyloguj[$lang]).'.html">	
                                '.$text_wyloguj[$lang].'
                            </a>
                        </li>
                    </ul>
                </nav>
				';
	}
	
	
// menu uszlachetniania
//$menu_uszlachetnianie = array ('1'=>$text_techniki_uszlachet[$lang], '2'=>$text_folia_matowa[$lang], '3'=>$text_folia_blyszczaca[$lang], '4'=>$text_folia_aksamitna[$lang], '5'=>$text_lakier_strukturalny[$lang], '6'=>$text_lakier_termo[$lang]);

$menu_uszlachetnianie = array ('1'=>$text_techniki_uszlachet[$lang], '2'=>$text_folie[$lang], '3'=>$text_folie_wzorzyste[$lang], '4'=>$text_folie_strukturalne[$lang], '5'=>$text_folie_metalizowane[$lang], '6'=>$text_folie_pet[$lang], '7'=>$text_folie_octanowe[$lang], '8'=>$text_lakier_uv[$lang]);

// opis uszlachetnianie
$opis_uszlachetnianie = array ('1'=>$opis_techniki_uszlachet[$lang], '2'=>$opis_folie[$lang], '3'=>$opis_folie_wzorzyste[$lang], '4'=>$opis_folie_strukturalne[$lang], '5'=>$opis_folie_metalizowane[$lang], '6'=>$opis_folie_pet[$lang], '7'=>$opis_folie_octanowe[$lang], '8'=>$opis_lakier_uv[$lang]);


// menu prototypow
$menu_prototypy = array ('1'=>$text_powstawanie[$lang], '2'=>$text_nasze_prototypy[$lang], '3'=>$text_zamow_prototyp[$lang]);
	
	
	function PokazZdjecia ($zdjecia,$size_w="",$size_h="",$url="",$name_url="",$alt="") {
		global $tab;
		global $row;
		global $lang;
		$tab = explode(',', $zdjecia);
		for( $i = 0, $cnt = count($tab); $i < $cnt; $i++ ){ 
			if($tab[$i]){
				if($size_w)$size_w='width="'.$size_w.'"';
				if($size_h)$size_h='height="'.$size_h.'"';
				
				$img_url="http://".$_SERVER[HTTP_HOST]."/obrazki/".$name_url.",".$lang.",".$tab[$i].".png";
				//$img_url="http://".$_SERVER[HTTP_HOST]."/img/".$lang."/".$tab[$i].".png";
				//echo '<li><figure><a href="http://'.$_SERVER[HTTP_HOST].''.$url.'"><img '.$size_w.' '.$size_h.' src="'.$img_url.'" alt="'.$row['nazwa_pl'].'" /></a></figure></li>';
				echo '<li><figure>';
				if($url){echo '<a href="http://'.$_SERVER[HTTP_HOST].''.$url.'">';}
				echo '<img '.$size_w.' '.$size_h.' src="'.$img_url.'" alt="'.$alt.'" />';
				if($url){echo '</a>';}
				echo '</figure></li>';
			}
		}
	}
	
	function PokazZdjeciaCms ($zdjecia) {
		global $lang;
		$tab = explode(',', $zdjecia);  
		for( $i = 0, $cnt = count($tab); $i < $cnt; $i++ ){
			if($tab[$i]){
				echo '<li><figure><img width="100" src="/img/'.$lang.'/'.$tab[$i].'.png" /></figure></li>';
			}
		}
	}
	
// metatagi
	
	$description="Segregatory, teczki, podkładki do pisania, wizytowniki, wzorniki i próbniki, prezentery, pudełka i etui - od 2001 roku tworzymy najwyższej jakości materiały reklamowe i promocyjne. Z kartonu, tektury i papieru jesteśmy w stanie zrobić wszystko. Nasze możliwości są nieograniczone, a inspirację zawsze stanowią dla nas potrzeby klientów.";
	$keywords="produkty, prototypy, uszlachetnianie, Segregatory, Wzorniki i próbniki, Prezentery, Teczki, Clipboardy, Wizytowniki, Pudełka i etui, Receptariusze";
	$title="Achilles Polska";
	if($lang=="en"){
		$description="Binders, folders, clipboards, business card folders, sample folders, easel binders, boxes and cases - from 2001 Achiles Polska has been creating top quality promotional products. Out of paper and cardboard we can make everything. The possibilities are unlimited and our inspiration always comes from our clients' needs.";
		$keywords="products, prototypes, paper finishing, ringbinders, custom binders, sample folders, easel binders, folders, clipboards, business card folders, boxes and cases, prescription folders";
		$title="Achilles Polska";
	}
	if($lang=="no"){
		$description="Permer, mapper, ordrebrett, visittkortmapper, mønsterbøker, fargeprøver,presentasjonsmapper, bokser og etui - fra 2001 har vi levert topp kvalitet innen reklame-og markedsføringsmateriell. Med papp, kartong og papir kan vi lage alt mulig. Våre muligheter er ubegrenset, og det er våre kunders behov som inspirerer oss.";
		$keywords="produkter, prototyper, foredling av papir, reklamemapper, mønsterbøker, fargeprøver presentasjonsmapper, mapper, skriveplater, visittkortmapper, esker og etui, reseptmapper";
		$title="Achilles Nordic";
	}
	if($lang=="se"){
		$description="Achilles Nordic tillverkar lådor med eget tryck. Vi skräddarsyr kartonger, pärmar och marknadsmaterial med egen logga och design som hjälper ditt företag att synas bättre. ";
		$keywords="Lådor med eget tryck, Lådor med tryck, Kartonger med tryck, Kartonger med egen logga, Förpackningar med egen logga, ringpärmar med tryck, bopärmar, marknadsmaterial, Förpackningar med logga";
		$title="Förpackningar, lådor och pärmar med eget tryck - Achilles Nordic";	
	}	

// na potrzeby cms
$in = $_SESSION[admin];
$in = str_replace (",", "','", $in);

$_WOJEWODZTWO["1"]="Dolnośląskie";
$_WOJEWODZTWO["2"]="Kujawsko-Pomorskie";
$_WOJEWODZTWO["14"]="Łódzkie";
$_WOJEWODZTWO["3"]="Lubelskie";
$_WOJEWODZTWO["4"]="Lubuskie";
$_WOJEWODZTWO["6"]="Małopolskie";
$_WOJEWODZTWO["5"]="Mazowieckie";
$_WOJEWODZTWO["7"]="Opolskie";
$_WOJEWODZTWO["8"]="Podkarpackie";
$_WOJEWODZTWO["9"]="Podlaskie";
$_WOJEWODZTWO["10"]="Pomorskie";
$_WOJEWODZTWO["15"]="Śląskie";
$_WOJEWODZTWO["16"]="Świętokrzyskie";
$_WOJEWODZTWO["11"]="Warmińsko-Mazurskie";
$_WOJEWODZTWO["12"]="Wielkopolskie";
$_WOJEWODZTWO["13"]="Zachodniopomorskie";

$_WOJEWODZTWO_MAIL[1]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[2]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[14]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[3]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[4]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[6]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[5]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[7]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[8]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[9]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[10]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[15]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[16]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[11]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[12]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[13]="j.makowska@achilles.pl,e.mieczkowska@achilles.pl";

/*
$_WOJEWODZTWO_MAIL[1]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[2]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[14]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[3]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[4]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[6]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[5]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[7]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[8]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[9]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[10]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[15]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[16]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[11]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[12]="t.kolaszynski@achilles.pl";
$_WOJEWODZTWO_MAIL[13]="t.kolaszynski@achilles.pl";

$_WOJEWODZTWO_MAIL[1]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[2]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[14]="m.m@achilles.pl";
$_WOJEWODZTWO_MAIL[3]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[4]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[6]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[5]="m.m@achilles.pl";
$_WOJEWODZTWO_MAIL[7]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[8]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[9]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[10]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[15]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[16]="i.laszczewska@achilles.pl";
$_WOJEWODZTWO_MAIL[11]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[12]="e.mieczkowska@achilles.pl";
$_WOJEWODZTWO_MAIL[13]="e.mieczkowska@achilles.pl";
*/
?>
