<?
include('wyceny_header.php');
if($_POST[zapisz]){
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	if(!$_POST[format_oklejka])$bug[format_oklejka]="<br/><span class='label label-important'>Brak formatu oklejki.</span>";
	if(!$_POST[folia_x])$bug[folia_x]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[folia_y])$bug[folia_y]="<br/><span class='label label-important'>Brak formatu.</span>";

	if(!$_POST[sztuk_arkusz])$bug[sztuk_arkusz]="<br/><span class='label label-important'>Brak liczby.</span>";
	//if(!$_POST[typ])$bug[typ]="<br/><span class='label label-important'>Brak typu foli.</span>";
	
	if(!is_numeric($_POST[folia_x]) ||	!is_numeric($_POST[folia_y]) ||	!is_numeric($_POST[sztuk_arkusz])){
		$bug[numer]="<br/><span class='label label-important'>Wszystkie wartości muszą być liczbami.</span>";
	}
	
	if($bug){
		if($_POST[zapisz]=="add"){
			$_GET[add]=1;
			$alert="Formularz dodawania foli zawiera błędy";
		}
		if($_POST[zapisz]=="edit"){
			$_GET[edit_id_format]=$_POST[edit_id_format];
			$alert="Formularz edycji foli zawiera błędy";
		}
	}else{
		if($_POST[zapisz]=="add"){
			$sql="INSERT INTO format_folia_oklejka ";
			$sql.="(id_format_oklejka,folia_x,folia_y,sztuk_arkusz,typ,cena,waluta) VALUES ";
			$sql.="('$_POST[format_oklejka]','$_POST[folia_x]','$_POST[folia_y]','$_POST[sztuk_arkusz]','$_POST[typ]','$_POST[cena]','$_POST[waluta]')";
			if(!mysql_query($sql)){
				$alert="Dodanie formatu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Format został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE format_folia_oklejka SET ";
			$sql.="id_format_oklejka='$_POST[format_oklejka]',folia_x='$_POST[folia_x]',folia_y='$_POST[folia_y]',
			sztuk_arkusz='$_POST[sztuk_arkusz]',typ='$_POST[typ]',cena='$_POST[cena]',waluta='$_POST[waluta]'";
			$sql.=" WHERE id_format=$_POST[edit_id_format]";
			if(!mysql_query($sql)){
				$alert="Edycja foli nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Format foli zaktualizowany.";
				$_GET[typ]=$_POST[typ];
			}
		}
	}
}

