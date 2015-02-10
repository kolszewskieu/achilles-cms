<?
include('wyceny_header.php');

if(!$_GET[liczba])$_GET[liczba]=500;
if(!$_GET[kurs] || $_GET[wczytaj_waluta])$_GET[kurs]=$_KURS_CONF;
$_KURS=$_GET[kurs];

if(!$_GET[pricing_lang])$_GET[pricing_lang]="";

//if(!$_GET[papier_oklejka])$_GET[papier_oklejka]=1;

//DODAĆ WCZYTYWANIE CENY TEKTURY !!!!

//include('wyceny_menu.php');
//        </div><!--/span-->
//        <div class="span10">
?>
		<?if($alert){?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Operation error!</strong>&nbsp;<?=$alert?>
			</div>
		<?}?>
		<?if($alert_ok){?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Operation completed!</strong>&nbsp;<?=$alert_ok?>
			</div>
		<?}?>
		<?
		//<div class="row-fluid">
		//	<div class="span12">
		?>
			<form name="wycena" action="">
		<?
		if($_GET[przelicz]==1 || $_GET[przelicz_nowa]==1){
			if($_GET[show_wycena_id]){
				$sql="SELECT parametry FROM wyceny WHERE id='$_GET[show_wycena_id]'";
				if($res=mysql_query($sql)){
					list($parametry)=mysql_fetch_row($res);
				}else{
					echo "Read pricing problem:".mysql_error();
				}
				$_GET=array_merge($_GET,unserialize($parametry));
				if($_GET[kurs])$_KURS=$_GET[kurs];
			}
			foreach($_GET as $key => $val){
				if(is_array($val)){
					foreach($val as $vkey => $vval){
						if($vval){
					?>
						<input type="hidden" value="<?=$vval?>" name="<?=$key?>[<?=$vkey?>]">
					<?
						}
					}
				}else{?>
					<input type="hidden" value="<?=$val?>" name="<?=$key?>">
			<?	}
			}
//			<div class="row-fluid">
//			<div class="span12">

		?>
			<?if(!$_GET['print']){?><h3>Przeliczenie wyceny</h3><?}?>
			<fieldset>				
				<div class="row-fluid">
					<div class="span6">
						<legend>Parametry wyceny</legend>
						Typ produktu &nbsp; <strong><?=$_GET[typ_nazwa]?></strong><br/>
						Grubość &nbsp;<strong><?=$_GET[grubosc]?></strong><br/>
						Format produktu &nbsp;<strong><?=$_GET[format_x]?> x <?=$_GET[format_y]?></strong>
					</div>
					<div class="span6">
						<legend>Dane klienta</legend>
							Nazwa klienta &nbsp; <strong><?=$_GET[nazwa_klienta]?></strong><br/>
							Nazwa zlecenia &nbsp;<strong><?=$_GET[nazwa_zlecenia]?></strong><br/>
							Liczba sztuk &nbsp; <strong><?=$_GET[liczba]?> szt.</strong>
					</div>
				</div>
				
				<table class="table table-bordered">
				<th>#</th>
				<th>Komponent</th>
				<th>Koszt całkowity  EUR <small>(kurs: <?=$_KURS["pln/eur"];?> zł)</small></th>
				<th>Koszt na jedną sztukę produktu EUR</th>
				<th>Koszt całkowity PLN</th>
				<th>Koszt na jedną sztukę produktu PLN</th>
				<tr><td>1</td><td>
				<?
					$sql="SELECT id_format,format_x_od,format_x_do,format_y_od,format_y_do,tektura_x,tektura_y,sztuk_arkusz FROM format_tektura ";
					$sql.="WHERE typ='$_GET[typ]' AND (";
					$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
					$sql.=" OR ";
					$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					$sql.=" AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
					$sql.=") AND grubosc_od<='$_GET[grubosc]' AND grubosc_do>='$_GET[grubosc]' ";
					$sql.="AND del='0' ORDER BY prio ASC";
					list($id_format,$format_x_od,$format_x_do,$format_y_od,$format_y_do,$tektura_x,$tektura_y,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
					echo "Tektura ";
					echo "(format: ".$tektura_x." x ".$tektura_y.", Utilities: ".$sztuk_arkusz."&nbsp;items per sheet, grubość: ".$_GET[grubosc].", ".$_CONF["cena_tektura_tona"][$_GET[typ]]." ".$_CONF[waluta_tektura_tona][$_GET[typ]]."/tona)";
					$_koszt_pln[1]=round(((($_GET[grubosc]*0.6)*($tektura_x/1000)*($tektura_y/1000)*(($_CONF["cena_tektura_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_tektura_tona][$_GET[typ]]])/1000))*$_GET[liczba])/$sztuk_arkusz,2);
					$_koszt_eur[1]=round(((($_GET[grubosc]*0.6)*($tektura_x/1000)*($tektura_y/1000)*(($_CONF["cena_tektura_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_tektura_tona][$_GET[typ]]])/1000))*$_GET[liczba])/$sztuk_arkusz,2);;
					$SUMA_PLN=$_koszt_pln[1];
					$SUMA_EUR=$_koszt_eur[1];
				?>
				</td><td><?=$_koszt_eur[1];?></td><td><?=round($_koszt_eur[1]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[1];?></td><td><?=round($_koszt_pln[1]/$_GET[liczba],2);?></td></tr>
				<tr><td>2</td><td>
				<?
					$sql="SELECT id_format as id_format_oklejka,papier_x as papier_oklejka_x,papier_y as papier_oklejka_y,grubosc_od,sztuk_arkusz FROM format_oklejka ";
					$sql.="WHERE typ='$_GET[typ]' AND";
					$sql.="(";
					$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]')";
					$sql.=" OR ";
					$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
					$sql.=") ";
					$sql.="AND del='0' ORDER BY prio ASC";
					list($id_format_oklejka,$papier_oklejka_x,$papier_oklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
					echo "Papier oklejka (Grammage: &nbsp;".$grubosc_od.",format:&nbsp;".$papier_oklejka_x." x ".$papier_oklejka_y.",Utilities: &nbsp;".$sztuk_arkusz." items per sheet)<br/>";

					$_koszt_pln[2]=round(($_GET[liczba]*($grubosc_od/1000)*($papier_oklejka_x/1000)*($papier_oklejka_y/1000)*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000))/$sztuk_arkusz,2);
					$_koszt_eur[2]=round(($_GET[liczba]*($grubosc_od/1000)*($papier_oklejka_x/1000)*($papier_oklejka_y/1000)*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000))/$sztuk_arkusz,2);
					$SUMA_PLN+=$_koszt_pln[2];
					$SUMA_EUR+=$_koszt_eur[2];
				?>
					</td><td><?=$_koszt_eur[2];?></td><td><?=round($_koszt_eur[2]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[2];?></td><td><?=round($_koszt_pln[2]/$_GET[liczba],2);?></td></tr>
				<tr><td>3</td><td>
				<?
				if($_GET[bez_papier_wklejka]){
				?>
					Papier wklejka</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>				
				<?
				}else{
					$sql="SELECT id_format as id_format_wklejka,papier_x as papier_wklejka_x,papier_y as papier_wklejka_y,grubosc_od,sztuk_arkusz FROM format_wklejka ";
					$sql.="WHERE typ='$_GET[typ]' AND ";
					$sql.="(";
					$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
					$sql.=" OR ";
					$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
					$sql.=") ";					
					$sql.="AND del='0' ORDER BY prio ASC";
					list($id_format_wklejka,$papier_wklejka_x,$papier_wklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));					
					echo "Papier wklejka (Grammage: &nbsp;".$grubosc_od.",format:&nbsp;".$papier_wklejka_x." x ".$papier_wklejka_y.",Utilities: &nbsp;".$sztuk_arkusz." items per sheet)<br/>";

					$_koszt_pln[3]=round(($_GET[liczba]*($grubosc_od/1000)*($papier_wklejka_x/1000)*($papier_wklejka_y/1000)*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000))/$sztuk_arkusz,2);
					$_koszt_eur[3]=round(($_GET[liczba]*($grubosc_od/1000)*($papier_wklejka_x/1000)*($papier_wklejka_y/1000)*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000))/$sztuk_arkusz,2);
					$SUMA_PLN+=$_koszt_pln[3];
					$SUMA_EUR+=$_koszt_eur[3];
				?>
				</td><td><?=$_koszt_eur[3];?></td><td><?=round($_koszt_eur[3]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[3];?></td><td><?=round($_koszt_pln[3]/$_GET[liczba],2);?></td></tr>				
				<?
				}
				?>
				<tr><td>4</td><td>
				Druk oklejka
				<?
					if($_GET[druk_typ_oklejka]){
						echo "(Typ druku &nbsp;".$_GET[druk_typ_oklejka].")";
						$sql="SELECT id as id_druk_oklejka,cena,cena_szt,cena_typ,waluta,szt_od,szt_do FROM druk_oklejka ";
						$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
						$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
						$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
						$sql.="AND del='0'";
						list($id_druk_oklejka,$cena,$cena_szt,$cena_typ,$waluta,$szt_od,$szt_do)=mysql_fetch_row(mysql_query($sql));
						if($id_druk_oklejka){
							if($cena>0){echo "<br>Cena :".$cena." ".$waluta." ";}
							if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
						}
						if($cena>0){
							$_koszt_pln[4]=round($cena*$_KURS["pln/$waluta"],3);
							$_koszt_eur[4]=round($cena*$_KURS["eur/$waluta"],3);
						}
						if($cena_szt>0){
							if($szt_do==0 || $szt_do > $_GET[liczba])$szt_do=$szt_od;
							$_koszt_pln[4]+=round(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["pln/$waluta"]),2);
							$_koszt_eur[4]+=round(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["eur/$waluta"]),2);
						}
						?>
						</td><td><?=$_koszt_eur[4];?></td><td><?=round($_koszt_eur[4]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[4];?></td><td><?=round($_koszt_pln[4]/$_GET[liczba],2);?></td></tr>
						<?
						$SUMA_PLN+=$_koszt_pln[4];
						$SUMA_EUR+=$_koszt_eur[4];
					}else{
						?>
						</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
						<?
					}
				?>
				<tr><td>5</td><td>
				Druk wklejka
				<?
					if($_GET[druk_typ_wklejka]){
						echo "(Typ druku &nbsp;".$_GET[druk_typ_wklejka].")";
						$sql="SELECT id as id_druk_wklejka,cena,cena_szt,cena_typ,waluta,szt_od,szt_do FROM druk_wklejka ";
						$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
						$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
						$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
						$sql.="AND del='0'";
						list($id_druk_wklejka,$cena,$cena_szt,$cena_typ,$waluta,$szt_od,$szt_do)=mysql_fetch_row(mysql_query($sql));
						if($id_druk_oklejka){
							if($cena>0){echo "<br>Cena :".$cena." ".$waluta." ";}
							if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
						}
						if($cena>0){
							$_koszt_pln[5]=round($cena*$_KURS["pln/$waluta"],2);
							$_koszt_eur[5]=round($cena*$_KURS["eur/$waluta"],2);
						}
						if($cena_szt>0){
							if($szt_do==0 || $szt_do > $_GET[liczba])$szt_do=$szt_od;
							$_koszt_pln[5]+=round(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["pln/$waluta"]),2);
							$_koszt_eur[5]+=round(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["eur/$waluta"]),2);
						}
						?>
						</td><td><?=$_koszt_eur[5];?></td><td><?=round($_koszt_eur[5]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[5];?></td><td><?=round($_koszt_pln[5]/$_GET[liczba],2);?></td></tr>
						<?
						$SUMA_PLN+=$_koszt_pln[5];	
						$SUMA_EUR+=$_koszt_eur[5];
					}else{
						?>
						</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
						<?
					}				
				?>
				<tr><td>6</td><td>
				Folia oklejka
				<?
				if($_GET[typ_foli_oklejka]){
					$sql="SELECT nazwa FROM folie WHERE id='".$_GET[typ_foli_oklejka]."'";
					list($nazwa_folia_oklejka)=mysql_fetch_row(mysql_query($sql));
					
					echo "(Typ foli:&nbsp;".$nazwa_folia_oklejka.", ";
					$sql="SELECT id_format as id_format_folia_oklejka,folia_x as folia_oklejka_x,folia_y as folia_oklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_oklejka ";
					$sql.="WHERE typ_folie='$_GET[typ_foli_oklejka]' AND typ='$_GET[typ]' ";
					//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
					//$sql.="AND format_oklejka='".$papier_oklejka_x."x".$papier_oklejka_y."' ";
					$sql.="AND id_format_oklejka = '".$id_format_oklejka."' ";
					$sql.="AND del='0'";
					list($id_format_folia_oklejka,$folia_oklejka_x,$folia_oklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_format_folia_oklejka){
						echo "format: ".$folia_oklejka_x." x ".$folia_oklejka_y;
						//echo " z tektura: ".$tektura_x." x ".$tektura_y." oklejka: ".$papier_oklejka_x." x ".$papier_oklejka_y." <br/>";
						echo ", Utilities: &nbsp;".$sztuk_arkusz." items per sheet)";
						echo " cena m2: ".$cena." ".$waluta;

						$_koszt_pln[6]=round(($_GET[liczba]*($cena*$_KURS["pln/$waluta"])*($folia_oklejka_x/1000)*($folia_oklejka_y/1000))/$sztuk_arkusz,2);
						$_koszt_eur[6]=round(($_GET[liczba]*($cena*$_KURS["eur/$waluta"])*($folia_oklejka_x/1000)*($folia_oklejka_y/1000))/$sztuk_arkusz,2);
						$SUMA_PLN+=$_koszt_pln[6];
						$SUMA_EUR+=$_koszt_eur[6];

						?>
						</td><td><?=$_koszt_eur[6];?></td><td><?=round($_koszt_eur[6]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[6];?></td><td><?=round($_koszt_pln[6]/$_GET[liczba],2);?></td></tr>
						<?
					}
				}else{
					?>
					</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
					<?
				}
				?>
				<tr><td>7</td><td>
				Folia wklejka
				<?
				if($_GET[typ_foli_wklejka]){
					$sql="SELECT nazwa FROM folie WHERE id='".$_GET[typ_foli_wklejka]."'";
					list($nazwa_folia_wklejka)=mysql_fetch_row(mysql_query($sql));

					echo "(Typ foli &nbsp;".$nazwa_folia_wklejka.", ";
					$sql="SELECT id_format as id_format_folia_wklejka,folia_x as folia_wklejka_x,folia_y as folia_wklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_wklejka ";
					$sql.="WHERE typ_folie='$_GET[typ_foli_wklejka]' AND typ='$_GET[typ]' ";
					//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
					//$sql.="AND format_wklejka='".$papier_wklejka_x."x".$papier_wklejka_y."' ";
					$sql.="AND id_format_wklejka = '".$id_format_wklejka."' ";
					$sql.="AND del='0'";
					list($id_format_folia_wklejka,$folia_wklejka_x,$folia_wklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_format_folia_wklejka){
						echo "format: ".$folia_wklejka_x." x ".$folia_wklejka_y;
						//echo " z tektura: ".$tektura_x." x ".$tektura_y." oklejka: ".$papier_wklejka_x." x ".$papier_wklejka_y." <br/>";
						echo ", Utilities: &nbsp;".$sztuk_arkusz." items per sheet)";
						echo "cena m2: ".$cena." ".$waluta;
						
						$_koszt_pln[7]=round(($_GET[liczba]*($cena*$_KURS["pln/$waluta"])*($folia_wklejka_x/1000)*($folia_wklejka_y/1000))/$sztuk_arkusz,2);
						$_koszt_eur[7]=round(($_GET[liczba]*($cena*$_KURS["eur/$waluta"])*($folia_wklejka_x/1000)*($folia_wklejka_y/1000))/$sztuk_arkusz,2);
						$SUMA_PLN+=$_koszt_pln[7];
						$SUMA_EUR+=$_koszt_eur[7];
						?>
						</td><td><?=$_koszt_eur[7];?></td><td><?=round($_koszt_eur[7]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[7];?></td><td><?=round($_koszt_pln[7]/$_GET[liczba],2);?></td></tr>
						<?	
					}
				}else{
					?>
					</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
					<?
				}
				?>
				<tr><td>8</td><td>
				Lakierowanie oklejka
				<?
				if($_GET[lakierowanie_typ_oklejka]){
					echo "(Typ lakierowania: ".$_GET[lakierowanie_typ_oklejka].")";
					$sql="SELECT id as lakierowanie_id_oklejka,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
					$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ='$_GET[lakierowanie_typ_oklejka]' AND ";
					$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
					$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
					$sql.="AND del='0'";
					
					list($lakierowanie_id_oklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($lakierowanie_id_oklejka){
						if($cena>0){echo "<br>Cena :".$cena." ".$waluta." ";}
						if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
					}
					if($cena>0){
						$_koszt_pln[8]=round($cena*$_KURS["pln/$waluta"],2);
						$_koszt_eur[8]=round($cena*$_KURS["eur/$waluta"],2);
					}
					if($cena_szt>0){
						if($szt_do==0 || $szt_do > $_GET[liczba])$szt_do=$szt_od;
						$_koszt_pln[8]+=($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["pln/$waluta"]);
						$_koszt_eur[8]+=($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["eur/$waluta"]);
					}
					$SUMA_PLN+=$_koszt_pln[8];
					$SUMA_EUR+=$_koszt_eur[8];
					?>
					</td><td><?=$_koszt_eur[8];?></td><td><?=round($_koszt_eur[8]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[8];?></td><td><?=round($_koszt_pln[8]/$_GET[liczba],2);?></td></tr>
				<?
				}else{
					?>
					</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
					<?
				}
				?>
				<tr><td>9</td><td>
				Lakierowanie wklejka
				<?
				if($_GET[lakierowanie_typ_wklejka]){
					echo "(Typ lakierowania: ".$_GET[lakierowanie_typ_wklejka].")";
					$sql="SELECT id as lakierowanie_id_wklejka,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
					$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ='$_GET[lakierowanie_typ_wklejka]' AND ";
					$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
					$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
					$sql.="AND del='0'";

					list($lakierowanie_id_wklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($lakierowanie_id_wklejka){
						if($cena>0){echo "<br>Cena :".$cena." ".$waluta." ";}
						if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
					}
					if($cena>0){
						$_koszt_pln[9]=round($cena*$_KURS["pln/$waluta"],2);
						$_koszt_eur[9]=round($cena*$_KURS["eur/$waluta"],2);
					}
					if($cena_szt>0){
						if($szt_do==0)$szt_do=$szt_od;
						$_koszt_pln[9]=round(($cena*$_KURS["pln/$waluta"])+(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["pln/$waluta"])),2);
						$_koszt_eur[9]=round(($cena*$_KURS["eur/$waluta"])+(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["eur/$waluta"])),2);
					}
					$SUMA_PLN+=$_koszt_pln[9];
					$SUMA_EUR+=$_koszt_eur[9];
					?>
					</td><td><?=$_koszt_eur[9];?></td><td><?=round($_koszt_eur[9]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[9];?></td><td><?=round($_koszt_pln[9]/$_GET[liczba],2);?></td></tr>
					<?

				}else{
					?>
					</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
					<?
				}
				if($_GET[id_mechanizm]){
				?>
					<tr class="warning"><td>10</td><td colspan="5">Mechanizmy</td></tr>
					<?
					foreach($_GET[id_mechanizm] as $key => $val){
						if($val){
							$sql="SELECT nazwa,typ_mechanizm,cena,waluta,liczba_nitow,liczba_szt_pudlo FROM mechanizmy WHERE id='$val'";
							list($nazwa,$typ_mechanizm,$cena,$waluta,$liczba_nitow,$liczba_szt_pudlo)=mysql_fetch_row(mysql_query($sql));
							echo "<tr><td></td><td>";
								echo $nazwa." ".$typ_mechanizm;
								echo " (liczba nitów: ".$liczba_nitow.", ";
								echo "liczba w opak: ".$liczba_szt_pudlo.") ";
								echo "Cena: ".$cena." ".$waluta.", ";
								
								$liczba_nitow_all+=$liczba_nitow;
								if($liczba_szt_pudlo>$liczba_w_opak)$liczba_w_opak=$liczba_szt_pudlo;
							$_koszt_pln[10]=round($_GET[liczba]*$cena*$_KURS["pln/".$waluta],2);
							$_koszt_eur[10]=round($_GET[liczba]*$cena*$_KURS["eur/".$waluta],2);
							$SUMA_PLN+=$_koszt_pln[10];
							$SUMA_EUR+=$_koszt_eur[10];
							?>
							</td><td><?=$_koszt_eur[10];?></td><td><?=round($_koszt_eur[10]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[10];?></td><td><?=round($_koszt_pln[10]/$_GET[liczba],2);?></td></tr>
							<?
						}
					}									
				}
				if($_GET[id_element]){
				?>
					<tr class="warning"><td>11</td><td colspan="5">Elementy stałe</td></tr>
					<?
					foreach($_GET[id_element] as $key => $val){
						if($val){
							$sql="SELECT id,nazwa,cena,waluta,z_mechanizmy FROM elementy WHERE id='$val'";
							list($id,$nazwa,$cena,$waluta,$z_mechanizmy)=mysql_fetch_row(mysql_query($sql));
							echo "<tr><td></td><td>";
							//sprawdzamy czy to są nity i dodajemy do wyceny liczbę nitów
							$_koszt_pln[11]=round($_GET[liczba]*$cena*$_KURS["pln/$waluta"],2);
							$_koszt_eur[11]=round($_GET[liczba]*$cena*$_KURS["eur/$waluta"],2);
							echo $nazwa." ".$cena." ".$waluta."/szt.";
							
							//if(($id=="3" || $id=="21") && $liczba_nitow_all){
							if($z_mechanizmy=="1" && $liczba_nitow_all){
								echo "<br/>Liczba nitów z mechanizmów: ".$liczba_nitow_all." nity/szt.";
								$_koszt_pln[11]=round($liczba_nitow_all*$_GET[liczba]*$cena*$_KURS["pln/$waluta"],2);
								$_koszt_eur[11]=round($liczba_nitow_all*$_GET[liczba]*$cena*$_KURS["eur/$waluta"],2);
								$_koszt_nity_pln=$_koszt_pln[11];
								$_koszt_nity_eur=$_koszt_eur[11];
							}
							//if($id=="5" || $id=="22"){
							if($z_mechanizmy=="2"){
								echo "<br/>Liczba szt w opakowaniu z mechanizmów: ".$liczba_w_opak." szt/op.";
								$_koszt_pln[11]=round(($_GET[liczba]/$liczba_w_opak)*$cena*$_KURS["pln/$waluta"],2);
								$_koszt_eur[11]=round(($_GET[liczba]/$liczba_w_opak)*$cena*$_KURS["eur/$waluta"],2);
							}
							$SUMA_PLN+=$_koszt_pln[11];
							$SUMA_EUR+=$_koszt_eur[11];
							?>
							</td><td><?=$_koszt_eur[11];?></td><td><?=round($_koszt_eur[11]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[11];?></td><td><?=round($_koszt_pln[11]/$_GET[liczba],2);?></td></tr>
							<?
						}
					}
				}
				if($_GET[dodatki]){
				?>
					<tr class="warning"><td>12</td><td colspan="5">Dodatkowe elementy</td></tr>
					<?
					foreach($_GET[dodatki] as $key => $val){
						if($val){
							$_GET[dodatki_cena][$key]=str_replace(",",".",$_GET[dodatki_cena][$key]);
							echo "<tr><td></td><td>";
							echo $val;
							echo " - ".$_GET[dodatki_cena][$key]." ".$_GET[dodatki_waluta][$key]."/".$_GET[dodatki_typ_cena][$key].".";
							$_koszt_pln[12]=round($_GET[dodatki_cena][$key]*$_KURS["pln/".trim($_GET[dodatki_waluta][$key])],2);
							$_koszt_eur[12]=round($_GET[dodatki_cena][$key]*$_KURS["eur/".trim($_GET[dodatki_waluta][$key])],2);

							if($_GET[dodatki_typ_cena][$key] == "szt"){
								$_koszt_pln[12]=round($_GET[liczba]*$_koszt_pln[12],2);
								$_koszt_eur[12]=round($_GET[liczba]*$_koszt_eur[12],2);
							}
							$SUMA_PLN+=$_koszt_pln[12];
							$SUMA_EUR+=$_koszt_eur[12];
							?>
							</td><td><?=$_koszt_eur[12];?></td><td><?=round($_koszt_eur[12]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[12];?></td><td><?=round($_koszt_pln[12]/$_GET[liczba],2);?></td></tr>
							<?
						}
					}									
				}
				if($_GET[odpady]){
				?>
					<tr class="warning"><td>13</td><td colspan="5">Odpady</td></tr>
					<?
					foreach($_GET[odpady] as $key => $val){
						if($val){
							$szt_odpadu="";
							$procent="";
							$sql="SELECT odpad_typ,procent,szt_odpadu,id_grupy_wyceny FROM odpady WHERE id='$val'";
							list($odpad_typ,$procent,$szt_odpadu,$id_grupy_wyceny)=mysql_fetch_row(mysql_query($sql));
							echo "<tr><td></td><td>";
							echo $odpad_typ." - ";
							if($szt_odpadu>0 && $szt_odpadu){echo $szt_odpadu." szt.";}else{echo $procent."%";}
							if($id_grupy_wyceny!=100){
								if($szt_odpadu > 0 && $szt_odpadu){
									$iloczyn=$szt_odpadu*100;
									$_koszt_pln[13]=round(($_koszt_pln[$id_grupy_wyceny]/$_GET[liczba])*$szt_odpadu,2);
									$_koszt_eur[13]=round(($_koszt_eur[$id_grupy_wyceny]/$_GET[liczba])*$szt_odpadu,2);
								}else{
									$_koszt_pln[13]=round($_koszt_pln[$id_grupy_wyceny]*($procent/100),2);
									$_koszt_eur[13]=round($_koszt_eur[$id_grupy_wyceny]*($procent/100),2);
								}
							}else{
								$_koszt_pln[13]=round($_koszt_nity_pln*($procent/100),2);
								$_koszt_eur[13]=round($_koszt_nity_eur*($procent/100),2);
							}
							$SUMA_PLN+=$_koszt_pln[13];
							$SUMA_EUR+=$_koszt_eur[13];
							?>
								</td><td><?=$_koszt_eur[13];?></td><td><?=round($_koszt_eur[13]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[13];?></td><td><?=round($_koszt_pln[13]/$_GET[liczba],2);?></td></tr>
							<?
						}
					}									
				}?>
				<tr class="success">
				<td></td>
				<td><strong>Razem</strong></td>				
				<td><strong><?=round($SUMA_EUR,2);?> euro</strong></td>
				<td><strong><?=round($SUMA_EUR/$_GET[liczba],2);?> euro/szt.</strong></td>
				<td><strong><?=round($SUMA_PLN,2);?> zł</strong></td>
				<td><strong><?=round($SUMA_PLN/$_GET[liczba],2);?> zł/szt.</strong></td>
				</tr>
				<tr class="success">
				<td></td>
				<?
				$sql="SELECT cena as cena_sugerowana FROM cena_sugerowana WHERE 
				(szt_od<$_GET[liczba] AND szt_do>$_GET[liczba]) OR (szt_od<$_GET[liczba] AND szt_do=0)
				AND typ='$_GET[typ]'";
				list($cena_sugerowana)=mysql_fetch_row(mysql_query($sql));
				?>
				<td><strong>Cena sugerowana (x <?=$cena_sugerowana?>)</strong></td>
				<td><strong><?=round($SUMA_EUR*$cena_sugerowana,2);?> euro</strong></td>
				<td><strong><?=round(($SUMA_EUR/$_GET[liczba])*$cena_sugerowana,2);?> euro/szt.</strong></td>
				<td><strong><?=round($SUMA_PLN*$cena_sugerowana,2);?> zł</strong></td>
				<td><strong><?=round(($SUMA_PLN/$_GET[liczba])*$cena_sugerowana,2);?> zł/szt.</strong></td>
				</tr>
				</table>
				<?
				if($_GET[wycena_id] && !$_GET[show_wycena_id] && !$_GET[przelicz_nowa]){
					$sql="UPDATE wyceny SET nazwa_klienta='".$_GET[nazwa_klienta]."',nazwa_zlecenia='".$_GET[nazwa_zlecenia]."',szt='".$_GET[liczba]."',koszt_calkowity_eur='".round($SUMA_EUR,2)."',koszt_szt_eur='".round($SUMA_EUR/$_GET[liczba],2)."',koszt_calkowity_pln='".round($SUMA_PLN,2)."',koszt_szt_pln='".round($SUMA_PLN/$_GET[liczba],2)."',kurs_eur='".$_KURS["pln/eur"]."',parametry='".serialize($_GET)."',modyf='".$_SESSION['user_id']."',data_last_modyf=NOW() WHERE id='$_GET[wycena_id]'";
					if(mysql_query($sql)){?>
						<input type="hidden" name="wycena_id" value="<?=$_GET[wycena_id];?>">
					    <div class="alert">
						<strong>Valuation</strong> has been updated.
						</div>
					<?
					}else{
						echo mysql_error()." <br>".$sql;
					}
				}elseif(!$_GET[show_wycena_id]){
					$sql="INSERT INTO wyceny (nazwa_klienta,nazwa_zlecenia,szt,koszt_calkowity_eur,koszt_szt_eur,koszt_calkowity_pln,koszt_szt_pln,kurs_eur,parametry,wprow,data_wprow) VALUES ('".$_GET[nazwa_klienta]."','".$_GET[nazwa_zlecenia]."','".$_GET[liczba]."','".round($SUMA_EUR,2)."','".round($SUMA_EUR/$_GET[liczba],2)."','".round($SUMA_PLN,2)."','".round($SUMA_PLN/$_GET[liczba],2)."','".$_KURS["pln/eur"]."','".serialize($_GET)."','".$_SESSION['user_id']."',NOW())";
					if(mysql_query($sql)){
						$sql="SELECT MAX(id) FROM wyceny WHERE nazwa_klienta='".$_GET[nazwa_klienta]."' AND nazwa_zlecenia='".$_GET[nazwa_zlecenia]."' AND szt='".$_GET[liczba]."' AND koszt_calkowity_eur='".round($SUMA_EUR,2)."'";
						list($wycena_id)=mysql_fetch_row(mysql_query($sql));
						?>
						<input type="hidden" name="wycena_id" value="<?=$wycena_id;?>">
					    <div class="alert">
						<strong>Pricing</strong> has been saved.
						</div>
					<?}
				}
				
				if(!$_GET['print']){
				?>
				<div class="row-fluid">				
					<div class="span12">
					<legend>Next ...</legend>
					<p>
						<!--button class="btn btn-info" type="button">Zapisz aktualną wycenę</button-->
						<input type="hidden" name="przelicz_nowa" value="0">
						<button class="btn btn-danger" name="przelicz" type="submit" value="0" >Reconfigure</button>
					</p>
					</div>
				</div>
				<?}?>
			</fieldset>
		<?
		}else{
			if($_GET[wycena_id] && !$_GET[typ]){
				$sql="SELECT parametry FROM wyceny WHERE id='$_GET[wycena_id]'";
				list($parametry)=mysql_fetch_row(mysql_query($sql));
				$_GET=array_merge($_GET,unserialize($parametry));
				if($_GET[kurs])$_KURS=$_GET[kurs];
			}
		?>
						<h3>New Calculation</h3>
						<input type="hidden" name="action" value="<?=$_GET[action]?>">
						<input type="hidden" name="site" value="<?=$_GET[site]?>">
						<?if($_GET[wycena_id]){?>
							<input type="hidden" name="wycena_id" value="<?=$_GET[wycena_id];?>">
						<?}?>
						<fieldset>
							<div class="row-fluid">
								<div class="span6">
									<a name="Parametry_wyceny"></a>
									<legend>Parameters</legend>
									<label class="inline">Type of product &nbsp;
										<?
										$sql="SELECT id as typ,nazwa".$_GET[pricing_lang]." as nazwa FROM produkty WHERE aktywny='1' AND del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										?>
										<select name="typ" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											//if(!$_GET[typ])$_GET[typ]=$dane[typ];
											echo "<option ";
											if($_GET[typ]==$dane[typ]){
												echo " selected ";
												$_GET[typ_nazwa]=$dane[nazwa];
											}
											echo " value='".$dane[typ]."'>".$dane[nazwa]." </option>";
										}
										?>
										</select>
										<input type="hidden" name="typ_nazwa" value="<?=$_GET[typ_nazwa]?>">
									</label>
									<?
									//domyślne grubosc,format
									if(!$_GET[grubosc] || ($_GET[typ]!=$_GET[typ_old] && $_GET[typ_old]!="")){
										$sql="SELECT def_grubosc,def_format_x,def_format_y FROM produkty WHERE id=$_GET[typ]";
										list($_GET[grubosc],$_GET[format_x],$_GET[format_y])=mysql_fetch_row(mysql_query($sql));
										$_GET[wczytaj]=0;
									}
									?>
									<label class="inline">Thickness &nbsp;
										<select name="grubosc" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?	
										$lista_grubosc=array("1.8","1.9","2.0","2.25","1.0","1.1","1.2","1.3","1.4","1.5","1.6","1.7","2.30","2.40","2.50","2.60","2.70","2.75","2.80","2.90","3.00");
										foreach($lista_grubosc as $key => $val){
											echo "<option ";
											if($_GET[grubosc]==$val){echo " selected ";}
											echo " value='".$val."'>".$val."</option>";											
										}
										?>
										</select>
									</label>
									<label class="inline">Product format &nbsp;
										<?
										if(!$_GET[typ]){
												echo "<span class='label label-warning'>Select type of product</span>";
										}elseif(!$_GET[grubosc]){
											echo "<span class='label label-warning'>Select thickness</span>";
										}else{
										if(!$_GET[format_x])$_GET[format_x]="555";
										if(!$_GET[format_y])$_GET[format_y]="315";
										?>
											<input name="format_x" value="<?=$_GET[format_x]?>" type="text" class="input-mini" autocomplete="off">&nbsp;x
											<input name="format_y" value="<?=$_GET[format_y]?>" type="text" class="input-mini" autocomplete="off">
											<input type="hidden" name="wczytaj" value="1">
											<input type="hidden" name="typ_old" value="<?=$_GET[typ]?>">
											<button class="btn btn-mini btn-primary" name="wczytaj" type="button" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">Load</button></label>
										</label>
										<?
											if($_GET[wczytaj]==1 && $_GET[format_x] && $_GET[format_y]){
												$sql="SELECT id_format,format_x_od,format_x_do,format_y_od,format_y_do,tektura_x,tektura_y,sztuk_arkusz FROM format_tektura ";
												$sql.="WHERE typ='$_GET[typ]' AND (";
												$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
												$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
												$sql.=" OR ";
												$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
												$sql.=" AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
												$sql.=") AND grubosc_od<='$_GET[grubosc]' AND grubosc_do>='$_GET[grubosc]' ";
												$sql.="AND del='0' ORDER BY prio ASC";
												list($id_format,$format_x_od,$format_x_do,$format_y_od,$format_y_do,$tektura_x,$tektura_y,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
												if(!$_GET[typ]){
													echo "<span class='label label-warning'>Select type of product</span><strong>";
												}elseif(!$_GET[grubosc]){
													echo "<span class='label label-warning'>Select thickness</span>";
												}elseif($id_format){
													echo "<pre>";
													echo "<span class='label label-success'>Paperboard: </span>&nbsp;<strong>";
													//if($format_x_od != $format_x_do){echo "od ".$format_x_od." do ".$format_x_do;}else{echo $format_x_od;}
													echo $tektura_x." x ".$tektura_y;
													//if($format_y_od != $format_y_do){echo "od ".$format_y_od." do ".$format_y_do;}else{echo $format_y_od;}
													echo "</strong>&nbsp;<span class='label label-success'>Utilities: </span>&nbsp;";
													echo " <strong>".$sztuk_arkusz."&nbsp;items per sheet</strong>";
													echo "</pre>";
												}else{
													echo "<span class='label label-important'>No paperboard format</span>";
													echo "&nbsp;<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty.php?typ=$_GET[typ]&add=1'>Add new paperboard format</a>";
												}
											}else{
												echo "<span class='label label-warning'>Specify product format</span>";
											}
										}
										?>
								</div>
								<div class="span6">
									<legend>Customer data</legend>
									<label class="inline">Customer name &nbsp; <input type="text" placeholder="Nazwa klienta" name="nazwa_klienta" value="<?=$_GET[nazwa_klienta]?>" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;<small>required</small></label>
									<label class="inline">Order name &nbsp; <input type="text" placeholder="Nazwa zlecenia" name="nazwa_zlecenia" value="<?=$_GET[nazwa_zlecenia]?>" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;<small>required</small></label>
									<label class="inline">Items &nbsp; <input type="text" class="input-small" name="liczba" value="<?=$_GET[liczba]?>">&nbsp;<small>required</small>
									<button class="btn btn-mini btn-primary" type="button" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">Change</button></label>
									<?
									foreach($_KURS as $key => $val){
										echo "<input type='hidden' name='kurs[".trim($key)."]' value='".$val."'>";
									}
									?>
									<span class='label label-success'>EUR</span>&nbsp;<strong><?=$_KURS['pln/eur']?> zł.</strong>&nbsp;
									<?if($_KURS['pln/eur']!=$_KURS_CONF['pln/eur']){?><small>(now: <?=$_KURS_CONF['pln/eur']?>)</small><?$akt=1;}?>
									<span class='label label-success'>USD: </span>&nbsp;<strong><?=$_KURS['pln/usd']?> zł.</strong>
									<?if($_KURS['pln/usd']!=$_KURS_CONF['pln/usd']){?><small>(now: <?=$_KURS_CONF['pln/usd']?>)</small><?$akt=1;}?>
									<span class='label label-success'>EUR/USD: </span>&nbsp;<strong><?=$_KURS['eur/usd']?></strong>
									<?if($_KURS['eur/usd']!=$_KURS_CONF['eur/usd']){?><small>(now: <?=$_KURS_CONF['eur/usd']?>)</small><?$akt=1;}?>
									<span class='label label-success'>USD/EUR: </span>&nbsp;<strong><?=$_KURS['usd/eur']?></strong>
									<?if($_KURS['usd/eur']!=$_KURS_CONF['usd/eur']){?><small>(now: <?=$_KURS_CONF['usd/eur']?>)</small><?$akt=1;}?>
									<?if($akt==1){?>
										<!--input type="hidden" name="wczytaj_waluta" value="1"-->
										<input class="btn btn-mini btn-primary" type="submit" name="wczytaj_waluta" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()" value="Load current exchange"></label>
									<?}?>
								</div>
							</div>
							<?
							if($id_format){
							?>
							<div class="row-fluid">
								<div class="span6">
									<legend>Out-sticker paper</legend>
									<?
									$sql="SELECT id_format as id_format_oklejka,papier_x as papier_oklejka_x,papier_y as papier_oklejka_y,grubosc_od,sztuk_arkusz FROM format_oklejka ";
									$sql.="WHERE typ='$_GET[typ]' AND";
									$sql.="(";
									$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
									$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]')";
									$sql.=" OR ";
									$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
									$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
									$sql.=") ";
									$sql.="AND del='0' ORDER BY prio ASC";
									list($id_format_oklejka,$papier_oklejka_x,$papier_oklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
									if($id_format_oklejka){
										echo "<pre>";
										echo "<span class='label label-success'>Paper format: </span>&nbsp;<strong>";
										echo $papier_oklejka_x." x ".$papier_oklejka_y."</strong><br/>";
										echo "<span class='label label-success'>Grammage: </span>&nbsp;<strong>&nbsp;";
										echo $grubosc_od."</strong><br/>";
										echo "<span class='label label-success'>Utilities: </span>&nbsp;<strong>&nbsp;";
										echo $sztuk_arkusz." items per sheet</strong>";
										echo "</pre>";
									}else{?>
											<span class='label label-important'>No Out-sticker format</span>
											<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_oklejka.php?typ=$_GET[typ]&add=1'>Dodaj nowy format oklejki</a>
									<?}?>
								</div>
								<div class="span6">
									<legend>In-sticker paper
									<small> - without in-sticker paper&nbsp;<input type="checkbox" name="bez_papier_wklejka" value="1" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()"
									<?if($_GET[bez_papier_wklejka]=="1")echo "checked";?>
									></small></legend>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'>No Out-sticker format</span>
									<?
									}else{
										$sql="SELECT id_format as id_format_wklejka,papier_x as papier_wklejka_x,papier_y as papier_wklejka_y,grubosc_od,sztuk_arkusz FROM format_wklejka ";
										$sql.="WHERE typ='$_GET[typ]' AND ";
										$sql.="(";
										$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
										$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
										$sql.=" OR ";
										$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
										$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
										$sql.=") ";
										$sql.="AND del='0' ORDER BY prio ASC";
										list($id_format_wklejka,$papier_wklejka_x,$papier_wklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
										if($id_format_wklejka){
											echo "<pre>";
											echo "<span class='label label-success'>Paper format: </span>&nbsp;<strong>";
											echo $papier_wklejka_x." x ".$papier_wklejka_y."</strong><br/>";
											echo "<span class='label label-success'>Grammage: </span>&nbsp;<strong>&nbsp;";
											echo $grubosc_od."</strong><br/>";
											echo "<span class='label label-success'>Utilities: </span>&nbsp;<strong>&nbsp;";
											echo $sztuk_arkusz." items per sheet</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'>No in-sticker format</span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_wklejka.php?typ=$_GET[typ]&add=1'>Add new in-sticker format</a>
										<?}
									}
									?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Druk_oklejka"></a>
									<legend>Out-sticker print</legend>
									<label class="inline">Print type &nbsp;
									<?
									$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
									$res=mysql_query($sql);
									?>
									<select name="druk_typ_oklejka" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
									<option value="">-- select --</option>
									<?
									while($dane=mysql_fetch_array($res)){
										echo "<option ";
										if($_GET[druk_typ_oklejka]==$dane[druk_typ_oklejka]){echo " selected ";}
										echo " value='".$dane[druk_typ_oklejka]."'>".$dane[druk_typ_oklejka]."</option>";
									}
									?>
									</select>
									</label>
									<?
									if($_GET[druk_typ_oklejka]){
										$sql="SELECT id as id_druk_oklejka,cena,cena_szt,cena_typ,waluta FROM druk_oklejka ";
										$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($id_druk_oklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($id_druk_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>Out-sticker print: </span>&nbsp;<strong>";
											echo $_GET[druk_typ_oklejka]." ";
											if($cena>0){echo $cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'>No out-sticker print format</span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_druk_oklejka.php?add=1'>Dodaj nowy typ druku oklejki</a>
										<?}
									}else{
										echo "<span class='label label-warning'>Product without out-sticker print</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend>In-sticker print</legend>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'>Without in-sticker print</span>
									<?
									}else{
									?>
										<label class="inline">Print type &nbsp;
										<?
											$sql="SELECT DISTINCT druk_typ as druk_typ_wklejka FROM druk_wklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
											$res=mysql_query($sql);
											?>
											<select name="druk_typ_wklejka" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
											<option value="">-- select --</option>
											<?
											while($dane=mysql_fetch_array($res)){
												echo "<option ";
												if($_GET[druk_typ_wklejka]==$dane[druk_typ_wklejka]){echo " selected ";}
												echo " value='".$dane[druk_typ_wklejka]."'>".$dane[druk_typ_wklejka]."</option>";
											}
											?>
											</select>
										</label>
										<?
										if($_GET[druk_typ_wklejka]){
											$sql="SELECT id as id_druk_wklejka,cena,cena_szt,cena_typ,waluta FROM druk_wklejka ";
											$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
											$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
											$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
											$sql.="AND del='0'";
											list($id_druk_wklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
											if($id_druk_oklejka){
												echo "<pre>";
												echo "<span class='label label-success'>Druk oklejki: </span>&nbsp;<strong>";
												echo $_GET[druk_typ_wklejka]." ";
												if($cena>0){echo $cena." ".$waluta." ";}
												if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
												echo "</strong>";
												echo "</pre>";
											}else{?>
													<span class='label label-important'>No in-sticker print format</span>
													<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_druk_oklejka.php?add=1'>Dodaj nowy typ druku oklejki</a>
											<?}
										}else{
											echo "<span class='label label-warning'>Product without in-sticker print</span>";
										}
									}
									?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Folia_oklejka"></a>
									<legend>Out-sticker foiling</legend>
									<label class="inline">Foiling type &nbsp;
									<?
										$sql="SELECT id as typ_foli_oklejka,nazwa,nazwa_en,nazwa_de FROM folie WHERE del='0'";
										$res=mysql_query($sql);
										?>
										<select name="typ_foli_oklejka" onChange="document.forms['wycena'].action='#Folia_oklejka';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option ";
											if($_GET[typ_foli_oklejka]==$dane[typ_foli_oklejka]){echo " selected ";}
											echo " value='".$dane[typ_foli_oklejka]."'>".$dane[nazwa].", ".$dane[nazwa_en].", ".$dane[nazwa_de]."</option>";
										}
										?>
										</select>
									</label>
									<?
									if($_GET[typ_foli_oklejka]){
										$sql="SELECT id_format as id_format_folia_oklejka,folia_x as folia_oklejka_x,folia_y as folia_oklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_oklejka ";
										$sql.="WHERE typ_folie='$_GET[typ_foli_oklejka]' AND typ='$_GET[typ]' ";
										//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
										//$sql.="AND format_oklejka='".$papier_oklejka_x."x".$papier_oklejka_y."' ";
										$sql.="AND id_format_oklejka = '".$id_format_oklejka."' ";
										$sql.="AND del='0'";
										list($id_format_folia_oklejka,$folia_oklejka_x,$folia_oklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($id_format_folia_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>Out-sticker foiling: </span>&nbsp;<strong>";
											echo $folia_oklejka_x." x ".$folia_oklejka_y."</strong>";
											//echo "<br/>z tektura: ".$tektura_x." x ".$tektura_y." oklejka: ".$papier_oklejka_x." x ".$papier_oklejka_y." <br/>";
											echo "<br/><span class='label label-success'>Utilities: </span>&nbsp;<strong>&nbsp;";
											echo $sztuk_arkusz." items per sheet</strong><br/>";
											echo "<span class='label label-success'>Price: </span>&nbsp;<strong>&nbsp;";
											echo $cena." ".$waluta."</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'>No out-sticker foiling</span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_oklejka.php?typ=$_GET[typ]&add=1'>Add new out-sticker foiling format</a>
										<?}
									}else{
										echo "<span class='label label-warning'>Product without out-sticker foiling</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend>In-sticker foiling</legend>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'>With out in-sticker foiling</span>
									<?
									}else{
									?>
										<label class="inline">Foiling type&nbsp;
										<?
											$sql="SELECT id as typ_foli_wklejka,nazwa,nazwa_en,nazwa_de FROM folie WHERE del='0'";
											$res=mysql_query($sql);
											?>
											<select name="typ_foli_wklejka" onChange="document.forms['wycena'].action='#Folia_oklejka';document.forms['wycena'].submit()">
											<option value="">-- select --</option>
											<?
											while($dane=mysql_fetch_array($res)){
												echo "<option ";
												if($_GET[typ_foli_wklejka]==$dane[typ_foli_wklejka]){echo " selected ";}
												echo " value='".$dane[typ_foli_wklejka]."'>".$dane[nazwa].", ".$dane[nazwa_en].", ".$dane[nazwa_de]."</option>";
											}
											?>
											</select>
										</label>
										<?
										if($_GET[typ_foli_wklejka]){
											$sql="SELECT id_format as id_format_folia_wklejka,folia_x as folia_wklejka_x,folia_y as folia_wklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_wklejka ";
											$sql.="WHERE typ_folie='$_GET[typ_foli_wklejka]' AND typ='$_GET[typ]' ";
											//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
											//$sql.="AND format_wklejka='".$papier_wklejka_x."x".$papier_wklejka_y."' ";
											$sql.="AND id_format_wklejka = '".$id_format_wklejka."' ";
											$sql.="AND del='0'";
											list($id_format_folia_wklejka,$folia_wklejka_x,$folia_wklejka_y,$sztuk_arkusz,$cena_folia_wklejka,$waluta)=mysql_fetch_row(mysql_query($sql));
											if($id_format_folia_wklejka){
												echo "<pre>";
												echo "<span class='label label-success'>In-sticker foiling: </span>&nbsp;<strong>";
												echo $folia_wklejka_x." x ".$folia_wklejka_y."</strong>";
												//echo "<br/>z tektura: ".$tektura_x." x ".$tektura_y." wklejka: ".$papier_wklejka_x." x ".$papier_wklejka_y." <br/>";											
												echo "<br/><span class='label label-success'>Utilities: </span>&nbsp;<strong>&nbsp;";
												echo $sztuk_arkusz." items per sheet</strong><br/>";
												echo "<span class='label label-success'>Price: </span>&nbsp;<strong>&nbsp;";
												echo $cena_folia_wklejka." ".$waluta."</strong>";
												echo "</pre>";
											}else{?>
													<span class='label label-important'>No in-sticker foiling format</span>
													<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_oklejka.php?typ=$_GET[typ]&add=1'>Dodaj nowy format</a>
											<?}
										}else{
											echo "<span class='label label-warning'>Product without in-sticker foiling</span>";
										}
									}
										?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Lakierowanie_oklejka"></a>
									<legend>Out-sticker lacquering</legend>
									<label class="inline">Lacquering type&nbsp;
									<?
										$sql="SELECT DISTINCT lakierowanie_typ as lakierowanie_typ_oklejka FROM lakierowanie WHERE typ='$_GET[typ]' AND del='0' ORDER BY lakierowanie_typ";
										$res=mysql_query($sql);
										?>
										<select name="lakierowanie_typ_oklejka" onChange="document.forms['wycena'].action='#Lakierowanie_oklejka';document.forms['wycena'].submit();">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option ";
											if($_GET[lakierowanie_typ_oklejka]==$dane[lakierowanie_typ_oklejka]){echo " selected ";}
											echo " value='".$dane[lakierowanie_typ_oklejka]."'>".$dane[lakierowanie_typ_oklejka]."</option>";
										}
										?>
										</select>
									</label>
									<?
									if($_GET[lakierowanie_typ_oklejka]){
										$sql="SELECT id as lakierowanie_id_oklejka,lakierowanie_typ,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
										$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ='$_GET[lakierowanie_typ_oklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($lakierowanie_id_oklejka,$lakierowanie_typ,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($lakierowanie_id_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>Out-sticker lacquering: </span>&nbsp;<strong>";
											if($cena>=0){echo $lakierowanie_typ." ".$cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/item ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'>No number of items</span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_lakierowanie.php?typ=$_GET[lakierowanie_typ_oklejka]&add=1'>Dodaj nowy format</a>
										<?}
									}else{
										echo "<span class='label label-warning'>Product without out-sticker lacquering</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend>In-sticker lacquering</legend>
									<label class="inline">Lacquering type&nbsp;
									<?
										$sql="SELECT DISTINCT lakierowanie_typ as lakierowanie_typ_wklejka FROM lakierowanie WHERE typ='$_GET[typ]' AND del='0' ORDER BY lakierowanie_typ";
										$res=mysql_query($sql);
										?>
										<select name="lakierowanie_typ_wklejka" onChange="document.forms['wycena'].action='#Lakierowanie_oklejka';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option ";
											if($_GET[lakierowanie_typ_wklejka]==$dane[lakierowanie_typ_wklejka]){echo " selected ";}
											echo " value='".$dane[lakierowanie_typ_wklejka]."'>".$dane[lakierowanie_typ_wklejka]."</option>";
										}
										?>
										</select>
									</label>
									<?
									if($_GET[lakierowanie_typ_wklejka]){
										$sql="SELECT id as lakierowanie_id_wklejka,lakierowanie_typ,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
										$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ='$_GET[lakierowanie_typ_wklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($lakierowanie_id_wklejka,$lakierowanie_typ,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($lakierowanie_id_wklejka){
											echo "<pre>";
											echo "<span class='label label-success'>In-sticker lacquering: </span>&nbsp;<strong>";
											if($cena>=0){echo $lakierowanie_typ." ".$cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/item ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'>No number of items</span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_lakierowanie.php?typ=$_GET[lakierowanie_typ_wklejka]&add=1'>Dodaj nowy format</a>
										<?}
									}else{
										echo "<span class='label label-warning'>Product without out-sticker lacquering</span>";
									}
									?>
								</div>
							</div>
							<a name="mechanizmy"></a>
							<div class="row-fluid">
								<div class="span6">
									<a name="Mechanizmy"></a>
									<legend>Mechanisms</legend>
									<label class="inline">Add mechanisms &nbsp;
									<?
										$sql="SELECT id as id_mechanizm,nazwa,typ_mechanizm FROM mechanizmy WHERE del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										if(!$_GET[id_mechanizm][1]){
											$count=1;
										}else{
											$count=count($_GET[id_mechanizm])+1;
										}
										?>
										<select name="id_mechanizm[<?=$count;?>]" onChange="document.forms['wycena'].action='#Mechanizmy';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option value='".$dane[id_mechanizm]."'>".$dane[nazwa]." - ".$dane[typ_mechanizm]."</option>";
										}
										?>
										</select>
									</label>
									<?
									if($_GET[id_mechanizm]){
										foreach($_GET[id_mechanizm] as $key => $val){
											if($val){
												$sql="SELECT nazwa,typ_mechanizm,cena,waluta,liczba_nitow,liczba_szt_pudlo FROM mechanizmy WHERE id='$val'";
												list($nazwa,$typ_mechanizm,$cena,$waluta,$liczba_nitow,$liczba_szt_pudlo)=mysql_fetch_row(mysql_query($sql));
												echo "<input type='hidden' name='id_mechanizm[$key]' value='$val'>";
												echo "<pre>";
													$url_del=str_replace("&id_mechanizm%5B$key%5D=$val","",$_SERVER[QUERY_STRING]);
													echo "<a href='?".$url_del."#Mechanizmy' class='close'>&times;</a>";
													echo "<span class='label label-success'>Mechanism: </span>&nbsp;<strong>".$nazwa." ".$typ_mechanizm."</strong><br/>";
													echo "<span class='label label-success'>Price: </span>&nbsp;<strong>".$cena." ".$waluta."</strong><br/>";
													echo "<span class='label label-success'>Number of rivets: </span>&nbsp;<strong>".$liczba_nitow."</strong><br/>";
													echo "<span class='label label-success'>Number in box: </span>&nbsp;<strong>".$liczba_szt_pudlo."</strong>";
												echo "</pre>";
											}
										}									
									}else{
										echo "<span class='label label-warning'>Produkt bez mechanizmów</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend>Fixed parts</legend>
									<?
										$sql="SELECT id as id_element,nazwa,cena,waluta FROM elementy WHERE typ='$_GET[typ]' AND del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											//echo "<label class='checkbox'>";
											echo "<input type='hidden' name='id_element[]' ";
											//if($_GET[id_element] && in_array($dane[id_element],$_GET[id_element])) echo " checked ";
											echo "value='".$dane[id_element]."'> ".$dane[nazwa]." ".$dane[cena]." ".$dane[waluta]."<br/>";
											//echo "</label>";
										}
									?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Dodatki"></a>
									<legend>More parts</legend>
									<?
										if(!$_GET[dodatki][1]){
											$count_dodatki=1;
										}else{
											ksort($_GET[dodatki]);
											end($_GET[dodatki]);
											$count_dodatki=key($_GET[dodatki])+1;
										}
										$sql="SELECT id as id_dodatek,nazwa,cena,waluta FROM dodatki WHERE del='0' ORDER BY nazwa";										
										//typ='$_GET[typ]' AND 
										$res=mysql_query($sql);
									?>
										<select name="dodatki_baza" onChange="document.forms['wycena'].action='#Dodatki';document.forms['wycena'].submit()">
										<option value="">-- select --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option value='".$dane[id_dodatek]."'>".$dane[nazwa]." - ".$dane[cena]." ".$dane[waluta]."/szt. </option>";
										}
										if($_GET[dodatki_baza]){
											$sql="SELECT nazwa,cena,waluta FROM dodatki WHERE id='$_GET[dodatki_baza]' AND del='0' ORDER BY nazwa";
											list($nazwa,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
											$_GET[dodatki][$count_dodatki]=$nazwa;
											$_GET[dodatki_cena][$count_dodatki]=$cena;
											$_GET[dodatki_typ_cena][$count_dodatki]="szt";
											$_GET[dodatki_waluta][$count_dodatki]=$waluta;
											$count_dodatki++;
										}
										?>
										</select>
										<label>
										Name
										<input class="span6" name="dodatki[<?=$count_dodatki?>]" type="text">&nbsp;
										</label>
										Price
									    <div class="input-append">
											<input class="span2" name="dodatki_cena[<?=$count_dodatki?>]" id="appendedInputButton" type="text">
											<select name="dodatki_waluta[<?=$count_dodatki?>]" class="span2">
													<option value="pln">pln
													<option value="eur">eur
													<option value="usd">usd
											</select>												
											<select name="dodatki_typ_cena[<?=$count_dodatki?>]" class="span2">
													<option value="szt">per item.
													<option value="cal">all
											</select>
											<button class="btn" type="button" onClick="document.forms['wycena'].action='#Dodatki';document.forms['wycena'].submit()"><i class="icon-plus"></i>Add</button>
										</div>
									<?
									if($_GET[dodatki]){
										foreach($_GET[dodatki] as $key => $val){
											if($val){
												echo "<input type='hidden' name='dodatki[$key]' value='$val'>";
												echo "<input type='hidden' name='dodatki_cena[$key]' value='".$_GET[dodatki_cena][$key]."'>";
												echo "<input type='hidden' name='dodatki_typ_cena[$key]' value='".$_GET[dodatki_typ_cena][$key]."'>";
												echo "<input type='hidden' name='dodatki_waluta[$key]' value='".$_GET[dodatki_waluta][$key]."'>";
												echo "<pre>";
													$val_del=urlencode($val);
													$val_del_cena=urlencode($_GET[dodatki_cena][$key]);
													$val_del_waluta=urlencode($_GET[dodatki_waluta][$key]);
													$url_del_dodatki=str_replace("&dodatki%5B$key%5D=$val_del","",$_SERVER[QUERY_STRING]);
													//echo $url_del_dodatki;
													$url_del_dodatki=str_replace("&dodatki_cena%5B$key%5D=$val_del_cena","",$url_del_dodatki);
													$url_del_dodatki=str_replace("&dodatki_waluta%5B$key%5D=$val_del_waluta","",$url_del_dodatki);
													echo "<a href='?".$url_del_dodatki."#Dodatki' class='close'>&times;</a>";
													echo "<span class='label label-success'>Add:</span>&nbsp;<strong>".$val."</strong> - ".$_GET[dodatki_cena][$key]." ".$_GET[dodatki_waluta][$key];
													if($_GET[dodatki_typ_cena][$key]){
														echo "/".$_GET[dodatki_typ_cena][$key].".";
													}else{
														echo "/item";
													}
													echo "<br/>";
												echo "</pre>";
											}
										}									
									}else{
										echo "<span class='label label-warning'>Produkt bez dodatków</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend>Rejectamenta</legend>
									<?
										$sql="SELECT id as odpady_id,odpad_typ,procent,szt_odpadu FROM odpady ";
										$sql.="WHERE (szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											//echo "<label class='checkbox'>";
											echo "<input type='hidden' name='odpady[]' ";
											//if($_GET[odpady] && in_array($dane[odpady_id],$_GET[odpady])) echo " checked ";
											echo "value='".$dane[odpady_id]."'> ".$dane[odpad_typ]." ";
											if($dane[szt_odpadu]>0){echo $dane[szt_odpadu]." item.";}else{echo $dane[procent]."%";}
											echo "<br/>";
											//echo "</label>";
										}
									?>
								</div>
							</div>
							<?
							}
							if($id_format && $_GET[nazwa_klienta] && $_GET[nazwa_zlecenia] && $_GET[liczba] && !$_GET['print']){
							?>
							<div class="row-fluid">
								<div class="span12">
								<legend>Next ...</legend>
								<p>
									<!--button class="btn btn-info" type="button">Zapisz aktualną wycenę</button-->
									<button class="btn btn-success" name="przelicz" type="submit" value="1" >Calculate pricing</button>
									<?if($_GET[wycena_id]){?>
										<button class="btn" name="przelicz_nowa" type="submit" value="1" >Calculate and save as new</button>
									<?}?>
								</p>
								</div>
							</div>
							<?}?>
							</fieldset>
						<?}?>	
						</form>				
						</div>
					</div>
<?
//			</div>

//			</div><!--/span-->
//        </div><!--/span-->
//		</div><!--/row-->

include('wyceny_footer.php');
?>