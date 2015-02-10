<?php include 'language.php'; ?>
<?php
include 'conf.php';
if(!$sort)$sort="DESC";
?>
<? include 'header.php'; ?>
<div style="width: 142px; display: inline-block;">
<script language='JavaScript' type='text/javascript' src='http://ads.uszlachetnianiedruku.pl/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://ads.uszlachetnianiedruku.pl/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:3&amp;block=1");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://ads.uszlachetnianiedruku.pl/adclick.php?n=aa40b84b' target='_blank'><img src='http://ads.uszlachetnianiedruku.pl/adview.php?what=zone:3&amp;n=aa40b84b' border='0' alt=''></a></noscript>
</div>
<div id="content" role="main" <? if ($page == (LadneURLe($text_strefa_klienta[$lang]))) { echo 'class="registration-complete"'; } ?>>
<?if($_GET[test]==1){?>
<a href="?alert=1"><marquee bgcolor="#FFFFFF" style="color: #F47920" align="middle"><b>Kliknij, oddzwonimy do Ciebie !!</b></marquee></a>
<?}?>
<?if($_GET[test]==2){?>
<div bgcolor="#FFFFFF" align="middle"><a href="?alert=1" style="color: #F47920"><b>Kliknij, oddzwonimy do Ciebie !!</b></a></div>
<?}?>
<? switch ($page) {
	//case ($page == (LadneURLe($text_produkty[$lang]))):	
	//case ($page == 'produkty' || $page == 'products' || $page == 'produkter'):
	//case ($page == LadneURLe($text_produkty[pl]) || $page == LadneURLe($text_produkty[en]) || $page == LadneURLe($text_produkty[se]) || $page == LadneURLe($text_produkty[no])):
	case ($case_produkty):		
		$right = '';
		$sql = "select nazwa,opis,zdjecia from kategorie_".$lang." where id='$id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$sql = "select nazwa from kategorie_".$lang." where id='$id'";
		$result = mysql_query($sql);
		$rowk = mysql_fetch_array($result);
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <a href="/<? echo $text_produkty[$lang]; ?>.html"><? echo ucfirst($text_produkty[$lang]); ?></a> &gt; <span><? echo $row[nazwa]; ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li class="selected">
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box proto-tab products-tab">
                <header>
                    <h2><? echo $row[nazwa]; ?></h2>
                </header>
				<div class="content with-nav">
                    <nav class="box tabs staticUrls">
					<ul>
						<? MenuKategorie($page); ?>    
						</ul>
                      </nav>
                    <div class="tab-content">
                    	<div align="center">
                        <div class="slides">
                            <ul>
                                <?
									PokazZdjecia($row[zdjecia],'','','/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html',$row[nazwa],$row[nazwa]);
								?>   
                            </ul>
                        </div>
                        </div>
                        <div>
                            <p>
                            <? echo nl2br($row[opis]); ?></p>
                        </div>
                        <footer>
                           <!-- <a class="button ask" href="/<? echo LadneURLe($text_zapytaj[$lang]).'/'.$kategoria.','.$id.''; ?>.html"><? echo ucfirst($text_zapytaj[$lang]); ?></a> -->
                            <? $tabmenu = array(4,5,6,9,10,13,25,26);
                            if (!in_array($id, $tabmenu)) {
                            echo "Zapraszamy do zapoznania się z naszą ofertą w sklepie internetowym";
                            echo '<a href="http://www.segregatory24.pl" target="blank" title="Segregatory, teczki, clipboardy reklamowe"><img src="http://www.uszlachetnianiedruku.pl/wp-content/uploads/2013/10/segregatory24.png" /> </a> </br></br>';
                            }
                            ?>                                                                         
                        </footer>
                    </div>
				</div>
<? 		break;
	case "home": 		
		$right = '_home';
?>
		<div id="left-col">
			<?
			$sql = "SELECT * FROM produkty_".$lang." WHERE nowosc='1' order by id DESC LIMIT 10";
			$result = mysql_query($sql);
			$ile_nowosci=mysql_num_rows($result);
			if($ile_nowosci>0){
			?>
			<div class="box" style="text-align: center;">
				<header  style="text-align: left;">
				<h2 class="achilles">Achilles <span><? echo $text_nowosci[$lang]; ?>.</span></h2>
				</header>
				<div class="tab-content">
					<div class="slidesFull" style="margin:0 -10px 0;">
						<ul>
						<?
						while($row=mysql_fetch_assoc($result)){
							$sql = "select nazwa from kategorie_".$lang." where id='$row[kategoria]'";
							$resultk = mysql_query($sql);
							$rowk = mysql_fetch_array($resultk);
							$foto_nowosci=explode(',', $row[zdjecia]);
							$url='/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.LadneURLe($rowk[nazwa]).'/'.LadneURLe($row[nazwa]).','.$row[kategoria].','.$row[id].'.html';
							PokazZdjecia($foto_nowosci[1],350,267,$url);
						}
						?>
						</ul>
					</div>
				</div>
			</div>
			<?}?>
          <div class="box">
              <header>
                  <h2 class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></h2>
              </header>
              <div class="content with-nav">
					<nav class="box tabs staticUrls">
						<ul>
						<? MenuKategorie(LadneURLe($text_produkty[$lang])); ?>     
						</ul>
					</nav>
					<div class="tab-content">
						<div class="slides" style="margin:0 -10px 0;">
                            <ul>
						<? 
						$dir = opendir('img/home');
						$count_foto = 0;
						while(false !== ($file = readdir($dir))) {
							if($file != '.' && $file != '..') {
								$count_foto++;
							}
						}
						$f = glob('img/home/*.jpg', GLOB_BRACE);
						for ($i = 0; $i < $count_foto;  $i++) {
							if ($i==0) echo '<li><figure><a href="produkty/opakowania-tekturowe,25.html"><img src="'.$f[$i].'" /></a></figure></li>';
							else
							echo '<li><figure><img src="'.$f[$i].'" /></figure></li>';
						}
						/*
							$sql = "select nazwa_".$lang.",zdjecia from kategorie";													
							$result = mysql_query($sql);							
							while ($row = mysql_fetch_array($result)) {
								$alt = 'nazwa_'.$lang;
								$tab = explode(',', $row[zdjecia]);								
								echo '<li><figure><img src="/img/'.$tab[0].'.jpg" alt="'.$row[$alt].'" /></figure></li>';
							}*/					
						?>
							</ul>
                        </div>
                        <div>
                            <p>
                            <? echo $text_glowna[$lang]; ?></p>
                        </div>
                        
                    </div>
                </div>        
<?	 	break;
	case "newsletter": 		
		if(!$_POST){
		    header("Location: /");
		}
		$right = '_null';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span>Newsletter</span>
        </div>
        <div class="box profile">
            <header class="message">
                Newsletter <span class="achilles">Achilles <span>Polska!</span></span>
            </header>            
            <div class="content">
<?	
		// link aktywujacy wysylac? zabezpieczenie przed zapisaniem kogos
		$_POST['email'] = Czysc($_POST['email']);
		$result = mysql_query("SELECT * FROM `uzytkownicy` WHERE email='".$_POST['email']."' LIMIT 1");
		// jak nie ma @ w bazie to zapisujemy do newslettera wstepnie i wysylamy mail
		if (mysql_num_rows($result) == 0) {
			$code = strtoupper(substr(md5(time()),0,8));
			if ($lang == 'pl') {
				$body .= '<html><head><title>Rejestracja w newsleterze Achilles Polska</title></head><body>'; 
				$body .= '<p><b>Witaj!</b></p>'; 
				$body .= '<p>Adres '.$_POST['email'].' został dodany do bazy subskrybentów newslettera Achilles Polska.<br/>Aby potwierdzić subskrypcję kliknij link:</p>';
				$body .= '<a href="http://www.achilles.pl/index.php?page=newsletter-zapisz&email='.$_POST['email'].'&code='.$code.'">http://www.achilles.pl/index.php?page=newsletter-zapisz&email='.$_POST['email'].'&code='.$code.'</a>';
				$body .= '<p>Jeśli niniejsza wiadomość dotarła do Ciebie przez pomyłkę, zignoruj ją.</p>';
				$body .= '<p>Pozdrawiamy<br/>Zespół Achilles Polska.</p>';
				$body .= '</body></html>';
				$subject = 'Rejestracja w newsleterze Achilles Polska';
				$headers .= 'From: Newsletter Achilles Polska <no-reply@achilles.pl>'.PHP_EOL;
			} else {
				$body .= '<html><head><title>Registration to Achilles Polska Newsletter</title></head><body>';
				$body .= '<p><b>Hallo!</b></p>';
				$body .= '<p>Your e-mail address '.$_POST['email'].' has just been entered for subscription of Achilles Polska Newsletter.<br/>In order to confirm your registration please click the link below:</p>';
				$body .= '<a href="http://en.achilles.pl/index.php?page=newsletter-zapisz&email='.$_POST['email'].'&code='.$code.'">http://en.achilles.pl/index.php?page=newsletter-zapisz&email='.$_POST['email'].'&code='.$code.'</a>';
				$body .= '<p>If it was not your intention to subscribe, simply ignore this message.</p>';
				$body .= '<p>Best regards<br/>Achilles Polska Team.</p>';
				$body .= '</body></html>';
				$subject = 'Registration to Achilles Polska Newsletter';
				$headers .= 'From: Achilles Polska Newsletter <no-reply@achilles.pl>'.PHP_EOL;
			}			
			$headers .= 'MIME-Version: 1.0'.PHP_EOL;
			$headers .= 'Content-type: text/html; charset=utf-8'.PHP_EOL;			
			$headers.="X-Mailer: PHP/". phpversion();			
			if (mail($_POST['email'], $subject, $body, $headers)) {		
				$sql = "INSERT INTO `uzytkownicy` (`email`, `temppassword`, `datarejestr`, `newsletter`, `aktywne`) VALUES ('{$_POST['email']}', '".$code."', '".time()."', 'yes', 'no')";	
				echo '<div class="subtitle">'.$text_rejestracja_ok[$lang].'</div>'; // TLUMACZYC
			}
		} else {
			$row = mysql_fetch_assoc($result);
			// jak jest @ w bazie, ale bez hasla, to oznacza, ze user tylko na newsletter zapisany juz wczesniej albo nie potwierdzony mailem
			if ($row['password'] == '') {
				if ($row['aktywne'] == 'yes') {
					echo '<div class="subtitle">'.$text_adres_juz_dopisany[$lang].'.</div>';
					} else {
						echo '<div class="subtitle">'.$text_rejestracja__sprawdz_mail[$lang].'</div>';  // TLUMACZYC
				}
			}
			// jak jest @ i haslo to tylko dopisujemy ze newsletter
			else {
				$sql = "UPDATE `uzytkownicy` SET `newsletter` = 'yes' WHERE `email` = '".$_POST['email']."'";
				echo '<div class="subtitle">'.$text_rejestracja_ok[$lang].'.</div>';
			}
		}
		$result = mysql_query($sql);		
	 	break;
	case ($page == 'newsletter-zapisz'):
			$right = '_null';
			 	if ($_GET[email] && $_GET[code]) {
					$sql="SELECT id FROM uzytkownicy WHERE temppassword='".$_GET[code]."' AND email='".$_GET[email]."'LIMIT 1";
					list ($id) = mysql_fetch_row(mysql_query($sql));
					if ($id) {
						$sql_upd="UPDATE uzytkownicy SET aktywne='yes', temppassword='' WHERE id='$id'";
						mysql_query($sql_upd);	
						} else {
							echo 'Wystapil błąd';				// TLUMACZYC	
						}
					echo '<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span>Newsletter</span>
        </div>
        <div class="box profile">
            <header class="message">
                Newsletter <span class="achilles">Achilles <span>Polska!</span></span>
            </header>            
            <div class="content">'.$text_rejestracja_ok[$lang];
					
				}
    	break;
	case ($case_o_firmie): 
		$right = '';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst($text_o_firmie[$lang]); ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box proto-tab">
                <header>
                    <h2><? echo ucfirst($text_o_firmie[$lang]); ?></h2>
                </header>
                <div class="content with-nav">
                    <nav class="box tabs staticUrls">
                        <ul>
                            <li>
                                <a class="selected" href="/<? echo LadneURLe($text_o_firmie[$lang]); ?>.html">
                                    <? echo ucfirst($text_o_firmie[$lang]); ?>
                                </a>
                            </li>
                            <li>
                                <a href="/<? echo LadneURLe($text_nasi_klienci[$lang]); ?>.html">
                                    <? echo ucfirst($text_nasi_klienci[$lang]); ?>
                                </a>
                            </li>
                            <li>
                                <a href="/<? echo LadneURLe($text_kontakt[$lang]); ?>.html">
                                    <? echo ucfirst($text_kontakt[$lang]); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
						<div class="tab-content">
                        
                            
                            <div class="viewport">
                                <div class="overview">
                                    <? echo $opis_ofirmie[$lang]; ?>
                                </div>
                            </div>
                        
                        <div align="center">
                        <div class="slides">
                                <ul>
                                    <li>
                                        <figure>
                                            <img src="/img/segregatory-reklamowe.png" />
                                        </figure>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="/img/segregatory-reklamowe.png" />
                                        </figure>
                                    </li>
                                </ul>
                          </div>
                          </div>
                    </div>
                </div>        
<?	 	break;
	case ($case_zapytaj): 
		$right = '_null';
		$sql = "select nazwa,opis,zdjecia from kategorie_".$lang." where id='$id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst($text_zapytaj[$lang]); ?></span>
        </div>

          
        <div class="box" id="question-form">
            <header>
                <h2><? echo ucfirst($text_zapytaj[$lang]); ?></h2>
            </header>
            <div class="content">
		<?			
			if ($kategoria == (LadneURLe($text_wyslij[$lang]))) {
				if($_POST['name'] && $_POST['surname'] && $_POST['question_email'] && $_POST['phone']){
				    $_POST['name'] = Czysc($_POST['name']);
				    $_POST['surname'] = Czysc($_POST['surname']);
				    $_POST['question_email'] = Czysc($_POST['question_email']);
				    $_POST['company'] = Czysc($_POST['company']);
				    $_POST['phone'] = Czysc($_POST['phone']);
				    //$_POST['question'] = Czysc($_POST['question']);				
				
				    $sql = "INSERT INTO `zapytania` (`imie`, `nazwisko`, `firma`, `email`, `telefon`, `wojewodztwo`, `zapytanie`, `data`, `wyslanoodpowiedz`,`url_produkt`) VALUES ('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['company']}', '{$_POST['question_email']}', '{$_POST['phone']}', '{$_POST['wojewodztwo']}', '{$_POST['question']}', '".time()."', 'nie','".$_POST[referer]."')";
				    $result = mysql_query($sql);
										
				    $body .= '<html><head><title>Zapytanie ze strony Achilles Polska</title></head><body>';
				    $body .= '<p><b>Zapytanie ze strony Achilles Polska</b></p>';
				    $body .= '<p>Imię: '.$_POST[name].'</p>';
				    $body .= '<p>Nazwisko: '.$_POST[surname].'</p>';
				    if (isset($_POST[company])) { $body .= '<p>Firma: '.$_POST[company].'</p>'; }
				    $body .= '<p>E-mail: '.$_POST[question_email].'</p>';
				    if (isset($_POST[phone])) { $body .= '<p>Telefon: '.$_POST[phone].'</p>'; }
					$body .= '<p>Województwo: '.$_WOJEWODZTWO[$_POST[wojewodztwo]].'</p>';
				    $body .= '<p>Treść zapytania:<br />'.$_POST[question].'</p>';
				    $body .= '<p>Produkt:'.$_POST[referer].'</p>';

				    $headers  = 'MIME-Version: 1.0'.PHP_EOL;
				    $headers .= 'Content-type: text/html; charset=utf-8'.PHP_EOL;
				    $headers .= 'From: Strona WWW <stronawww@achilles.pl>'.PHP_EOL;
				    $headers.="X-Mailer: PHP/". phpversion();
				    $subject = 'Zapytanie ze strony Achilles Polska';
					$to=$_WOJEWODZTWO_MAIL[$_POST[wojewodztwo]];
					
				    if (mail($to, $subject, $body, $headers)){
						$body.="<hr><p>Wysłane automatycznie do: ".$_WOJEWODZTWO_MAIL[$_POST[wojewodztwo]]."</p>";
						$body .= '</body></html>';
						mail($to_admin, $subject, $body, $headers);
						echo $text_zapytanie_wyslane[$lang];
					}
				}
			}
		else {
				// jak zapytanie z podaniem kategorii to prezentacja
				if (isset($_GET[kategoria]) || isset($_GET[produkt])) { 
					echo '<div style="positon: relative; float: right;">';
						if (isset($produkt)) {
							echo $_SESSION['produkt_nazwa'].'<p><img src="/img/'.$lang.'/'.$_SESSION['produkt_zdjecie'].'.png" alt="'.$_SESSION['produkt_nazwa'].'" /></p>';
						}
						else { 
							$foto = explode(',', $row[zdjecia]); 
							echo $row[nazwa].'<p><img src="/img/tmp/'.$foto[1].'.png" alt="'.$row[nazwa].'" /></p>';
						}
					echo '</div>';
				}
		?>
                <form action="/<? echo $page.'/'.LadneURLe($text_wyslij[$lang]); ?>.html" method="post">
				<input type="hidden" name="referer" value="<?=$_SERVER[HTTP_REFERER]?>">
                    <dl>
                        <dt>
                            <label for="name"><? echo $text_imie[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="text" name="name" id="name" />
                            <? echo $text_wymagane[$lang]; ?>
                        </dd>
                        
                        <dt>
                            <label for="surname"><? echo $text_nazwisko[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="text" name="surname" id="surname" />
                            <? echo $text_wymagane[$lang]; ?>
                        </dd>
                        
                        <dt>
                            <label for="company"><? echo $text_firma[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input type="text" name="company" id="company" />
                        </dd>
                        
                        <dt>
                            <label for="question_email"><? echo $text_email[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="email" name="question_email" id="question_email" />
                            <? echo $text_wymagane[$lang]; ?>
                        </dd>
                        
                        <dt>
                            <label for="phone"><? echo $text_telefon[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="text" name="phone" id="phone" />
                            <? echo $text_wymagane[$lang]; ?>
                        </dd>
                       	<? if ($lang == 'pl') { ?>
						<dt>
                		<label for="wojewodztwo">Województwo:</label>
            			</dt>
            			<dd>
						<select required class="noreload" id="wojewodztwo" name="wojewodztwo">					
							<option value="1" <?if($_POST[wojewodztwo]=='1')echo 'selected="selected"';?>>Dolnośląskie</option>
							<option value="2" <?if($_POST[wojewodztwo]=='2')echo 'selected="selected"';?>>Kujawsko-Pomorskie</option>
							<option value="14" <?if($_POST[wojewodztwo]=='14')echo 'selected="selected"';?>>Łódzkie</option>
							<option value="3" <?if($_POST[wojewodztwo]=='3')echo 'selected="selected"';?>>Lubelskie</option>
							<option value="4" <?if($_POST[wojewodztwo]=='4')echo 'selected="selected"';?>>Lubuskie</option>
							<option value="6" <?if($_POST[wojewodztwo]=='6')echo 'selected="selected"';?>>Małopolskie</option>
							<option value="5" <?if($_POST[wojewodztwo]=='5')echo 'selected="selected"';?>>Mazowieckie</option>
							<option value="7" <?if($_POST[wojewodztwo]=='7')echo 'selected="selected"';?>>Opolskie</option>
							<option value="8" <?if($_POST[wojewodztwo]=='8')echo 'selected="selected"';?>>Podkarpackie</option>
							<option value="9" <?if($_POST[wojewodztwo]=='9')echo 'selected="selected"';?>>Podlaskie</option>
							<option value="10" <?if($_POST[wojewodztwo]=='10')echo 'selected="selected"';?>>Pomorskie</option>
							<option value="15" <?if($_POST[wojewodztwo]=='15')echo 'selected="selected"';?>>Śląskie</option>
							<option value="16" <?if($_POST[wojewodztwo]=='16')echo 'selected="selected"';?>>Świętokrzyskie</option>
							<option value="11" <?if($_POST[wojewodztwo]=='11')echo 'selected="selected"';?>>Warmińsko-Mazurskie</option>
							<option value="12" <?if($_POST[wojewodztwo]=='12')echo 'selected="selected"';?>>Wielkopolskie</option>
							<option value="13" <?if($_POST[wojewodztwo]=='13')echo 'selected="selected"';?>>Zachodniopomorskie</option>
						</select>
						<? echo $text_wymagane[$lang]; ?>
            			</dd>
            			<? } ?>
                    </dl>
                    <label for="question"><? echo $text_uwagi_prototyp[$lang]; ?></label>
                    <textarea name="question" id="question"></textarea>
                    <footer>
                        <a href="#submit" class="button more"><? echo $text_wyslij[$lang]; ?></a>						
                        <input id="submit" type="submit" value="<? echo $text_wyslij[$lang]; ?>" />
                    </footer>
                </form>				
				<?
					}					
				?>
			
<?	 	break;
	case ($page == (LadneURLe($text_polityka_prywatnosci[$lang]))): 
		$right = '';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst(mb_strtolower($text_polityka_prywatnosci[$lang], 'UTF-8')); ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box static">
               
                <div class="content">
                        <div class="viewport">
                            <div class="overview">
								<?=$opis_polityka_prywatnosci[$lang]?>
                            </div>
                        </div>
                </div>        
<?	 	break;
	case ($page == (LadneURLe($text_regulamin_serwisu[$lang]))): 
		$right = '';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst(mb_strtolower($text_regulamin_serwisu[$lang], 'UTF-8')); ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box static">
             <header>
                <h2><? echo ucfirst(mb_strtolower($text_regulamin_serwisu[$lang], 'UTF-8')); ?></h2>
          	 </header>
                <div class="content">
                        <div class="viewport">
                            <div class="overview">
								<?=$opis_regulamin_serwisu[$lang]?>
                            </div>
                        </div>
                </div>        
<?	 	break;
	case ($page == (LadneURLe($text_nasi_klienci[$lang]))):
		$right = '';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst($text_nasi_klienci[$lang]); ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box proto-tab">
                <header>
                    <h2><? echo ucfirst($text_nasi_klienci[$lang]); ?></h2>
                </header>
                <div class="content with-nav">
                    <nav class="box tabs staticUrls">
                        <ul>
                            <li>
                                <a href="/<? echo LadneURLe($text_o_firmie[$lang]); ?>.html">
                                    <? echo ucfirst($text_o_firmie[$lang]); ?>
                                </a>
                            </li>
                            <li>
                                <a class="selected" href="/<? echo LadneURLe($text_nasi_klienci[$lang]); ?>.html">
                                    <? echo ucfirst($text_nasi_klienci[$lang]); ?>
                                </a>
                            </li>
                            <li>
                                <a href="/<? echo LadneURLe($text_kontakt[$lang]); ?>.html">
                                    <? echo ucfirst($text_kontakt[$lang]); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
						<div class="tab-content">
                        <div class="viewport">
                            <div class="overview">                               
                                <? echo $opis_nasi_klienci[$lang]; ?>
                            </div>
                        </div>
                  </div>  
                </div>        
<?	 	break;
	case ($page == (LadneURLe($text_kontakt[$lang]))): 
		$right = '';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst($text_kontakt[$lang]); ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box contact-info">
              <div class="contact-info-tab">
                <div class="addresses">
                    <header>
                        <h2><? echo ucfirst($text_kontakt[$lang]); ?></h2>
                    </header>
                    <? echo $opis_kontakt[$lang]; ?>
                </div>
                <div class="images">
                    <ul>
                        <li>
                            <img src="/img/kontakt-1.jpg" alt="" />
                        </li>
                        <li>
                            <img src="/img/kontakt-2.jpg" alt="" />
                        </li>
                        <li>
                            <img src="/img/kontakt-3.jpg" alt="" />
                        </li>
                    </ul>
                </div>
            </div>
<?	 	break;
	case ($case_prototypy): 
		$right = '';
		if (!isset($_GET['id'])) $_GET['id'] = '1';
		$sql = "select nazwa from kategorie_".$lang." where id='$id'";
		$result = mysql_query($sql);
		$rowk = mysql_fetch_array($result);
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <a href="/<? echo $text_prototypy[$lang]; ?>.html"><? echo $text_produkty_prototypowe[$lang]; ?></a> &gt; <span><? echo $menu_prototypy[$_GET['id']]; ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li class="selected">
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box proto-tab">
                <header>
                    <h2><? echo $text_pracownia_prototypow[$lang]; ?></h2>
                </header>
                <div class="content with-nav">
                    <nav class="box tabs staticUrls">
                        <ul>
                        <? 	foreach ($menu_prototypy as $k => $v) {
								if ($id == $k) { 
								$class = ' class="selected"'; 
								}
								echo '<li><a'.$class.' href="/'.$page.'/'.LadneURLe($v).','.$k.'.html">'.$v.'</a></li>';
								$class = '';
							}
						?>
                        </ul>
                    </nav>
		<? 	switch ($id) {
				default: 
		?>
                    <div class="tab-content">
				        <? echo $opis_jak_powstaje_prototyp[$lang]; ?>
                    </div>
		<?			break;
				case 2: 
		?>
                <div class="tab-content">
                        <?/*
						<nav class="topnav">
                            <label for="branch"><? echo ucfirst($text_branza[$lang]); ?>:</label> 
                            <select>
                                <? echo '<option value="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.ucfirst($text_wybierz[$lang]).'</option>';                                
                                	MenuBranze($page,$id); ?>
                            </select>
                          </span>
                        </nav>
						*/?>
							<?	
								//$branza = $_GET['branza'];
								if (!isset($branza)) $idb=1;								
								if (!$_SESSION['logged']) {
									$sql = "SELECT * FROM produkty_".$lang." WHERE (logowanie=0 AND prototyp=1 AND branza=$idb) ORDER BY kategoria";
									$sql = "SELECT * FROM produkty_".$lang." WHERE logowanie=0 AND prototyp=1 ORDER BY kategoria";
									}
								else {
									$sql = "SELECT * FROM produkty_".$lang." WHERE (logowanie='0,1' AND prototyp=1 AND branza=$idb) ORDER BY kategoria";
									$sql = "SELECT * FROM produkty_".$lang." WHERE logowanie='0,1' AND prototyp=1 ORDER BY kategoria";
								}
								//echo "sql=".$sql;
								$result = mysql_query($sql);  // pobieram calosc, sortuje wg kategorii
								while ($row = mysql_fetch_assoc($result)) {	
							?>
                        <h3><? echo $row['nazwa']; ?></h3>
						<div class="slides">
                            <ul>                                
                                <?
									PokazZdjecia($row['zdjecia']);
								?>                                 
                            </ul>
                        </div><!--
                        --><div class="product-details">
                        <? if ($row['logowanie'] == '1') { // klodka na zalogowanych?>
                        	<div style="float:left"><img src="/img/lock_icon40.png"></div><div style="font-size:8px">widoczne tylko<br />dla zalogowanych<br /></div>
                        <? } ?>
                           <dl>
						<?		
								$cechy = $row['cechy'];															// to sie powtarza <dl> do </dl> - wywalic do funkcji
								$result2 = mysql_query("select * from cechy_".$lang." where id in ($cechy)");
								//$nazwa = 'nazwa_'.$lang;
								//$opis = 'opis_'.$lang;
								while ($row2 = mysql_fetch_assoc($result2)) {	
									echo '<dt>'.$row2[nazwa].': </dt><dd>'.$row2[opis].'</dd>';
									}
									
						?>
                                  
                                  <dt>
                                    <? echo ucfirst($text_krotki_opis[$lang]); ?>:
                                  </dt>
                                  <dd>
                                     <? echo $row[opis]; ?>
                                  </dd>
                              </dl>		
                        </div>
                        <footer>
                            <? echo '<a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$row[kategoria].'/'.LadneURLe($row[nazwa]).','.$id.','.$row[id].'.html" class="button more">'.$text_wiecej[$lang].'</a>'; ?>
                        </footer>
						<? } ?>
                    </div>
		<?											
					break;
				case 3: 
					echo '<div class="tab-content">';
					if ($_POST[funkcja]) {  
						/*	javascript jest skonfigurowany, ze select i option z html przerzuca po wybraniu na wpisana w value strone, a ja chce zostawic biezaca a przekazac wartosc
							przerzucam sztucznie na te sama strone, przekazuje wartosc, usuwam niepotrzebna czesc */
						$_POST['typ'] = str_replace("/prototypy/zamow,", "", $_POST['typ']);	
						$_POST['typ'] = str_replace(".html", "", $_POST['typ']);
							 
						$sql = "INSERT INTO `zamowienia` (`typ`, `funkcja`, `komentarz`, `email`, `data`) VALUES ('{$_POST['typ']}', '{$_POST['funkcja']}', '{$_POST['komentarz']}', '{$_POST['email']}', '".time()."')";
						$result = mysql_query($sql);
						
						$body .= '<html><head><title>Zamówienie ze strony Achilles Polska</title></head><body>';
						$body .= '<p><b>Zamówienie ze strony Achilles Polska</b></p>';
						$body .= '<p>Typ prototypu: '.$_POST[typ].'</p>';
						$body .= '<p>Funkcja: '.$_POST[funkcja].'</p>';
						$body .= '<p>Komentarz:<br />'.$_POST[komentarz].'</p>';
						$body .= '<p>E-mail: '.$_POST[email].'</p>';
						$body .= '</body></html>';
						$headers  = 'MIME-Version: 1.0'.PHP_EOL;
						$headers .= 'Content-type: text/html; charset=utf8'.PHP_EOL;
						$headers .= 'From: Strona WWW <stronawww@achilles.pl>'.PHP_EOL;
						$headers.="X-Mailer: PHP/". phpversion();
						$subject = 'Zamówienie prototypu ze strony Achilles Polska';
										
						if (mail($to, $subject, $body, $headers)) {						
							echo $text_zapytanie_wyslane[$lang];
						}
					}else{		
						// slowo wyslij zastapimy jak wersje jezykowe beda
						echo '<form action="/'.$page.'/'.$kategoria.',3.html" method="post">'.$opis_zamow_prototyp[$lang].'</form>';                   	
					}
					echo '</div>';
				break;
			}
		?>	
		</div>
<?	 	break;
	case ($case_uszlachetnianie): 
		$right = '';		
		if (!isset($_GET['id'])) $_GET['id'] = '1';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html"><? echo ucfirst($text_uszlachetnianie[$lang]); ?></a> &gt; <span><? echo $menu_uszlachetnianie[$_GET['id']]; ?></span>
        </div>
		<div id="left-col">
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li class="selected">
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box proto-tab finish-tab">
                <header>
                    <h2><? echo $menu_uszlachetnianie[$_GET['id']]; ?></h2>
                </header>
                <div class="content with-nav">
                    <nav class="box tabs staticUrls">
                        <ul>
						<? 	
							if ($lang == 'no' || $lang == 'se') {
								echo '<li><a class="selected href="/'.$page.'/'.$menu_uszlachetnianie[1].',1.html">'.$menu_uszlachetnianie[1].'</a></li>';
							} else {
								foreach ($menu_uszlachetnianie as $k => $v) {
									if($v){
										if ($id == $k) { 
										$class = ' class="selected"'; 
										}
										echo '<li><a'.$class.' href="/'.$page.'/'.LadneURLe($v).','.$k.'.html">'.$v.'</a></li>';
										$class = '';
									}
								}
							}
						?>                            
                        </ul>
                    </nav>
                    <div class="tab-content">    
                            <?  								
								echo $opis_uszlachetnianie[$_GET['id']];								
							 ?>
                                               
                    </div>
				</div>
				
<?	 	break;
	case ($case_nasze_realizacje): 
		$right = '_null'; 
		$sql = "SELECT * FROM produkty_".$lang." WHERE id='$produkt' ";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$sql = "select nazwa from kategorie_".$lang." where id='$id'";
		$result = mysql_query($sql);
		$rowk = mysql_fetch_array($result);
		$sql = "select nazwa from branze_".$lang." where id='$idb'";
		$result = mysql_query($sql);
		$rowb = mysql_fetch_array($result);
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <a href="/<? echo LadneURLe($text_nasze_realizacje[$lang]); ?>.html"><? echo ucfirst($text_nasze_realizacje[$lang]); ?></a>
			<? 
				if (isset($kategoria) && (!isset($branza))) { 
					if (!isset($produkt)) {
						echo ' &gt; <span>'.$rowk[nazwa].'</span>'; 
					}
					else {
						echo ' &gt; <a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.$rowk[nazwa].'</a> &gt; <span>'.$row['nazwa'].'</span>';
					}				
				} 
				if (isset($kategoria) && (isset($branza))) {
					if (!isset($produkt)) {
						echo ' &gt; <a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.$rowk[nazwa].'</a> &gt; <span>'.$rowb[nazwa].'</span>'; 
					}
					else {
						echo ' &gt; <a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.$rowk[nazwa].'</a> &gt; <a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'/'.$branza.','.$idb.'.html">'.$rowb[nazwa].'</a> &gt; <span>'.$row['nazwa'].'</span>';
					}
				}
			?>
		</div>
          <nav id="main-tabs">
              <ul>               
                  <li>
                      <li>
                      <a href="/<? echo $text_produkty[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_produkty[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo $text_prototypy[$lang]; ?>.html" class="achilles">Achilles <span><? echo $text_prototypy[$lang]; ?>.</span></a>
                  </li><!--
                  --><li>
                      <a href="/<? echo LadneURLe($text_uszlachetnianie[$lang]); ?>.html" class="achilles">Achilles <span><? echo $text_uszlachetnianie[$lang]; ?>.</span></a>
                  </li>
              </ul>
          </nav>
          <div class="box our-product">
              <div class="toprigth">
                  <? echo ucfirst($text_nasze_realizacje[$lang]); ?>
              </div>
              <nav class="box tabs staticUrls">
                    <ul>
						<? MenuKategorie($page); ?> 
					</ul>					
                </nav>
				<?
					// wersja bez wyboru kategorii z ostatnim z kazdej kategorii
					// wylaczona w conf.php (wymuszona domyslnie 1 kategoria)
					if (!isset($kategoria)) {
				?>

                  <div class="product-list">
						<?		
								$result = mysql_query("select id from kategorie_".$lang." where widocznosc='tak'");  //wszystkie kategorie
								while ($row_kateg = mysql_fetch_assoc($result)) {	
									if (!$_SESSION['logged']) {
										$sql = "SELECT MAX(id) AS maxid FROM produkty_".$lang." WHERE (logowanie=0 AND kategoria=".$row_kateg['id'].")"; //max id w danej kategorii
										}
									else {
										$sql = "SELECT MAX(id) AS maxid FROM produkty_".$lang." WHERE (logowanie='0,1' AND kategoria=".$row_kateg['id'].")";
									}
									//echo "sql=".$sql;
									$result3 = mysql_query($sql);
									$row = mysql_fetch_assoc($result3); 															
									$sql = "SELECT nazwa,opis,cechy,zdjecia FROM produkty_".$lang." WHERE id=".$row[maxid];	//dane produktu dla max id
									$result3 = mysql_query($sql);  
									$row = mysql_fetch_assoc($result3); 									
						?>
						<header>
                          <h2><? echo $row['nazwa']; ?></h2>  
						</header>
					  <div class="row first">		  
                          <div class="slides">
                                <ul>
                                <?
									PokazZdjecia($row['zdjecia']);
								?> 
                                </ul>
                          </div><!--
                          --><div class="product-details">	  
                          <? if ($row['logowanie'] == '1') { // klodka na zalogowanych?>
                        	<div style="float:left"><img src="/img/lock_icon40.png"></div><div style="font-size:8px">widoczne tylko<br />dla zalogowanych<br /></div>
                        <? } ?>
                              <dl>
						<?		
								$cechy = $row['cechy'];
								$result2 = mysql_query("SELECT * FROM cechy_".$lang." WHERE id IN ($cechy)");
								//$nazwa = 'nazwa_'.$lang;
								//$opis = 'opis_'.$lang;								
								while ($row2 = mysql_fetch_assoc($result2)) {	
									echo '<dt>'.$row2[nazwa].': </dt><dd>'.$row2[opis].'</dd>';
									}
									
						?>
                                  
                                  <dt>
                                    <? echo ucfirst($text_krotki_opis[$lang]); ?>:
                                  </dt>
                                  <dd>
                                     <? echo $row[opis]; ?>
                                  </dd>
                              </dl>
                              <div class="ask-cont">
                                 <a href="/index.php?page=zapytaj&kategoria=<? echo $row_kateg['id']; ?>" class="button ask"><? echo ucfirst($text_zapytaj[$lang]); ?></a>  
                              </div>
                          </div>
                      </div>

					 
                <?	 		}
						} 
					else {
						if (!isset($produkt)) {
						
				?>
				
				    <div class="product-list">
                      <!--header>
                          <span class="col1">
                            <? echo ucfirst($text_branza[$lang]); ?> 
                            <select>
                                <? echo '<option value="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.ucfirst($text_wybierz[$lang]).'</option>';                                
                                	MenuBranze($page,$id); ?>
                            </select>
                          </span>
                          <span class="col2">
                            <? echo ucfirst($text_sortuj[$lang]); ?>
                            <select>
								<? echo '<option value="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html">'.ucfirst($text_wybierz[$lang]).'</option>'; ?>
                                <option<? if ($sort == 'DESC') echo ' selected="selected"'; ?> value="/index.php?page=<? echo $page; ?>&id=<? echo $id; if (isset($idb)) echo "&idb=".$idb; ?>&sort=DESC"><? echo $text_od_najnowszego[$lang]; ?></option>                                
                                <option<? if ($sort == 'ASC') echo ' selected="selected"'; ?> value="/index.php?page=<? echo $page; ?>&id=<? echo $id; if (isset($idb)) echo "&idb=".$idb; ?>&sort=ASC"><? echo $text_od_najstarszego[$lang]; ?></option>
                            </select>
                          </span>
                      </header-->
					<? 	
						if (!isset($idb)) {
							$sql = "SELECT * FROM produkty_".$lang." WHERE (kategoria='$id' AND logowanie IN ($_SESSION[logowanie])) ORDER BY id ".$sort;							
							} else {
							$sql = "SELECT * FROM produkty_".$lang." WHERE (kategoria='$id' AND branza='$idb' AND logowanie IN ($_SESSION[logowanie])) ORDER BY id ".$sort;
						}						
						//echo '-------------------------------------------sql '.$sql;
						$result = mysql_query($sql);
						while ($row = mysql_fetch_assoc($result)) {
							?>
							  <header>
								  <h2><? echo $row['nazwa']; ?></h2>  
								</header>
							  <div class="row first">
								  <div class="slides">
										<ul>
										<?
										$cechy = $row['cechy'];															// to sie powtarza <dl> do </dl> - wywalic do funkcji
										$result2 = mysql_query("select * from cechy_".$lang." where id in ($cechy)");
										//$nazwa = 'nazwa_'.$lang;
										//$opis = 'opis_'.$lang;
											if (!isset($idb)) {
												$url="/".$page."/".$kategoria."/".LadneURLe($row[nazwa]).",".$id.",".$row[id].".html";
											} else {
												$url="/".$page."/".$kategoria."/".$branza."/".LadneURLe($row[nazwa]).",".$id.",".$idb.",".$row[id].".html";
											}
											PokazZdjecia($row['zdjecia'],"300","300",$url);
										?> 
										</ul>
								  </div>
								  <div class="product-details">
								  <? if ($row['logowanie'] == '1') { // klodka na zalogowanych?>
									<div style="float:left"><img src="/img/lock_icon40.png"></div><div style="font-size:12px">widoczne tylko dla zalogowanych<br /></div>
								<? } 
								/*	
								?>
									  <dl>
								<?		
										while ($row2 = mysql_fetch_assoc($result2)) {	
											echo '<dt>'.$row2[nazwa].': </dt><dd>'.$row2[opis].'</dd>';
										}									
								?>                                  
										  <dt>
											<? echo ucfirst($text_krotki_opis[$lang]); ?>:
										  </dt>
										  <dd>
											 <? echo $row[opis]; ?>
										  </dd>
									</dl>
								<?
								*/
								?>
										<div class="ask-cont">                              
										 <? 
											echo '<a href="'.$url.'" class="button ask">'.ucfirst($text_szczegoly[$lang]).'</a>';
										 ?>
									  </div>
								  </div>
							  </div>
                     <? } ?>
                      
                  </div>
                  
              </div>
          
			<?			}
				else { 
					/* $sql = "SELECT * FROM produkty WHERE id='$produkt'";
					$result = mysql_query($sql);
					$row = mysql_fetch_assoc($result); */
					//$tab = explode(',', $row['zdjecia']);  // do funkcji
					$_SESSION['produkt_nazwa'] = $row['nazwa']; // przechowuje nazwe do zapytania
					
				?>
				<div class="table">
                  <div class="product-desc">
                      <header>
                          <h2><? echo $row['nazwa']; ?></h2>  
                      </header>
                      <div class="row first">
                          <div class="slides">
                                <ul>
								<?
									PokazZdjecia($row['zdjecia'],"","","",LadneURLe($row['nazwa']),$row['nazwa']);
									$_SESSION['produkt_zdjecie'] = $tab[1]; // przechowuje zdjecie do zapytania
								?>                                    
                                </ul>
                          </div><!--
                          --><div class="product-details">
                          <? if ($row['logowanie'] == '1') { // klodka na zalogowanych?>
                        	<div style="float:left"><img src="/img/lock_icon40.png"></div><div style="font-size:8px">widoczne tylko<br />dla zalogowanych<br /></div>
                        <? } ?>
                              <dl>
						<?		
								$cechy = $row['cechy'];		
								$sql = "select * from cechy_".$lang." where id in (".$cechy.")";													// to sie powtarza <dl> do </dl> - wywalic do funkcji
								$result2 = mysql_query($sql);
								//$nazwa = 'nazwa_'.$lang;
								//$opis = 'opis_'.$lang;								
								while ($row2 = mysql_fetch_assoc($result2)) {	
									echo '<dt>'.$row2[nazwa].': </dt><dd>'.$row2[opis].'</dd>';
									}									
						?>                                  
                                  <dt>
                                    <? echo ucfirst($text_krotki_opis[$lang]); ?>:
                                  </dt>
                                  <dd>
                                     <? echo $row[opis]; ?>
                                  </dd>
							  <?
							if($row[karta_format]=='1'){
								if ($handle = opendir($_DIR_CART."/".$row[id]."/")) {
									$i=0;
									while (false !== ($entry = readdir($handle))) {
										if ($entry != "." && $entry != "..") {
											echo "<a href='".$_DIR_CART_WWW."/".$row[id]."/".$entry."'><img src='/img/pdf.png'> Karta formatowa";
											if($i>0)echo " ".$i;
											echo "</a>";
											if($_SESSION['admin'] != 'not' && $_SESSION['admin']){
												echo " <a style='color:red;' href='/format.php?del_id=$row[id]&file=".$entry."' onClick=\"if(!confirm('Are you sure?')){return false;}else{return true;}\">usun</a>";
											}
											echo "<br>";
										$i++;
										}
									}
								closedir($handle);
								}
							}
							?>
								</dl>
							  <a class="button ask" href="/<? echo LadneURLe($text_zapytaj[$lang]).','.$produkt; ?>.html"><? echo ucfirst($text_zapytaj[$lang]); ?></a>
						  </div>
							<?
							if($_SESSION['admin'] != 'not' && $_SESSION['admin']){
								echo "<br>Dodaj kartę formatową:";
								echo "<form enctype='multipart/form-data' method='post' action='/format.php?add=1'>";
								echo "<input type='hidden' name='prod_id' value='$row[id]'>";
								echo "<br><br><input type='file' name='kart'>";
								echo "<input type='submit' value='Wyślij'>";
								echo "</form>";
								
							}
							?>
						</div>
                  </div>
                <? // sprawdzanie czy sa 3 podobne oprocz wyswietlanego					
					$sql = "SELECT count(id) FROM produkty_".$lang." WHERE (kategoria='$id' AND id<>'$produkt' AND logowanie IN ($_SESSION[logowanie]))"; // moze sa 3 z tej kategorii	
					$result = mysql_query($sql);
					$row = mysql_fetch_row($result);
					if ($row[0] > 2) { // sa 3, a czy jest branza wybrana						
						$sql = "SELECT count(id) FROM produkty_".$lang." WHERE (kategoria='$id' AND branza='$idb' AND id<>'$produkt' AND logowanie IN ($_SESSION[logowanie]))";
							$result = mysql_query($sql);
							$row = mysql_fetch_row($result);
								if ($row[0] > 2) { // sa przynajmniej 3 inne podobne z branzy i kategorii
									// !zrobic! random z 3, kategoria i branza, samo zapytanie
									$sql = "SELECT id,nazwa,zdjecia FROM produkty_".$lang." WHERE (kategoria='$id' AND branza='$idb' AND id<>'$produkt' AND logowanie IN ($_SESSION[logowanie])) ORDER BY RAND() LIMIT 3"; // na razie bez random
									} else { // branza nie wybrana lub nie ma 3 innych z branzy, a na pewno sa 3 z kategorii
								// !zrobic! random z 3, kategoria tylko, samo zapytanie
								$sql = "SELECT id,nazwa,zdjecia FROM produkty_".$lang." WHERE (kategoria='$id' AND id<>'$produkt' AND logowanie IN ($_SESSION[logowanie])) ORDER BY RAND() LIMIT 3"; 
								}
						// wiec wyswietlamy							
						
				?>
                  <div class="similar-products">
                      <header>
                          <h2><? echo ucfirst($text_podobne_produkty[$lang]); ?></h2>
                      </header>
					  <ul class="images">
					<? 							
						//echo 's: '.$sql;
						$result = mysql_query($sql);
						while ($row = mysql_fetch_assoc($result)) {							
							$tab = explode(',', $row['zdjecia']);
					?>                    
                          <li>
                              <h3><? echo $row['nazwa']; ?></h3>       
                              <? echo '<a href="/'.$page.'/'.LadneURLe($kategoria).'/'.LadneURLe($row[nazwa]).','.$id.','.$row[id].'.html">'; 
								$img_url="http://".$_SERVER[HTTP_HOST]."/obrazki/".LadneURLe($row[nazwa]).",".$lang.",".$tab[1].".png";
							  ?>
                              <img style="width:132px;padding:20px" src="<?=$img_url?>" alt="<? echo $row['nazwa']; ?>" />
							  </a>
                          </li>       
                    <?
							}
					?>					
                      </ul>
                  </div>
                  <? } // koniec podobnych?>
              </div>
              <!--div class="button-cont">
                  <a class="button ask" href="/<? echo LadneURLe($text_zapytaj[$lang]).','.$produkt; ?>.html"><? echo ucfirst($text_zapytaj[$lang]); ?></a>
              </div-->
<?	 				}
				}
		
		break;
	case ($page == 'zmiana-hasla'):
			$right = '_null';
			?>
				
            <? 	if ($_GET[email] && $_GET[code]) {
					$sql="SELECT id FROM uzytkownicy WHERE temppassword='".$_GET[code]."' AND email='".$_GET[email]."'LIMIT 1";
					list ($id) = mysql_fetch_row(mysql_query($sql));
					if ($id) {
						$sql_upd="UPDATE uzytkownicy SET password=temppassword,temppassword='' WHERE id='$id'";
						mysql_query($sql_upd);	
						} else {
						echo 'cos nie tak';					}
					header ('location: /'.LadneURLe($text_strefa_klienta[$lang]).'.html');
					exit;
				}
    	break;
	case ($page == (LadneURLe($text_nie_pamietam[$lang]))):
			$right = '_null';
			?>
				<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span><? echo ucfirst($text_nie_pamietam[$lang]); ?></span>
        </div>
        <div class="box profile">
            <header class="message">
			<?=$text_nie_pamietam_naglowek[$lang];?>
            </header>            
            <div class="content">
            <? 	if ($kategoria == LadneURLe($text_wyslij[$lang])) {
            		$sql = "SELECT id,email,imie FROM uzytkownicy WHERE (email = '$_POST[emailp]' AND password != '' AND aktywne = 'yes') LIMIT 1";
            		//echo 'sql ',$sql;
            		list ($id,$email,$imie)=mysql_fetch_row(mysql_query($sql));
            			if (!$id) {
            				echo 'Nie znaleziono takiego użytkownika';
            				} else {
								$new_pass=strtoupper(substr(md5(time()),0,8));
								$temppassword=KodujHaslo($new_pass);							
								$headers  = 'MIME-Version: 1.0'.PHP_EOL;
								$headers .= 'Content-type: text/html; charset=utf-8'.PHP_EOL;
								$headers .= 'From: Achilles.pl <noreply@achilles.pl>'.PHP_EOL;
								$headers .= 'X-Mailer: PHP/'. phpversion();
								$recipient = $email;
								if ($lang == 'pl') {
									$subject = 'Zmiana hasła w serwisie Achilles.pl';
									$body .= '<html><head><title>Zmiana hasła w serwisie achilles.pl</title></head><body>';
									$body .= '<p><b>Witaj '.$imie.'!</b></p>';
									$body .= '<p>Niniejszy email został wysłany automatycznie z serwisu Achilles Polska, w odpowiedzi na prośbę utworzenia nowego hasła dla Twojego profilu.</p>';
									$body .= '<p>Twoje nowe hasło to: '.$new_pass.'</p>';
									$body .= '<p>W celu potwierdzenia zmiany hasła dla konta kliknij na poniższy link:<br />';
									$body .= 'http://www.achilles.pl/index.php?page=zmiana-hasla&email='.$email.'&code='.$temppassword;
									$body .= '<p>Jeśli niniejszy email został wysłany niezgodnie z intencjami, prosimy go zignorować.</p>';									
									$body .= '<p>Pozdrawiamy, <br />'; 
									$body .= 'Zespół Achilles Polska<br />';
								}
								if ($lang == 'en') {
									$subject = 'Pasword recovery for achilles.pl website';
									$body .= '<html><head><title>Pasword recovery for achilles.pl website</title></head><body>';
									$body .= '<p><b>Dear '.$imie.'.</b></p>';
									$body .= '<p>This e-mail has been generated automatically in response to password recovery request from Achilles.pl website.</p>';
									$body .= '<p>In order to generate a new password, please click the link below:<br />';
									$body .= 'http://en.achilles.pl/index.php?page=zmiana-hasla&email='.$email.'&code='.$temppassword;								
									$body .= '<p>Your new password is: '.$new_pass.'</p>';
									$body .= '<p>Best regards, <br />';
									$body .= 'Achilles Polska Team<br />';								
								}
								if ($lang == 'no') {
									$subject = 'Endret passord achilles.pl';
									$body .= '<html><head><title>Endret passord achilles.pl</title></head><body>';
									$body .= '<p><b>Hei, '.$imie.'.</b></p>';
									$body .= '<p>Denne e-posten ble sendt automatisk fra achilles.pl som svar på en forespørsel om å opprette et nytt passord.</p>';
									$body .= '<p>Klikk på linken nedenfor for å opprette et nytt passord:<br />';
									$body .= 'http://achilles.uszlachetnianiedruku.pl/index.php?page=zmiana-hasla&email='.$email.'&code='.$temppassword;
									$body .= '<p>Dersom du har ikke forventet denne e-posten, vennligst se bort fra den.</p>';
									$body .= '<p>Ditt nye passord er: '.$new_pass.'</p>';
									$body .= '<p>Hilsen, <br />';
									$body .= 'Achilles Polens team<br />';									
								}
								if ($lang == 'se') {
									$subject = 'Ändring av lösenord i achilles.pl';
									$body .= '<html><head><title>Ändring av lösenord i achilles.pl</title></head><body>';
									$body .= '<p><b>Hej, '.$imie.'.</b></p>';
									$body .= '<p>Detta e-mail har skickats automatiskt från achilles.pl  som svar på din anmälan om ett nytt lösenord.</p>';
									$body .= '<p>För att skapa ett nytt lösenord ska du klicka på länk nedan:<br />';
									$body .= 'http://achilles.uszlachetnianiedruku.pl/index.php?page=zmiana-hasla&email='.$email.'&code='.$temppassword;
									$body .= '<p>Om detta e-mail inte stämmer med ditt ändamål, kan du bortse ifrån detta meddelande.</p>';
									$body .= '<p>Ditt nya lösenord är: '.$new_pass.'</p>';
									$body .= '<p>Med vänliga hälsningar, <br />';
									$body .= 'Achilles Polen team<br />';
								}
								$body .= '</body></html>';
								if (mail($recipient, $subject, $body, $headers)) {
									$sql_upd = "UPDATE uzytkownicy SET temppassword='".$temppassword."' WHERE id='".$id."'";
									$result = mysql_query($sql_upd);
									if ($lang == 'pl') echo 'Na adres '.$recipient.' wysłana została informacja dotycząca zmiany hasła dla twojego konta w serwisie Achilles Polska.<br />Postępuj zgodnie ze wskazówkami z maila.';
									if ($lang == 'en' || $lang == 'no' || $lang == 'se') echo 'In order to reset your password, please follow the instructions sent to you by email.';
								}            				
            			}
            		} else {
            		if ($_SESSION['logged']) {
	            		echo 'Skorzystaj z przypomnienia po wylogowaniu';
    	        		} else {
						echo '<form method="post" action="/'.LadneURLe($text_nie_pamietam[$lang]).'/'.LadneURLe($text_wyslij[$lang]).'.html"><dl>
								<dt>
            					   	<label for="login">'.$text_email[$lang].':</label>
            					</dt>
            					<dd>
	                				<input required type="email" name="emailp" id="emailp" value="'.$_POST['email'].'" />
    	        				</dd>
        	   		 			<footer>
            	    				<a href="#submit" class="button more">'.$text_wyslij[$lang].'</a>
                					<input id="submit" type="submit" value="'.$text_wyslij[$lang].'" />				
            					</footer>
    						</form>';
					}
				}
            	?>

<?	 	break;
	case ($page == (LadneURLe($text_strefa_klienta[$lang]))): 
		$right = '_null';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <a href="/<? echo LadneURLe($text_strefa_klienta[$lang]); ?>.html"><? echo ucfirst($text_strefa_klienta[$lang]); ?></a> &gt; <span><? echo str_replace('-', ' ', ucfirst($kategoria)); ?></span>
        </div>
        <div class="box profile">                       
            <div class="content">
		<?
			    // sprawdzamy czy user nie jest przypadkiem zalogowany
				if(!$_SESSION['logged']) {
					if ($kategoria == $text_rejestracja[$lang]) {
						
					//	echo '<div class="subtitle">'.$text_okno_rejestracji[$lang].'</div>';
								if(!$_SESSION['logged']) {
		// jeśli zostanie naciśnięty przycisk "Zarejestruj"
		if(isset($_POST['email'])) {
			// filtrujemy dane...
			$_POST['imie'] = Czysc($_POST['imie']);
			$_POST['nazwisko'] = Czysc($_POST['nazwisko']);
			$_POST['email'] = Czysc($_POST['email']);
			$_POST['password'] = Czysc($_POST['password']);
			$_POST['password2'] = Czysc($_POST['password2']);
			$_POST['firma'] = Czysc($_POST['firma']);		
			$_POST['telefon'] = Czysc($_POST['telefon']);
			$_POST['wojewodztwo'] = Czysc($_POST['wojewodztwo']);
			 
			// sprawdzamy czy wszystkie pola zostały wypełnione
			if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) {
				echo '<p>'.$text_wszystkie_pola[$lang].'.</p>';
			// sprawdzamy czy podane dwa hasła są takie same
			} elseif($_POST['password'] != $_POST['password2']) {
				echo '<p>'.$text_hasla_rozne[$lang].'.</p>';
			// sprawdzamy poprawność emaila
			} elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				echo '<p>'.$text_email_nieprawidlowy[$lang].'.</p>';
			} else {
				// sprawdzamy czy są jacyś uzytkownicy z takim adresem email !!!!!!!!!!!dodac sprawdzanie czy sa ale tylko na newsletter
				$result = mysql_query("SELECT Count(id) FROM `uzytkownicy` WHERE `email` = '{$_POST['email']}'");
				$row = mysql_fetch_row($result);
				if($row[0] > 0) {
					echo '<p>'.$text_login_istnieje[$lang].'.</p>';
				} else {
					// jeśli nie istnieje to kodujemy haslo...
					$_POST['password'] = KodujHaslo($_POST['password']);
					// i wykonujemy zapytanie na dodanie usera 
					mysql_query("INSERT INTO `uzytkownicy` (`email`, `password`, `datarejestr`, `imie`, `nazwisko`, `firma`, `telefon`, `wojewodztwo`, `newsletter`, `aktywne`, `jezyk`) VALUES ('{$_POST['email']}', '{$_POST['password']}', '".time()."', '{$_POST['imie']}', '{$_POST['nazwisko']}', '{$_POST['firma']}', '{$_POST['telefon']}', '{$_POST['wojewodztwo']}', '{$_POST['newsletter']}', 'no', '{$lang}')");
					
					// wysylamy maila do admina, ze zalozono konto
					$body .= '<html><head><title>Założono nowe konto na stronie Achilles Polska</title></head><body>';
					$body .= '<p><b>Założono nowe konto na stronie Achilles Polska</b></p>';
					$body .= '<p>Imię: '.$_POST[imie].'</p>';
					$body .= '<p>Nazwisko: '.$_POST[nazwisko].'</p>';
					if (isset($_POST[firma])) { $body .= '<p>Firma: '.$_POST[firma].'</p>'; }
					$body .= '<p>E-mail: '.$_POST[email].'</p>';		
					$body .= '<p>Link do aktywacji: <a href="http://www.achilles.pl/admin/index.php?site=aktywacja">http://www.achilles.pl/admin/index.php?site=aktywacja</a></p>';						
					$body .= '</body></html>';
					$headers  = 'MIME-Version: 1.0'.PHP_EOL;
					$headers .= 'Content-type: text/html; charset=utf8'.PHP_EOL;
					$headers .= 'From: Strona WWW <stronawww@achilles.pl>'.PHP_EOL;
					$headers.="X-Mailer: PHP/". phpversion();
					$subject = 'Nowe konto na stronie Achilles Polska';
									
					// wysylamy maila do usera, ze zalozyl sobie konto
					$u_body .= '<html><head><title>Założono nowe konto na stronie Achilles Polska</title></head><body>';
					$u_body .= '<p>Niniejszy email został wysłany automatycznie z serwisu achilles.pl, w odpowiedzi na prośbę utworzenia nowego konta.</a></p>';
					$u_body .= '<p>Jeśli niniejszy email został wysłany niezgodnie z intencjami, prosimy go zignorować.</p>';				
					$u_body .= '<p>Imię: '.$_POST[imie].'</p>';
					$u_body .= '<p>Nazwisko: '.$_POST[nazwisko].'</p>';
					if (isset($_POST[firma])) { $u_body .= '<p>Firma: '.$_POST[firma].'</p>'; }
					$u_body .= '<p>E-mail: '.$_POST[email].'</p>';
					$u_body .= '</body></html>';
					$u_headers  = 'MIME-Version: 1.0'.PHP_EOL;
					$u_headers .= 'Content-type: text/html; charset=utf8'.PHP_EOL;
					$u_headers .= 'From: Strona WWW <stronawww@achilles.pl>'.PHP_EOL;
					$u_headers.="X-Mailer: PHP/". phpversion();
					$u_subject = 'Nowe konto na stronie Achilles Polska';
					
					if (mail($to, $subject, $body, $headers)){
						mail($_POST[email], $u_subject, $u_body, $u_headers);
						echo '<p>'.$text_udana_rejestracja[$lang].'</p>';
						$register_ok=1;
					}			
				}
			}
		} 
    // wyświetlamy formularz rejestracji
	if(!$register_ok){
	echo '<div class="subtitle">'.$text_okno_rejestracji[$lang].'</div>';
		?>
		
		<form method="post" action="/<? echo LadneURLe($text_strefa_klienta[$lang]).'/'.$text_rejestracja[$lang]; ?>.html">	
			<dl>
				<dt>
					<label for="imie"><? echo $text_imie[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="imie" name="imie" id="imie" value="<? echo $_POST['imie']; ?>" /> <? echo $text_wymagane[$lang]; ?>
				</dd>
				<dt>
					<label for="nazwisko"><? echo $text_nazwisko[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="nazwisko" name="nazwisko" id="nazwisko" value="<? echo $_POST['nazwisko']; ?>" /> <? echo $text_wymagane[$lang]; ?>
				</dd>			
				<dt>
					<label for="login"><? echo $text_email[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="email" name="email" id="email" value="<? echo $_POST['email']; ?>" /> <? echo $text_adres_wymagany[$lang]; ?>
				</dd>
				<dt>
					<label for="password"><? echo $text_haslo[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="password" name="password" id="password" value="<? echo $_POST['password']; ?>" /> <? echo $text_wymagane[$lang]; ?>
				</dd>
				<dt>
					<label for="password"><? echo $text_powtorz_haslo[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="password" name="password2" id="password2" value="<? echo $_POST['password2']; ?>" /> <? echo $text_wymagane[$lang]; ?>
				</dd>
				<dt>
					<label for="firma"><? echo $text_firma[$lang]; ?>:</label>
				</dt>
				<dd>
					<input type="firma" name="firma" id="firma" value="<? echo $_POST['firma']; ?>" />
				</dd>			
				<dt>
					<label for="telefon"><? echo $text_telefon[$lang]; ?>:</label>
				</dt>
				<dd>
					<input required type="telefon" name="telefon" id="telefon" value="<? echo $_POST['telefon']; ?>" /> <? echo $text_wymagane[$lang]; ?>
				</dd>
				<? if ($lang == 'pl') { ?>
				<dt>
					<label for="wojewodztwo">Województwo:</label>
				</dt>
				<dd>
					<select required class="noreload" id="wojewodztwo" name="wojewodztwo">					
						<option value="1" <?if($_POST[wojewodztwo]=='1')echo 'selected="selected"';?>>Dolnośląskie</option>
						<option value="2" <?if($_POST[wojewodztwo]=='2')echo 'selected="selected"';?>>Kujawsko-Pomorskie</option>
						<option value="14" <?if($_POST[wojewodztwo]=='14')echo 'selected="selected"';?>>Łódzkie</option>
						<option value="3" <?if($_POST[wojewodztwo]=='3')echo 'selected="selected"';?>>Lubelskie</option>
						<option value="4" <?if($_POST[wojewodztwo]=='4')echo 'selected="selected"';?>>Lubuskie</option>
						<option value="6" <?if($_POST[wojewodztwo]=='6')echo 'selected="selected"';?>>Małopolskie</option>
						<option value="5" <?if($_POST[wojewodztwo]=='5')echo 'selected="selected"';?>>Mazowieckie</option>
						<option value="7" <?if($_POST[wojewodztwo]=='7')echo 'selected="selected"';?>>Opolskie</option>
						<option value="8" <?if($_POST[wojewodztwo]=='8')echo 'selected="selected"';?>>Podkarpackie</option>
						<option value="9" <?if($_POST[wojewodztwo]=='9')echo 'selected="selected"';?>>Podlaskie</option>
						<option value="10" <?if($_POST[wojewodztwo]=='10')echo 'selected="selected"';?>>Pomorskie</option>
						<option value="15" <?if($_POST[wojewodztwo]=='15')echo 'selected="selected"';?>>Śląskie</option>
						<option value="16" <?if($_POST[wojewodztwo]=='16')echo 'selected="selected"';?>>Świętokrzyskie</option>
						<option value="11" <?if($_POST[wojewodztwo]=='11')echo 'selected="selected"';?>>Warmińsko-Mazurskie</option>
						<option value="12" <?if($_POST[wojewodztwo]=='12')echo 'selected="selected"';?>>Wielkopolskie</option>
						<option value="13" <?if($_POST[wojewodztwo]=='13')echo 'selected="selected"';?>>Zachodniopomorskie</option>
					</select>
					<? echo $text_wymagane[$lang]; ?>
				</dd>
				<? } ?>
				<dt>
					<label for="newsletter">Newsletter:</label>
				</dt>
				<dd>
					<input checked type="checkbox" name="newsletter" id="newsletter" value="yes">		
				</dd>
				<footer>
					<a href="#submit" class="button more"><? echo $text_zarejestruj_sie[$lang]; ?></a>
					<input id="submit" type="submit" value="<? echo $text_zarejestruj_sie[$lang]; ?>" />				
				</footer>
		</form>
	<?
	}
} else {
    echo '<p>Jesteś już zalogowany, więc nie możesz stworzyć nowego konta.</p>
        <p>[<a href="index.php">Powrót</a>]</p>';
}                                  
			
						
						}
					else {
					
					echo '<div class="subtitle">'.$text_okno_logowania[$lang].'</div>';
					
					// jeśli zostanie naciśnięty przycisk "Zaloguj"
					if(isset($_POST['email'])) {
						
						// czyszczenie
						$_POST['email'] = Czysc($_POST['email']);
						$_POST['password'] = Czysc($_POST['password']);
						// i kodujemy hasło
						$_POST['password'] = KodujHaslo($_POST['password']);
 
						// sprawdzam czy dane ok
						$result = mysql_query("SELECT `id`,`admin` FROM `uzytkownicy` WHERE `email` = '{$_POST['email']}' AND `password` = '{$_POST['password']}' AND `aktywne` = 'yes' LIMIT 1");
						if(mysql_num_rows($result) > 0) {
							// jeśli tak to ustawiamy sesje "logged" na true oraz do sesji "user_id" wstawiamy id usera
							$row = mysql_fetch_assoc($result);
							$_SESSION['logged'] = true;
							$_SESSION['user_id'] = $row['id'];
							if ($row['admin'] != 'not') $_SESSION['admin'] = $row['admin'];
							$userid = $row['id'];
							//$logowanie='0,1';							
							header ('location: /'.LadneURLe($text_strefa_klienta[$lang]).'.html');
							exit();
							echo '<p>'.$text_logowanie_poprawne[$lang].'.</p>';
			
						} else {
							echo '<p>'.$text_login_haslo_zle[$lang].'.</p>';
						}
					}
				
    // wyświetlamy komunikat na zalogowanie się
    
 
			?>
                <form method="post" action="/<? echo LadneURLe($text_strefa_klienta[$lang]); ?>.html">				
                    <dl>
                        <dt>
                            <label for="login"><? echo $text_login[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="email" name="email" id="email" value="<? echo $_POST['email']; ?>" />
                        </dd>
                        
                        <dt>
                            <label for="password"><? echo $text_haslo[$lang]; ?></label>
                        </dt>
                        <dd>
                            <input required type="password" name="password" id="password" value="<? echo $_POST['password']; ?>" />
                        </dd>
                    </dl>
                    <footer>						
                        <a href="/<? echo LadneURLe($text_nie_pamietam[$lang]); ?>.html" class="remind-password"><? echo $text_nie_pamietam[$lang]; ?></a>
                        <a href="#submit" class="button more"><? echo $text_zaloguj[$lang]; ?></a>
                        <input id="submit" type="submit" value="<? echo $text_zaloguj[$lang]; ?>" />
						<a class="remind-password" href="/<? echo LadneURLe($text_strefa_klienta[$lang]).'/'.$text_rejestracja[$lang]; ?>.html"><? echo $text_nie_mam_konta[$lang]; ?></a>						
                    </footer>
                </form>
			<?	} 
			}
			
			else {
						$sql = "SELECT imie,nazwisko,email,datarejestr,dataedycji,firma,adres,telefon FROM uzytkownicy WHERE id = ".$_SESSION['user_id'];
						$result = mysql_query($sql);
						$row = mysql_fetch_assoc($result);								
						echo '<div class="subtitle">'.$text_witamy_strefa_klienta[$lang].' <span class="achilles">Achilles <span>Polska</span></span></div>';
				switch ($kategoria) {					
					case ($kategoria == LadneURLe($text_wyloguj[$lang])): 
						echo '<p>'.$text_zostales_wylogowany[$lang].'.</p>';  // mozna dac location gdzies poza switcha
						$_SESSION['logged'] = false;
						$_SESSION['admin'] = false;
						$_SESSION['cmslang'] = false;
						$_SESSION['user_id'] = -1;						
						break;
					case ($kategoria == LadneURLe($text_dane_podstawowe[$lang])):
						MenuStrefa();						
						echo '<div class="tab-content">
                                <div class="overview" style="top: 0px;">
                                    <dl><dt>'.$text_imie[$lang].': </dt><dd>'.$row["imie"].'</dd><dt>'.$text_nazwisko[$lang].': </dt><dd>'.$row["nazwisko"].'</dd><dt>'.$text_email[$lang].': </dt><dd>'.$row["email"].'</dd><dt>'.$text_data_rejestracji[$lang].':  </dt><dd>'.date("d.m.Y, H:i", $row['datarejestr']).'</dd>';
						if ($row['dataedycji'] != '0') { 
							echo '<dt>'.$text_data_edycji[$lang].':  </dt><dd>'.date("d.m.Y, H:i", $row['dataedycji']).'</dd>';
						}
						if ($_SESSION['admin'] != 'not' && $_SESSION['admin']) {
								echo '<dt>Administrator: </dt><dd> ';
           						$lang_cms = explode(',', $_SESSION['admin']); 
            					$lang_cms_count = count ($lang_cms);
            					for ($i = 0; $i < $lang_cms_count;  $i++) {	
									echo '<img src="/img/flags/'.$lang_cms[$i].'.png" />&nbsp;';
              					}              
            				echo '</dd>';
							}
						echo '</dl>
							</div>                            
                        </div>';
						break;
					case ($kategoria == LadneURLe($text_realizacje[$lang])):
						MenuStrefa();	
						echo '<div class="tab-content">
                                <div class="overview" style="top: 0px;">
                                    Tu będą realizacje.
                                </div>                            
                        </div>';
						break;
					case ($kategoria == LadneURLe($text_dane_adresowe[$lang])):
						MenuStrefa();	
						echo '<div class="tab-content">
                                <div class="overview" style="top: 0px;">
                                    <dl><dt>'.$text_firma[$lang].': </dt><dd>'.$row["firma"].'</dd><dt>'.$text_adres[$lang].': </dt><dd>'.$row["adres"].'</dd><dt>'.$text_telefon[$lang].': </dt><dd>'.$row["telefon"].'</dd>
                                </div>                            
                        </div>';
						break;
					//case ($kategoria == 'edytuj' || $kategoria == 'edit' || $kategoria == 'redigere' || $kategoria == 'redigera'):
					case ($kategoria == LadneURLe($text_edytuj[$lang])):
						MenuStrefa();	
						echo '<div class="tab-content">
                                <div class="overview" style="top: 0px;">';
			?>
			<?	$user_data = PobierzDane();
 
// edytuj profil
if(isset($_POST['email'])) {
    
    $_POST['email'] = Czysc($_POST['email']);
    $_POST['imie'] = Czysc($_POST['imie']);
    $_POST['nazwisko'] = Czysc($_POST['nazwisko']);
    $_POST['new_password'] = Czysc($_POST['new_password']);
    $_POST['new_password2'] = Czysc($_POST['new_password2']);
    $_POST['password'] = Czysc($_POST['password']);
	$_POST['newsletter'] = Czysc($_POST['newsletter']);
	$_POST['firma'] = Czysc($_POST['firma']);
	$_POST['adres'] = Czysc($_POST['adres']);
	$_POST['telefon'] = Czysc($_POST['telefon']);
	$_POST['wojewodztwo'] = Czysc($_POST['wojewodztwo']);

     // zmienna tymczasowa na text bledu
    $err = '';
    // zmienna tymczasowa na zapytanie sql
    $up2 = '';
 
    // jeśli zostanie podane nowe hasło lub inny email
    if(!empty($_POST['new_password']) || $_POST['email'] != $user_data['email']) {
        // sprawdzamy czy zostało podane aktualne hasło
        if(empty($_POST['password'])) {
            $err = '<p>'.$text_aktualne_haslo_wymagane[$lang].'.</p>';
        // jeśli tak to czy poprawne
        } elseif(KodujHaslo($_POST['password']) != $user_data['password']) {
            $err = '<p>'.$text_aktualne_haslo_zle[$lang].'.</p>';
        } else {
            // jesli wszystko ok
 
            // sprawdzamy czy user chce zmienić hasło
            if(!empty($_POST['new_password'])) {
                // jeśli podane dwa hasła są różne to wyświetlamy błąd
                if($_POST['new_password'] != $_POST['new_password2']) {
                    $err = '<p>'.$text_hasla_rozne[$lang].'.</p>';
                // jeśli wszystko jest ok, dopisujemy do zmiennej tymczasowej zapytanie do zaktualizowania hasła
                } else {
                    $up2.= ", `password` = '".KodujHaslo($_POST['new_password'])."'";
                }
            }
            // sprawdzamy czy user chce zmienić email (czy ten podany jest różny od aktualnego)
            if($_POST['email'] != $user_data['email']) {
                // sprawdzamy czy podany email jest prawidłowy
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $err = '<p>'.$text_email_zly[$lang].'.</p>';
                } else {
                    // sprawdzamy czy istnieje taki email w bazie przy czym omijamy usera który jest zalogowany
					$sql = "SELECT Count(id) FROM `uzytkownicy` WHERE `id` != '{$user_data['id']}' AND `email` = '{$_POST['email']}'";
					//echo 'SQL '.$sql;
                    $result = mysql_query($sql);
                    $row = mysql_fetch_row($result);
                    if($row[0] > 0) {
                        $err = '<p>'.$text_login_istnieje[$lang].'.</p>';
                    } else {
                        // jeśli wszystko jest ok to dopisujemy zapytanie do zaktualizowania emaila
                        $up2.= ", `email` = '{$_POST['email']}'";
                    }
                }
            }
        }
    }
 
    // jeśli są jakieś błędy z powyższych działań to je wyświetlamy
    if(!empty($err)) {
        echo $err;
    } else {
        // jeśli nie ma błędów to wykonujemy zapytanie dopisując te na aktualizacje hasła oraz emaila - $up2
		$sql = "UPDATE `uzytkownicy` SET `imie` = '{$_POST['imie']}', `nazwisko` = '{$_POST['nazwisko']}', `firma` = '{$_POST['firma']}', `adres` = '{$_POST['adres']}', `wojewodztwo` = '{$_POST['wojewodztwo']}', `telefon` = '{$_POST['telefon']}', `dataedycji` = '".time()."'{$up2} WHERE `id` = '{$user_data['id']}'";
        $result = mysql_query($sql);
        if($result) {
            // jeśli zapytanie się wykonało to wyświetlamy komunikat...
            echo '<p>'.$text_dane_zmienione[$lang].'.</p>';			
            // i pobieramy od nowa dane usera aby w poniższym formularze się one zaktualizowały
            $user_data = PobierzDane();
        } else {
            // jeśli zapytanie będzie błędne to wyświetlamy treść errora
            echo '<p>Niestety wystąpił błąd:<br>'.mysql_error().'</p>';
        }
    }
}
 
// formularz
echo '<form method="post" action="/'.$text_strefa_klienta[$lang].'/'.LadneURLe($text_edytuj[$lang]).'.html">
    <dl>
        <dt>
			<label for="login">'.$text_login[$lang].'</label>
        </dt>
        <dd>
			<input type="text" value="'.$user_data['email'].'" name="email">
		</dd>
		<dt>
			<label for="imie">'.$text_imie[$lang].'</label>
		</dt>
		<dd>
			<input type="text" value="'.$user_data['imie'].'" name="imie">
		</dd>
		<dt>
			<label for="nazwisko">'.$text_nazwisko[$lang].'</label>
		</dt>
        <dd>
			<input type="text" value="'.$user_data['nazwisko'].'" name="nazwisko">
		</dd>
		<dt>
			<label for="password">'.$text_nowe_haslo[$lang].'</label>
		</dt>
		<dd>
			<input type="password" value="" name="new_password" autocomplete="off"> '.$text_zostaw_puste[$lang].'
		</dd>
		<dt>
			<label for="password">'.$text_powtorz_nowe_haslo[$lang].'</label>
		</dt>
		<dd>
			<input type="password" value="" name="new_password2" autocomplete="off">
		</dd>
		<dt>    
			<label for="password">'.$text_aktualne_haslo[$lang].'</label>
		</dt>
		<dd>
			<input type="password" value="" name="password" autocomplete="off"> '.$text_wymagane_przy_zmianie[$lang].'
		</dd>
		<dt>
			<label for="firma">'.$text_firma[$lang].'</label>
		</dt>
        <dd>
			<input type="text" value="'.$user_data['firma'].'" name="firma">
		</dd>
        <dt>
			<label for="adres">'.$text_adres[$lang].'</label>
		</dt>
        <dd>
			<input type="text" value="'.$user_data['adres'].'" name="adres">
		</dd>
        <dt>
			<label for="telefon">'.$text_telefon[$lang].'</label>
		</dt>
        <dd>
			<input type="text" value="'.$user_data['telefon'].'" name="telefon">
		</dd>';
        if ($user_data[wojewodztwo] != '') {     ?>     		
        <dt>
			<label for="wojewodztwo"><? echo $text_wojewodztwo[$lang]; ?></label>
		</dt>          		
        <dd>     		
                 <select class="noreload" id="wojewodztwo" name="wojewodztwo">	
                 	<option value="1" <?if($user_data[wojewodztwo]=='1')echo 'selected="selected"';?>>Dolnośląskie</option>
					<option value="2" <?if($user_data[wojewodztwo]=='2')echo 'selected="selected"';?>>Kujawsko-Pomorskie</option>
					<option value="14" <?if($user_data[wojewodztwo]=='14')echo 'selected="selected"';?>>Łódzkie</option>
					<option value="3" <?if($user_data[wojewodztwo]=='3')echo 'selected="selected"';?>>Lubelskie</option>
					<option value="4" <?if($user_data[wojewodztwo]=='4')echo 'selected="selected"';?>>Lubuskie</option>
					<option value="6" <?if($user_data[wojewodztwo]=='6')echo 'selected="selected"';?>>Małopolskie</option>
					<option value="5" <?if($user_data[wojewodztwo]=='5')echo 'selected="selected"';?>>Mazowieckie</option>
					<option value="7" <?if($user_data[wojewodztwo]=='7')echo 'selected="selected"';?>>Opolskie</option>
					<option value="8" <?if($user_data[wojewodztwo]=='8')echo 'selected="selected"';?>>Podkarpackie</option>
					<option value="9" <?if($user_data[wojewodztwo]=='9')echo 'selected="selected"';?>>Podlaskie</option>
					<option value="10" <?if($user_data[wojewodztwo]=='10')echo 'selected="selected"';?>>Pomorskie</option>
					<option value="15" <?if($user_data[wojewodztwo]=='15')echo 'selected="selected"';?>>Śląskie</option>
					<option value="16" <?if($user_data[wojewodztwo]=='16')echo 'selected="selected"';?>>Świętokrzyskie</option>
					<option value="11" <?if($user_data[wojewodztwo]=='11')echo 'selected="selected"';?>>Warmińsko-Mazurskie</option>
					<option value="12" <?if($user_data[wojewodztwo]=='12')echo 'selected="selected"';?>>Wielkopolskie</option>
					<option value="13" <?if($user_data[wojewodztwo]=='13')echo 'selected="selected"';?>>Zachodniopomorskie</option>
                 </select>
        </dd>
        <? }        
	echo '</dl>
	<footer>
		<input type="submit" value="'.$text_zmien_dane[$lang].'">
	</footer>
    </form>';
                        echo '        </div>                            
                        </div>';
						break;
					default:					
						MenuStrefa();	
						echo '<div class="tab-content">
                                <div class="overview" style="top: 0px;">
                                    <dl><dt>'.$text_imie[$lang].': </dt><dd>'.$row["imie"].'</dd><dt>'.$text_nazwisko[$lang].': </dt><dd>'.$row[nazwisko].'</dd><dl><dt>'.$text_email[$lang].': </dt><dd>'.$row["email"].'</dd>
                                </div>                            
                        </div>';
						break;
				}
			}   
		break;
	default:
			$right = '_null';
?>
		<div class="breadcrumbs">
            <a href="/">Achilles.pl</a>
        </div>
        <div class="box profile">
            <header class="message">
                <?=$text_podana_strona_nie_istnieje[$lang]?>
            </header>            
            <div class="content"><?=$opis_podana_strona_nie_istnieje[$lang]?>
	<?		
	break;
	}
?>
                
          </div>
      </div><!--  
      --><div id="right-col"><? include "right".$right.".php"; ?>
      </div>
  </div>
 <?/* 
  <div style="width: 120px; display: inline-block;">
  <script language='JavaScript' type='text/javascript' src='http://ads.uszlachetnianiedruku.pl/adx.js'></script>
	<script language='JavaScript' type='text/javascript'>
	<!--
	   if (!document.phpAds_used) document.phpAds_used = ',';
	   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
	   
	   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
	   document.write ("http://ads.uszlachetnianiedruku.pl/adjs.php?n=" + phpAds_random);
	   document.write ("&amp;what=zone:4&amp;block=1");
	   document.write ("&amp;exclude=" + document.phpAds_used);
	   if (document.referrer)
		  document.write ("&amp;referer=" + escape(document.referrer));
	   document.write ("'><" + "/script>");
	//-->
	</script><noscript><a href='http://ads.uszlachetnianiedruku.pl/adclick.php?n=a0bf86e0' target='_blank'><img src='http://ads.uszlachetnianiedruku.pl/adview.php?what=zone:4&amp;n=a0bf86e0' border='0' alt=''></a></noscript>
  </div>
  */?>
<? 
	include 'footer.php'
?>
