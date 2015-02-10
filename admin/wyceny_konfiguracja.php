<?
include('wyceny_header.php');

if($_POST[zapisz]){
	if(!$_POST[cena])$bug[cena]="<br/><span class='label label-important'>Brak kursu.</span>";
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	if($bug){
		if($_POST[zapisz]=="edit"){
			$_GET[waluta]=$_POST[waluta];
			$alert="Formularz edycji zawiera błędy";
		}
	}else{
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE ceny_stale SET ";
			$sql.="cena='$_POST[cena]',waluta='$_POST[waluta]' ";
			$sql.=" WHERE material='$_POST[material]' AND typ='$_POST[typ]' ";
			if(!mysql_query($sql)){
				$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Element zaktualizowany.";
			}
		}
	}
}
if($_POST[zapisz_cena_sugerowana]){
	if(!$_POST[cena])!$_POST[cena]=1;
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	$sql="UPDATE cena_sugerowana SET ";
	$sql.="cena='$_POST[cena]',szt_od='$_POST[szt_od]',szt_do='$_POST[szt_do]' WHERE id='$_POST[zapisz_cena_sugerowana]'";
	if(!mysql_query($sql)){
		$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
	}else{
		$alert_ok="Sugerowana cena zapisana.";
	}
}
if($_POST[add_cena_sugerowana]){
	if(!$_POST[cena])!$_POST[cena]=1;
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	$sql="INSERT INTO cena_sugerowana (cena,szt_od,szt_do,typ) VALUES ('$_POST[cena]','$_POST[szt_od]','$_POST[szt_do]','$_POST[add_cena_sugerowana]')";
	if(!mysql_query($sql)){
		$alert="Dodanie ceny nie powiodło się <br/>".mysql_error()."<br/>".$sql;
	}else{
		$alert_ok="Sugerowana cena dodana.";
	}
}
if($_GET[del_typ_cena]){
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	$sql="UPDATE cena_sugerowana SET del='1' WHERE id='$_GET[del_typ_cena]'";
	if(!mysql_query($sql)){
		$alert="Usunięcie elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
	}else{
		$alert_ok="Sugerowana cena została usunięta.";
	}
}

if($_POST[zapisz_waluta]){
	if(!$_POST[kurs])$bug[kurs]="<br/><span class='label label-important'>Brak ceny.</span>";
	$_POST[kurs]=str_replace(",",".",$_POST[kurs]);
	if($bug){
		if($_POST[zapisz]=="edit"){
			$_GET[kurs]=$_POST[kurs];
			$alert="Formularz edycji zawiera błędy";
		}
	}else{
		if($_POST[zapisz_waluta]=="edit"){
			$sql="UPDATE kursy SET ";
			$sql.="kurs='$_POST[kurs]' ";
			$sql.=" WHERE waluta='$_POST[waluta]'";
			if(!mysql_query($sql)){
				$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Element zaktualizowany.";
				$sql="SELECT kurs FROM kursy WHERE waluta='pln/usd'";
				list($eur)=mysql_fetch_row(mysql_query($sql));
				$sql="SELECT kurs FROM kursy WHERE waluta='pln/eur'";
				list($usd)=mysql_fetch_row(mysql_query($sql));
				$eu=$eur/$usd;
				$us=$usd/$eur;
				
				$sql="UPDATE kursy SET ";
				$sql.="kurs='$eu' ";
				$sql.=" WHERE waluta='eur/usd'";
				if(!mysql_query($sql)){
					$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
				}else{
					$alert_ok.="<br>Element eur/usd zaktualizowany.";
				}
				$sql="UPDATE kursy SET ";
				$sql.="kurs='$us' ";
				$sql.=" WHERE waluta='usd/eur'";
				if(!mysql_query($sql)){
					$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
				}else{
					$alert_ok.="<br>Element usd/eur zaktualizowany.";
				}
			}
		}
	}
}
if($_POST[nbp] || $_GET[nbp]==1){
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
	if($_GET[nbp]==1)exit;
}
include('wyceny_menu.php');

$sql="SELECT * FROM produkty WHERE del='0' ORDER BY nazwa";
$res=mysql_query($sql);
while($dane=mysql_fetch_array($res)){
	$_PRODUKTY[$dane[id]]=$dane[nazwa];
}

