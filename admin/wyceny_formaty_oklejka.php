<?
include('wyceny_header.php');

if($_POST[zapisz]){
	if(!$_POST[format_x_od] || !$_POST[format_y_od])$bug[format_x_od]="<br/><span class='label label-important'>Brak fromatu.</span>";
	if(!$_POST[papier_x])$bug[tektura_x]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[papier_y])$bug[tektura_y]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[grubosc_od])$bug[grubosc_od]="<br/><span class='label label-important'>Brak grubości.</span>";
	if(!$_POST[sztuk_arkusz])$bug[sztuk_arkusz]="<br/><span class='label label-important'>Brak liczby.</span>";
	
	if(!$_POST[format_x_do] && $_POST[format_x_od])$_POST[format_x_do]=$_POST[format_x_od];
	if(!$_POST[format_y_do] && $_POST[format_y_od])$_POST[format_y_do]=$_POST[format_y_od];
	if(!$_POST[grubosc_do] && $_POST[grubosc_od])$_POST[grubosc_do]=$_POST[grubosc_od];

	if(!is_numeric($_POST[format_x_od]) || !is_numeric($_POST[format_x_do]) ||	!is_numeric($_POST[format_y_od]) ||	!is_numeric($_POST[format_y_do]) ||	!is_numeric($_POST[papier_x]) || !is_numeric($_POST[papier_y]) || !is_numeric($_POST[grubosc_od]) ||	!is_numeric($_POST[grubosc_do]) ||	!is_numeric($_POST[sztuk_arkusz])){
		$bug[numer]="<br/><span class='label label-important'>Wszystkie wartości muszą być liczbami.</span>";
	}
	
	if($_POST[format_x_do] < $_POST[format_x_od])$bug[format_x_od_do]="<br/><span class='label label-important'>Złe wartości graniczne.</span>";
	if($_POST[format_y_do] < $_POST[format_y_od])$bug[format_x_od_do]="<br/><span class='label label-important'>Złe wartości graniczne.</span>";
	
	if($bug){
		if($_POST[zapisz]=="add"){
			$_GET[add]=1;
			$alert="Formularz dodawania zawiera błędy";
		}
		if($_POST[zapisz]=="edit"){
			$_GET[edit_id_format]=$_POST[edit_id_format];
			$alert="Formularz edycji zawiera błędy";
		}
	}else{
		if($_POST[zapisz]=="add"){
			$sql="INSERT INTO format_oklejka ";
			$sql.="(format_x_od,format_x_do,format_y_od,format_y_do,papier_x,papier_y,grubosc_od,grubosc_do,sztuk_arkusz,typ,prio) VALUES ";
			$sql.="('$_POST[format_x_od]','$_POST[format_x_do]','$_POST[format_y_od]','$_POST[format_y_do]','$_POST[papier_x]','$_POST[papier_y]','$_POST[grubosc_od]','$_POST[grubosc_do]','$_POST[sztuk_arkusz]','$_POST[typ]','1000".$_POST[prio]."')";
			if(!mysql_query($sql)){
				$alert="Dodanie formatu oklejki nie powiodło się <br/>".mysql_error();
			}else{
				$sql_prio="UPDATE format_oklejka SET prio=prio+1 WHERE typ=".$_GET[typ]." AND prio>=".$_POST[prio]." AND prio<1000".$_POST[prio]."" ;
				mysql_query($sql_prio);
				$sql_prio="UPDATE format_oklejka SET prio=$_POST[prio] WHERE typ=".$_GET[typ]." AND prio=1000".$_POST[prio];
				mysql_query($sql_prio);

				$alert_ok="Format oklejki został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
			$sql="SELECT MAX(id_format) FROM format_oklejka";
			list($id_format_oklejka_last)=mysql_fetch_row(mysql_query($sql));

			$folia_x_new=$_POST[papier_x]-10;
			$folia_y_new=$_POST[papier_y]-10;
			$sztuk_arkusz_new=$_POST[sztuk_arkusz];

			$sql="SELECT id,cena,waluta FROM folie WHERE del='0'";
			$res=mysql_query($sql);
			while($dane=mysql_fetch_array($res)){
				$sql_ins_folia="INSERT INTO format_folia_oklejka (id_format_oklejka,folia_x,folia_y,sztuk_arkusz,typ,typ_folie,cena,waluta) VALUE ('$id_format_oklejka_last','$folia_x_new','$folia_y_new','$sztuk_arkusz_new','$_POST[typ]','$dane[id]','$dane[cena]','$dane[waluta]') ";
				if(!mysql_query($sql_ins_folia)){
					$alert.="<br>Dodanie foli oklejki nie powiodło się <br/>".mysql_error();
				}else{
					$alert_ok.="<br>Folia oklejki została dodana do bazy.";
				}				
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE format_oklejka SET ";
			$sql.="format_x_od='$_POST[format_x_od]',format_x_do='$_POST[format_x_do]',format_y_od='$_POST[format_y_od]',format_y_do='$_POST[format_y_do]',papier_x='$_POST[papier_x]',papier_y='$_POST[papier_y]',grubosc_od='$_POST[grubosc_od]',grubosc_do='$_POST[grubosc_do]',sztuk_arkusz='$_POST[sztuk_arkusz]',typ='$_POST[typ]'";
			$sql.=" WHERE id_format=$_POST[edit_id_format]";
			if(!mysql_query($sql)){
				$alert="Edycja formatu oklejki nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Format oklejki zaktualizowany.";
				$_GET[typ]=$_POST[typ];
				
				$folia_x_new=$_POST[papier_x]-10;
				$folia_y_new=$_POST[papier_y]-10;
				$sztuk_arkusz_new=$_POST[sztuk_arkusz];

				$sql="SELECT id,cena FROM folie WHERE del='0'";
				$res=mysql_query($sql);
				while($dane=mysql_fetch_array($res)){
					$sql_ins_folia="UPDATE format_folia_oklejka SET folia_x='$folia_x_new',folia_y='$folia_y_new',sztuk_arkusz='$sztuk_arkusz_new' WHERE id_format_oklejka='$_POST[edit_id_format]' AND del='0'";
					if(!mysql_query($sql_ins_folia)){
						$alert.="<br>Aktualizacja folii oklejki nie powiodło się <br/>".mysql_error();
					}else{
						$alert_ok.="<br>Folia oklejki został zaktualizowana.";
					}				
				}				
			}
		}
	}
}

if($_GET[prio_up]){
	$prio_tmp=$_GET[count_kateg]+1;
	$new_prio=$_GET[prio_up]-1;
	$sql="UPDATE format_oklejka SET prio='$prio_tmp' WHERE typ=".$_GET[typ]." AND prio=".$_GET[prio_up]."";
	mysql_query($sql);
	$sql="UPDATE format_oklejka SET prio='".$_GET[prio_up]."' WHERE typ=".$_GET[typ]." AND prio=$new_prio";
	mysql_query($sql);
	$sql="UPDATE format_oklejka SET prio='$new_prio' WHERE typ=".$_GET[typ]." AND prio=".$prio_tmp."";
	mysql_query($sql);
}
if($_GET[prio_down]){
	$prio_tmp=$_GET[count_kateg]+1;
	$new_prio=$_GET[prio_down]+1;
	$sql="UPDATE format_oklejka SET prio='$prio_tmp' WHERE typ=".$_GET[typ]." AND prio=".$_GET[prio_down]."";
	mysql_query($sql);
	$sql="UPDATE format_oklejka SET prio='".$_GET[prio_down]."' WHERE typ=".$_GET[typ]." AND prio=$new_prio";
	mysql_query($sql);
	$sql="UPDATE format_oklejka SET prio='$new_prio' WHERE typ=".$_GET[typ]." AND prio=".$prio_tmp."";
	mysql_query($sql);
}

if($_GET[del_id_format]){
	//$sql="UPDATE format_oklejka SET del='1' WHERE id_format=$_GET[del_id_format]";
	$sql="DELETE FROM format_oklejka WHERE id_format=$_GET[del_id_format]";
	if(!mysql_query($sql)){
		$alert="Usunięcie oklejki nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Format został usunięty z bazy.";
		$sql = "UPDATE format_oklejka SET prio=prio-1 WHERE typ=".$_GET[typ]." AND prio > ".$_GET[del_prio];
		if(!mysql_query($sql)){
			$alert="Aktualizacja priorytetów NIE OK.";
		}else{
			$alert_ok="Aktualizacja priorytetów OK.";
		}
	}
	$sql="UPDATE format_folia_oklejka SET del='1' WHERE id_format_oklejka=$_GET[del_id_format]";
	if(!mysql_query($sql)){
		$alert.="<br/>Usunięcie folii oklejki nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok.="<br/>Folia oklejki została usunięta z bazy.";
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
									<legend>Format oklejek&nbsp;&nbsp;&nbsp;
									<?select_typ();?>
									<a class="btn btn-mini btn-primary" role="button" href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>&add=1">Dodaj nową oklejkę</a>
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
									<form name="edycja" method="POST" action="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>">
									<input type="hidden" name="typ" value="<?=$_GET[typ];?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Prio</th>
											<th>Format produktu</th>
											<th>Format oklejki</th>
											<th>Grubość</th>
											<th>Liczba użytków</th>
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[edit_id_format] || $_GET[add]){
											$lists=array("format_x_od"=>"","format_x_do"=>"","format_y_od"=>"","format_y_do"=>"","papier_x"=>"","papier_y"=>"","grubosc_od"=>"","grubosc_do"=>"","sztuk_arkusz"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM format_oklejka WHERE del='0'";
												$res=mysql_query($sql);									
												while($row=mysql_fetch_array($res)){
													if($lists[$key])$lists[$key].=",";
													$lists[$key].="&quot;".$row[dana]."&quot;";
												}
											}
										}
										$sql="SELECT * FROM format_oklejka WHERE typ='$_GET[typ]' AND del='0' ORDER BY prio";
										$res=mysql_query($sql);
										$count=mysql_num_rows($res);
										
										if($_GET[add]){?>
											<tr>
											<td>
											<select name="prio" class="span14">
											<?
											for($p=1;$p<=$count+1;$p++){
												echo "<option ";
												if($p==$_POST[prio]){
													echo " selected ";
												}
												echo "value=".$p.">".$p;
											}
											?>
											</select>
											</td>
											<td>
												<input name="format_x_od" value="<?=$_POST[format_x_od]?>" data-source="[<?=$lists[format_x_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												...
												<input name="format_x_do" value="<?=$_POST[format_x_do]?>" data-source="[<?=$lists[format_x_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
												<input name="format_y_od" value="<?=$_POST[format_y_od]?>" data-source="[<?=$lists[format_y_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">...
												<input name="format_y_do" value="<?=$_POST[format_y_do]?>" data-source="[<?=$lists[format_y_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[format_x_od];?>
												<?echo $bug[format_y_od];?>
												<?echo $bug[format_x_od_do];?>
												<?echo $bug[numer];?>
											</td>
											<td>
												<input name="papier_x" value="<?=$_POST[papier_x]?>" data-source="[<?=$lists[tektura_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
												<input name="papier_y" value="<?=$_POST[papier_y]?>" data-source="[<?=$lists[tektura_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[tektura_x];?>
											</td>
											<td>
												<input name="grubosc_od" value="<?=$_POST[grubosc_od]?>" data-source="[<?=$lists[grubosc_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">...
												<input name="grubosc_do" value="<?=$_POST[grubosc_do]?>" data-source="[<?=$lists[grubosc_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[grubosc_od];?>												
											</td>
											<td>
												<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[sztuk_arkusz];?>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id_format]==$dane[id_format]){
												$_POST=$dane;
											?>
												<tr>
												<td></td>
												<td>
													<input name="format_x_od" value="<?=$_POST[format_x_od]?>" data-source="[<?=$lists[format_x_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													...
													<input name="format_x_do" value="<?=$_POST[format_x_do]?>" data-source="[<?=$lists[format_x_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
													<input name="format_y_od" value="<?=$_POST[format_y_od]?>" data-source="[<?=$lists[format_y_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">...
													<input name="format_y_do" value="<?=$_POST[format_y_do]?>" data-source="[<?=$lists[format_y_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[format_x_od];?>
													<?echo $bug[format_y_od];?>
													<?echo $bug[format_x_od_do];?>
													<?echo $bug[numer];?>
												</td>
												<td>
													<input name="papier_x" value="<?=$_POST[papier_x]?>" data-source="[<?=$lists[papier_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
													<input name="papier_y" value="<?=$_POST[papier_y]?>" data-source="[<?=$lists[papier_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[tektura_x];?>
												</td>
												<td>
													<input name="grubosc_od" value="<?=$_POST[grubosc_od]?>" data-source="[<?=$lists[grubosc_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">...
													<input name="grubosc_do" value="<?=$_POST[grubosc_do]?>" data-source="[<?=$lists[grubosc_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[grubosc_od];?>												
												</td>
												<td>
													<input name="sztuk_arkusz" value="<?=$_POST[sztuk_arkusz]?>" data-source="[<?=$lists[sztuk_arkusz]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[sztuk_arkusz];?>
												</td>
												<td>
													<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="edit_id_format" value="<?=$_GET[edit_id_format]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr><td>".$dane[prio];
												if($dane[prio]>1){
													echo '<a href="?site=wyceny_formaty_oklejka&typ='.$_GET[typ].'&prio_up='.$dane[prio].'&count_kateg='.$count.'"><i class="icon-hand-up"></i></a>';
												}
												echo'&nbsp;';	
												if($dane[prio]<$count){
													echo '<a href="?site=wyceny_formaty_oklejka&typ='.$_GET[typ].'&prio_down='.$dane[prio].'&count_kateg='.$count.'"><i class="icon-hand-down"></i></a>';
												}
												echo "</td><td>";
												echo "<a name='f".$dane[id_format]."'></a>";
												if($dane[format_x_od] != $dane[format_x_do]){
													echo $dane[format_x_od]." ... ".$dane[format_x_do];
												}else{
													echo $dane[format_x_od];
												}
												echo "&nbsp;x&nbsp;";
												if($dane[format_y_od] != $dane[format_y_do]){
													echo $dane[format_y_od]." ... ".$dane[format_y_do];
												}else{
													echo $dane[format_y_od];
												}
												echo "</td><td>".$dane[papier_x]." x ".$dane[papier_y]."</td>";
												if($dane[grubosc_od] != $dane[grubosc_do]){
													echo "<td>".$dane[grubosc_od]." ... ".$dane[grubosc_do]."</td>";
												}else{
													echo "<td>".$dane[grubosc_od]."</td>";
												}
												echo "<td>".$dane[sztuk_arkusz]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&typ=".$_GET[typ]."&edit_id_format=".$dane[id_format]."#f".$dane[id_format]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&typ=".$_GET[typ]."&del_id_format=".$dane[id_format]."&del_prio=".$dane[prio]."' onClick=\"if(confirm('Chcesz usunąć format ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a></td>";
												echo "</tr>";
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
			</div>
			</div><!--/span-->
        </div><!--/span-->
      </div><!--/row-->
	</div><!--/.fluid-container-->
<?include('wyceny_footer.php');?>