if($_GET[del_id_format]){
	$sql="UPDATE format_folia_oklejka SET del='1' WHERE id_format=$_GET[del_id_format]";
	if(!mysql_query($sql)){
		$alert="Usunięcie foli nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Format foli został usunięty z bazy.";
	}
}
?>
<?include('wyceny_menu.php')?>
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
						<form name="wycena">
						<input type="hidden" name="site" value="<?=$_GET[site]?>">
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<legend>Formaty foli oklejka&nbsp;&nbsp;&nbsp;
									<?select_typ_folie();?>
									<?select_typ();?>
									<span class='label label-important'>Dodawanie foli oklejki odbywa się przez dodanie formatu oklejki.</span>
									<!--a class="btn btn-mini btn-primary" role="button" href="?typ=<?=$_GET[typ]?>&add=1">Dodaj nową folię</a-->
									</legend>
								</div>
							</div>
							</fieldset>
						</form>						
						</div>
						<div class="row-fluid">
						<div class="span12">
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<?
										$sql="SELECT id_format,format_x_od,format_x_do,format_y_od,format_y_do,
										papier_x,papier_y,grubosc_od,grubosc_do FROM format_oklejka WHERE del='0'";
										$res=mysql_query($sql);									
										while($row=mysql_fetch_array($res)){
											$text=$row[format_x_od]."...".$row[format_x_do]." x ";
											if($row[format_y_od]==$row[format_y_do]){
												$text.=$row[format_y_od];
											}else{
												$text.=$row[format_y_od]."...".$row[format_y_do];
											}
											if($row[papier_x]==$row[papier_y]){
												$text.=", papier:".$row[papier_x];
											}else{
												$text.=", papier:".$row[papier_x]." x ".$row[papier_y];
											}
											if($row[grubosc_od]==$row[grubosc_do]){
												$text.=", grubość:".$row[grubosc_od];
											}else{
												$text.=", grubość:".$row[grubosc_od]." - ".$row[grubosc_do];
											}
											$lists_oklejka_format[$row[id_format]]=$text;
											
										}
										if($_GET[edit_id_format] || $_GET[add]){											
											$lists=array("folia_x"=>"","folia_y"=>"","sztuk_arkusz"=>"","typ"=>"","typ_folie"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM format_folia_oklejka WHERE del='0'";
												$res=mysql_query($sql);									
												while($row=mysql_fetch_array($res)){
													if($lists[$key])$lists[$key].=",";
													$lists[$key].="&quot;".$row[dana]."&quot;";
												}
											}
										}
									?>
									<form name="edycja" method="POST" action="?typ=<?=$_GET[typ]?>">
									<input type="hidden" name="typ" value="<?=$_GET[typ];?>">
									<input type="hidden" name="typ_folie" value="<?=$_GET[typ_folie];?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Format</th>
											<th>Format foli</th>
											<th>Liczba użytków</th>
											<th>Cena m2</th>											
											<!--th>Edycja</th-->
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td>
												Format oklejki: &nbsp;<select name="format_oklejka">
												<?
												foreach($lists_oklejka_format as $key => $val){
													echo "<option ";
													if($key==$_POST[format_oklejka])echo " selected ";
													echo " value='".$key."'>".$val."</option>";
												}
												?>
												</select>
												<?echo $bug[format_oklejka];?>
												<?echo $bug[numer];?>
											</td>
											<td>
												<input name="folia_x" value="<?=$_POST[folia_x]?>" data-source="[<?=$lists[folia_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
												<input name="folia_y" value="<?=$_POST[folia_y]?>" data-source="[<?=$lists[folia_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">												
												<?echo $bug[folia_x];?>
											</td>
											<td>
												<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[sztuk_arkusz];?>
											</td>
											<td>
												<input name="cena" value="<?=$_POST[cena]?>" data-source="[<?=$lists[cena]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<select name="waluta" class="span5">
													<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
													<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
													<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
												</select>
												<?echo $bug[cena];?>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										
										$sql="SELECT * FROM format_folia_oklejka WHERE typ='$_GET[typ]' AND typ_folie='$_GET[typ_folie]' AND del='0' ORDER BY id_format_oklejka";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id_format]==$dane[id_format]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													Format oklejki: <br/>
													<?echo $lists_oklejka_format[$_POST[id_format_oklejka]];?>
												</td>
												<td>
													<input name="folia_x" value="<?=$_POST[folia_x]?>" data-source="[<?=$lists[folia_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
													<input name="folia_y" value="<?=$_POST[folia_y]?>" data-source="[<?=$lists[folia_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[folia_x];?>
												</td>
												<td>
													<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[sztuk_arkusz];?>
												</td>
												<td>
													<input name="cena" value="<?=$_POST[cena]?>" data-source="[<?=$lists[cena]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<select name="waluta" class="span5">
														<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
														<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
														<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
													</select>
													<?echo $bug[cena];?>
												</td>
												<td>
													<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="edit_id_format" value="<?=$_GET[edit_id_format]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr><td>";
												echo "<a name='f".$dane[id_format]."'></a>";
												echo "Format oklejka: ".$lists_oklejka_format[$dane[id_format_oklejka]];
												//echo "<br/>Tektura: ".$dane[format_papieru];
												//echo "<br/>Oklejka: ".$dane[format_oklejka];
												echo "</td><td>".$dane[folia_x]." x ".$dane[folia_y]."</td>";
												echo "<td>".$dane[sztuk_arkusz]."</td>";
												echo "<td>".$dane[cena]." ".$dane[waluta]."</td>";
												//echo "<td>";
												//<a href='?typ=".$_GET[typ]."&edit_id_format=".$dane[id_format]."#f".$dane[id_format]."'><i class='icon-pencil'></i>edytuj</a> ";
												//echo "<a href='?typ=".$_GET[typ]."&del_id_format=".$dane[id_format]."' onClick=\"if(confirm('Chcesz usunąć format ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a>";
												//echo "</td>";
												echo "</tr>";
											}
										}
										?>
											<!--tr>
											<td colspan=6>
												Skopiuj wszystkie do typu foli:&nbsp;
												<input name="typ_n" value="<?=$_GET[typ]?>" data-source="[<?=$lists[typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Przenieś</button>
											</td>
											</tr-->
										</table>
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