?>

        </div><!--/span-->
        <div class="span10">		
		<?if($alert){?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Wystapił błąd!</strong>&nbsp;<?=$alert?>
			</div>
		<?}?>
		<?if($alert_ok){?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Operacja powiodła się!</strong>&nbsp;<?=$alert_ok?>
			</div>
		<?}?>
		<div class="row-fluid">
            <div class="span12">
				<div class="row-fluid">
					<div class="span12">
						<fieldset>
						<div class="row-fluid">
							<div class="span12">
								<legend>Konfiguracja wycen&nbsp;&nbsp;&nbsp;</legend>
							</div>
						</div>
						</fieldset>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<form name="edycja" method="POST" action="?site=<?=$_GET[site]?>">
									<input type="hidden" name="site" value="<?=$_GET[site]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Materiał</th>
											<th>Produkt</th>
											<th>Cena</th>
											<th>Waluta</th>
										</thead>
										<?
										$sql="SELECT * FROM ceny_stale ORDER BY typ";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[material]==$dane[material] && $_GET[typ]==$dane[typ]){
												$_POST=$dane;
											?>
												<tr>
												<td>
												<?echo "<a name='f".$dane[material]."_".$dane[typ]."'></a>";?>
													<?echo $dane[material];?>
													<?echo $bug[cena];?>
												</td>
												<td><?=$_PRODUKTY[$dane[typ]];?></td>
												<td>
													<input name="cena" value="<?=$_POST[cena]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<select name="waluta" class="span5">
														<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
														<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
														<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
													</select>
												</td>
												<td>
													<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="material" value="<?=$_GET[material]?>">
													<input type="hidden" name="typ" value="<?=$_GET[typ]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr>";
												echo "<td>";
												echo $dane[material];
												echo "</td>";
												echo "<td>".$_PRODUKTY[$dane[typ]]."</td>";
												echo "<td>".$dane[cena]."</td>";
												echo "<td>".$dane[waluta]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&material=".$dane[material]."&typ=".$dane[typ]."#f".$dane[material]."_".$dane[typ]."'><i class='icon-pencil'></i>edytuj</a> ";
												//echo "<a href='?site=".$_GET[site]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć mechanizm ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
												echo "</td></tr>";
											}
										}
										?>
										</table>
									</form>
								</div>
							</div>
							</fieldset>
						</div>
					</div>
					<div class="row-fluid">
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<form name="edycja_cena" method="POST" action="?site=<?=$_GET[site]?>">
									<input type="hidden" name="site" value="<?=$_GET[site]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Produkt</th>
											<th>Współczynnik ceny sugerowanej</th>
											<th>Sztuk</th>
										</thead>
										<?
										if($_GET[typ_add]){
										?>
											<tr>
											<td>
												<?=$_PRODUKTY[$_GET[typ_add]];?>
											</td>
											<td>
												<input name="cena" value="<?=$_POST[cena]?>" type="text" class="input-medium" autocomplete="off">
											</td>
											<td>
												<input name="szt_od" value="<?=$_POST[szt_od]?>" type="text" class="input-medium" autocomplete="off">x
												<input name="szt_do" value="<?=$_POST[szt_do]?>" type="text" class="input-medium" autocomplete="off">
											</td>
											<td>
												<input type="hidden" name="add_cena_sugerowana" value="<?=$_GET[typ_add];?>">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja_cena'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?
										}
										$sql="SELECT * FROM cena_sugerowana WHERE del='0' ORDER BY typ";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[typ_edit]==$dane[id]){
												$_POST=$dane;
										?>
												<tr>
												<td>
													<?echo $_PRODUKTY[$dane[typ]];?>
												</td>
												<td>
													<input name="cena" value="<?=$_POST[cena]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input name="szt_od" value="<?=$_POST[szt_od]?>" type="text" class="input-medium" autocomplete="off">x													
													<input name="szt_do" value="<?=$_POST[szt_do]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input type="hidden" name="zapisz_cena_sugerowana" value="<?=$dane[id];?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja_cena'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr>";
												echo "<td>";												
												echo $_PRODUKTY[$dane[typ]];
												echo "</td>";
												echo "<td>".$dane[cena]."</td>";
												if($dane[szt_od]==0 && $dane[szt_do]==0){
													echo "<td>wszystkie</td>";
												}elseif($dane[szt_do]==0){
													echo "<td>Od: ".$dane[szt_od]."</td>";
												}else{
													echo "<td>Od: ".$dane[szt_od]." do: ".$dane[szt_do]."</td>";
												}
												echo "<td><a href='?site=".$_GET[site]."&typ_edit=".$dane[id]."#fid".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "&nbsp;<a href='?site=".$_GET[site]."&typ_add=".$dane[typ]."#fid".$dane[id]."'><i class='icon-plus'></i>dodaj</a> ";
												if($arr_is[$dane[typ]]){
													echo "&nbsp;<a href='?site=".$_GET[site]."&del_typ_cena=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć cenę ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a>";
												}
												echo "</td></tr>";
											}
											$arr_is[$dane[typ]]="1";
										}
										?>
										</table>
									</form>
								</div>
							</div>
							</fieldset>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<form name="edycja_waluta" method="POST" action="?site=<?=$_GET[site]?>">
									<input type="hidden" name="site" value="<?=$_GET[site]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Waluta</th>
											<th>Kurs</th>
											<th>Aktualizacja NBP</th>
										</thead>
										<?
										$sql="SELECT * FROM kursy";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[waluta]==$dane[waluta]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													<?echo $dane[waluta];?>
													<?echo $bug[kurs];?>
												</td>
												<td>
													<input name="kurs" value="<?=$_POST[kurs]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td><?=$dane[aktualizacja];?></td>
												<td>
													<input type="hidden" name="zapisz_waluta" value="edit">
													<input type="hidden" name="waluta" value="<?=$_GET[waluta]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja_waluta'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr>";
												echo "<td>";
												echo "<a name='f".$dane[waluta]."'></a>";
												echo $dane[waluta];
												echo "</td>";
												echo "<td>".$dane[kurs]."</td>";
												echo "<td>".$dane[aktualizacja]."</td>";
												echo "<td>";
												if($dane[waluta] != "eur/usd" && $dane[waluta] != "usd/eur"){
													echo "<a href='?site=".$_GET[site]."&waluta=".$dane[waluta]."#f".$dane[waluta]."'><i class='icon-pencil'></i>edytuj</a>";
												}
												//echo "<a href='?del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć mechanizm ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
												echo "</td></tr>";
											}
										}
										?>
										</table>
										<button class="btn btn-success" name="nbp" type="submit" value="1" >Aktualizuj kursy z NBP</button>
									</form>
								</div>
							</div>
							</fieldset>
						</div>
					</div>
			</div>
			</div><!--/span-->
        </div><!--/span-->
      </div><!--/row-->
	</div><!--/.fluid-container-->
<?include('wyceny_footer.php');?>