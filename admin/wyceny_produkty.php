<?
include('wyceny_header.php');

$_POST[def_grubosc]=str_replace(",",".",$_POST[def_grubosc]);

if($_POST[zapisz]){
	if(!$_POST[nazwa])$bug[nazwa]="<br/><span class='label label-important'>Brak nazwy produktu.</span>";
	
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
			$sql="INSERT INTO produkty ";
			$sql.="(nazwa,nazwa_en,nazwa_de,def_grubosc,def_format_x,def_format_y,ile_tektur,aktywny) VALUES ";
			$sql.="('$_POST[nazwa]','$_POST[nazwa_en]','$_POST[nazwa_de]','$_POST[def_grubosc]','$_POST[def_format_x]','$_POST[def_format_y]','$_POST[ile_tektur]',1)";
			if(!mysql_query($sql)){
				$alert="Dodanie elementu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Element został dodany do bazy.";
			}
			$sql="SELECT MAX(id) FROM produkty";
			list($typ_last)=mysql_fetch_row(mysql_query($sql));

			$sql="INSERT INTO cena_sugerowana ";
			$sql.="(cena,typ,szt_od,szt_do) VALUES ('1',".$typ_last.",0,0)";
			if(!mysql_query($sql)){
				$alert.="<br>Dodanie konfiguracji dla ceny sugerowanej nie powiodło się <br/>".mysql_error();
				$alert.="<br>".$sql;
			}else{
				$alert_ok.="<br>Konfiguracja dla ceny sugerowanej dodana do bazy.";
			}
			
			$sql="SELECT cena,waluta FROM ceny_stale WHERE material='tektura'";
			list($cena_tektura,$waluta_tektura)=mysql_fetch_row(mysql_query($sql));
			$sql="INSERT INTO ceny_stale (material,typ,cena,waluta) VALUES ('tektura','".$typ_last."','".$cena_tektura."','".$waluta_tektura."')";
			if(!mysql_query($sql)){
				$alert.="<br>Dodanie konfiguracji dla ceny tektury nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok.="<br>Konfiguracja dla ceny tektury dodana do bazy.";
			}
			$sql="SELECT cena,waluta FROM ceny_stale WHERE material='papier'";
			list($cena_papier,$waluta_papier)=mysql_fetch_row(mysql_query($sql));
			$sql="INSERT INTO ceny_stale (material,typ,cena,waluta) VALUES ('papier',".$typ_last.",'".$cena_papier."','".$waluta_papier."')";
			if(!mysql_query($sql)){
				$alert.="<br>Dodanie konfiguracji dla ceny papier nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok.="<br>Konfiguracja dla ceny papier dodana do bazy.";
			}
		}
		if($_POST[zapisz]=="edit"){
			$def_format_x=implode(";",$_POST[def_format_x]);
			$def_format_y=implode(";",$_POST[def_format_y]);
			$sql="UPDATE produkty SET ";
			$sql.="nazwa='$_POST[nazwa]',nazwa_en='$_POST[nazwa_en]',nazwa_de='$_POST[nazwa_de]',def_grubosc='$_POST[def_grubosc]',def_format_x='$def_format_x',def_format_y='$def_format_y',aktywny='$_POST[aktywny]',ile_tektur='$_POST[ile_tektur]' ";
			$sql.=" WHERE id=$_POST[edit_id]";
			if(!mysql_query($sql)){
				$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Element zaktualizowany.";
			}
		}
	}
}

