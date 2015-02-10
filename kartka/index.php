<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Achilles CMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="admin/css/bootstrap.css" rel="stylesheet">	
<link href="admin/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
<link href="admin/css/bootstrap.css" rel="stylesheet">	

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
</style>
</head>
<body>
<?
if(!$lang)$lang="PL";
if(!$tytul)$tytul="Wesołych Świąt, wiosennych Świąt...";
?>

<h1>Wysyłamy kartkę świąteczną :-)</h1><br/>
<form action="kartka.php" method="GET">
	<label class="control-label" for="inputEmail">Od nazwa:</label>
	<input type="text" placeholder="Imie i Nazwisko" value="<?=$od_nazwa?>" name="od_nazwa"><br/><br/>
	<label class="control-label" for="inputEmail">Od email:</label>
	<input type="text" id="inputEmail" placeholder="Email" value="<?=$od?>" name="od"><br/><br/>
	<label class="control-label" for="inputEmail">Podpis:</label>
	<input type="text" placeholder="Podpis" value="<?=$podpis?>" name="podpis"><br/><br/>
	<label class="control-label" for="inputEmail">Podpis druga linia:</label>
	<input type="text" placeholder="Podpis" value="<?=$podpisA?>" name="podpisA"><br/><br/>
	<label class="control-label" for="inputEmail">Wersja:</label>
	<input type="radio" name="lang" value="PL" <?=($lang=="PL"?"checked":"")?>> PL <input type="radio" name="lang" value="EN" <?=($lang=="EN"?"checked":"")?>> EN <br/><br/>
	<label class="control-label" for="inputEmail">Tytuł maila:</label>
	<input type="text" value="<?=$tytul?>" name="tytul">
	<br/>propozycje tytułów:
	<br/>Wesołych Świąt, wiosennych Świąt ...
	<br/>Happy Easter time!
	<br/><br/>
	<label class="control-label" for="inputEmail">Wysyłam do:</label>
	<input type="text" id="inputEmail" placeholder="Email" value="<?=$do?>"  name="do">(pozostaw puste jeśli chcesz wygenerować tylko HTML kartki) <br/><br/>
	<!--input type="submit" value="Go, Ho ho ho !!" name="send"-->
	<input type="submit" value="Happy Easter" name="send">
</form>
</body>
</html>