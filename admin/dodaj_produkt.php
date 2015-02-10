<?
	if ($action == 'zapisz') {		
		for($i = 0; $i < count($_POST[nazwapl3]); $i++) { //cechy z multiple selecta poki sa
			$cechy .= $_POST[nazwapl3][$i].','; // sobie listuje z przecinkiem
		}		
		$cechy = rtrim($cechy, ','); // a ostatni wycinam
		$_POST['nazwa'] = Czysc($_POST['nazwa']);
		$_POST['opis'] = Czysc($_POST['opis']);
	
		$sql = "INSERT INTO `produkty_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `opis` = '".$_POST[opis]."', `kategoria` = '".$_POST[nazwapl1]."', `branza` = '".$_POST[nazwapl2]."', `cechy` = '".$cechy."', `prototyp` = '".$_POST[prototyp]."', `logowanie` = '".$_POST[logowanie]."', `nowosc` = '".$_POST[nowosc]."'";
		$sql .= ", seo_title='".$_POST[seo_title]."' ,seo_desc='".$_POST[seo_desc]."',seo_key='".$_POST[seo_key]."' ";
		$result = mysql_query($sql);
		$id = mysql_insert_id();
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>New product added.<br /><i class="icon-camera"></i> <a href="javascript:popup(\'zdjecia_produkty.php?produkt='.$id.'\')">Add photos to added product</a>.</h5>';
		echo '<a class="btn btn-success" href="'.$_SERVER[SCRIPT_NAME].'?site=dodaj_produkt">Add next product</a>';
		echo '</div>';
	}
	else {
		echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th style="min-width:120px;">Name</th>
                  <th>Description</th>
                  <th style="min-width:110px;">Category</th>
                  <th style="min-width:80px;">Trade</th>
				  <th>Features</th>
				  <th style="width:95px;">New</th>
				  <th style="width:95px;">Prototype</th>
				  <th>Login</th>				  
				  <th style="width:60px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
    
    
		$sql = "SELECT nazwa FROM `kategorie_$cmslang` WHERE `id`='".$row['kategoria']."'";
		$res1 = mysql_query($sql);		
		$row1 = mysql_fetch_assoc($res1);
		$sql = "SELECT nazwa FROM `branze_$cmslang` WHERE `id`='".$row['branza']."'";
		$res2 = mysql_query($sql);		
		$row2 = mysql_fetch_assoc($res2);
		$sql = "SELECT id,nazwa,opis FROM `cechy_$cmslang` WHERE `id` IN (".$row['cechy'].")";
		$res3 = mysql_query($sql);		
		
		echo '<tr><form method="post" action="index.php?site=dodaj_produkt&action=zapisz">
				<td><input style="font-size:12px;width:auto;" type="text" name="nazwa" id="nazwa_pl"></td>
				<td><textarea style="font-size:12px;line-height:14px;width:90%" rows="10" id="opis" name="opis"></textarea></td>
				<td><select style="font-size:12px;width:auto;" name="nazwapl1" style="font-size:12px;width:auto;">';
					$sql = "SELECT id,nazwa FROM `kategorie_$cmslang` WHERE `widocznosc`='yes'";
					$res4 = mysql_query($sql);
					while($row4 = mysql_fetch_assoc($res4)) {					
						if ($row1['nazwa'] == $row4['nazwa'])  $sel = ' selected'; 
						echo '<option value="'.$row4['id'].'"'.$sel.'>'.$row4['nazwa'].'</option>';
						$sel = '';
					}
				echo '</td>
				<td><select style="font-size:12px;width:auto;" name="nazwapl2" style="font-size:12px;width:auto;">';
					$sql = "SELECT id,nazwa FROM `branze_$cmslang` WHERE `widocznosc`='yes'";
					$res4 = mysql_query($sql);
					while($row4 = mysql_fetch_assoc($res4)) {					
						if ($row2['nazwa'] == $row4['nazwa'])  $sel = ' selected'; 
						echo '<option value="'.$row4['id'].'"'.$sel.'>'.$row4['nazwa'].'</option>';
						$sel = '';
					}				
				echo '</td>
				<td><select style="font-size:12px;width:auto;" name="nazwapl3[]" multiple style="font-size:12px;width:auto;" size="10">';
					//if (!$res3) echo '<option value="0" selected>BRAK</option>';
					//echo '<option>'.$res3.'</option>';
					$sql = "SELECT id,nazwa,opis FROM `cechy_$cmslang` WHERE `widocznosc`='yes'";
					$res4 = mysql_query($sql);						
					while($row4 = mysql_fetch_assoc($res4)) {						
						while($row3 = mysql_fetch_assoc($res3)) {
							if ($row3 == $row4)  $sel = ' selected';				
						}						
						echo '<option value="'.$row4['id'].'"'.$sel.'>'.$row4['nazwa'].': '.$row4['opis'].'</option>';
						$sel = '';
						mysql_data_seek($res3, 0);
					}
						if ($row['cechy'] == '0') $sel = ' selected';
						echo '<option value="0"'.$sel.'>NOTHING</option>'; // to wstaw 0
						
				echo '</td>';
				//$row[prototyp]=='yes'?$yesp=' checked':$nop=' checked';
				echo '<td><input type="radio" name="nowosc" id="nowosc" value="0" checked> no<br /><input type="radio" name="nowosc" id="nowosc" value="1"> yes </td>';
				echo '<td><input type="radio" name="prototyp" id="prototyp" value="0" checked> no<br /><input type="radio" name="prototyp" id="prototyp" value="1"> yes </td>';
				//$row[logowanie]=='yes'?$yesl=' checked':$nol=' checked';
				echo '<td nowrap><input type="radio" name="logowanie" id="logowanie" value="0" checked> no<br /><input type="radio" name="logowanie" id="logowanie" value="1"> yes </td>';
				echo '<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></tr>';
				echo '<tr class="warning"><td><b>SEO Title</b></td><td colspan="2"><input class="input-xlarge" type="text" name="seo_title" id="seo_title" value="'.$row["seo_title"].'">';
				echo '<td><b>SEO Desc</b></td><td colspan="8"><textarea name="seo_desc" rows="2">'.$row["seo_desc"].'</textarea></td></tr>';
				echo '<tr class="warning"><td><b>SEO KeyWords</b></td><td colspan="9"><input class="input-xlarge" type="text" name="seo_key" id="seo_key" value="'.$row["seo_key"].'"></td></form></tr>';

	}
				echo '</tbody></table></div>';
?>