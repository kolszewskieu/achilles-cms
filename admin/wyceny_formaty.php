<?
include('wyceny_header.php');
if($_POST[zapisz]){
	if(!$_POST[format_x_od] || !$_POST[format_y_od])$bug[format_x_od]="<br/><span class='label label-important'>Brak fromatu.</span>";
	if(!$_POST[tektura_x])$bug[tektura_x]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[tektura_y])$bug[tektura_y]="<br/><span class='label label-important'>Brak formatu.</span>";
	if(!$_POST[grubosc_od])$bug[grubosc_od]="<br/><span class='label label-important'>Brak grubości.</span>";
	if(!$_POST[sztuk_arkusz])$bug[sztuk_arkusz]="<br/><span class='label label-important'>Brak liczby.</span>";
	if(!$_POST[typ])$bug[typ]="<br/><span class='label label-important'>Brak typu produktu.</span>";
	
	if(!$_POST[format_x_do] && $_POST[format_x_od])$_POST[format_x_do]=$_POST[format_x_od];
	if(!$_POST[format_y_do] && $_POST[format_y_od])$_POST[format_y_do]=$_POST[format_y_od];
	if(!$_POST[grubosc_do] && $_POST[grubosc_od])$_POST[grubosc_do]=$_POST[grubosc_od];

	if(!is_numeric($_POST[format_x_od]) || !is_numeric($_POST[format_x_do]) ||	!is_numeric($_POST[format_y_od]) ||	!is_numeric($_POST[format_y_do]) ||	!is_numeric($_POST[tektura_x]) ||	!is_numeric($_POST[tektura_y]) ||	!is_numeric($_POST[grubosc_od]) ||	!is_numeric($_POST[grubosc_do]) ||	!is_numeric($_POST[sztuk_arkusz])){
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
			$sql="INSERT INTO format_tektura ";
			$sql.="(format_x_od,format_x_do,format_y_od,format_y_do,tektura_x,tektura_y,grubosc_od,grubosc_do,sztuk_arkusz,typ,prio) VALUES ";
			$sql.="('$_POST[format_x_od]','$_POST[format_x_do]','$_POST[format_y_od]','$_POST[format_y_do]','$_POST[tektura_x]','$_POST[tektura_y]','$_POST[grubosc_od]','$_POST[grubosc_do]','$_POST[sztuk_arkusz]','$_POST[typ]','1000".$_POST[prio]."')";
			if(!mysql_query($sql)){
				$alert="Dodanie formatu nie powiodło się <br/>".mysql_error();
			}else{
				$sql_prio="UPDATE format_tektura SET prio=prio+1 WHERE typ=".$_GET[typ]." AND prio>=".$_POST[prio]." AND prio<1000".$_POST[prio]."" ;
				mysql_query($sql_prio);
				$sql_prio="UPDATE format_tektura SET prio=$_POST[prio] WHERE typ=".$_GET[typ]." AND prio=1000".$_POST[prio];
				mysql_query($sql_prio);
				$alert_ok="Format został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE format_tektura SET ";
			$sql.="format_x_od='$_POST[format_x_od]',format_x_do='$_POST[format_x_do]',format_y_od='$_POST[format_y_od]',format_y_do='$_POST[format_y_do]',tektura_x='$_POST[tektura_x]',tektura_y='$_POST[tektura_y]',grubosc_od='$_POST[grubosc_od]',grubosc_do='$_POST[grubosc_do]',sztuk_arkusz='$_POST[sztuk_arkusz]',typ='$_POST[typ]'";
			$sql.=" WHERE id_format=$_POST[edit_id_format]";
			if(!mysql_query($sql)){
				$alert="Edycja formatu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Format zaktualizowany.";
				$_GET[typ]=$_POST[typ];
			}
		}
	}
}

if($_GET[prio_up]){
	$prio_tmp=$_GET[count_kateg]+1;
	$new_prio=$_GET[prio_up]-1;
	$sql="UPDATE format_tektura SET prio='$prio_tmp' WHERE typ=".$_GET[typ]." AND prio=".$_GET[prio_up]."";
	mysql_query($sql);
	$sql="UPDATE format_tektura SET prio='".$_GET[prio_up]."' WHERE typ=".$_GET[typ]." AND prio=$new_prio";
	mysql_query($sql);
	$sql="UPDATE format_tektura SET prio='$new_prio' WHERE typ=".$_GET[typ]." AND prio=".$prio_tmp."";
	mysql_query($sql);
}
if($_GET[prio_down]){
	$prio_tmp=$_GET[count_kateg]+1;
	$new_prio=$_GET[prio_down]+1;
	$sql="UPDATE format_tektura SET prio='$prio_tmp' WHERE typ=".$_GET[typ]." AND prio=".$_GET[prio_down]."";
	mysql_query($sql);
	$sql="UPDATE format_tektura SET prio='".$_GET[prio_down]."' WHERE typ=".$_GET[typ]." AND prio=$new_prio";
	mysql_query($sql);
	$sql="UPDATE format_tektura SET prio='$new_prio' WHERE typ=".$_GET[typ]." AND prio=".$prio_tmp."";
	mysql_query($sql);
}

