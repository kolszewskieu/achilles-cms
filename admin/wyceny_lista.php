<?
include('wyceny_header.php');
include('wyceny_menu.php');

if(!$_GET[p])$_GET[p]=0;
$on_page=50;
if($_GET[del_id]){
	$sql="UPDATE wyceny SET del='1' WHERE id=$_GET[del_id]";
	if(!mysql_query($sql)){
		$alert="Usunięcie elementu nie powiodło się <br/>".mysql_error();
	}else{
		$alert_ok="Element został usunięty z bazy.";
	}
}
//        </div><!--/span-->
//        <div class="span10">
?>
		<?if($alert){?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Operation error!</strong>&nbsp;<?=$alert?>
			</div>
		<?}?>
		<?if($alert_ok){?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Operation completed!</strong>&nbsp;<?=$alert_ok?>
			</div>
		<?}?>		
		<div class="row-fluid">
            <div class="span12">
					<div class="row-fluid">
						<div class="span12">
							<fieldset>
							<div class="row-fluid">
								<div class="span1">
									<legend>Valuation</legend>
								</div>
								<div class="span11">
									<form class="form-search" name="search">
									<input type="hidden" name="site" value="<?=$_GET[site]?>">
									<select name="set_wprow" onChange="document.forms['search'].submit()">
									<option value="">only created by: 
									<option value="">-- all --
								<?
								$sql="SELECT DISTINCT wprow FROM wyceny WHERE del='0'";
								$res=mysql_query($sql);
								while($row=mysql_fetch_array($res)){
									echo "<option value='".$row[wprow]."'";
									if($_GET[set_wprow]==$row[wprow])echo " selected ";
									echo ">".$_USERS_LIST[$row[wprow]];
								}?>	
									</select>
									Customer:
									 <div class="input-append">
										<input type="text" class="span8 search-query" name="set_klient" value="<?=$_GET[set_klient]?>">
										<button type="submit" class="btn"><i class="icon-search"></i></button>
									</div>
									</form>
								</div>
							</div>
							</fieldset>
						</div>
						<div class="row-fluid">
						<div class="span12">
							<fieldset>
							<div class="row-fluid">
							<?
							$sql="SELECT *,DATE_FORMAT(data_wprow,'%e.%m.%y %H:%i') as data_wprow_s,DATE_FORMAT(data_last_modyf,'%e.%m.%y %H:%i') as data_last_modyf_s FROM wyceny WHERE del='0'";
							if($_GET[set_wprow])$sql.=" AND wprow='".$_GET[set_wprow]."' ";
							if($_GET[set_klient])$sql.=" AND nazwa_klienta LIKE '%".$_GET[set_klient]."%' ";

							$ile=mysql_num_rows(mysql_query($sql));
							$start=$_GET[p]*$on_page;
							if(!$_GET["sort"])$_GET["sort"]="data_wprow";
							if(!$_GET["sortt"])$_GET["sortt"]="DESC";
							$sql.=" ORDER BY ".$_GET["sort"]." ".$_GET["sortt"]." LIMIT $start,$on_page";

							$res=mysql_query($sql);
							?>
								<div class="pagination pagination-centered">
									<ul>
									<?
									for($i=0;$i<$ile/$on_page;$i++){
										if($i==$_GET[p]){?>
											<li class="active"><span><a href="?site=pricing_list&action=list&p=<?=$i?>&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=<?=$_GET[sort]?>&sortt=<?=$_GET[sortt]?>"><?=$i+1;?></a></span></li>
										<?}else{?>
											<li class="disabled"><span><a href="?site=pricing_list&action=list&p=<?=$i?>&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=<?=$_GET[sort]?>&sortt=<?=$_GET[sortt]?>"><?=$i+1;?></a></span></li>
										<?}?>
									<?}?>
									<!--li class="active"><span><?=$ile;?></span></li-->
									</ul>
								</div>
										<table class="table table-striped table-hover">
										<thead align="center">
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=nazwa_klienta&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Customer</a>
											<?if($_GET[sort]=="nazwa_klienta" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="nazwa_klienta" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=nazwa_zlecenia&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Order</a>
											<?if($_GET[sort]=="nazwa_zlecenia" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="nazwa_zlecenia" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=szt&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Items</a>
											<?if($_GET[sort]=="szt" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="szt" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=koszt_calkowity_eur&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Price in EUR</a>
											<?if($_GET[sort]=="koszt_calkowity_eur" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="koszt_calkowity_eur" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=koszt_szt_eur&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Price item/EUR</a>
											<?if($_GET[sort]=="koszt_szt_eur" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="koszt_szt_eur" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>											
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=koszt_calkowity_pln&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Price in PLN</a>
											<?if($_GET[sort]=="koszt_calkowity_pln" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="koszt_calkowity_pln" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>											
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=koszt_szt_pln&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Price item/PLN</a>
											<?if($_GET[sort]=="koszt_szt_pln" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="koszt_szt_pln" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>								
											<th nowrap="1">EUR rate</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=modyf&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Edit by</a>
											<?if($_GET[sort]=="modyf" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="modyf" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=data_last_modyf&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Edit date</a>
											<?if($_GET[sort]=="data_last_modyf" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="data_last_modyf" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=wprow&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Creat by</a>
											<?if($_GET[sort]=="wprow" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="wprow" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
											<th nowrap="1"><a href="?site=pricing_list&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=data_wprow&sortt=<?=($_GET[sortt]=="DESC"?"ASC":"DESC")?>">Creat date.</a>
											<?if($_GET[sort]=="data_wprow" && $_GET[sortt]=="ASC"){?><i class="icon-chevron-up"></i><?}?>
											<?if($_GET[sort]=="data_wprow" && $_GET[sortt]=="DESC"){?><i class="icon-chevron-down"></i><?}?>
											</th>
										</thead>
										<?
										while($dane=mysql_fetch_array($res)){
											?>
												<tr>
												<td><?=$dane[nazwa_klienta];?></td>
												<td><?=$dane[nazwa_zlecenia];?></td>
												<td><?=$dane[szt];?></td>
												<td><?=$dane[koszt_calkowity_eur];?></td>
												<td><?=$dane[koszt_szt_eur];?></td>
												<td><?=$dane[koszt_calkowity_pln];?></td>
												<td><?=$dane[koszt_szt_pln];?></td>
												<td><?=$dane[kurs_eur];?></td>
												<td nowrap="1"><a href="?site=<?=$_GET[site]?>&set_wprow=<?=$dane[modyf]?>" title="<?=$_USERS_LIST[$dane[modyf]];?>"><?=$_USERS_LIST_IMIE[$dane[modyf]];?></a></td>
												<td nowrap="1"><?echo ($dane[data_last_modyf]!="0000-00-00 00:00:00"?$dane[data_last_modyf_s]:"");?></td>
												<td nowrap="1"><a href="?site=<?=$_GET[site]?>&set_wprow=<?=$dane[wprow]?>" title="<?=$_USERS_LIST[$dane[wprow]];?>"><?=$_USERS_LIST_IMIE[$dane[wprow]];?></a></td>
												<td nowrap="1"><?echo ($dane[data_wprow]!="0000-00-00 00:00:00"?$dane[data_wprow_s]:"");?></td>												
												<td nowrap="1">
													<?
													if (!$dane[linkp]) $dane[linkp]='pricing';
													if($_SESSION['user_id']==$dane[wprow]){
													
													?>
													<a class="btn btn-mini btn-danger" href="?site=<?=$dane[linkp];?>&action=new&wycena_id=<?=$dane[id];?>">Edit</a>
													<?}
										
													?>
													<a class="btn btn-mini btn-info" href="?site=<?=$dane[linkp];?>&action=new&przelicz=1&show_wycena_id=<?=$dane[id];?>">Show</a>
													<a class="btn btn-mini btn-warning" href="?site=<?=$dane[linkp];?>&action=new&przelicz=1&show_wycena_id=<?=$dane[id];?>&print=1" target="_blank">Print</a>
													<?if($_SESSION[pricing] == 'full'){?>
														<a href='?site=pricing_list&p=<?=$_GET[p]?>&del_id=<?=$dane[id];?>&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=<?=$_GET[sort]?>&sortt=<?=$_GET[sortt]?>' onClick="if(confirm('Do you want to delete valuation?')){return true;}else{return false;}"><i class='icon-trash'></i>delete</a>
													<?}?>
												</td>
												</tr>
										<?}?>
										</table>
								<div class="pagination pagination-centered">
									<ul>
									<?
									for($i=0;$i<$ile/$on_page;$i++){
										if($i==$_GET[p]){?>
											<li class="active"><span><a href="?site=pricing_list&action=list&p=<?=$i?>&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=<?=$_GET[sort]?>&sortt=<?=$_GET[sortt]?>"><?=$i+1;?></a></span></li>
										<?}else{?>
											<li class="disabled"><span><a href="?site=pricing_list&action=list&p=<?=$i?>&set_wprow=<?=$_GET[set_wprow]?>&set_klient=<?=$_GET[set_klient]?>&sort=<?=$_GET[sort]?>&sortt=<?=$_GET[sortt]?>"><?=$i+1;?></a></span></li>
										<?}?>
									<?}?>
									<!--li class="active"><span><?=$ile;?></span></li-->
									</ul>
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