if($_GET[del_id]){
	$sql="UPDATE produkty SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie elementu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Element został usunięty z bazy.";
	}
	$sql="DELETE FROM ceny_stale WHERE typ=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert.="<br>Usunięcie konfiguracji materiału nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok.="<br>Cena stała dla materiałów usunięta.";
	}
	$sql="DELETE FROM cena_sugerowana WHERE typ=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert.="<br>Usunięcie konfiguracji cena sugerowana nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok.="<br>Cena sugerowana usunięta.";
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
									<legend>Produkty&nbsp;&nbsp;&nbsp;
									<a class="btn btn-mini btn-primary" role="button" href="?site=wyceny_produkty&add=1">Dodaj produkt</a>
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
									<form name="edycja" method="POST" action="?site=wyceny_produkty&typ=<?=$_GET[typ]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th>Nazwa PL</th>
											<th>Nazwa EN</th>
											<th>Nazwa DE</th>
											<th>Domyślna grubość</th>
											<th>Domyślny format</th>
											<th>Liczba tektur</th>
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
												<input name="def_grubosc" value="<?=$_POST[def_grubosc]?>" type="text" class="input-mini" autocomplete="off">
											</td>
											<td nowrap=1>
												<input name="def_format_x" value="<?=$_POST[def_format_x]?>" type="text" class="input-mini" autocomplete="off">
												x<input name="def_format_y" value="<?=$_POST[def_format_y]?>" type="text" class="input-mini" autocomplete="off">
											</td>
											<td>1</td>										
											<td nowrap=1>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=wyceny_produkty"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}										
										$sql="SELECT * FROM produkty WHERE del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id]==$dane[id]){
												$_POST=$dane;
												$_POST[def_format_x]=explode(";",$_POST[def_format_x]);
												$_POST[def_format_y]=explode(";",$_POST[def_format_y]);
											?>
												<tr>
												<td>
													<input name="nazwa" value="<?=$_POST[nazwa]?>" type="text" class="input-medium" autocomplete="off">
													<br/><input type="radio" name="aktywny" value="1"
													<?if($_POST[aktywny]==1)echo " checked ";?>
													>&nbsp;Aktywny &nbsp;
													<input type="radio" name="aktywny" value="0"
													<?if($_POST[aktywny]==0)echo " checked ";?>
													>&nbsp;Nie aktywny
													<?echo $bug[nazwa];?>
												</td>
												<td>
													<input name="nazwa_en" value="<?=$_POST[nazwa_en]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input name="nazwa_de" value="<?=$_POST[nazwa_de]?>" type="text" class="input-medium" autocomplete="off">
												</td>
												<td>
													<input name="def_grubosc" value="<?=$_POST[def_grubosc]?>" type="text" class="input-mini" autocomplete="off">
												</td>
												<td nowrap=1>
												<?
												for($a=0;$a<=$_POST[ile_tektur]-1;$a++){
													if($a>0)echo "<br/>";
												?>
													<input name="def_format_x[<?=$a?>]" value="<?=$_POST[def_format_x][$a]?>" type="text" class="input-mini" autocomplete="off">
													x<input name="def_format_y[<?=$a?>]" value="<?=$_POST[def_format_y][$a]?>" type="text" class="input-mini" autocomplete="off">
												<?}?>
												</td>
												<td>
												<input name="ile_tektur" value="<?=$_POST[ile_tektur]?>" type="text" class="input-mini" autocomplete="off">
												</td>
												<td nowrap=1>
													<input type="hidden" name="zapisz" value="edit">
													<input type="hidden" name="edit_id" value="<?=$_GET[edit_id]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=wyceny_produkty&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												$dane[def_format_x]=explode(";",$dane[def_format_x]);
												$dane[def_format_y]=explode(";",$dane[def_format_y]);
												echo "<tr ";
												if($dane[aktywny]==1){
													echo "class='success' ";
												}else{
													echo "class='error' ";
												}
												echo ">";
												echo "<td>";
												echo "<a name='f".$dane[id]."'></a>";
												echo $dane[nazwa];
												echo "</td>";
												echo "<td>".$dane[nazwa_en]."</td>";
												echo "<td>".$dane[nazwa_de]."</td>";
												echo "<td>".$dane[def_grubosc]."</td>";
												echo "<td>";
												for($b=0;$b<=$dane[ile_tektur]-1;$b++){
													if($b>0)echo "<br/>";
													echo $dane[def_format_x][$b]."x".$dane[def_format_y][$b];
												}
												echo "</td>";
												echo "<td>".$dane[ile_tektur]."</td>";
												echo "<td><a href='?site=wyceny_produkty&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=wyceny_produkty&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć mechanizm ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
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