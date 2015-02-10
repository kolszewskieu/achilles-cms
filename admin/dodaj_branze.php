<?

	
	if ($action == 'zapisz') {		
				
		$_POST['nazwa'] = Czysc($_POST['nazwa']);		
		$_POST['opis'] = Czysc($_POST['opis']);		
		
		$sql = "INSERT INTO `branze_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `widocznosc` = '".$_POST[widocznosc]."'";
		if(mysql_query($sql)){
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>New trade added.</h5></div>';
		}else{
			echo mysql_error();
		}
	}
	else {
		echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th style="width:70%">Name</th>			
				  <th style="width:10%">Visible</th>				 				
				  <th style="width:20%;min-width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
    
    	
		
		echo '<tr><form method="post" action="index.php?site=dodaj_branze&action=zapisz">
				<td><input style="font-size:12px;" type="text" name="nazwa" id="nazwa"></td>
				<td><input type="radio" name="widocznosc" id="widocznosc" value="yes" checked> yes <br /><input type="radio" name="widocznosc" id="widocznosc" value="no"> no </td>								
				<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td>
				</form></tr>';
	}
				echo '</tbody></table></div>';
		 

?>