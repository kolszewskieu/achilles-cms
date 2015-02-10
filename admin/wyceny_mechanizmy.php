<?
include('wyceny_header.php');

if($_POST[zapisz]){
	$_POST[cena]=str_replace(",",".",$_POST[cena]);
	if(!$_POST[nazwa])$bug[nazwa]="<br/><span class='label label-important'>Brak nazwy mechanizmu.</span>";
	if(!$_POST[typ_mechanizm])$bug[typ_mechanizm]="<br/><span class='label label-important'>Brak typu mechanizmu.</span>";
	if(!$_POST[cena])$bug[cena]="<br/><span class='label label-important'>Brak ceny mechanizmu.</span>";
	
	if($bug){
		if($_POST[zapisz]=="add"){
			$_GET[add]=1;
			$alert="Formularz dodawania mechanizmu zawiera błędy";
		}
		if($_POST[zapisz]=="edit"){
			$_GET[edit_id_format]=$_POST[edit_id_format];
			$alert="Formularz edycji mechanizmu zawiera błędy";
		}
	}else{
		if($_POST[zapisz]=="add"){
			$sql="INSERT INTO mechanizmy ";
			$sql.="(nazwa,typ_mechanizm,cena,waluta,liczba_nitow,liczba_szt_pudlo) VALUES ";
			$sql.="('$_POST[nazwa]','$_POST[typ_mechanizm]','$_POST[cena]','$_POST[waluta]','$_POST[liczba_nitow]','$_POST[liczba_szt_pudlo]')";
			if(!mysql_query($sql)){
				$alert="Dodanie mechanizmu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Mechanizm został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE mechanizmy SET ";
			$sql.="nazwa='$_POST[nazwa]',typ_mechanizm='$_POST[typ_mechanizm]',cena='$_POST[cena]',waluta='$_POST[waluta]',liczba_nitow='$_POST[liczba_nitow]',liczba_szt_pudlo='$_POST[liczba_szt_pudlo]'";
			$sql.=" WHERE id=$_POST[edit_id]";
			if(!mysql_query($sql)){
				$alert="Edycja mechanizmu nie powiodła się <br/>".mysql_error()."<br/>".$sql;
			}else{
				$alert_ok="Mechanizm zaktualizowany.";
				$_GET[typ]=$_POST[typ];
			}
		}
	}
}

if($_GET[del_id]){
	$sql="UPDATE mechanizmy SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie mechanimu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Mechanizm został usunięty z bazy.";
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
									<legend>Mechanizmy&nbsp;&nbsp;&nbsp;
									<a class="btn btn-mini btn-primary" role="button" href="?site=<?=$_GET[site]?>&add=1">Dodaj nowy mechanizm</a>
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
											$lists=array("nazwa"=>"","typ_mechanizm"=>"");
											foreach($lists as $key => $val){
												$sql="SELECT DISTINCT $key as dana FROM mechanizmy WHERE del='0'";
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
									<form name="edycja" method="POST" action="?site=<?=$_GET[site]?>">
										<table class="table table-striped table-hover">
										<thead align="center">
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=nazwa&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Nazwa</a>
											<?if($_GET[sort]=="nazwa" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="nazwa" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=typ_mechanizm&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Typ</a>
											<?if($_GET[sort]=="typ_mechanizm" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="typ_mechanizm" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=cena&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Cena szt.</a>
											<?if($_GET[sort]=="cena" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="cena" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=liczba_nitow&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Liczba nitów</a>
											<?if($_GET[sort]=="liczba_nitow" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="liczba_nitow" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=<?=$_GET[site]?>&sort=liczba_szt_pudlo&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Szt. pudełko</a>
											<?if($_GET[sort]=="liczba_szt_pudlo" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="liczba_szt_pudlo" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
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
												<input name="typ_mechanizm" value="<?=$_POST[typ_mechanizm]?>" data-source="[<?=$lists[typ_mechanizm]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
												<?echo $bug[typ_mechanizm];?>
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
												<input name="liczba_nitow" value="<?=$_POST[liczba_nitow]?>" data-source="[<?=$lists[liczba_nitow]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[liczba_nitow];?>
											</td>
											<td>
												<input name="liczba_szt_pudlo" value="<?=$_POST[liczba_szt_pudlo]?>" data-source="[<?=$lists[liczba_szt_pudlo]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
												<?echo $bug[liczba_szt_pudlo];?>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										
										$sql="SELECT * FROM mechanizmy WHERE del='0'";
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
													<input name="typ_mechanizm" value="<?=$_POST[typ_mechanizm]?>" data-source="[<?=$lists[typ_mechanizm]?>]" type="text" data-provide="typeahead" class="input-medium" autocomplete="off">
													<?echo $bug[typ_mechanizm];?>
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
													<input name="liczba_nitow" value="<?=$_POST[liczba_nitow]?>" data-source="[<?=$lists[liczba_nitow]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[liczba_nitow];?>
												</td>
												<td>
													<input name="liczba_szt_pudlo" value="<?=$_POST[liczba_szt_pudlo]?>" data-source="[<?=$lists[liczba_szt_pudlo]?>]" type="text" data-provide="typeahead" class="input-mini" autocomplete="off">
													<?echo $bug[liczba_szt_pudlo];?>
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
												echo $dane[nazwa];
												echo "</td><td>".$dane[typ_mechanizm]."</td>";
												echo "<td>".$dane[cena]." ".$dane[waluta]."</td>";
												echo "<td>".$dane[liczba_nitow]."</td>";
												echo "<td>".$dane[liczba_szt_pudlo]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć mechanizm ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
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