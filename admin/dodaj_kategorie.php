<?
	if ($action == 'zapisz') {		
				
		$_POST['nazwa'] = Czysc($_POST['nazwa']);		
		$_POST['opis'] = Czysc($_POST['opis']);		
				
		$sql = "INSERT INTO `kategorie_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `opis` = '".$_POST[opis]."', `widocznosc` = '".$_POST[widocznosc]."' ";
		$sql .= ",seo_title='".$_POST[seo_title]."' ,seo_desc='".$_POST[seo_desc]."',seo_key='".$_POST[seo_key]."' ";
		$result = mysql_query($sql);
		$id = mysql_insert_id();		
		$sql= "SELECT MAX(prio)+1 FROM `kategorie_$cmslang`";
		list($mprio)=mysql_fetch_row(mysql_query($sql));
		$sql = "UPDATE `kategorie_$cmslang` SET `prio` = $mprio WHERE id=$id";
		mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>New category added.<br /><i class="icon-camera"></i> <a href="javascript:popup(\'zdjecia_kategorie.php?kategoria='.$id.'\')">Add photos to added category</a>.</h5></div>';		
	}
	else {
		echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th style="width:20%">Name</th>			
				  <th style="width:10%">Visible</th>	  
				  <th style="width:50%">Description</th>				
				  <th style="width:20%;min-width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
    
    	
		
		echo '<tr><form method="post" action="index.php?site=dodaj_kategorie&action=zapisz">
				<td><input style="font-size:12px;" type="text" name="nazwa" id="nazwa"></td>
				<td><input type="radio" name="widocznosc" id="widocznosc" value="yes" checked> yes <br /><input type="radio" name="widocznosc" id="widocznosc" value="no"> no </td>
				<td><textarea style="font-size:12px;line-height:14px;width:90%" rows="5" id="opis" name="opis"></textarea></td>
				<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></tr>';
				echo '<tr class="warning"><td><b>SEO Title</b></td><td colspan="9"><input class="input-xlarge" type="text" name="seo_title" id="seo_title" value="'.$row["seo_title"].'"></td></tr>';
				echo '<tr class="warning"><td><b>SEO Desc</b></td><td colspan="9"><textarea name="seo_desc" rows="2">'.$row["seo_desc"].'</textarea></td></tr>';
				echo '<tr class="warning"><td><b>SEO KeyWords</b></td><td colspan="9"><input class="input-xlarge" type="text" name="seo_key" id="seo_key" value="'.$row["seo_key"].'"></td></form></tr>';
	}
				echo '</tbody></table></div>';
		 

?>