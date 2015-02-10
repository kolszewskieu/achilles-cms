<?
$body='<html><head>
	<title>Achilles.pl</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		#outlook a {padding:0;}
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;color:#4a4a4a}
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:10px auto; padding:0; line-height: 100% !important;}

		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;}
		.image_fix {display:block;}

		p {margin: 10px 0 0 0;}


		h1, h2, h3, h4, h5, h6 {color: black !important;}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
			color: red !important;
		 }

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
			color: purple !important;
		}

		table td {border-collapse: collapse;}

    table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;  font-family:arial}

		a {color:  #E56B14;;}

	</style>
</head>
<body  style="color:#000000">
	<table width="700" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="color:#000000" align="center">
	<tr>
		<td style="border:<?=$_GET[ramka];?>px solid #F26522">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td height="91" width="300">
						<img style="display:block" src="http://www.achilles.pl/kartka/choinka_small.jpg" alt="Wesołych Świąt" />
					</td>
					<td width="400" valign="top">
						<center><a href="http://www.achilles.pl" target="_blank"><img src="http://www.achilles.pl/kartka/logo_AchillesPolska_rgb_300.jpg" alt="Achilles Polska" border="0"/></a></center>';
if($_GET[lang]=="EN"){
	$body.='<p style="margin-left:20px;margin-top:10;padding-top: 30px;border: solid 0px white;"><b>Merry Christmas!</b></p>
	<p style="margin-left:20px;margin-top:30px;border: solid 0px white;">May this Christmas season be unforgettable,</p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">filled with magical moments, </p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">warmth and joy, </p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">and the New Year full of pleasant </p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">surprises and sunny days.</p>';
}
if(!$_GET[lang] || $_GET[lang]=="PL"){
	$body.='<p style="margin-left:20px;margin-top:10;padding-top: 30px;border: solid 0px white;"><b>Wesołych Świąt!</b></p>
	<p style="margin-left:20px;margin-top:30px;border: solid 0px white;">Niezapomnianych Świąt Bożego Narodzenia,</p>
	<p style="margin-left:20px;margin-top:10;border: solid 0px white;">pełnych magicznych chwil, uśmiechu,</p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">ciepła i radości.</p>
	<p style="margin-left:20px;margin-top:10;border: solid 0px white;">W Nowym Roku samych miłych niespodzianek</p>
	<p style="margin-left:20px;margin-top:1;border: solid 0px white;">i słonecznych dni</p>
	<p style="margin-left:20px;margin-top:10">życzy</p>';
}
if($_GET[podpis]){
	$body.='<p style="margin-left:20px;margin-top:10"><b>'.$_GET[podpis].'</b></p>';
}
if($_GET[podpisA]){
	$body.='<p style="margin-left:20px;margin-top:10;font-size:75%"><b>'.$_GET[podpisA].'</b></p>';
}
$body.='	</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>';

if($_GET[send] && $_GET["do"] && ($_GET["podpis"] || $_GET["podpisA"])){
	$headers  = 'MIME-Version: 1.0'.PHP_EOL;
	$headers .= 'Content-type: text/html; charset=UTF-8'.PHP_EOL;
	$headers .= 'From: =?UTF-8?B?' . base64_encode($_GET[od_nazwa]) . '?= <'.$_GET["od"].'>'.PHP_EOL;
	$headers .= 'Reply-To: '.$_GET["od"].'>'.PHP_EOL;
	$recipient = $_GET["do"];
	$subject = $_GET["tytul"];

	if(mail($recipient, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers)){
		echo 'Mail został wysłany. <a href="#" onClick="javascript:history.back()"><< kolejny</a><br/>';
	}
}
elseif($_GET[send] && $_GET["do"] && !$_GET["podpis"] && !$_GET["podpisA"]){
	echo '<b><font color="red">Musisz podpisać wiadomość.</font></b><br/>';
	echo 'Mail NIE został wysłany. <a href="#" onClick="javascript:history.back()"><< popraw</a><br/>';
}
echo $body;
?>