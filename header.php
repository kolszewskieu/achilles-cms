<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=$lang?>"> <!--<![endif]-->
<? 
// ustawienia strony i klasy dla <body>
if	(!isset($page)) {
	$body_id = 'home';
	$page = 'home';
}
elseif ($page == (LadneURLe($text_produkty[$lang]))) {
	$body_id = 'products';
}
elseif ($page == (LadneURLe($text_o_firmie[$lang]))) {
	$body_id = 'o-firmie';
}
elseif ($page == (LadneURLe($text_nasi_klienci[$lang]))) {
	$body_id = 'o-firmie';
}
elseif ($page == (LadneURLe($text_strefa_klienta[$lang]))) {
	$body_id = 'profile';
}
else {
	$body_id = 'static-page';
}
//sprawdzamy ustawienia dla SEO
$sql="SELECT seo_title,seo_desc,seo_key,category,product FROM seo_tags_".$lang." WHERE page='".$page."'";
list($seo_title,$seo_desc,$seo_key,$category,$product)=mysql_fetch_row(mysql_query($sql));
//echo $seo_title,$seo_desc,$seo_key,$category,$product;
if($product==1 && $produkt){
	$sql="select seo_title, seo_desc, seo_key FROM produkty_".$lang." WHERE id='".$produkt."'";
	list($seo_title,$seo_desc,$seo_key)=mysql_fetch_row(mysql_query($sql));
}elseif($category==1 && $id){
	$sql="select seo_title, seo_desc, seo_key FROM kategorie_".$lang." WHERE id='".$id."'";
	list($seo_title,$seo_desc,$seo_key)=mysql_fetch_row(mysql_query($sql));
}
if($seo_title)$title=$seo_title;
if($seo_desc)$description=$seo_desc;
if($seo_key)$keywords=$seo_key;
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?=$title?><?
	if(!$title){
		if($page) echo "- ".ucfirst($page);
		if($_GET[kategoria]) echo "- ".ucfirst($_GET[kategoria]);
		if($_GET[nazwa]) echo "- ".ucfirst($_GET[nazwa]);
	}
	?></title>
  <meta name="description" content="<?=$description?>" lang="<?=$lang?>" />
  <meta name="keywords" content="<?=$keywords?>" lang="<?=$lang?>" />

  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/smoothness/jquery-ui-1.8.23.custom.css">
  <link rel="stylesheet" href="/css/ui.selectmenu.css">
  
  <script src="/js/libs/modernizr-2.5.3.min.js"></script>
  <script src="/js/libs/jquery-1.7.1.min.js"></script>
  <script src="/js/libs/jquery-ui-1.8.23.custom.min.js"></script>
  <script src="/js/libs/jquery-tinyscrollbar.js"></script>
  <script src="/js/libs/ui.selectmenu.js"></script>
  <script src="/js/script.js"></script>
<?
	$_GOOGLE_ANAL_NO[pl]="UA-28794318-1";
	$_GOOGLE_ANAL_NO[en]="UA-28794318-1";
	$_GOOGLE_ANAL_NO[se]="UA-28794318-3";
	$_GOOGLE_ANAL_NO[no]="UA-28794318-3";
	$_GOOGLE_ANAL_DOMAIN[pl]="achilles.pl";
	$_GOOGLE_ANAL_DOMAIN[en]="achilles.pl";
	$_GOOGLE_ANAL_DOMAIN[se]="achillesnordic.se";
	$_GOOGLE_ANAL_DOMAIN[no]="achillesnordic.se";
?>
  <script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?=$_GOOGLE_ANAL_NO[$lang]?>']);
	_gaq.push(['_setDomainName', '<?=$_GOOGLE_ANAL_DOMAIN[$lang]?>']);
	_gaq.push(['_trackPageview']);

	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
   </script>
