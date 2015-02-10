<?
$typ_folia="wklejka";
if($_POST[zapisz]){
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	if(!$_POST[format_papieru])$bug[format_papieru]="<br/><span class='label label-important'>Brak formatu piaperu.</span>";
	if(!$_POST['format_'.$typ_folia])$bug['format_'.$typ_folia]="<br/><span class='label label-important'>Brak formatu $typ_folia.</span>";
	if(!$_POST[folia_x])$bug[folia_x]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[folia_y])$bug[folia_y]="<br/><span class='label label-important'>Brak formatu.</span>";

	if(!$_POST[sztuk_arkusz])$bug[sztuk_arkusz]="<br/><span class='label label-important'>Brak liczby.</span>";
	if(!$_POST[typ])$bug[typ]="<br/><span class='label label-important'>Brak typu foli.</span>";
	
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
			$sql="INSERT INTO format_folia_".$typ_folia;
			$sql.=" (format_papieru,format_".$typ_folia.",folia_x,folia_y,sztuk_arkusz,typ,cena,waluta) VALUES ";
			$sql.="('$_POST[format_papieru]','$_POST[format_$typ_folia]','$_POST[folia_x]','$_POST[folia_y]','$_POST[sztuk_arkusz]','$_POST[typ]','$_POST[cena]','$_POST[waluta]')";
			if(!mysql_query($sql)){
				$alert="Dodanie formatu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Format został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE format_folia_$typ_folia SET ";
			$sql.="format_papieru='$_POST[format_papieru]',format_$typ_folia='$_POST[format_$typ_folia]',folia_x='$_POST[folia_x]',folia_y='$_POST[folia_y]',
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
	$sql="UPDATE format_folia_$typ_folia SET del='1' WHERE id_format=$_GET[del_id_format]";
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
							<fieldset>
							<div class="row-fluid">
								<div class="span12">
									<legend>Formaty foli <?=$typ_folia?>&nbsp;&nbsp;&nbsp;
									<select name="typ" onChange="document.forms['wycena'].submit()">
									<?
									$sql="SELECT DISTINCT typ FROM format_folia_$typ_folia WHERE del='0' ORDER BY typ";
									$res=mysql_query($sql);
									while($dane=mysql_fetch_array($res)){
										if(!$_GET[typ])$_GET[typ]=$dane[typ];
										echo "<option ";
										if($_GET[typ]==$dane[typ]){echo " selected ";}
										echo " value='".$dane[typ]."'>".$dane[typ]."</option>";
									}
									?>
									</select>
									<a class="btn btn-mini btn-primary" role="button" href="?typ=<?=$_GET[typ]?>&add=1">Dodaj nową folię</a>
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
										if($_GET[edit_id_format] || $_GET[add]){
											$sql="SELECT DISTINCT tektura_x,tektura_y FROM format_tektura WHERE del='0'";
											$res=mysql_query($sql);									
											while($row=mysql_fetch_array($res)){
												$lists_paper[$row[tektura_x]."x".$row[tektura_y]]=1;
											}
											$sql="SELECT DISTINCT papier_x,papier_y FROM format_$typ_folia WHERE del='0'";
											$res=mysql_query($sql);									
											while($row=mysql_fetch_array($res)){
												$lists_klejka[$row[papier_x]."x".$row[papier_y]]=1;
											}	
											$lists=array("folia_x"=>"","folia_y"=>"","sztuk_arkusz"=>"","typ"=>"");
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
										<table class="table table-striped">
										<thead align="center">
											<th>Format</th>
											<th>Format foli</th>
											<th>Liczba użytków</th>
											<th>Cena m2</th>											
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td>
												Typ foli:&nbsp;<input name="typ" value="<?=$_GET[typ]?>" data-source="[<?=$lists[typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[typ];?>
												<br/>
												Format tektury: <select name="format_papieru">
												<?
												foreach($lists_paper as $key => $val){
													echo "<option ";
													if($key==$_POST[format_papieru])echo " selected ";
													echo " value='".$key."'>".$key."</option>";
												}
												?>
												</select>
												<?echo $bug[format_papieru];?>
												<br/>Format <?=$typ_folia?>: &nbsp;<select name="format_$typ_folia">
												<?
												foreach($lists_klejka as $key => $val){
													echo "<option ";
													if($key==$_POST[format_$typ_folia])echo " selected ";
													echo " value='".$key."'>".$key."</option>";
												}
												?>
												</select>
												<?echo $bug[format_$typ_folia];?>
												<?echo $bug[numer];?>
											</td>
											<td>
												<br/><br/>
												<input name="folia_x" value="<?=$_POST[folia_x]?>" data-source="[<?=$lists[folia_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
												<input name="folia_y" value="<?=$_POST[folia_y]?>" data-source="[<?=$lists[folia_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">												
												<?echo $bug[folia_x];?>
											</td>
											<td>
												<br/><br/>
												<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[sztuk_arkusz];?>
											</td>
											<td>
												<br/><br/>
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
										
										$sql="SELECT * FROM format_folia_$typ_folia WHERE typ='$_GET[typ]' AND del='0' ORDER BY format_papieru";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id_format]==$dane[id_format]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													Typ foli:&nbsp;<input name="typ" value="<?=$_POST[typ]?>" data-source="[<?=$lists[typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[typ];?>
													<br/>
													Format tektury: <select name="format_papieru">
													<?
													foreach($lists_paper as $key => $val){
														echo "<option ";
														if($key==$_POST[format_papieru])echo " selected ";
														echo " value='".$key."'>".$key."</option>";
													}
													?>
													</select>
													<?echo $bug[format_papieru];?>
													<br/>Format oklejki: &nbsp;<select name="format_<?=$typ_folia;?>">
													<?
													foreach($lists_klejka as $key => $val){
														echo "<option ";
														if($key==$_POST[format_$typ_folia])echo " selected ";
														echo " value='".$key."'>".$key."</option>";
													}
													?>
													</select>
													<?echo $bug[format_$typ_folia];?>
													<?echo $bug[numer];?>
												</td>
												<td>
													<br/><br/>
													<input name="folia_x" value="<?=$_POST[folia_x]?>" data-source="[<?=$lists[folia_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
													<input name="folia_y" value="<?=$_POST[folia_y]?>" data-source="[<?=$lists[folia_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[folia_x];?>
												</td>
												<td>
													<br/><br/>
													<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[sztuk_arkusz];?>
												</td>
												<td>
													<br/><br/>
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
												echo "Tektura: ".$dane[format_papieru];
												echo "<br/>Oklejka: ".$dane[format_$typ_folia];
												echo "</td><td>".$dane[folia_x]." x ".$dane[folia_y]."</td>";
												echo "<td>".$dane[sztuk_arkusz]."</td>";
												echo "<td>".$dane[cena]." ".$dane[waluta]."</td>";
												echo "<td><a href='?typ=".$_GET[typ]."&edit_id_format=".$dane[id_format]."#f".$dane[id_format]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?typ=".$_GET[typ]."&del_id_format=".$dane[id_format]."' onClick=\"if(confirm('Chcesz usunąć format ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a></td>";
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