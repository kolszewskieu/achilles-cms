<?
include('wyceny_header.php');

if(!$_GET[liczba])$_GET[liczba]=500;
if(!$_GET[kurs] || $_GET[wczytaj_waluta])$_GET[kurs]=$_KURS_CONF;
$_KURS=$_GET[kurs];

//if(!$_GET[pricing_lang])$_GET[pricing_lang]="";

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
			<?if(!$_GET['print']){?><h3><?SL("valuation_order",$_GET[pricing_lang]);?></h3><?} //WYCENA SHOW ?> 
			<fieldset>
				<div class="row-fluid">
					<div class="span6">
						<legend><?SL("parameters",$_GET[pricing_lang]);?></legend>
						<?SL("type_of_product",$_GET[pricing_lang]);?>&nbsp; <strong><?=$_GET[typ_nazwa]?></strong><br/>
						<!--<?SL("thickness",$_GET[pricing_lang]);?>&nbsp;<strong><?=$_GET[grubosc]?></strong><br/> -->
						<?SL("product_format",$_GET[pricing_lang]);?> &nbsp;<strong><?=$_GET[format_x]?> x <?=$_GET[format_y]?></strong>
					</div>
					<div class="span6">
						<legend><?SL("customer_data",$_GET[pricing_lang]);?></legend>
							<?SL("customer_name",$_GET[pricing_lang]);?>&nbsp; <strong><?=$_GET[nazwa_klienta]?></strong><br/>
							<?SL("order_name",$_GET[pricing_lang]);?>&nbsp;<strong><?=$_GET[nazwa_zlecenia]?></strong><br/>
							<?SL("items",$_GET[pricing_lang]);?>&nbsp; <strong><?=$_GET[liczba]?> <?SL("items",$_GET[pricing_lang]);?></strong>
					</div>
				</div>
				
				<table class="table table-bordered">
				<th>#</th>
				<th><?SL("component",$_GET[pricing_lang]);?></th>
				<th><?SL("cost_eur",$_GET[pricing_lang]);?> <small>(<?SL("exchange",$_GET[pricing_lang]);?>: <?=$_KURS["pln/eur"];?> zł)</small></th>
				<th><?SL("cost_it_eur",$_GET[pricing_lang]);?></th>
				<th><?SL("cost_pln",$_GET[pricing_lang]);?></th>
				<th><?SL("cost_it_pln",$_GET[pricing_lang]);?></th>
				<tr><td>1</td><td>
				<?
				$cardboard = round(($_GET[format_x] * $_GET[format_y])/1000000 * $_GET[liczba],3);
				//$cardboard = floor($cardboard * 100) / 100;
				$cardboard = ceil($cardboard);
                $sheets = round($_GET[liczba]/$_GET[sheetitems]);
                				//$b0 = FALSE;
				$b0 = !(($_GET[format_x] <= 1000 || $_GET[format_y] <=1000) && ($_GET[format_x] <= 700 || $_GET[format_y] <=700));
				$sql="SELECT materials.id, name, price_range, price FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[tektura]' AND ";
										$sql.="$cardboard<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price)=mysql_fetch_row(mysql_query($sql));
										$_koszt_pln[1]=round($cardboard*$price,2);
										
					//$sql="SELECT id_format,format_x_od,format_x_do,format_y_od,format_y_do,tektura_x,tektura_y,sztuk_arkusz FROM format_tektura ";
					//$sql.="WHERE typ='$_GET[typ]' AND (";
					//$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					//$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
					//$sql.=" OR ";
					//$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					//$sql.=" AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') )";
					//$sql.=") AND grubosc_od<='$_GET[grubosc]' AND grubosc_do>='$_GET[grubosc]' ";
					//$sql.="AND del='0' ORDER BY prio ASC";
					//list($id_format,$format_x_od,$format_x_do,$format_y_od,$format_y_do,$tektura_x,$tektura_y,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
					SL("paperboard",$_GET[pricing_lang]);
					echo " (Typ: ".$name." ) "; // nazwa tektury
					//echo " (format: ".$tektura_x." x ".$tektura_y.",";
					//SL("utilities",$_GET[pricing_lang]);
					//echo ": ".$sztuk_arkusz."&nbsp;";
					//SL("items_per_sheet",$_GET[pricing_lang]);
					//echo " ,";
					//SL("grammage",$_GET[pricing_lang]);
					//echo ": ".$_GET[grubosc].", ".$_CONF["cena_tektura_tona"][$_GET[typ]]." ".$_CONF[waluta_tektura_tona][$_GET[typ]]."/tona)";
					//$_koszt_pln[1]=round(((($_GET[grubosc]*0.6)*($tektura_x/1000)*($tektura_y/1000)*(($_CONF["cena_tektura_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_tektura_tona][$_GET[typ]]])/1000))*$_GET[liczba])/$sztuk_arkusz,2);
					//$_koszt_eur[1]=round(((($_GET[grubosc]*0.6)*($tektura_x/1000)*($tektura_y/1000)*(($_CONF["cena_tektura_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_tektura_tona][$_GET[typ]]])/1000))*$_GET[liczba])/$sztuk_arkusz,2);;
					$_koszt_eur[1]=round($cardboard*($price*$_KURS["eur/pln"]),2);
					$SUMA_PLN=$_koszt_pln[1];
					$SUMA_EUR=$_koszt_eur[1];
				?>
				</td><td><?=$_koszt_eur[1];?></td><td><?=round($_koszt_eur[1]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[1];?></td><td><?=round($_koszt_pln[1]/$_GET[liczba],2);?></td></tr>
				<tr><td>2</td><td>
				<?
				//Papier Oklejki
				$sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
				//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
				$sql.="WHERE materials.id='$_GET[papiero]' AND ";
				$sql.="$cardboard<=price_range ORDER BY price_range";
				//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
				$sql.=" LIMIT 0,1";
				list($id_material,$name, $price_range, $price, $gsm,$currency)=mysql_fetch_row(mysql_query($sql));
				//$_koszt_pln[2]=$cardboard*$price;
					//$sql="SELECT id_format as id_format_oklejka,papier_x as papier_oklejka_x,papier_y as papier_oklejka_y,grubosc_od,sztuk_arkusz FROM format_oklejka ";
					//$sql.="WHERE typ='$_GET[typ]' AND";
					//$sql.="WHERE typ=8 AND";
					//$sql.="(";
					//$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					//$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]')";
					//$sql.=" OR ";
					//$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					//$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
					//$sql.=") ";
					//$sql.="AND del='0' ORDER BY prio ASC";
					//list($id_format_oklejka,$papier_oklejka_x,$papier_oklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));
					SL("out_sticker_paper",$_GET[pricing_lang]);
					echo " (";
					echo "&nbsp;".$name." ";
					//SL("grammage",$_GET[pricing_lang]);
					//echo ": &nbsp;".$grubosc_od.", format:&nbsp;".$papier_oklejka_x." x ".$papier_oklejka_y.", ";
					//SL("utilities",$_GET[pricing_lang]);
					//echo ": &nbsp;".$sztuk_arkusz." ";
					//SL("items_per_sheet",$_GET[pricing_lang]);
					echo ")<br/>";

					//$_koszt_pln[2]=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
					//$_koszt_eur[2]=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
					$_koszt_pln[2] = round($cardboard*$price*$_KURS["pln/$currency"],2);
					$_koszt_eur[2] = round($cardboard*$price*$_KURS["eur/$currency"],2);
                    $SUMA_PLN+=$_koszt_pln[2];
					$SUMA_EUR+=$_koszt_eur[2];
				?>
					</td><td><?=$_koszt_eur[2];?></td><td><?=round($_koszt_eur[2]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[2];?></td><td><?=round($_koszt_pln[2]/$_GET[liczba],2);?></td></tr>
				<tr><td>3</td><td>
				<?
				if($_GET[bez_papier_wklejka]){
				?>
					<?SL("in_sticker_paper",$_GET[pricing_lang]);?></td><td>-</td><td>-</td><td>-</td><td>-</td></tr>				
				<?
				}else{
					//Papier wklejki	
					$sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[papierw]' AND ";
										$sql.="$cardboard<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price, $gsm, $currency)=mysql_fetch_row(mysql_query($sql));
										//$_koszt_pln[3]=$cardboard*$price;
					//$sql="SELECT id_format as id_format_wklejka,papier_x as papier_wklejka_x,papier_y as papier_wklejka_y,grubosc_od,sztuk_arkusz FROM format_wklejka ";
					//$sql.="WHERE typ='$_GET[typ]' AND ";
					//$sql.="WHERE typ=8 AND";
					//$sql.="(";
					//$sql.="(format_x_od<='$_GET[format_x]' AND format_x_do>='$_GET[format_x]' ";
					//$sql.="AND format_y_od<='$_GET[format_y]' AND format_y_do>='$_GET[format_y]') ";
					//$sql.=" OR ";
					//$sql.="(format_x_od<='$_GET[format_y]' AND format_x_do>='$_GET[format_y]' ";
					//$sql.="AND format_y_od<='$_GET[format_x]' AND format_y_do>='$_GET[format_x]') ";
					//$sql.=") ";					
					//$sql.="AND del='0' ORDER BY prio ASC";
					//list($id_format_wklejka,$papier_wklejka_x,$papier_wklejka_y,$grubosc_od,$sztuk_arkusz)=mysql_fetch_row(mysql_query($sql));					

					SL("in_sticker_paper",$_GET[pricing_lang]);
					echo " (";
					echo "&nbsp;".$name." ";
					//SL("grammage",$_GET[pricing_lang]);
					//echo ": &nbsp;".$grubosc_od.", format:&nbsp;".$papier_wklejka_x." x ".$papier_wklejka_y.", ";
					//SL("utilities",$_GET[pricing_lang]);
					//echo ": &nbsp;".$sztuk_arkusz." ";
					//SL("items_per_sheet",$_GET[pricing_lang]);
					echo ")<br/>";

					
					//$_koszt_pln[3]=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
					//$_koszt_eur[3]=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["eur/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
					
					$_koszt_pln[3] = round($cardboard*$price*$_KURS["pln/$currency"],2);
					$_koszt_eur[3] = round($cardboard*$price*$_KURS["eur/$currency"],2);
					$SUMA_PLN+=$_koszt_pln[3];
					$SUMA_EUR+=$_koszt_eur[3];
				?>
				</td><td><?=$_koszt_eur[3];?></td><td><?=round($_koszt_eur[3]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[3];?></td><td><?=round($_koszt_pln[3]/$_GET[liczba],2);?></td></tr>				
				<?
				}
				?>
				<tr><td>4</td><td>
				<?//Druk Oklejki
				SL("out_sticker_print",$_GET[pricing_lang]);
					if($_GET[druk_typ_oklejka] && $_GET[papiero]){
						echo " (";
						SL("print_type",$_GET[pricing_lang]);
						echo "&nbsp;".$_GET[druk_typ_oklejka].")";
						if ($b0 === FALSE) {
						$sql="SELECT id as id_druk_oklejka,cena,cena_szt,cena_typ,waluta,szt_od,szt_do FROM druk_oklejka ";
						//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
						$sql.="WHERE typ=12 AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
						$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
						$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
						$sql.="AND del='0'";
						list($id_druk_oklejka,$cena,$cena_szt,$cena_typ,$waluta,$szt_od,$szt_do)=mysql_fetch_row(mysql_query($sql));
						if($id_druk_oklejka){
							if($cena>0){
								echo "<br>";
								SL("price",$_GET[pricing_lang]);
								echo ": ".$cena." ".$waluta." ";}
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
						}else //arkusz B0
						{
							$sql="SELECT print_type, price_range, price, currency FROM druk_zakres ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE print_type='$_GET[druk_typ_oklejka]' AND ";
										$sql.="$_GET[liczba]<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
							list($print_type,$price_range, $price, $currency)=mysql_fetch_row(mysql_query($sql));
							if ($print_type) { //zaznaczony typ druku - print type selected
							$transport = 200;
                            $transport = ($_GET[liczba] >= 2500) ? 400 : $transport;
                            $transport = ($_GET[liczba] >= 5000) ? 600 : $transport;
                            $transport = ($_GET[liczba] >= 7000) ? 800 : $transport;
                            $transport = ($_GET[liczba] >= 9000) ? 1000 : $transport;
                            $transport_eur = $transport*$_KURS["eur/pln"];
                            echo "&nbsp; + ".$transport."PLN";	
							$_koszt_pln[4]=round($transport+$price*$_GET[liczba]*$_KURS["pln/$currency"],3);
							$_koszt_eur[4]=round($transport_eur+$price*$_GET[liczba]*$_KURS["eur/$currency"],3);
								}	else{
							$_koszt_pln[4]=0;
							$_koszt_eur[4]=0;
								}	
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
				<?
				SL("in_sticker_print",$_GET[pricing_lang]);
					if($_GET[druk_typ_wklejka]){
						echo " (";
						SL("print_type",$_GET[pricing_lang]);
						echo "&nbsp;".$_GET[druk_typ_wklejka].")";

						$sql="SELECT id as id_druk_wklejka,cena,cena_szt,cena_typ,waluta,szt_od,szt_do FROM druk_wklejka ";
						//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
						$sql.="WHERE typ=12 AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
						$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
						$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
						$sql.="AND del='0'";
						list($id_druk_wklejka,$cena,$cena_szt,$cena_typ,$waluta,$szt_od,$szt_do)=mysql_fetch_row(mysql_query($sql));
						if($id_druk_oklejka){
							if($cena>0){
								echo "<br>";
								SL("price",$_GET[pricing_lang]);
								echo ": ".$cena." ".$waluta." ";}
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
				<?
				SL("out_sticker_foiling",$_GET[pricing_lang]);
				//if($_GET[typ_foli_oklejka] && $_GET[papiero]){
				    if($_GET[typ_foli_oklejka]) {
					$sql="SELECT nazwa".$_GET[pricing_lang]." as nazwa FROM folie WHERE id='".$_GET[typ_foli_oklejka]."'";
					list($nazwa_folia_oklejka)=mysql_fetch_row(mysql_query($sql));
					echo " (";
					SL("foiling_type",$_GET[pricing_lang]);
					echo ":&nbsp;".$nazwa_folia_oklejka.", ";
					//$sql="SELECT id_format as id_format_folia_oklejka,folia_x as folia_oklejka_x,folia_y as folia_oklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_oklejka ";
					//$sql.="WHERE typ_folie='$_GET[typ_foli_oklejka]' AND typ='$_GET[typ]' ";
					//$sql.="AND id_format_oklejka = '".$id_format_oklejka."' ";
					$sql="SELECT id as id_folie, nazwa".$_GET[pricing_lang]." as nazwa, cena, waluta FROM folie WHERE id='".$_GET[typ_foli_oklejka]."'";
					$sql.="AND del='0'";
					//list($id_format_folia_oklejka,$folia_oklejka_x,$folia_oklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					list($id_folie,$nazwa_folia_oklejka,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_folie){
						//echo " format: ".$folia_oklejka_x." x ".$folia_oklejka_y.", ";
						//SL("utilities",$_GET[pricing_lang]);
						//echo "&nbsp;".$sztuk_arkusz." ";
						//SL("items_per_sheet",$_GET[pricing_lang]);
						echo ") ";
						SL("price_m",$_GET[pricing_lang]);
						echo ": ".$cena." ".$waluta;

						$_koszt_pln[6]=round(($cardboard*($cena*$_KURS["pln/$waluta"])),2);
						$_koszt_eur[6]=round(($cardboard*($cena*$_KURS["eur/$waluta"])),2);
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
				<?
				SL("in_sticker_foiling",$_GET[pricing_lang]);
				if($_GET[typ_foli_wklejka]){
					$sql="SELECT nazwa".$_GET[pricing_lang]." as nazwa FROM folie WHERE id='".$_GET[typ_foli_wklejka]."'";
					list($nazwa_folia_wklejka)=mysql_fetch_row(mysql_query($sql));
					echo " (";
					SL("foiling_type",$_GET[pricing_lang]);
					echo ":&nbsp;".$nazwa_folia_wklejka.", ";
					//$sql="SELECT id_format as id_format_folia_wklejka,folia_x as folia_wklejka_x,folia_y as folia_wklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_wklejka ";
					//$sql.="WHERE typ_folie='$_GET[typ_foli_wklejka]' AND typ='$_GET[typ]' ";
					//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
					//$sql.="AND format_wklejka='".$papier_wklejka_x."x".$papier_wklejka_y."' ";
					//$sql.="AND id_format_wklejka = '".$id_format_wklejka."' ";
					//$sql.="AND del='0'";
					//list($id_format_folia_wklejka,$folia_wklejka_x,$folia_wklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					$sql="SELECT id as id_folie, nazwa".$_GET[pricing_lang]." as nazwa, cena, waluta FROM folie WHERE id='".$_GET[typ_foli_wklejka]."'";
					$sql.="AND del='0'";
					//list($id_format_folia_oklejka,$folia_oklejka_x,$folia_oklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					list($id_folie,$nazwa_folia_oklejka,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_folie){
						//echo " format: ".$folia_oklejka_x." x ".$folia_oklejka_y.", ";
						//SL("utilities",$_GET[pricing_lang]);
						//echo "&nbsp;".$sztuk_arkusz." ";
						//SL("items_per_sheet",$_GET[pricing_lang]);
						echo ") ";
						SL("price_m",$_GET[pricing_lang]);
						echo ": ".$cena." ".$waluta;

						$_koszt_pln[7]=round(($cardboard*($cena*$_KURS["pln/$waluta"])),2);
						$_koszt_eur[7]=round(($cardboard*($cena*$_KURS["eur/$waluta"])),2);
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
				<?
				SL("out_sticker_lacquering",$_GET[pricing_lang]);
				if($_GET[lakierowanie_typ_oklejka]){
					echo " (";
					SL("lacquering_type",$_GET[pricing_lang]);
					echo ": ".$_GET[lakierowanie_typ_oklejka].")";
					$sql="SELECT id as lakierowanie_id_oklejka,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
					//$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ".$_GET[pricing_lang]." ='$_GET[lakierowanie_typ_oklejka]' AND ";
					$sql.="WHERE typ=8 AND lakierowanie_typ".$_GET[pricing_lang]." ='$_GET[lakierowanie_typ_oklejka]' AND ";
					$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
					$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
					$sql.="AND del='0'";
					
					list($lakierowanie_id_oklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($lakierowanie_id_oklejka){
						if($cena>0){echo "<br>";SL("price",$_GET[pricing_lang]);echo ": ".$cena." ".$waluta." ";}
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
				<?
				SL("in_sticker_lacquering",$_GET[pricing_lang]);
				if($_GET[lakierowanie_typ_wklejka]){
					echo " (";
					SL("lacquering_type",$_GET[pricing_lang]);
					echo ": ".$_GET[lakierowanie_typ_wklejka].")";

					$sql="SELECT id as lakierowanie_id_wklejka,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
					//$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_wklejka]' AND ";
					$sql.="WHERE typ=8 AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_wklejka]' AND ";
					$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
					$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
					$sql.="AND del='0'";

					list($lakierowanie_id_wklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($lakierowanie_id_wklejka){
						if($cena>0){echo "<br>";SL("price",$_GET[pricing_lang]);echo ": ".$cena." ".$waluta." ";}
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
				/**if($_GET[id_mechanizm]){
				?>
					<tr class="warning"><td>10</td><td colspan="5">
					<?SL("mechanisms",$_GET[pricing_lang]);?></td></tr>
					<?
					foreach($_GET[id_mechanizm] as $key => $val){
						if($val){
							$sql="SELECT nazwa,typ_mechanizm,cena,waluta,liczba_nitow,liczba_szt_pudlo FROM mechanizmy WHERE id='$val'";
							list($nazwa,$typ_mechanizm,$cena,$waluta,$liczba_nitow,$liczba_szt_pudlo)=mysql_fetch_row(mysql_query($sql));
							echo "<tr><td></td><td>";
								echo $nazwa." ".$typ_mechanizm;
								echo " (";
								SL("number_of_rivets",$_GET[pricing_lang]);
								echo ": ".$liczba_nitow.", ";
								SL("number_in_box",$_GET[pricing_lang]);
								echo ": ".$liczba_szt_pudlo.") ";
								SL("price",$_GET[pricing_lang]);
								echo ": ".$cena." ".$waluta.", ";
								
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
				}**/
				if($_GET[kaszerowane]){
				?>
					<tr class="warning"><td>10</td><td>
					<?SL("coating",$_GET[pricing_lang]);?></td>
					<?
						$sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
							//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
							$sql.="WHERE materials.id=10 AND ";
							$sql.="$cardboard<=price_range ORDER BY price_range";
							//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
							$sql.=" LIMIT 0,1";
							list($id_material,$name, $price_range, $price, $gsm, $waluta)=mysql_fetch_row(mysql_query($sql));
							
							$_koszt_pln[10]=round($cardboard*$price*$_KURS["pln/".$waluta],2);
							
							$_koszt_eur[10]=round($cardboard*$price*$_KURS["eur/".$waluta],2);
							$SUMA_PLN+=$_koszt_pln[10];
							$SUMA_EUR+=$_koszt_eur[10];
							?>
							</td><td><?=$_koszt_eur[10];?></td><td><?=round($_koszt_eur[10]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[10];?></td><td><?=round($_koszt_pln[10]/$_GET[liczba],2);?></td></tr>
							<?
						
														
				} else{
					?><tr class="warning"><td>10</td><td>
					<?SL("coating",$_GET[pricing_lang]);?></td>
					</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
					<?
				}
				if($_GET[kaszerowanie]){
				    $counter = sizeof($_GET[kaszerowanie]);
                ?>
                    <tr class="warning"><td>10</td><td>
                    <?SL("coating",$_GET[pricing_lang]); ?></td>
                    <? 
                        $sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
                            //$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
                            $sql.="WHERE materials.id=10 AND ";
                            $sql.="$cardboard<=price_range ORDER BY price_range";
                            //$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
                            $sql.=" LIMIT 0,1";
                            list($id_material,$name, $price_range, $price, $gsm, $waluta)=mysql_fetch_row(mysql_query($sql));
                            
                            $_koszt_pln[10]=round($cardboard*$price*$_KURS["pln/".$waluta],2)*$counter;
                            $_koszt_eur[10]=round($cardboard*$price*$_KURS["eur/".$waluta],2)*$counter;
                            $SUMA_PLN+=$_koszt_pln[10];
                            $SUMA_EUR+=$_koszt_eur[10];
                            ?>
                            </td><td><?=$_koszt_eur[10];?></td><td><?=round($_koszt_eur[10]/$_GET[liczba],2);?></td><td><?=$_koszt_pln[10];?></td><td><?=round($_koszt_pln[10]/$_GET[liczba],2);?></td></tr>
                            <?
                        
                                                        
                }
				
				if($_GET[id_element]){
				?>
					<tr class="warning"><td>11</td><td colspan="5"><?SL("fixed_parts",$_GET[pricing_lang]);?></td></tr>
					<?
					//print_r($_GET[id_element]);
					foreach($_GET[id_element] as $key => $val){
						if($val){
							$sql="SELECT id,nazwa".$_GET[pricing_lang]." as nazwa,cena,waluta,z_mechanizmy FROM elementy WHERE id='$val'";
							list($id,$nazwa,$cena,$waluta,$z_mechanizmy)=mysql_fetch_row(mysql_query($sql));
							echo "<tr><td></td><td>";
							//sprawdzamy czy to są nity i dodajemy do wyceny liczbę nitów
							$_koszt_pln[11]=round($_GET[liczba]*$cena*$_KURS["pln/$waluta"],2);
							$_koszt_eur[11]=round($_GET[liczba]*$cena*$_KURS["eur/$waluta"],2);
							echo $nazwa." ".$cena." ".$waluta."/";
							SL("items",$_GET[pricing_lang]);
							
							//if(($id=="3" || $id=="21") && $liczba_nitow_all){
							if($z_mechanizmy=="1" && $liczba_nitow_all){
								echo "<br/>";
								SL("rivets_mechanisms",$_GET[pricing_lang]);
								echo ": ".$liczba_nitow_all." nity/szt.";
								$_koszt_pln[11]=round($liczba_nitow_all*$_GET[liczba]*$cena*$_KURS["pln/$waluta"],2);
								$_koszt_eur[11]=round($liczba_nitow_all*$_GET[liczba]*$cena*$_KURS["eur/$waluta"],2);
								$_koszt_nity_pln=$_koszt_pln[11];
								$_koszt_nity_eur=$_koszt_eur[11];
							}
							//if($id=="5" || $id=="22"){
							if($z_mechanizmy=="2"){
								echo "<br/>";
								SL("pieces_in_packaging",$_GET[pricing_lang]);
								echo ": ".$liczba_w_opak." szt/op.";
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
					<tr class="warning"><td>12</td><td colspan="5"><?SL("more_parts",$_GET[pricing_lang]);?></td></tr>
					<?
					foreach($_GET[dodatki] as $key => $val){
						if($val){
							$_GET[dodatki_cena][$key]=str_replace(",",".",$_GET[dodatki_cena][$key]);
							echo "<tr><td></td><td>";
							echo $val;
							echo " - ".$_GET[dodatki_cena][$key]." ".$_GET[dodatki_waluta][$key]."/".$_GET[dodatki_typ_cena][$key].".";
							$_koszt_pln[12]=round($_GET[dodatki_cena][$key]*$_KURS["pln/".trim($_GET[dodatki_waluta][$key])],2);
							$_koszt_eur[12]=round($_GET[dodatki_cena][$key]*$_KURS["eur/".trim($_GET[dodatki_waluta][$key])],2);

							if($_GET[dodatki_typ_cena][$key] == "szt" || $_GET[dodatki_typ_cena][$key] == "item"){
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
					<tr class="warning"><td>13</td><td colspan="5"><?SL("rejectamenta",$_GET[pricing_lang]);?></td></tr>
					<?
					foreach($_GET[odpady] as $key => $val){
						if($val){
							$szt_odpadu="";
							$procent="";
							$sql="SELECT odpad_typ".$_GET[pricing_lang]." as odpad_typ,procent,szt_odpadu,id_grupy_wyceny FROM odpady WHERE id='$val'";
							list($odpad_typ,$procent,$szt_odpadu,$id_grupy_wyceny)=mysql_fetch_row(mysql_query($sql));
							if ($id_grupy_wyceny==10 || $id_grupy_wyceny==100) continue;
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
				<td><strong><?SL("sum",$_GET[pricing_lang]);?></strong></td>				
				<td><strong><?=round($SUMA_EUR,2);?> euro</strong></td>
				<td><strong><?=round($SUMA_EUR/$_GET[liczba],2);?> euro/<?SL("per_item",$_GET[pricing_lang]);?></strong></td>
				<td><strong><?=round($SUMA_PLN,2);?> zł</strong></td>
				<td><strong><?=round($SUMA_PLN/$_GET[liczba],2);?> zł/<?SL("per_item",$_GET[pricing_lang]);?></strong></td>
				</tr>
				<tr class="success">
				<td></td>
				<?
				$sql="SELECT cena as cena_sugerowana FROM cena_sugerowana WHERE 
				(szt_od<$_GET[liczba] AND szt_do>$_GET[liczba]) OR (szt_od<$_GET[liczba] AND szt_do=0)
				AND typ='$_GET[typ]'";
				list($cena_sugerowana)=mysql_fetch_row(mysql_query($sql));
				?>
				<td><strong><?SL("suggested_price",$_GET[pricing_lang]);?> (x <?=$cena_sugerowana?>)</strong></td>
				<td><strong><?=round($SUMA_EUR*$cena_sugerowana,2);?> euro</strong></td>
				<td><strong><?=round(($SUMA_EUR/$_GET[liczba])*$cena_sugerowana,2);?> euro/<?SL("per_item",$_GET[pricing_lang]);?></strong></td>
				<td><strong><?=round($SUMA_PLN*$cena_sugerowana,2);?> zł</strong></td>
				<td><strong><?=round(($SUMA_PLN/$_GET[liczba])*$cena_sugerowana,2);?> zł/<?SL("per_item",$_GET[pricing_lang]);?></strong></td>
				</tr>
				</table>
				<?
				if($_GET[wycena_id] && !$_GET[show_wycena_id] && !$_GET[przelicz_nowa]){
					$sql="UPDATE wyceny SET nazwa_klienta='".$_GET[nazwa_klienta]."',nazwa_zlecenia='".$_GET[nazwa_zlecenia]."',szt='".$_GET[liczba]."',koszt_calkowity_eur='".round($SUMA_EUR,2)."',koszt_szt_eur='".round($SUMA_EUR/$_GET[liczba],2)."',koszt_calkowity_pln='".round($SUMA_PLN,2)."',koszt_szt_pln='".round($SUMA_PLN/$_GET[liczba],2)."',kurs_eur='".$_KURS["pln/eur"]."',parametry='".serialize($_GET)."',modyf='".$_SESSION['user_id']."',linkp='pricing_cbox',data_last_modyf=NOW() WHERE id='$_GET[wycena_id]'";
					if(mysql_query($sql)){?>
						<input type="hidden" name="wycena_id" value="<?=$_GET[wycena_id];?>">
					    <div class="alert">
						<strong><?SL("pricing",$_GET[pricing_lang]);?></strong> <?SL("update",$_GET[pricing_lang]);?>.
						</div>
					<?
					}else{
						echo mysql_error()." <br>".$sql;
					}
				}elseif(!$_GET[show_wycena_id]){
					$sql="INSERT INTO wyceny (nazwa_klienta,nazwa_zlecenia,szt,koszt_calkowity_eur,koszt_szt_eur,koszt_calkowity_pln,koszt_szt_pln,kurs_eur,parametry,wprow,linkp,data_wprow) VALUES ('".$_GET[nazwa_klienta]."','".$_GET[nazwa_zlecenia]."','".$_GET[liczba]."','".round($SUMA_EUR,2)."','".round($SUMA_EUR/$_GET[liczba],2)."','".round($SUMA_PLN,2)."','".round($SUMA_PLN/$_GET[liczba],2)."','".$_KURS["pln/eur"]."','".serialize($_GET)."','".$_SESSION['user_id']."','pricing_cbox',NOW())";
					if(mysql_query($sql)){
						$sql="SELECT MAX(id) FROM wyceny WHERE nazwa_klienta='".$_GET[nazwa_klienta]."' AND nazwa_zlecenia='".$_GET[nazwa_zlecenia]."' AND szt='".$_GET[liczba]."' AND koszt_calkowity_eur='".round($SUMA_EUR,2)."'";
						list($wycena_id)=mysql_fetch_row(mysql_query($sql));
						?>
						<input type="hidden" name="wycena_id" value="<?=$wycena_id;?>">
					    <div class="alert">
						<strong><?SL("pricing",$_GET[pricing_lang]);?></strong> <?SL("update",$_GET[pricing_lang]);?>.
						</div>
					<?}
				}
				
				if(!$_GET['print']){
				?>
				<div class="row-fluid">				
					<div class="span12">
					<legend><?SL("next",$_GET[pricing_lang]);?> ...</legend>
					<p>
						<!--button class="btn btn-info" type="button">Zapisz aktualną wycenę</button-->
						<input type="hidden" name="przelicz_nowa" value="0">
						<button class="btn btn-danger" name="przelicz" type="submit" value="0" ><?SL("reconfigure",$_GET[pricing_lang]);?></button>
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
						<h3><?SL("new_calculation",$_GET[pricing_lang]);?></h3>
						<input type="hidden" name="action" value="<?=$_GET[action]?>">
						<input type="hidden" name="site" value="<?=$_GET[site]?>">
						<?if($_GET[wycena_id]){?>
							<input type="hidden" name="wycena_id" value="<?=$_GET[wycena_id];?>">
						<?}?>
						<fieldset>
							<div class="row-fluid">
								<div class="span6">
									<a name="Parametry_wyceny"></a>
									<legend><?SL("parameters",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("type_of_product",$_GET[pricing_lang]);?> &nbsp;
										<?
										$sql="SELECT id as typ,nazwa".$_GET[pricing_lang]." as nazwa FROM produkty WHERE aktywny='1' AND del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										?>
										<select name="typ" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
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
									//if(!$_GET[grubosc] || ($_GET[typ]!=$_GET[typ_old] && $_GET[typ_old]!="")){
										//$sql="SELECT def_grubosc,def_format_x,def_format_y,ile_tektur FROM produkty WHERE id=$_GET[typ]";
										//list($_GET[grubosc],$_GET[format_x],$_GET[format_y],$_GET[ile_tektur])=mysql_fetch_row(mysql_query($sql));
										//$_GET[wczytaj]=0;
									//}
									?>
									
									<label class="inline"><?SL("cardboard_type",$_GET[pricing_lang]);?>&nbsp;
									<?
									//$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
									$sql="SELECT DISTINCT id as id_material, name FROM materials WHERE typ='tektura' ORDER BY id_material";
									$res=mysql_query($sql);
									?>
									<select name="tektura" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
									<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
									<?
									while($dane=mysql_fetch_array($res)){
										echo "<option ";
										if($_GET[tektura]==$dane[id_material]){echo " selected ";}
										echo " value='".$dane[id_material]."'>".$dane[name]."</option>";
									}
									?>
									</select>
									</label>
									
									<?
									if($_GET[tektura]){
										$sql="SELECT materials.id, name, price_range, price FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[tektura]' ";
										//$sql.="'$_GET[liczba]'<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price)=mysql_fetch_row(mysql_query($sql));
										if($id_material){
											echo "<pre>";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Tektura';
											echo ": </span>&nbsp;<strong>";
											echo $name;
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>&nbsp;";
											if(!$_GET[kaszerowane]=="1")
											echo "+Kaszerowanie <input type=\"checkbox\" name=\"kaszerowane\" value=\"1\" onClick=\"document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()\"/>";
											else {
												echo "+Kaszerowanie <input type=\"checkbox\" name=\"kaszerowane\" checked value=\"1\" onClick=\"document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()\"/>";
											}
											echo "</pre>";
										}else{?>
												<span class='label label-important'>
													Brak Cennika
													<?
													//SL("no_out_sticker_print_format",$_GET[pricing_lang]);?>
													</span>
												<!-- <a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_druk_oklejka.php?add=1'><?SL("add_new_out_sticker_print_type",$_GET[pricing_lang]);?></a> -->
										<?}
									}else{
										echo "<span class='label label-warning'>";
										//SL("product_without_out_sticker_print",$_GET[pricing_lang]);
										echo 'Wybierz Rodzaj Tektury';
										echo "</span>";
									}
									?>
								<!-- koniec materiał tektura-->
									<!-- <label class="inline"><?SL("thickness",$_GET[pricing_lang]);?> &nbsp;
										<select name="grubosc" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
										<?	
										$lista_grubosc=array("1.8","1.9","2.0","2.25","1.0","1.1","1.2","1.3","1.4","1.5","1.6","1.7","2.30","2.40","2.50","2.60","2.70","2.75","2.80","2.90","3.00");
										foreach($lista_grubosc as $key => $val){
											echo "<option ";
											if($_GET[grubosc]==$val){echo " selected ";}
											echo " value='".$val."'>".$val."</option>";											
										}
										?>
										</select>
									</label> -->
									<label class="inline"><?SL("product_format",$_GET[pricing_lang]);?>&nbsp;
										<?
										if(!$_GET[typ]){
												echo "<span class='label label-warning'>";
												SL("sel_type_product",$_GET[pricing_lang]);
												echo "</span>";
										//}elseif(!$_GET[grubosc]){
										//	echo "<span class='label label-warning'>";
										//	SL("select_thickness",$_GET[pricing_lang]);
										//	echo "</span>";
										}else{
											if(!$_GET[format_x])$_GET[format_x]="555";
											if(!$_GET[format_y])$_GET[format_y]="315";
											?>
												<input name="format_x" value="<?=$_GET[format_x]?>" type="text" class="input-mini" autocomplete="off">&nbsp;x
												<input name="format_y" value="<?=$_GET[format_y]?>" type="text" class="input-mini" autocomplete="off">
											<?
											}?>
											
  <br/>Arkusze i użytki:
  <label class="radio-inline" style="display: inline;">
    <input type="radio" name="sheetsize" id="ob0" value="B0" <?if ($_GET[sheetsize]==='B0') echo checked;?> onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit();">
    B0
    </label>

  <label class="radio-inline" style="display: inline;">
    <input type="radio" name="sheetsize" id="ob1" value="B1" <?if ($_GET[sheetsize]==='B1') echo checked;?> onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit();">
   B1
  </label>
  <label class="radio-inline" style="display: inline;">
       <input type="radio" name="sheetsize" id="ob2" value="B2" <?if ($_GET[sheetsize]==='B2') echo checked;?> onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit();">
   B2
  </label>
  / Ilość użytków <input name="sheetitems" value="<?=$_GET[sheetitems]?>" type="text" class="input-mini" autocomplete="off">&nbsp;
  <label class="inline"><?SL("cardboard_type",$_GET[pricing_lang]);?>&nbsp;
                                    <?
                                    //$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
                                    $sql="SELECT DISTINCT id as id_drukarnia, name FROM drukarnie  ORDER BY id_drukarnia";
                                    $res=mysql_query($sql);
                                    ?>
                                    <select name="drukarnia" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
                                    <option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
                                    <?
                                    while($dane=mysql_fetch_array($res)){
                                        echo "<option ";
                                        if($_GET[drukarnia]==$dane[id_drukarnia]){echo " selected ";}
                                        echo " value='".$dane[id_drukarnia]."'>".$dane[name]."</option>";
                                    } 
                                    ?>
                                    </select>
                                    </label>

											<input type="hidden" name="ile_tektur" value="<?=$_GET[ile_tektur]?>">
											<input type="hidden" name="wczytaj" value="1">
											<input type="hidden" name="typ_old" value="<?=$_GET[typ]?>">
											<button class="btn btn-mini btn-primary" name="wczytaj" type="button" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()"><?SL("load",$_GET[pricing_lang]);?></button></label>
											</label>
											<?
											if($_GET[wczytaj]==1 && $_GET[format_x] && $_GET[format_y])
											{
											$cardboard = round(($_GET[format_x] * $_GET[format_y])/1000000 * $_GET[liczba],3);
											//$cardboard = floor($cardboard * 100) / 100;
											$cardboard = ceil($cardboard);
                                            $sheets = round($_GET[liczba]/$_GET[sheetitems]);
									    $sql="SELECT materials.id, name, price_range, price FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[tektura]' AND ";
										$sql.="$cardboard<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price)=mysql_fetch_row(mysql_query($sql));
										if($id_material){
											
											echo "<pre>";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Tektura m2';
											echo ": </span>&nbsp;<strong>";
											echo $cardboard;
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>&nbsp;";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Cena za m2';
											echo ": </span>&nbsp;<strong>";
											echo "PLN ".number_format($price, 3);
                                            
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}
											}else{
												echo "<span class='label label-warning'>";
												SL("specify_product_format",$_GET[pricing_lang]);
												echo "</span>";
											}
								?>
								</div>
								<div class="span6">
									<legend><?SL("customer_data",$_GET[pricing_lang]);?>
									<span class="label label-warning">
									<?SL("calc_lang",$_GET[pricing_lang]);?>&nbsp;
									<input type="radio" name="pricing_lang" value="" <?echo ($_GET[pricing_lang]==""?"checked":"");?> onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;
									<img src="/img/flags/pl.png" width="20" />
									&nbsp;
									<input type="radio" name="pricing_lang" value="_en" <?echo ($_GET[pricing_lang]=="_en"?"checked":"");?> onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;
									<img src="/img/flags/en.png" width="20" />
									&nbsp;
									</span>
									</legend>
									<label class="inline"><?SL("customer_name",$_GET[pricing_lang]);?> &nbsp; <input type="text" placeholder="<?SL("customer_name",$_GET[pricing_lang]);?>" name="nazwa_klienta" value="<?=$_GET[nazwa_klienta]?>" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;<small><?SL("required",$_GET[pricing_lang]);?></small></label>
									<label class="inline"><?SL("order_name",$_GET[pricing_lang]);?> &nbsp; <input type="text" placeholder="<?SL("order_name",$_GET[pricing_lang]);?>" name="nazwa_zlecenia" value="<?=$_GET[nazwa_zlecenia]?>" onChange="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()">&nbsp;<small><?SL("required",$_GET[pricing_lang]);?></small></label>
									<label class="inline"><?SL("items",$_GET[pricing_lang]);?> &nbsp; <input type="text" class="input-small" name="liczba" value="<?=$_GET[liczba]?>">&nbsp;<small><?SL("required",$_GET[pricing_lang]);?></small>
									<button class="btn btn-mini btn-primary" type="button" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()"><?SL("change",$_GET[pricing_lang]);?></button></label>
									<?
									foreach($_KURS as $key => $val){
										echo "<input type='hidden' name='kurs[".trim($key)."]' value='".$val."'>";
									}
									?>
									<span class='label label-success'>EUR</span>&nbsp;<strong><?=$_KURS['pln/eur']?> zł.</strong>&nbsp;
									<?if($_KURS['pln/eur']!=$_KURS_CONF['pln/eur']){?><small>(<?SL("now",$_GET[pricing_lang]);?>: <?=$_KURS_CONF['pln/eur']?>)</small><?$akt=1;}?>
									<span class='label label-success'>USD: </span>&nbsp;<strong><?=$_KURS['pln/usd']?> zł.</strong>
									<?if($_KURS['pln/usd']!=$_KURS_CONF['pln/usd']){?><small>(<?SL("now",$_GET[pricing_lang]);?>: <?=$_KURS_CONF['pln/usd']?>)</small><?$akt=1;}?>
									<span class='label label-success'>EUR/USD: </span>&nbsp;<strong><?=$_KURS['eur/usd']?></strong>
									<?if($_KURS['eur/usd']!=$_KURS_CONF['eur/usd']){?><small>(<?SL("now",$_GET[pricing_lang]);?>: <?=$_KURS_CONF['eur/usd']?>)</small><?$akt=1;}?>
									<span class='label label-success'>USD/EUR: </span>&nbsp;<strong><?=$_KURS['usd/eur']?></strong>
									<?if($_KURS['usd/eur']!=$_KURS_CONF['usd/eur']){?><small>(<?SL("now",$_GET[pricing_lang]);?>: <?=$_KURS_CONF['usd/eur']?>)</small><?$akt=1;}?>
									<?if($akt==1){?>
										<!--input type="hidden" name="wczytaj_waluta" value="1"-->
										<input class="btn btn-mini btn-primary" type="submit" name="wczytaj_waluta" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()" value="<?SL("load_exchange",$_GET[pricing_lang]);?>"></label>
									<?}?>
								</div>
							</div>
							<?
							if($cardboard){
							?>
							<div class="row-fluid">
								<div class="span6">
									
									<legend><?SL("out_sticker_paper",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("paper_type",$_GET[pricing_lang]);?>&nbsp;
									<?
									//$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
									$sql="SELECT DISTINCT id as id_material, name FROM materials WHERE typ='papier' ORDER BY id_material";
									$res=mysql_query($sql);
									?>
									<select name="papiero" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
									<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
									<?
									while($dane=mysql_fetch_array($res)){
										echo "<option ";
										if($_GET[papiero]==$dane[id_material]){echo " selected ";}
										echo " value='".$dane[id_material]."'>".$dane[name]."</option>";
									}
									?>
									</select>
									</label>
									<?
									    $sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[papiero]' AND ";
										$sql.="$cardboard<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price, $gsm, $currency)=mysql_fetch_row(mysql_query($sql));
										if($id_material){
											//$koszt=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
											$koszt = $cardboard*$price*$_KURS["pln/$currency"];
											//$_koszt_eur[4]+=round(($_GET[liczba]-$szt_do)*($cena_szt*$_KURS["eur/$waluta"]),2);
											echo "<pre>";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Papier m2';
											echo ": </span>&nbsp;<strong>";
											echo $cardboard;
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>&nbsp;";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Koszt';
											echo ": </span>&nbsp;<strong>";
											echo "PLN ".number_format($koszt, 3);
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
											<span class='label label-important'><?SL("no_out_sticker_paper",$_GET[pricing_lang]);?></span>
											
									<?}?>
								</div>
								<div class="span6">
									<legend><?SL("in_sticker_paper",$_GET[pricing_lang]);?>
									<small> - <?SL("in_sticker_paper",$_GET[pricing_lang]);?>&nbsp;<input type="checkbox" name="bez_papier_wklejka" value="1" onClick="document.forms['wycena'].action='#Parametry_wyceny';document.forms['wycena'].submit()"
									<?if($_GET[bez_papier_wklejka]=="1")echo "checked";?>
									></small></legend>
									<label class="inline"><?SL("paper_type",$_GET[pricing_lang]);?>&nbsp;
									<?
									//$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
									$sql="SELECT DISTINCT id as id_material, name FROM materials WHERE typ='papier' ORDER BY id_material";
									$res=mysql_query($sql);
									?>
									<select name="papierw" onChange="document.forms['wycena'].action='#Druk_wklejka';document.forms['wycena'].submit()">
									<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
									<?
									while($dane=mysql_fetch_array($res)){
										echo "<option ";
										if($_GET[papierw]==$dane[id_material]){echo " selected ";}
										echo " value='".$dane[id_material]."'>".$dane[name]."</option>";
									}
									?>
									</select>
									</label>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'><?SL("no_in_sticker_paper",$_GET[pricing_lang]);?></span>
									<?
									}else{
										
										$sql="SELECT materials.id, name, price_range, price, gsm, currency FROM materials JOIN ceny_zakres ON materials.id = ceny_zakres.id_item ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE materials.id='$_GET[papierw]' AND ";
										$sql.="$cardboard<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id_material,$name, $price_range, $price, $gsm, $currency)=mysql_fetch_row(mysql_query($sql));
										if($id_material){
											//$koszt=round((($cardboard*$gsm)/1000*(($_CONF["cena_papier_tona"][$_GET[typ]]*$_KURS["pln/".$_CONF[waluta_papier_tona][$_GET[typ]]])/1000)),2);
											$koszt = $cardboard*$price*$_KURS["pln/$currency"];
											echo "<pre>";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Papier m2';
											echo ": </span>&nbsp;<strong>";
											echo $cardboard;
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>&nbsp;";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Koszt';
											echo ": </span>&nbsp;<strong>";
											echo "PLN ".number_format($koszt, 3);
											//if($cena>0){echo $cena." ".$waluta." ";}
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'><?SL("no_in_sticker_paper",$_GET[pricing_lang]);?></span>
												
										<?}
									}
									?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Druk_oklejka"></a>
									<legend><?SL("out_sticker_print",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("print_type",$_GET[pricing_lang]);?>&nbsp;
									<?
									//$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
									$sql="SELECT DISTINCT druk_typ as druk_typ_oklejka FROM druk_oklejka WHERE typ=8 AND del='0' ORDER BY druk_typ";
									$res=mysql_query($sql);
									?>
									<select name="druk_typ_oklejka" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
									<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
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
										$b0 =!(($_GET[format_x] <= 1000 || $_GET[format_y] <=1000) && ($_GET[format_x] <= 700 || $_GET[format_y] <=700));
										if ($b0 === FALSE) {
										$sql="SELECT id as id_druk_oklejka,cena,cena_szt,cena_typ,waluta FROM druk_oklejka ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE typ=12 AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($id_druk_oklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($id_druk_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("print_type",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>";
											echo $_GET[druk_typ_oklejka]." ";
											if($cena>0){echo $cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'><?SL("no_out_sticker_print_format",$_GET[pricing_lang]);?></span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_druk_oklejka.php?add=1'><?SL("add_new_out_sticker_print_type",$_GET[pricing_lang]);?></a>
										<?} 
									}else{ //B0
										
										$sql="SELECT id_printhouse, print_type, sheetsize, price_range, price, currency, name, local FROM druk_zakres JOIN drukarnie ON id_printhouse = drukarnie.id ";
										//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
										$sql.="WHERE print_type='$_GET[druk_typ_oklejka]' AND ";
										$sql.="sheetsize ='$_GET[sheetsize]' AND id_printhouse='$_GET[drukarnia]' AND ";
										$sql.="$sheets<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.=" LIMIT 0,1";
										list($id, $print_type, $sheetsize, $price_range, $price, $currency, $name)=mysql_fetch_row(mysql_query($sql));
										if ($print_type){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("print_type",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>";
											echo $_GET[druk_typ_oklejka]." ";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Koszt-'; echo $name;
											echo ": </span>&nbsp;";
											echo "PLN ".number_format($price*$sheets, 2);
											echo "</strong>&nbsp;";
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
											} else {
												echo "<span class='label label-warning'>";
										SL("no_price",$_GET[pricing_lang]);
										echo "</span>";
											}
									}}else{
										echo "<span class='label label-warning'>";
										SL("product_without_out_sticker_print",$_GET[pricing_lang]);
										echo "</span>";
									}
									
									?>
								</div>
								<div class="span6">
									<legend><?SL("in_sticker_print",$_GET[pricing_lang]);?></legend>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'><?SL("product_without_in_sticker_print",$_GET[pricing_lang]);?></span>
									<?
									}else{
									?>
										<label class="inline"><?SL("print_type",$_GET[pricing_lang]);?>&nbsp;
										<?
											//$sql="SELECT DISTINCT druk_typ as druk_typ_wklejka FROM druk_wklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY druk_typ";
											$sql="SELECT DISTINCT druk_typ as druk_typ_wklejka FROM druk_wklejka WHERE typ=8 AND del='0' ORDER BY druk_typ";
											$res=mysql_query($sql);
											?>
											<select name="druk_typ_wklejka" onChange="document.forms['wycena'].action='#Druk_oklejka';document.forms['wycena'].submit()">
											<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
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
											//$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
											$sql.="WHERE typ=12 AND druk_typ='$_GET[druk_typ_wklejka]' AND ";
											$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
											$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
											$sql.="AND del='0'";
											list($id_druk_wklejka,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
											if($id_druk_wklejka){
												echo "<pre>";
												echo "<span class='label label-success'>";
												SL("in_sticker_print",$_GET[pricing_lang]);
												echo "</span>&nbsp;<strong>";
												echo $_GET[druk_typ_wklejka]." ";
												if($cena>0){echo $cena." ".$waluta." ";}
												if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
												echo "</strong>";
												echo "</pre>";
											}else{?>
													<span class='label label-important'><?SL("no_out_sticker_print_format",$_GET[pricing_lang]);?></span>
													<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_druk_oklejka.php?add=1'><?SL("add_new_out_sticker_print_type",$_GET[pricing_lang]);?></a>
											<?}
										}else{
											echo "<span class='label label-important'>";
											SL("product_without_in_sticker_print",$_GET[pricing_lang]);
											echo "</span>";

										}
									}
									?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<a name="Folia_oklejka"></a>
									<legend><?SL("out_sticker_foiling",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("foiling_type",$_GET[pricing_lang]);?>&nbsp;
									<?
										$sql="SELECT id as typ_foli_oklejka,nazwa".$_GET[pricing_lang]." as nazwa FROM folie WHERE del='0'";
										//$sql="SELECT DISTINCT id as id_material, name FROM materials WHERE typ='folia' ORDER BY id_material";
										$res=mysql_query($sql);
										?>
										<select name="typ_foli_oklejka" onChange="document.forms['wycena'].action='#Folia_oklejka';document.forms['wycena'].submit()">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option ";
											if($_GET[typ_foli_oklejka]==$dane[typ_foli_oklejka]){echo " selected ";}
											echo " value='".$dane[typ_foli_oklejka]."'>".$dane[nazwa]."</option>";
										}
										?>
										</select>
									</label>
									<?
									if($_GET[typ_foli_oklejka]){
										//$sql="SELECT id_format as id_format_folia_oklejka,folia_x as folia_oklejka_x,folia_y as folia_oklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_oklejka ";
//										$sql.="WHERE typ_folie='$_GET[typ_foli_oklejka]' AND typ='$_GET[typ]' ";
										//$sql.="WHERE typ_folie='$_GET[typ_foli_oklejka]' AND typ=8";
										//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
										//$sql.="AND format_oklejka='".$papier_oklejka_x."x".$papier_oklejka_y."' ";
										//$sql.="AND id_format_oklejka = '".$id_format_oklejka."' ";
										//$sql.="AND del='0'";
										//list($id_format_folia_oklejka,$folia_oklejka_x,$folia_oklejka_y,$sztuk_arkusz,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
										$sql="SELECT id as id_folie, nazwa".$_GET[pricing_lang]." as nazwa, cena, waluta FROM folie WHERE id='".$_GET[typ_foli_oklejka]."'";
										$sql.="AND del='0'";
										
										list($id_folie,$nazwa_folia_oklejka,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_folie){
						$koszt=round(($cardboard*($cena*$_KURS["pln/$waluta"])),2);
						echo "<pre>";
						echo "<span class='label label-success'>";
						echo 'Folia m2';
						echo ": </span>&nbsp;<strong>";
						echo $cardboard.'&nbsp;';
						//SL("price_m",$_GET[pricing_lang]);
						//echo ": ".$cena." ".$waluta;
						echo "<span class='label label-success'>";
						//SL("print_type",$_GET[pricing_lang]);
						echo 'Koszt';
						echo ": </span>&nbsp;";
						echo "PLN ".number_format($koszt, 2);
						echo "</strong>&nbsp;";
						echo "</pre>";
										
										/** if($id_format_folia_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("out_sticker_foiling",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>";
											echo $folia_oklejka_x." x ".$folia_oklejka_y."</strong>";
											//echo "<br/>z tektura: ".$tektura_x." x ".$tektura_y." oklejka: ".$papier_oklejka_x." x ".$papier_oklejka_y." <br/>";
											echo "<br/><span class='label label-success'>";
											SL("utilities",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>&nbsp;";
											echo $sztuk_arkusz." ";
											SL("items_per_sheet",$_GET[pricing_lang]);
											echo "</strong><br/>";
											echo "<span class='label label-success'>";											
											SL("price",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>&nbsp;";
											echo $cena." ".$waluta."</strong>";**/
											
									}else{?>
												<span class='label label-important'><?SL("no_out_sticker_foiling",$_GET[pricing_lang]);?></span>
												<!-- <a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_oklejka.php?typ=$_GET[typ]&add=1'><?SL("add_new_out_sticker_foiling_format",$_GET[pricing_lang]);?></a>-->
										<?}
									}else{
										echo "<span class='label label-warning'>";
										SL("product_without_out_sticker_foiling",$_GET[pricing_lang]);
										echo "</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend><?SL("in_sticker_foiling",$_GET[pricing_lang]);?></legend>
									<?
									if($_GET[bez_papier_wklejka]=="1"){
									?>
										<span class='label label-important'><?SL("no_in_sticker_foiling",$_GET[pricing_lang]);?></span>
									<?
									}else{
									?>
										<label class="inline"><?SL("foiling_type",$_GET[pricing_lang]);?>&nbsp;
										<?
											$sql="SELECT id as typ_foli_wklejka,nazwa".$_GET[pricing_lang]." as nazwa FROM folie WHERE del='0'";
											$res=mysql_query($sql);
											?>
											<select name="typ_foli_wklejka" onChange="document.forms['wycena'].action='#Folia_oklejka';document.forms['wycena'].submit()">
											<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
											<?
											while($dane=mysql_fetch_array($res)){
												echo "<option ";
												if($_GET[typ_foli_wklejka]==$dane[typ_foli_wklejka]){echo " selected ";}
												echo " value='".$dane[typ_foli_wklejka]."'>".$dane[nazwa]."</option>";
											}
											?>
											</select>
										</label>
										<?
										if($_GET[typ_foli_wklejka]){
											//$sql="SELECT id_format as id_format_folia_wklejka,folia_x as folia_wklejka_x,folia_y as folia_wklejka_y,sztuk_arkusz,cena,waluta FROM format_folia_wklejka ";
											//$sql.="WHERE typ_folie='$_GET[typ_foli_wklejka]' AND typ=8 ";
											//AND format_papieru='".$tektura_x."x".$tektura_y."' ";
											//$sql.="AND format_wklejka='".$papier_wklejka_x."x".$papier_wklejka_y."' ";
											//$sql.="AND id_format_wklejka = '".$id_format_wklejka."' ";
											//$sql.="AND del='0'";
											//list($id_format_folia_wklejka,$folia_wklejka_x,$folia_wklejka_y,$sztuk_arkusz,$cena_folia_wklejka,$waluta)=mysql_fetch_row(mysql_query($sql));
											/**if($id_format_folia_wklejka){
												echo "<pre>";
												echo "<span class='label label-success'>";
												SL("in_sticker_foiling",$_GET[pricing_lang]);
												echo "</span>&nbsp;<strong>";
												echo $folia_wklejka_x." x ".$folia_wklejka_y."</strong>";
												//echo "<br/>z tektura: ".$tektura_x." x ".$tektura_y." wklejka: ".$papier_wklejka_x." x ".$papier_wklejka_y." <br/>";											
												echo "<br/><span class='label label-success'>";
												SL("utilities",$_GET[pricing_lang]);
												echo ": </span>&nbsp;<strong>&nbsp;";
												echo $sztuk_arkusz;
												SL("items_per_sheet",$_GET[pricing_lang]);
												echo "</strong><br/>";
												echo "<span class='label label-success'>";
												SL("price",$_GET[pricing_lang]);
												echo ": </span>&nbsp;<strong>&nbsp;";
												echo $cena_folia_wklejka." ".$waluta."</strong>";
												echo "</pre>";**/
												$sql="SELECT id as id_folie, nazwa".$_GET[pricing_lang]." as nazwa, cena, waluta FROM folie WHERE id='".$_GET[typ_foli_wklejka]."'";
										$sql.="AND del='0'";
										
										list($id_folie,$nazwa_folia_oklejka,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
					if($id_folie){
						$koszt=round(($cardboard*($cena*$_KURS["pln/$waluta"])),2);
						echo "<pre>";
						echo "<span class='label label-success'>";
						echo 'Folia m2';
						echo ": </span>&nbsp;<strong>";
						echo $cardboard.'&nbsp;';
						//SL("price_m",$_GET[pricing_lang]);
						//echo ": ".$cena." ".$waluta;
						echo "<span class='label label-success'>";
						//SL("print_type",$_GET[pricing_lang]);
						echo 'Koszt';
						echo ": </span>&nbsp;";
						echo "PLN ".number_format($koszt, 2);
						echo "</strong>&nbsp;";
						echo "</pre>";
										
												
											}else{?>
													<span class='label label-important'><?SL("no_in_sticker_foiling_format",$_GET[pricing_lang]);?></span>
													<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_formaty_oklejka.php?typ=$_GET[typ]&add=1'><?SL("add_new_in_sticker_foiling_format",$_GET[pricing_lang]);?></a>
											<?}
										}else{
											echo "<span class='label label-warning'>";
											SL("product_without_in_sticker_foiling",$_GET[pricing_lang]);
											echo "</span>";
										}
									}
										?>
								</div>
							</div>
							 
							<div class="row-fluid">
								<div class="span6">
									<a name="Lakierowanie_oklejka"></a>
									<legend><?SL("out_sticker_lacquering",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("lacquering_type",$_GET[pricing_lang]);?>&nbsp;
									<?
										//$sql="SELECT DISTINCT lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ_oklejka FROM lakierowanie WHERE typ='$_GET[typ]' AND del='0' ORDER BY lakierowanie_typ";
										$sql="SELECT DISTINCT lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ_oklejka FROM lakierowanie WHERE typ=8 AND del='0' ORDER BY lakierowanie_typ";
										$res=mysql_query($sql);
										?>
										<select name="lakierowanie_typ_oklejka" onChange="document.forms['wycena'].action='#Lakierowanie_oklejka';document.forms['wycena'].submit();">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
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
										$sql="SELECT id as lakierowanie_id_oklejka,lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
										//$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_oklejka]' AND ";
										$sql.="WHERE typ=8 AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_oklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($lakierowanie_id_oklejka,$lakierowanie_typ,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($lakierowanie_id_oklejka){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("out_sticker_lacquering",$_GET[pricing_lang]);
											echo "</span>&nbsp;<strong>";
											if($cena>=0){echo $lakierowanie_typ." ".$cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/item ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'><?SL("no_number_of_items",$_GET[pricing_lang]);?></span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_lakierowanie.php?typ=$_GET[lakierowanie_typ_oklejka]&add=1'><?SL("add_new_format",$_GET[pricing_lang]);?></a>
										<?}
									}else{
										echo "<span class='label label-warning'>";
										SL("product_without_out_sticker_lacquering",$_GET[pricing_lang]);
										echo "</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend><?SL("in_sticker_lacquering",$_GET[pricing_lang]);?></legend>
									<label class="inline"><?SL("lacquering_type",$_GET[pricing_lang]);?>&nbsp;
									<?
										//$sql="SELECT DISTINCT lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ_wklejka FROM lakierowanie WHERE typ='$_GET[typ]' AND del='0' ORDER BY lakierowanie_typ";
										$sql="SELECT DISTINCT lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ_wklejka FROM lakierowanie WHERE typ=8 AND del='0' ORDER BY lakierowanie_typ";
										$res=mysql_query($sql);
										?>
										<select name="lakierowanie_typ_wklejka" onChange="document.forms['wycena'].action='#Lakierowanie_oklejka';document.forms['wycena'].submit()">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
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
										$sql="SELECT id as lakierowanie_id_wklejka,lakierowanie_typ".$_GET[pricing_lang]." as lakierowanie_typ,cena,cena_szt,cena_typ,waluta FROM lakierowanie ";
										//$sql.="WHERE typ='$_GET[typ]' AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_wklejka]' AND ";										
										$sql.="WHERE typ=8 AND lakierowanie_typ".$_GET[pricing_lang]."='$_GET[lakierowanie_typ_wklejka]' AND ";
										$sql.="(szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										list($lakierowanie_id_wklejka,$lakierowanie_typ,$cena,$cena_szt,$cena_typ,$waluta)=mysql_fetch_row(mysql_query($sql));
										if($lakierowanie_id_wklejka){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("in_sticker_lacquering",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>";
											if($cena>=0){echo $lakierowanie_typ." ".$cena." ".$waluta." ";}
											if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/item ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
										}else{?>
												<span class='label label-important'><?SL("no_number_of_items",$_GET[pricing_lang]);?></span>
												<a target='_blank' class='btn btn-mini btn-primary' role='button' href='wyceny_lakierowanie.php?typ=$_GET[lakierowanie_typ_wklejka]&add=1'><?SL("add_new_format",$_GET[pricing_lang]);?></a>
										<?}
									}else{
										echo "<span class='label label-warning'>";
										SL("product_without_in_sticker_lacquering",$_GET[pricing_lang]);
										echo "</span>";
									}
									?>
								</div>
							</div> 
							<a name="wykrojnik"></a>
							
							     
							<div class="row-fluid">
								<div class="span6">
									<a name="Dodatki"></a>
									<legend><?SL("more_parts",$_GET[pricing_lang]);?></legend>
									<?
										if(!$_GET[dodatki][1]){
											$count_dodatki=1;
										}else{
											ksort($_GET[dodatki]);
											end($_GET[dodatki]);
											$count_dodatki=key($_GET[dodatki])+1;
										}
										$sql="SELECT id as id_dodatek,nazwa".$_GET[pricing_lang]." as nazwa,cena,waluta FROM dodatki WHERE del='0' AND typ=12 ORDER BY nazwa";										
										//typ='$_GET[typ]' AND 
										$res=mysql_query($sql);
									?>
										<select name="dodatki_baza" onChange="document.forms['wycena'].action='#Dodatki';document.forms['wycena'].submit()">
										<option value="">-- <?SL("select",$_GET[pricing_lang]);?> --</option>
										<?
										while($dane=mysql_fetch_array($res)){
											echo "<option value='".$dane[id_dodatek]."'>".$dane[nazwa]." - ".$dane[cena]." ".$dane[waluta]."/szt. </option>";
										}
										if($_GET[dodatki_baza]){
											$sql="SELECT nazwa".$_GET[pricing_lang]." as nazwa,cena,waluta FROM dodatki WHERE id='$_GET[dodatki_baza]' AND del='0' ORDER BY nazwa";
											list($nazwa,$cena,$waluta)=mysql_fetch_row(mysql_query($sql));
											$_GET[dodatki][$count_dodatki]=$nazwa;
											$_GET[dodatki_cena][$count_dodatki]=$cena;
											$_GET[dodatki_typ_cena][$count_dodatki]="item";
											$_GET[dodatki_waluta][$count_dodatki]=$waluta;
											$count_dodatki++;
										}
										?>
										</select>
										<label>
										<?SL("name",$_GET[pricing_lang]);?>
										<input class="span6" name="dodatki[<?=$count_dodatki?>]" type="text">&nbsp;
										</label>
										<?SL("price",$_GET[pricing_lang]);?>
									    <div class="input-append">
											<input class="span2" name="dodatki_cena[<?=$count_dodatki?>]" id="appendedInputButton" type="text">
											<select name="dodatki_waluta[<?=$count_dodatki?>]" class="span2">
													<option value="pln">pln
													<option value="eur">eur
													<option value="usd">usd
											</select>												
											<select name="dodatki_typ_cena[<?=$count_dodatki?>]" class="span2">
													<option value="szt"><?SL("per_item",$_GET[pricing_lang]);?>
													<option value="cal"><?SL("all",$_GET[pricing_lang]);?>
											</select>
											<button class="btn" type="button" onClick="document.forms['wycena'].action='#Dodatki';document.forms['wycena'].submit()"><i class="icon-plus"></i><?SL("add",$_GET[pricing_lang]);?></button>
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
										echo "<span class='label label-warning'>";
										SL("no_more_parts",$_GET[pricing_lang]);
										echo "</span>";
									}
									?>
								</div>
								<div class="span6">
									<legend><?SL("rejectamenta",$_GET[pricing_lang]);?></legend>
									<?
										$sql="SELECT id as odpady_id,odpad_typ".$_GET[pricing_lang]." as odpad_typ,procent,szt_odpadu FROM odpady ";
										$sql.="WHERE (szt_od<='".$_GET[liczba]."' AND szt_do>='".$_GET[liczba]."' OR ";
										$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										$sql.="AND del='0'";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											//echo "<label class='checkbox'>";
											echo "<input type='hidden' name='odpady[]' ";
											//if($_GET[odpady] && in_array($dane[odpady_id],$_GET[odpady])) echo " checked ";
											echo "value='".$dane[odpady_id]."'> ".$dane[odpad_typ]." ";
											if($dane[szt_odpadu]>0){
												echo $dane[szt_odpadu]." ";
												echo SL("per_item",$_GET[pricing_lang]);
											}else{
												echo $dane[procent]."%";
											}
											echo "<br/>";
											//echo "</label>";
										}
									?>
								</div>
							</div>
							<?
							}
							if($cardboard && $_GET[nazwa_klienta] && $_GET[nazwa_zlecenia] && $_GET[liczba] && !$_GET['print']){
							?>
							<div class="row-fluid">
								<div class="span12">
								<legend><?SL("next",$_GET[pricing_lang]);?> ...</legend>
								<p>
									<!--button class="btn btn-info" type="button">Zapisz aktualną wycenę</button-->
									<button class="btn btn-success" name="przelicz" type="submit" value="1" ><?SL("calculate_pricing",$_GET[pricing_lang]);?></button>
									<?if($_GET[wycena_id]){?>
										<button class="btn" name="przelicz_nowa" type="submit" value="1" ><?SL("calculate_pricing_and_save",$_GET[pricing_lang]);?></button>
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