</head>
<body class="pl" id="<? echo $body_id; ?>">
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="site-header">
<?
//print_r($_GET);
if($_GET[SHOW_PAGE]==1 || $_SESSION[user_id]=="2" || $_SESSION[user_id]=="90"){
	$sql="SELECT page as page_fdb FROM seo_tags_".$lang." WHERE page='$page'";
	list($page_fdb)=mysql_fetch_row(mysql_query($sql));
	if(!$page_fdb){
		$sql="INSERT INTO seo_tags_".$lang." (page) VALUES (\"".$page."\")";
		mysql_query($sql);
		echo mysql_error();
	}else{
		echo "tags z bazy:".$page_fdb."<br>";
	}

	echo "Page:<b>".$page."</b> - Subpage:<b>".$kategoria."</b><br>";
	echo "Product: <b>".$produkt."</b> - Kategoria<b>".$id."</b>";
	echo "<br/>";
}
?>
      <nav id="lang">
          <ul>
              <li>
		<a href="http://www.achilles.pl/">
		<img src="/img/flags/pl<? if ($lang=="pl") echo "-selected"; ?>.png" alt="Polski" />
		</a>
              </li>
              <li>
                   <? //<a href="/?lang=en"> ?>
                   <a href="http://en.achilles.pl/">
                       <img src="/img/flags/en<? if ($lang=="en") echo "-selected"; ?>.png" alt="English" />
                   </a>
              </li>
              <li>
                   <? //<a href="/?lang=no">?>
                   <a href="http://norsk.achillesnordic.se/">
                       <img src="/img/flags/no<? if ($lang=="no") echo "-selected"; ?>.png" alt="Norsk" />
                   </a>
              </li>
              <li>
                   <a href="http://www.achillesnordic.se/">
                       <img src="/img/flags/se<? if ($lang=="se") echo "-selected"; ?>.png" alt="Svenska" />
                   </a>
              </li>
          </ul>
      </nav>
      <hgroup>
        <h1 class="achilles"><a <? if ($lang=="no" || $lang=="se") echo 'class="nordic" '; ?>href="/">Achilles <span><? if ($lang=="pl" || $lang=="en") { echo 'Polska'; } else { echo 'Nordic'; } ?>.</span></a></h1>
        <? echo strtoupper($text_logo[$lang]); ?>
      </hgroup>
      <nav id="main-nav">
          <ul>
              <li>
                  <a href="/"><img src="/img/home.png" alt="strona główna"/></a>
              </li>
              <li>
                  <a href="/<? echo LadneURLe($text_o_firmie[$lang]); ?>.html"><? echo mb_strtoupper($text_o_firmie[$lang], 'UTF-8'); ?></a>
              </li>
              <li>
                  <a href="/<? echo LadneURLe($text_nasi_klienci[$lang]); ?>.html"><? echo mb_strtoupper($text_nasi_klienci[$lang], 'UTF-8'); ?></a>
              </li>
              <li>
                  <a href="/<? echo LadneURLe($text_nasze_realizacje[$lang]); ?>.html"><? echo mb_strtoupper($text_nasze_realizacje[$lang], 'UTF-8'); ?></a>
              </li>
              <li>
                  <a href="/<? echo LadneURLe($text_strefa_klienta[$lang]); ?>.html"><? echo strtoupper($text_strefa_klienta[$lang]); ?></a>
              </li>
          </ul> 
      </nav>
      <aside id="contact">
          <h2><? echo ucfirst($text_kontakt_z_nami[$lang]); ?>:</h2>	
          <ul>
              <li class="phone"><? echo $tel_kontakt_header[$lang]; ?></li>
              <li><a href="mailto:<? echo $mail_kontakt_header[$lang]; ?>"><? echo $mail_kontakt_header[$lang]; ?></a></li>
              <li><a href="/<? echo LadneURLe($text_kontakt[$lang]); ?>.html"><? echo ucfirst($text_oddzialy[$lang]); ?></a></li>
          </ul>
      </aside>
      <aside id="newsletter">
          <h2>Newsletter:</h2>
          <form action="/newsletter.html" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="page" id="page" value="newsletter">
              <input required type="email" name="email" id="email" />
              <a href="#newsletter-submit" class="button"><? echo ucfirst($text_zapisz_sie[$lang]); ?></a>
              <input type="submit" id="newsletter-submit" value="<? echo ucfirst($text_zapisz_sie[$lang]); ?>" />
          </form>
      </aside>
	</header>
<?if ($lang=="pl"){?>
	<center>
	<script language='JavaScript' type='text/javascript' src='http://ads.uszlachetnianiedruku.pl/adx.js'></script>
	<script language='JavaScript' type='text/javascript'>
	<!--
	   if (!document.phpAds_used) document.phpAds_used = ',';
	   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
	   
	   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
	   document.write ("http://ads.uszlachetnianiedruku.pl/adjs.php?n=" + phpAds_random);
	   document.write ("&amp;what=zone:2&amp;block=1");
	   document.write ("&amp;exclude=" + document.phpAds_used);
	   if (document.referrer)
		  document.write ("&amp;referer=" + escape(document.referrer));
	   document.write ("'><" + "/script>");
	//-->
	</script>
	<noscript><a href='http://ads.uszlachetnianiedruku.pl/adclick.php?n=af48d7bf' target='_blank'><img src='http://ads.uszlachetnianiedruku.pl/adview.php?what=zone:2&amp;n=af48d7bf' border='0' alt=''></a></noscript>
	</center>
<?}?>