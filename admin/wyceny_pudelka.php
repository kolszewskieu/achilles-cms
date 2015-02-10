<?
include('wyceny_header.php');
?>
<h3>Pricing boxes</h3>
<a name="czeski"></a>
<form name="wycena_czeski" action="">
<input type="hidden" name="site" value="<?=$_GET[site]?>">
<fieldset>
	<div class="row-fluid">
		<div class="span6">
			<legend>Box type "Czech"</legend>
			<img src="img/pudelko_czeskie.PNG">
		</div>
		<div class="span6">
		<?
		$_GET[b]=str_replace(",",".",$_GET[b]);
		$_GET[l]=str_replace(",",".",$_GET[l]);
		$_GET[h]=str_replace(",",".",$_GET[h]);
		$_GET[z]=str_replace(",",".",$_GET[z]);
		if(!$_GET[b])$_GET[b]="310";
		if(!$_GET[l])$_GET[l]="315";
		if(!$_GET[h])$_GET[h]="105";
		if(!$_GET[z])$_GET[z]="1.9";
		?>
			<legend>Size</legend>
			<label class="inline">box width B in mm&nbsp;<input type="text" class="input-small" name="b" value="<?=$_GET[b]?>"></label>
			<label class="inline">box length L in mm&nbsp;<input type="text" class="input-small" name="l" value="<?=$_GET[l]?>"></label>
			<label class="inline">box height H in mm&nbsp;<input type="text" class="input-small" name="h" value="<?=$_GET[h]?>"></label>
			<label class="inline">paperboard thickness Z in mm&nbsp;<input type="text" class="input-small" name="z" value="<?=$_GET[z]?>">
			<input type="hidden" name="przelicz" value="1">
			<button class="btn btn-mini btn-primary" type="button" onClick="document.forms['wycena_czeski'].action='#czeski';document.forms['wycena_czeski'].submit()">Calculate</button></label>
			<?if($_GET[przelicz]==1){

				$fox=round((($_GET[b]+(2*$_GET[h])+(2*$_GET[z])+32)*1.05),0);
				$foy=round((($_GET[l]+(2*$_GET[h])+(2*$_GET[z])+32)*1.05),0);
				$ftx=round((($_GET[b]+(2*$_GET[h]))*1.03),0);
				$fty=round((($_GET[l]+(2*$_GET[h]))*1.03),0);
				$dnoz=round(((($_GET[b]*4)+($_GET[l]*4)+($_GET[h]*8)+($_GET[b]*2)+($_GET[l]*2)+($_GET[h]*8) )*1.1),0);
				$knoz=round(($dnoz*0.07),0);
			?>
				<span class='label label-success'>out-sticker format +5%</span>&nbsp;<strong><?=$fox?> x <?=$foy?> mm</strong><br/>
				<span class='label label-success'>paperboard format +5%</span>&nbsp;<strong><?=$ftx?> x <?=$fty?> mm</strong><br/>
				<span class='label label-success'>die cutter +5% out-sticker+paperboard</span>&nbsp;<strong><?=$dnoz;?> mm</strong><br/>
				<span class='label label-success'>approximate die cutter cost</span>&nbsp;<strong><?=$knoz;?> zł</strong><br/>
				<br><a target="_blank" class="btn btn-small btn-success" href="/admin/index.php?action=new&site=pricing&typ=8&grubosc=<?=$_GET[z]?>&format_x=<?=$ftx?>&format_y=<?=$fty?>&wczytaj=1&dodatki[1]=Wykrojnik&dodatki_cena[1]=<?=$knoz;?>&dodatki_waluta[1]=pln&dodatki_typ_cena[1]=cal">New Pricing</a>
			<?}?>
		</div>
	</div>
</fieldset>
</form>
<br>
<a name="etui"></a>
<form name="etui" action="">
<input type="hidden" name="site" value="<?=$_GET[site]?>">
<fieldset>
	<div class="row-fluid">
		<div class="span6">
			<legend>Slipcase</legend>
			<img src="img/etui.PNG">
		</div>
		<div class="span6">
		<?
		$_GET[m]=str_replace(",",".",$_GET[m]);
		$_GET[k]=str_replace(",",".",$_GET[k]);
		$_GET[lE]=str_replace(",",".",$_GET[lE]);
		$_GET[zE]=str_replace(",",".",$_GET[zE]);
		if(!$_GET[m])$_GET[m]="317";
		if(!$_GET[k])$_GET[k]="225";
		if(!$_GET[lE])$_GET[lE]="50";
		if(!$_GET[zE])$_GET[zE]="1.9";
		?>
			<legend>Size</legend>
			<label class="inline">slipcase height M in mm&nbsp;<input type="text" class="input-small" name="m" value="<?=$_GET[m]?>"></label>
			<label class="inline">slipcase depth K in mm&nbsp;<input type="text" class="input-small" name="k" value="<?=$_GET[k]?>"></label>
			<label class="inline">spine width L in mm&nbsp;<input type="text" class="input-small" name="lE" value="<?=$_GET[lE]?>"></label>
			<label class="inline">paperboard thickness Z in mm&nbsp;<input type="text" class="input-small" name="zE" value="<?=$_GET[zE]?>">
			<input type="hidden" name="przelicz_etui" value="1">
			<button class="btn btn-mini btn-primary" type="button" onClick="document.forms['etui'].action='#etui';document.forms['etui'].submit()">Calculate</button></label>
			<?if($_GET[przelicz_etui]==1){
				$foxE=round((($_GET[lE]+(2*$_GET[k])+(2*$_GET[zE])+32)*1.05),0);
				$foyE=round((($_GET[m]+(2*$_GET[lE]))*1.05),0);
				$ftxE=round((($_GET[lE]+(2*$_GET[k]))*1.03),0);
				$ftyE=round((((2*$_GET[lE])+$_GET[m])*1.03),0);
				$dnozE=round(((($_GET[m]*4)+($_GET[k]*6)+($_GET[lE]*6)+($_GET[m]*2)+($_GET[k]*4)+($_GET[lE]*6))*1.08),0);
				$knozE=round(($dnozE*0.07),0);
			?>
				<span class='label label-success'>out-sticker format +5%</span>&nbsp;<strong><?=$foxE?> x <?=$foyE?> mm</strong><br/>
				<span class='label label-success'>paperboard format +5%</span>&nbsp;<strong><?=$ftxE?> x <?=$ftyE?> mm</strong><br/>
				<span class='label label-success'>die cutter +5% out-sticker+paperboard</span>&nbsp;<strong><?=$dnozE;?> mm</strong><br/>
				<span class='label label-success'>approximate die cutter cost</span>&nbsp;<strong><?=$knozE;?> zł</strong><br/>
				<br><a target="_blank" class="btn btn-small btn-success" href="/admin/index.php?action=new&site=pricing&typ=4&grubosc=<?=$_GET[zE]?>&format_x=<?=$ftxE?>&format_y=<?=$ftyE?>&wczytaj=1&dodatki[1]=Wykrojnik&dodatki_cena[1]=<?=$knozE;?>&dodatki_waluta[1]=pln&dodatki_typ_cena[1]=cal">New Pricing</a>			<?}?>
		</div>
	</div>
</fieldset>
</form>
<?
include('wyceny_footer.php');
?>