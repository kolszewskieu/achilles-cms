<?
include('wyceny_header.php');

if($_POST[typ_kopia] && $_POST[zapisz]!="add"){
	copy_in_table("elementy",$_GET[typ],$_POST[typ_kopia],$_POST[id_copy]);
}

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
			$sql="INSERT INTO elementy ";
			$sql.="(nazwa,nazwa_en,cena,waluta,typ,z_mechanizmy) VALUES ";
			$sql.="('$_POST[nazwa]','$_POST[nazwa_en]','$_POST[cena]','$_POST[waluta]','$_GET[typ]','$_GET[z_mechanizmy]')";
			if(!mysql_query($sql)){
				$alert="Dodanie elementu nie powiodło się <br/>".mysql_error();
			}else{
				$alert_ok="Element został dodany do bazy.";
				$_GET[typ]=$_POST[typ];
			}
		}
		if($_POST[zapisz]=="edit"){
			$sql="UPDATE elementy SET ";
			$sql.="nazwa='$_POST[nazwa]',nazwa_en='$_POST[nazwa_en]',cena='$_POST[cena]',waluta='$_POST[waluta]',z_mechanizmy='$_POST[z_mechanizmy]' ";
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
	$sql="UPDATE elementy SET del='1' WHERE id=$_GET[del_id]";
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
									<legend>Elementy stałe&nbsp;&nbsp;&nbsp;
									<?select_typ();?>
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
												$sql="SELECT DISTINCT $key as dana FROM elementy WHERE del='0'";
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
											<th width="5">
											<?if(!$_GET[add]){?>
												<input type="checkbox" id="id_copy_all" name="id_copy_all" value="all" >
											<?}?>
											</th>
											<th>Nazwa</th>
											<th>Nazwa EN</th>
											<th>Cena szt.</th>
											<th>Z mechanizmy</th>
											<th>Edycja</th>
										</thead>
										<?
										if($_GET[add]){?>
											<tr>
											<td></td>
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
												<select name="z_mechanizmy" class="span5">
													<option value="0" <?echo ($_POST[z_mechanizmy]==0?"selected":"")?>>nie
													<option value="1" <?echo ($_POST[z_mechanizmy]==1?"selected":"")?>>szt. nitów
													<option value="2" <?echo ($_POST[z_mechanizmy]==2?"selected":"")?>>szt. w opakowaniu
												</select>
											</td>
											<td>
												<input type="hidden" name="zapisz" value="add">
												<button class="btn btn-mini btn-danger" type="button" onClick="document.forms['edycja'].submit()">Zapisz</button>
												<a href="?site=<?=$_GET[site]?>"><i class="icon-remove"></i>anuluj</a>
											</td>
											</tr>
										<?}
										
										$sql="SELECT * FROM elementy WHERE typ='$_GET[typ]' AND del='0' ORDER BY nazwa";
										$res=mysql_query($sql);
										while($dane=mysql_fetch_array($res)){
											if($_GET[edit_id]==$dane[id]){
												$_POST=$dane;
											?>
												<tr>
												<td></td>
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
													<select name="z_mechanizmy" class="span5">
														<option value="0" <?echo ($_POST[z_mechanizmy]==0?"selected":"")?>>nie
														<option value="1" <?echo ($_POST[z_mechanizmy]==1?"selected":"")?>>szt. nitów
														<option value="2" <?echo ($_POST[z_mechanizmy]==2?"selected":"")?>>szt. w opakowaniu
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
												$_Z_MECHANIZMY=array(0=>"nie",1=>"nity",2=>"opakowania");
												echo "<tr>";
												echo "<td>";
												if(!$_GET[add]){
													echo "<input type='checkbox' name='id_copy[]' value='".$dane[id]."'>";
												}
												echo "</td>";
												echo "<td>";
												echo $dane[nazwa];
												echo "</td><td>";
												echo $dane[nazwa_en];												echo "<td>".$dane[cena]." ".$dane[waluta]."</td>";
												echo "</td><td>".$_Z_MECHANIZMY[$dane[z_mechanizmy]]."</td>";
												echo "<td><a href='?site=".$_GET[site]."&typ=".$_GET[typ]."&edit_id=".$dane[id]."#f".$dane[id]."'><i class='icon-pencil'></i>edytuj</a> ";
												echo "<a href='?site=".$_GET[site]."&del_id=".$dane[id]."' onClick=\"if(confirm('Chcesz usunąć element ?')){return true;}else{return false;}\"><i class='icon-trash'></i>usuń</a></td>";
												echo "</tr>";
											}
										}
										if(!$_GET[add]){
										?>
											<tr><td></td><td colspan="7">Kopiuj do&nbsp;
											<?select_typ("typ_kopia",$_GET[typ],0,1);?>
											<button class="btn btn-mini btn-success" type="button" onClick="document.forms['edycja'].submit()">Kopiuj</button>
											</td>
											</tr>
										<?}?>
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
<script>
$('#id_copy_all').click(
    function()
    {
        $("input[type='checkbox']").attr('checked', $('#id_copy_all').is(':checked'));    
    }
)
</script>
<?include('wyceny_footer.php');?>