<?
/*
<div class="well sidebar-nav">
<ul class="nav nav-list">
  <li class="nav-header">Wyceny</li>
  <li <? if ($_GET[action]=='new') echo 'class="active"'?>><a href="wyceny.php?action=new">Nowa wycena</a></li>
  <li <? if ($_GET[action]=='list') echo 'class="active"'?>><a href="wyceny_lista.php?action=list">Wyceny</a></li>
  <!--li <? if ($_GET[action]=='load') echo 'class="active"'?>><a href="wyceny.php?action=load">Wczytaj wycenę</a></li-->
  <li class="nav-header">Słowniki</li>
  
<?
$_MENU_SLOWNIKI=array(
"wyceny_produkty.php"=>"Produkty",
"wyceny_formaty.php"=>"Formaty produkt",
"wyceny_formaty_oklejka.php"=>"Formaty oklejka",
"wyceny_formaty_wklejka.php"=>"Formaty wklejka",
"wyceny_folie.php"=>"Typy folii",
"wyceny_folia_oklejka.php"=>"Folia oklejka",
"wyceny_folia_wklejka.php"=>"Folia wklejka",
"wyceny_lakierowanie.php"=>"Lakierowanie",
"wyceny_druk_oklejka.php"=>"Druk oklejka",
"wyceny_druk_wklejka.php"=>"Druk wklejka",
"wyceny_mechanizmy.php"=>"Mechanizmy",
"wyceny_elementy.php"=>"Elementy stałe",
"wyceny_dodatki.php"=>"Dodatki",
"wyceny_odpady.php"=>"Odpady",
"wyceny_konfiguracja.php"=>"Konfiguracja");
$file=str_replace("/admin/","",$_SERVER[PHP_SELF]);

foreach($_MENU_SLOWNIKI as $key => $val){
?>
  <li <? if ($file ==$key) echo 'class="active"'?>><a href="<?=$key?>"><?=$val?></a></li>
<?}?>
  <!--li><a href="#myModal_ceny" role="button" data-toggle="modal">Ceny materiałów</a></li>
  <li><a href="#myModal_kursy" role="button" data-toggle="modal">Kurs EUR</a></li-->
</ul>
</div><!--/.well -->
*/
?>