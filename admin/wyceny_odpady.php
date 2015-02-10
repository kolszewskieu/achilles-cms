<?
include('wyceny_header.php');

if($_POST[zapisz]){
	if(!$_POST[odpad_typ])$bug[odpad_typ]="<br/><span class='label label-important'>Brak typu odpadu.</span>";
	if(!$_POST[odpad_typ_en])$_POST[odpad_typ_en]=$_POST[odpad_typ];
	if(!$_POST[szt_od] && $_POST[szt_od]!=0)$bug[szt_od]="<br/><span class='label label-important'>Brak liczyb sztuk od.</span>";
	if(!$_POST[procent] && !$_POST[szt_odpadu])$bug[procent]="<br/><span class='label label-important'>Brak procentu lub sztuk odpadu.</span>";	
	
	if(!$_POST[szt_do] && $_POST[szt_od] && !$_POST[bez_granicy])$_POST[szt_do]=$_POST[szt_od];
	if($_POST[bez_granicy] == 1)$_POST[szt_do]=0;

	if((!is_numeric($_POST[procent]) && !is_numeric($_POST[szt_odpadu])) || !is_numeric($_POST[szt_od]) || !is_numeric($_POST[szt_do])){
		$bug[numer]="<br/><span class='label label-important'>Zakres sztuk i liczba odpadów muszą być liczbami.</span>";
	}
	if($bug){
		if($_POST[zapisz]=="add"){
			$_GET[add]=1;
			$alert="Formularz dodawania odpadu zawiera błędy";
		}
		if($_POST[zapisz]=="edit"){
			$_GET[edit_id]=$_POST[edit_id];
			$alert="Formularz edycji odpadu zawiera błędy";
		}
	}else{
		if($_POST[zapisz]=="add"){
			$sql="INSERT INTO odpady ";
			$sql.="(odpad_typ,odpad_typ_en,szt_od,szt_do,procent,szt_odpadu,id_grupy_wyceny) VALUES ";
			$sql.="('$_POST[odpad_typ]','$_POST[odpad_typ_en]','$_POST[szt_od]','$_POST[szt_do]','$_POST[procent]','$_POST[szt_odpadu]','$_POST[id_grupy_wyceny]')";
			if(!mysql_query($sql)){
				$alert="Dodanie odpadu nie powiodło się <br/>".mysql_error();
				$alert.="<br>".$sql;
			}else{
				$alert_ok="Odpad został dodany do bazy.";
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE odpady SET ";
			$sql.="odpad_typ='$_POST[odpad_typ]',odpad_typ_en='$_POST[odpad_typ_en]',szt_od='$_POST[szt_od]',szt_do='$_POST[szt_do]',
			procent='$_POST[procent]',szt_odpadu='$_POST[szt_odpadu]',id_grupy_wyceny='$_POST[id_grupy_wyceny]'";
			$sql.=" WHERE id=$_POST[edit_id]";
			if(!mysql_query($sql)){
				$alert="Edycja odpadu nie powiodło się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Odpad zaktualizowany.";
			}
		}
	}
}

if($_GET[del_id]){
	$sql="UPDATE odpady SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie odpadu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="odpad został usunięty z bazy.";
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
									<legend>Odpady&nbsp;&nbsp;&nbsp;
									<a class="btn btn-mini btn-primary" role="button" href="?site=<?=$_GET[site]?>&add=1">Dodaj odpad</a>
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
										if($_GET[edit_id] || $_GET[add]){									
											$lists=array("odpad_typ"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM odpady WHERE del='0'";
												$res=mysql_query($sql);									
												while($row=mysql_fetch_array($res)){
													if($lists[$key])$lists[$key].=",";
													$lists[$key].="&quot;".$row[dana]."&quot;";
												}
											}
										}
									?>
									<form name="edycja" method="POST" action="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Typ odpadu</th>
											<th>Typ odpadu EN</th>
											<th>Liczba sztuk</th>
											<th>Procent</th>
											<th>Sztuk odpadu</th>
											<th>Grupy wyceny</th>
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td>
												<input name="odpad_typ" value="<?=$_POST[odpad_typ]?>" data-source="[<?=$lists[odpad_typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[odpad_typ];?>
											</td>
											<td>
												<input name="odpad_typ_en" value="<?=$_POST[odpad_typ_en]?>" data-source="[<?=$lists[odpad_typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[odpad_typ_en];?>
											</td>
											<td>
												od <input name="szt_od" value="<?=$_POST[szt_od]?>" data-source="[<?=$lists[szt_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;do
												<input name="szt_do" value="<?=$_POST[szt_do]?>" data-source="[<?=$lists[szt_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<input type="checkbox" name="bez_granicy" value="1"> bez granicy
												<?echo $bug[szt_od];?>
												<?echo $bug[numer];?>
											</td>
											<td>
												<input name="procent" value="<?=$_POST[procent]?>" type="text" class="input-mini" autocomplete="off">%
												<?echo $bug[procent];?>
											</td>
											<td>
												<input name="szt_odpadu" value="<?=$_POST[szt_odpadu]?>" type="text" class="input-mini" autocomplete="off"> szt.
											</td>
											<td>
												<select name="id_grupy_wyceny" class="span8">
													<?foreach($_CONF_LISTA as $key => $val){?>
														<option value="<?=$key;?>" <?echo ($_POST[id_grupy_wyceny]==$key?"selected":"")?>><?=$val;?>
													<?}?>
												</select>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										
										$sql="SELECT * FROM odpady WHERE del='0' ORDER BY odpad_typ,szt_od";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id]==$dane[id]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													<input name="odpad_typ" value="<?=$_POST[odpad_typ]?>" data-source="[<?=$lists[odpad_typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[odpad_typ];?>
												</td>
												<td>
													<input name="odpad_typ_en" value="<?=$_POST[odpad_typ_en]?>" data-source="[<?=$lists[odpad_typ]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[odpad_typ_en];?>
												</td>
												<td>
													od <input name="szt_od" value="<?=$_POST[szt_od]?>" data-source="[<?=$lists[szt_od]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">&nbsp;do
													<input name="szt_do" value="<?=$_POST[szt_do]?>" data-source="[<?=$lists[szt_do]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<input type="checkbox" name="bez_granicy" value="1"
													<?if($_POST[szt_od]>0 && $_POST[szt_do]==0){ echo " checked ";}?>
													> bez granicy
													<?echo $bug[szt_od];?>
												</td>
												<td>
													<input name="procent" value="<?=$_POST[procent]?>" type="text" class="input-mini" autocomplete="off">%
													<?echo $bug[procent];?>
												</td>
												<td>
													<input name="szt_odpadu" value="<?=$_POST[szt_odpadu]?>" type="text" class="input-mini" autocomplete="off"> szt.
												</td>
												<td>
													<select name="id_grupy_wyceny" class="span9">
														<?foreach($_CONF_LISTA as $key => $val){?>
															<option value="<?=$key;?>" <?echo ($_POST[id_grupy_wyceny]==$key?"selected":"")?>><?=$val;?>														
														<?}?>
													</select>
												</td>
												<td>
													<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="edit_id" value="<?=$_GET[edit_id]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr><td>";
												echo "<a name='f".$dane[id]."'></a>";
												echo $dane[odpad_typ];
												echo "</td><td>";
												echo $dane[odpad_typ_en];
												echo "</td><td>";
												if($dane[szt_od] && $dane[szt_do]){
													echo "od ".$dane[szt_od]." do ".$dane[szt_do];
												}elseif($dane[szt_od] == 0 && $dane[szt_do]){
													echo "do ".$dane[szt_do];
												}elseif($dane[szt_od] && $dane[szt_do]==0){
													echo "od ".$dane[szt_od];
												}
												echo "</td>";
												echo "<td>".$dane[procent]." %</td>";
												echo "<td>".$dane[szt_odpadu]." szt.</td>";
												echo "<td>".$_CONF_LISTA[$dane[id_grupy_wyceny]]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć odpad ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usun</a></td>";
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