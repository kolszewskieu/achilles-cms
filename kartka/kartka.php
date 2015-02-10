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
<body  style="color:#FFFFFF">
	<table width="400" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="color:#FFFFFF;background-color:#EE7000;" align="center">
	<tr>
		<td style="border:<?=$_GET[ramka];?>px solid #F26522">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="400" valign="top">';
//						<center><a href="http://www.achilles.pl" target="_blank"><img src="http://www.achilles.pl/kartka/logo_AchillesPolska_rgb_300.jpg" alt="Achilles Polska" border="0"/></a></center>';
$style="margin-left:0px;margin-top:10px;border: solid 0px white;text-align: center;text-transform:uppercase;font-size: 12px;";
if($_GET[lang]=="EN"){
	$body.='<p style="margin-left:0px;margin-top:10;padding-top: 0px;border: solid 0px white;text-align: center;text-transform:uppercase;"><b>In this special Easter season</b></p>
	<p style="'.$style.'">warm greetings, lots of joy and happiness,</p>
	<p style="'.$style.'">plenty of time with your family</p>
	<p style="'.$style.'">and exceptional atmosphere at the Easter table</p>
	<p style="'.$style.'">from</p>';
}
if(!$_GET[lang] || $_GET[lang]=="PL"){
	$body.='<p style="margin-left:0px;margin-top:10;padding-top: 0px;border: solid 0px white;text-align: center;text-transform:uppercase;"><b>Z okazji Świąt Wielkanocnych</b></p>
	<p style="'.$style.'">wszystkiego co najlepsze,</p>
	<p style="'.$style.'">rodzinnej atmosfery, szczęścia osobistego,</p>
	<p style="'.$style.'">pogody ducha, smacznego święconego jajka</p>
	<p style="'.$style.'">i suto zastawionych stołów</p>
	<p style="'.$style.'">życzy</p>';
}
//	<p style="'.$style.'">wszystkim naszym Partnerom,</p>
//	<p style="'.$style.'">Przyjaciołom, Klientom</p>
//	<p style="'.$style.'">i Współpracownikom</p>
	
if($_GET[podpis]){
	$body.='<p style="margin-left:0px;margin-top:10;text-align:center;"><b>'.$_GET[podpis].'</b></p>';
}
if($_GET[podpisA]){
	$body.='<p style="margin-left:0px;margin-top:10;font-size:75%;text-align:center;">'.$_GET[podpisA].'</p>';
}
$body.='	</td>
				</tr>
			<tr>
				<td height="91" width="300">
					<center><a target="_blank" href="http://www.achilles.pl"><img style="display:block;border: solid 0px black;" src="http://www.achilles.pl/kartka/jajka_2014.png" alt="Pisanki Achilles Polska." /></a></center>
				</td>
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