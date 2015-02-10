<?
include('wyceny_header.php');

if($_POST[zapisz]){
	if(!$_POST[nazwa])$bug[nazwa]="<br/><span class='label label-important'>Brak nazwy folii.</span>";
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	
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
			$sql="INSERT INTO folie ";
			$sql.="(nazwa,nazwa_en,nazwa_de,cena,waluta) VALUES ";
			$sql.="('$_POST[nazwa]','$_POST[nazwa_en]','$_POST[nazwa_de]','$_POST[cena]','$_POST[waluta]')";
			if(!mysql_query($sql)){
				$alert="Dodanie elementu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Element został dodany do bazy.";
				
				$sql="SELECT MAX(id) FROM folie";
				list($id_folie_last)=mysql_fetch_row(mysql_query($sql));

				/* kopiujemy formaty oklejek dla danego typu folii */
				$sql="SELECT * FROM format_folia_oklejka WHERE del='0' GROUP BY id_format_oklejka";
				$res=mysql_query($sql);
				while($dane=mysql_fetch_array($res)){
					$sql_ins_format="INSERT INTO format_folia_oklejka (id_format_oklejka,folia_x,folia_y,sztuk_arkusz,typ,typ_folie,cena,waluta) VALUE ('$dane[id_format_oklejka]','$dane[folia_x]','$dane[folia_y]','$dane[sztuk_arkusz]','$dane[typ]','$id_folie_last','$_POST[cena]','$_POST[waluta]') ";
					if(!mysql_query($sql_ins_format)){
						$alert.="<br>Dodanie formatu folii oklejki nie powiodło się <br/>".mysql_error();
					}else{
						$alert_ok.="<br>Format folii oklejki został dodany do bazy.";
					}
				}
				/* kopiujemy formaty wklejek dla danego typu folii */
				$sql="SELECT * FROM format_folia_wklejka WHERE del='0' GROUP BY id_format_wklejka";
				$res=mysql_query($sql);
				while($dane=mysql_fetch_array($res)){
					$sql_ins_format="INSERT INTO format_folia_wklejka (id_format_wklejka,folia_x,folia_y,sztuk_arkusz,typ,typ_folie,cena,waluta) VALUE ('$dane[id_format_wklejka]','$dane[folia_x]','$dane[folia_y]','$dane[sztuk_arkusz]','$dane[typ]','$id_folie_last','$_POST[cena]','$_POST[waluta]') ";
					if(!mysql_query($sql_ins_format)){
						$alert="<br>Dodanie formatu folii wklejki nie powiodło się <br/>".mysql_error();
					}else{
						$alert_ok="<br>Format folii wklejki został dodany do bazy.";
					}
				}
			}			
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE folie SET ";
			$sql.="nazwa='$_POST[nazwa]',nazwa_en='$_POST[nazwa_en]',nazwa_de='$_POST[nazwa_de]',cena='$_POST[cena]',waluta='$_POST[waluta]' ";
			$sql.=" WHERE id=$_POST[edit_id]";
			if(!mysql_query($sql)){
				$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Element zaktualizowany.";

				$sql_upd_oklejka="UPDATE format_folia_oklejka SET cena='$_POST[cena]', waluta='$_POST[waluta]' WHERE typ_folie=$_POST[edit_id] ";
				if(!mysql_query($sql_upd_oklejka)){
					$alert.="<br>Aktualizacja oklejki nie powiodło się <br/>".mysql_error()."<br/>".$sql;
				}else{
					$alert_ok.="<br>Oklejka zaktualizowana.";
				}
				$sql_upd_wklejka="UPDATE format_folia_wklejka SET cena='$_POST[cena]', waluta='$_POST[waluta]' WHERE typ_folie=$_POST[edit_id] ";
				if(!mysql_query($sql_upd_wklejka)){
					$alert.="<br>Aktualizacja wklejki nie powiodło się <br/>".mysql_error()."<br/>".$sql;
				}else{
					$alert_ok.="<br>Wklejka zaktualizowana.";
				}
			}
		}
	}
}

if($_GET[del_id]){
	$sql="UPDATE folie SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie elementu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Element został usunięty z bazy.";
		$sql_del_oklejka="UPDATE format_folia_oklejka  SET del='1' WHERE typ_folie=$_GET[del_id] ";
		if(!mysql_query($sql_del_oklejka)){
			$alert.="<br>Usunięcie oklejki nie powiodło się <br/>".mysql_error()."<br/>".$sql;
		}else{
			$alert_ok.="<br>Oklejka usunięta";
		}
		$sql_del_oklejka="UPDATE format_folia_wklejka  SET del='1' WHERE typ_folie=$_GET[del_id] ";
		if(!mysql_query($sql_del_oklejka)){
			$alert.="<br>Usunięcie wklejki nie powiodło się <br/>".mysql_error()."<br/>".$sql;
		}else{
			$alert_ok.="<br>Wklejka usunięta";
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
									<legend>Typy folii&nbsp;&nbsp;&nbsp;
									<a class="btn btn-mini btn-primary" role="button" href="?site=<?=$_GET[site]?>&add=1">Dodaj typ folii</a>
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
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Nazwa PL</th>
											<th>Nazwa EN</th>
											<th>Nazwa DE</th>
											<th>Cena</th>
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td>
												<input name="nazwa" value="<?=$_POST[nazwa]?>" type="text" class="input-medium" autocomplete="off">
												<?echo $bug[nazwa];?>
											</td>
											<td>
												<input name="nazwa_en" value="<?=$_POST[nazwa_en]?>" type="text" class="input-medium" autocomplete="off">
											</td>
											<td>
												<input name="nazwa_de" value="<?=$_POST[nazwa_de]?>" type="text" class="input-medium" autocomplete="off">
											</td>
											<td>
												<input name="cena" value="<?=$_POST[cena]?>" type="text" class="input-medium" autocomplete="off">
												<select name="waluta" class="span5">
														<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
														<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
														<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
												</select>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										
										$sql="SELECT * FROM folie WHERE del='0'";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id]==$dane[id]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													<input name="nazwa" value="<?=$_POST[nazwa]?>" type="text" class="input-medium" autocomplete="off">
													<?echo $bug[nazwa];?>
												</td>
												<td>
													<input name="nazwa_en" value="<?=$_POST[nazwa_en]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input name="nazwa_de" value="<?=$_POST[nazwa_de]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input name="cena" value="<?=$_POST[cena]?>" type="text" class="input-medium" autocomplete="off">
													<select name="waluta" class="span5">
														<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
														<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
														<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
													</select>
												</td>
												<td>
														<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="edit_id" value="<?=$_GET[edit_id]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr>";
												echo "<td>";
												echo "<a name='f".$dane[id]."'></a>";
												echo $dane[nazwa];
												echo "</td>";
												echo "<td>".$dane[nazwa_en]."</td>";
												echo "<td>".$dane[nazwa_de]."</td>";
												echo "<td>".$dane[cena]." ".$dane[waluta]." m2</td>";
												echo "<td><a href='?site=".$_GET[site]."&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć folię ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
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