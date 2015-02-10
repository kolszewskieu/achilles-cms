<?
include('wyceny_header.php');

if($_POST[zapisz]){
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	if(!$_POST[nazwa])$bug[nazwa]="<br/><span class='label label-important'>Brak nazwy.</span>";
	if(!$_POST[nazwa_en])$_POST[nazwa_en]=$_POST[nazwa];
	if(!$_POST[cena])$bug[cena]="<br/><span class='label label-important'>Brak ceny.</span>";
	
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
			/*if($_POST[wszystkie_produkty]){
				$sql="SELECT * FROM produkty WHERE del='0'";
				$res=mysql_query($sql);
				while($row=mysql_fetch_array($res)){
					$do_produktow[$row[id]]=$row[id];
				}
			}else{
				$do_produktow[$_GET[typ]]=$_GET[typ];
			}
			foreach($do_produktow as $key => $val){
			*/
			$sql="INSERT INTO dodatki ";
			$sql.="(nazwa,nazwa_en,cena,waluta,typ) VALUES ";
			$sql.="('$_POST[nazwa]','$_POST[nazwa_en]','$_POST[cena]','$_POST[waluta]','1')";
			if(!mysql_query($sql)){
				$alert="Dodanie elementu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Element został dodany do bazy.";
			}
			//}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE dodatki SET ";
			$sql.="nazwa='$_POST[nazwa]',nazwa_en='$_POST[nazwa_en]',cena='$_POST[cena]',waluta='$_POST[waluta]' ";
			$sql.=" WHERE id=$_POST[edit_id]";
			if(!mysql_query($sql)){
				$alert="Edycja elementu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Element zaktualizowany.";
				$_GET[typ]=$_POST[typ];
			}
		}
	}
}

if($_GET[del_id]){
	$sql="UPDATE dodatki SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie elementu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Element został usunięty z bazy.";
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
									<legend>Dodatkowe elementy&nbsp;&nbsp;&nbsp;
									<?//select_typ();?>
									<a class="btn btn-mini btn-primary" role="button" href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>&add=1">Dodaj element</a>
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
											$lists=array("nazwa"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM dodatki WHERE del='0'";
												$res=mysql_query($sql);									
												while($row=mysql_fetch_array($res)){
													if($lists[$key])$lists[$key].=",";
													$lists[$key].="&quot;".$row[dana]."&quot;";
												}
											}
										}
									if(!$_GET["sort"])$_GET["sort"]="nazwa";
									if(!$_GET["sortt"])$_GET["sortt"]="ASC";
									?>
									<form name="edycja" method="POST" action="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=nazwa&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Nazwa</a>
											<?if($_GET[sort]=="nazwa" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="nazwa" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=nazwa_en&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Nazwa EN</a>
											<?if($_GET[sort]=="nazwa_en" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="nazwa_en" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=cena&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Cena szt.</a>
											<?if($_GET[sort]=="cena" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="cena" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td>
												<input name="nazwa" value="<?=$_POST[nazwa]?>" data-source="[<?=$lists[nazwa]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[nazwa];?>
											</td>
											<td>
												<input name="nazwa_en" value="<?=$_POST[nazwa_en]?>" data-source="[<?=$lists[nazwa]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[nazwa_en];?>
											</td>											
											<td>
												<input name="cena" value="<?=$_POST[cena]?>" data-source="[<?=$lists[cena]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<select name="waluta" class="span5">
													<option value="pln" <?echo ($_POST[waluta]==pln?"selected":"")?>>pln
													<option value="eur" <?echo ($_POST[waluta]==eur?"selected":"")?>>eur
													<option value="usd" <?echo ($_POST[waluta]==usd?"selected":"")?>>usd
												</select>
												<?echo $bug[cena];?>
												<!--br/><input name="wszystkie_produkty" value="1" type="checkbox"> dodaj do wszystkich produktów-->
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										$sql="SELECT * FROM dodatki WHERE del='0' ";
										$sql.=" ORDER BY $_GET[sort] $_GET[sortt]";
										
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id]==$dane[id]){
												$_POST=$dane;
											?>
												<tr>
												<td>
													<input name="nazwa" value="<?=$_POST[nazwa]?>" data-source="[<?=$lists[nazwa]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[nazwa];?>
												</td>
												<td>
													<input name="nazwa_en" value="<?=$_POST[nazwa_en]?>" data-source="[<?=$lists[nazwa]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[nazwa_en];?>
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
													<input type="hidden" name="edit_id" value="<?=$_GET[edit_id]?>">
													<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
													<a href="?site=<?=$_GET[site]?>&typ=<?=$_GET[typ]?>"><i class="icon-remove"></i>anuluj</a>
												</td>
												</tr>
											<?
											}else{
												echo "<tr><td>";
												echo "<a name='f".$dane[id]."'></a>";
												echo $dane[nazwa];
												echo "</td><td>";
												echo $dane[nazwa_en];
												echo "</td><td>".$dane[cena]." ".$dane[waluta]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&typ=".$_GET[typ]."&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&typ=".$_GET[typ]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć dodatek ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
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