if($_GET[del_id_format]){
	//$sql="UPDATE format_tektura SET del='1' WHERE id_format=$_GET[del_id_format]";
	$sql="DELETE FROM format_tektura WHERE id_format=$_GET[del_id_format]";
	if(!mysql_query($sql)){
		$alert="Format NIE został usunięty z bazy <br/>".mysql_error();
	}else{
		$alert_ok="Format został usunięty z bazy.";
		$sql = "UPDATE format_tektura SET prio=prio-1 WHERE typ=".$_GET[typ]." AND prio > ".$_GET[del_prio];
		if(!mysql_query($sql)){
			$alert="Aktualizacja priorytetów NIE OK.";
		}else{
			$alert_ok="Aktualizacja priorytetów OK.";
		}
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
									<legend>Format tektury&nbsp;&nbsp;&nbsp;
									<?select_typ();?>
									<a class="btn btn-mini btn-primary" role="button" href="?site=wyceny_formaty&typ=<?=$_GET[typ]?>&add=1">Dodaj nowy format</a>
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
									<form name="edycja" method="POST" action="?site=wyceny_formaty&typ=<?=$_GET[typ]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Prio</th>
											<th>Format tekury</th>
											<th>Format arkusz tekury</th>
											<th>Grubość</th>
											<th>Liczba użytków</th>
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[edit_id_format] || $_GET[add]){
											$lists=array("format_x_od"=>"","format_x_do"=>"","format_y_od"=>"","format_y_do"=>"","tektura_x"=>"","tektura_y"=>"","grubosc_od"=>"","grubosc_do"=>"","sztuk_arkusz"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM format_tektura WHERE del='0'";
												$res=mysql_query($sql);									
												while($row=mysql_fetch_array($res)){
													if($lists[$key])$lists[$key].=",";
													$lists[$key].="&quot;".$row[dana]."&quot;";
												}
											}
										}
										
										$sql="SELECT * FROM format_tektura WHERE typ='$_GET[typ]' AND del='0' ORDER BY prio";
										//grubosc_od,format_x_od,format_x_do,format_y_od";
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
												<input name="typ" value="<?=$_GET[typ]?>" type="hidden">												
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
												<input name="tektura_x" value="<?=$_POST[tektura_x]?>" data-source="[<?=$lists[tektura_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
												<input name="tektura_y" value="<?=$_POST[tektura_y]?>" data-source="[<?=$lists[tektura_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
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
												<a href="?site=wyceny_formaty&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
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
													<input name="typ" value="<?=$_GET[typ]?>" type="hidden">												
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
													<input name="tektura_x" value="<?=$_POST[tektura_x]?>" data-source="[<?=$lists[tektura_x]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;x
													<input name="tektura_y" value="<?=$_POST[tektura_y]?>" data-source="[<?=$lists[tektura_y]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
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
													<a href="?site=wyceny_formaty&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr><td>".$dane[prio];
												if($dane[prio]>1){
													echo '<a href="?site=wyceny_formaty&typ='.$_GET[typ].'&prio_up='.$dane[prio].'&count_kateg='.$count.'"><i class="icon-hand-up"></i></a>';
												}
												echo'&nbsp;';	
												if($dane[prio]<$count){
													echo '<a href="?site=wyceny_formaty&typ='.$_GET[typ].'&prio_down='.$dane[prio].'&count_kateg='.$count.'"><i class="icon-hand-down"></i></a>';
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
												echo "</td><td>".$dane[tektura_x]." x ".$dane[tektura_y]."</td>";
												if($dane[grubosc_od] != $dane[grubosc_do]){
													echo "<td>".$dane[grubosc_od]." ... ".$dane[grubosc_do]."</td>";
												}else{
													echo "<td>".$dane[grubosc_od]."</td>";
												}
												echo "<td>".$dane[sztuk_arkusz]."</td>";
												echo "<td><a href='?site=wyceny_formaty&typ=".$_GET[typ]."&edit_id_format=".$dane[id_format]."#f".$dane[id_format]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=wyceny_formaty&typ=".$_GET[typ]."&del_id_format=".$dane[id_format]."&del_prio=".$dane[prio]."' onClick=\"if(confirm('Chcesz usunąć format ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a></td>";
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