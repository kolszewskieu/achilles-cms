<?
// sprawdzamy ilu jest wszystkich userów
$in = $_SESSION[admin];
$in = str_replace (",", "','", $in);
$sql = "SELECT Count(id) FROM `uzytkownicy` WHERE `jezyk` IN ('$in')";
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$count_prod = $row[0];
 
// ustawiamy ile ma być wyników na 1 strone
$per_page = 10;
 
// obliczamy ilość stron
$pages = ceil($count_prod / $per_page);
 
// aktualna strona - jeśli nie została podana to = 1
// jeśli została podana to filtrujemy ją i rzutujemy na int
$current_page = !isset($_GET['page']) ? 1 : (int)Czysc($_GET['page']);
 
// jeśli ktoś poda stronę mniejszą niż 1 lub większą niż ilość stron to zmieniamy ją na 1
if($current_page < 1 || $current_page > $pages) {
    $current_page = 1;
}

// jeśli jest chociaż 1 user to wyświetlamy
// wersja na table
if($count_prod > 0) {
	echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th>Name</th>
                  <th>Surname</th>
                  <th>E-mail</th>
				  <th>Password</th>                  
				  <th>Company</th>
				  <th>Address</th>
				  <th>Telephone</th>';
				  if ($cmslang == 'pl') echo '<th>Wojewodztwo</th>';
				  echo '<th>Newsletter</th>
				  <th>Active</th>
				  <th>Language</th>
				  <th>Admin</th>
				  <th>Pricing</th>
				  <th style="width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
    if ($_GET[action] == 'zapisz') {
    	$_POST['email'] = Czysc($_POST['email']);
	    $_POST['imie'] = Czysc($_POST['imie']);
    	$_POST['nazwisko'] = Czysc($_POST['nazwisko']);
    	$_POST['new_password'] = Czysc($_POST['new_password']);
    	$_POST['new_password2'] = Czysc($_POST['new_password2']);    	
		$_POST['firma'] = Czysc($_POST['firma']);
		$_POST['adres'] = Czysc($_POST['adres']);
		$_POST['telefon'] = Czysc($_POST['telefon']);
		for($i = 0; $i < count($_POST[adminx]); $i++) { //adminy z multiple selecta poki sa
			$adminx .= $_POST[adminx][$i].','; // sobie listuje z przecinkiem
		}		
		$adminx = rtrim($adminx, ','); // a ostatni wycinam
		//echo 'ad '.$adminx;
		
  		if(!empty($_POST['new_password'])) {                
        	if($_POST['new_password'] != $_POST['new_password2']) {
            	$err = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><h5>Passwords are different.</h5></div>';
                } else {
                    $up2.= ", `password` = '".KodujHaslo($_POST['new_password'])."'";
                }
            }
            if(!empty($err)) {
            	echo $err;
            } else {
		$sql = "UPDATE `uzytkownicy` SET `imie` = '{$_POST['imie']}', `nazwisko` = '{$_POST['nazwisko']}', `email` = '{$_POST['email']}', `firma` = '{$_POST['firma']}', `adres` = '{$_POST['adres']}', `wojewodztwo` = '{$_POST['wojewodztwo']}', `telefon` = '{$_POST['telefon']}', `dataedycji` = '".time()."', `newsletter` = '{$_POST['newsletter']}', `aktywne` = '{$_POST['aktywne']}', `admin` = '{$adminx}',pricing='$_POST[pricing]', `jezyk` = '{$_POST['jezyk']}'{$up2} WHERE `id` = '".$_GET[user]."'";
			if(mysql_query($sql)){
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Rekord has been changed.</h5></div>';
			}else{
				echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h5>Problem. <br/>'.mysql_error().'</h5></div>';
			}
		}
	}
	if ($action == 'usun') {
		$sql = "DELETE FROM `uzytkownicy` WHERE `id` = '".$_GET[user]."'";
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>User deleted.</h5></div>';
	}	
	if ($sort == '') { $sort = 'id ASC'; } else { $sort = $_GET[sort]; }	
    $result = mysql_query("SELECT * FROM `uzytkownicy` WHERE `jezyk` IN ('$in') ORDER BY ".$sort." LIMIT ".($per_page*($current_page-1)).", ".$per_page);
    while($row = mysql_fetch_assoc($result)) {		
		if (($_GET[action] == 'edytuj') && ($_GET[user] == $row['id'])){
			echo '<tr><form method="post" action="index.php?site=userzy&user='.$row['id'].'&action=zapisz&page='.$page.'">
				<td><input style="font-size:12px;width:100%;" type="text" name="imie" id="imie" value="'.$row['imie'].'"><br />
					<input style="font-size:10px;width:100%;" type="text" name="new_password" id="new_password" placeholder="Możesz wpisać nowe hasło"></td>
				<td><input style="font-size:12px;width:100%;" type="text" name="nazwisko" id="nazwisko" value="'.$row['nazwisko'].'"><br />
					<input style="font-size:10px;width:100%;" type="text" name="new_password2" id="new_password2" placeholder="Powtórz nowe hasło"></td>
				<td><input style="font-size:12px;width:100%;" type="text" name="email" id="email" value="'.$row['email'].'"></td>
				<td></td>
				<td><input style="font-size:12px;width:100%;" type="text" name="firma" id="firma" value="'.$row['firma'].'"></td>
				<td><input style="font-size:12px;width:100%;" type="text" name="adres" id="adres" value="'.$row['adres'].'"></td>
				<td><input style="font-size:12px;width:100%;" type="text" name="telefon" id="telefon" value="'.$row['telefon'].'"></td>';
				if ($cmslang == 'pl') { echo '<td><select style="font-size:12px;width:auto;" id="wojewodztwo" name="wojewodztwo">
					<option value="1"';if($row[wojewodztwo]=='1')echo 'selected="selected"';echo'>Dolnośląskie</option>
					<option value="2"';if($row[wojewodztwo]=='2')echo 'selected="selected"';echo'>Kujawsko-Pomorskie</option>
					<option value="14"';if($row[wojewodztwo]=='14')echo 'selected="selected"';echo'>Łódzkie</option>
					<option value="3"';if($row[wojewodztwo]=='3')echo 'selected="selected"';echo'>Lubelskie</option>
					<option value="4"';if($row[wojewodztwo]=='4')echo 'selected="selected"';echo'>Lubuskie</option>
					<option value="6"';if($row[wojewodztwo]=='6')echo 'selected="selected"';echo'>Małopolskie</option>
					<option value="5"';if($row[wojewodztwo]=='5')echo 'selected="selected"';echo'>Mazowieckie</option>
					<option value="7"';if($row[wojewodztwo]=='7')echo 'selected="selected"';echo'>Opolskie</option>
					<option value="8"';if($row[wojewodztwo]=='8')echo 'selected="selected"';echo'>Podkarpackie</option>
					<option value="9"';if($row[wojewodztwo]=='9')echo 'selected="selected"';echo'>Podlaskie</option>
					<option value="10"';if($row[wojewodztwo]=='10')echo 'selected="selected"';echo'>Pomorskie</option>
					<option value="15"';if($row[wojewodztwo]=='15')echo 'selected="selected"';echo'>Śląskie</option>
					<option value="16"';if($row[wojewodztwo]=='16')echo 'selected="selected"';echo'>Świętokrzyskie</option>
					<option value="11"';if($row[wojewodztwo]=='11')echo 'selected="selected"';echo'>Warmińsko-Mazurskie</option>
					<option value="12"';if($row[wojewodztwo]=='12')echo 'selected="selected"';echo'>Wielkopolskie</option>
					<option value="13"';if($row[wojewodztwo]=='13')echo 'selected="selected"';echo'>Zachodniopomorskie</option>
			        </select>						
				</td>';
				}
				$row[newsletter]=='yes'?$yesn=' checked':$non=' checked';
				echo '<td><input type="radio" name="newsletter" id="newsletter" value="no"'.$non.'> no<br /><input type="radio" name="newsletter" id="newsletter" value="yes"'.$yesn.'> yes </td>';
				$row[aktywne]=='yes'?$yesa=' checked':$noa=' checked';
				echo '<td><input type="radio" name="aktywne" id="aktywne" value="no"'.$noa.'> no<br /><input type="radio" name="aktywne" id="aktywne" value="yes"'.$yesa.'> yes </td>';		
				$jezyki = explode (",", $_SESSION[admin]);
				$admin = explode (",", $row[admin]);								
				echo '<td><select style="font-size:12px;width:auto;" name="jezyk" style="font-size:12px;width:auto;">';
				foreach ($jezyki as $value) {
					if ($value == $row[jezyk]) $selected = ' selected="selected"';
					echo '<option value="'.$value.'"'.$selected.'>'.$value.'</option>';
					$selected = '';
				}
				echo '</select></td>';	
				echo '<td><select style="font-size:12px;width:auto;" name="adminx[]" multiple style="font-size:12px;width:auto;" size="5">
				<option value="not"';
				if($admin[0]=='not')echo ' selected="selected"';
				echo '>not</option>';
				foreach ($jezyki as $value) {
					foreach ($admin as $value2) {
						if ($value2 == $value) $selected = ' selected="selected"';
					}
					echo '<option value="'.$value.'"'.$selected.'>'.$value.'</option>';
					$selected = '';
				}
				echo '</select></td>';
				if($row[pricing]=='yes')$yesn=' checked';
				if($row[pricing]=='no')$non=' checked';
				if($row[pricing]=='full')$yesf=' checked';
				echo '<td><input type="radio" name="pricing" id="pricing" value="no"'.$non.'> no
				<br /><input type="radio" name="pricing" id="pricing" value="yes"'.$yesn.'> yes 
				<br /><input type="radio" name="pricing" id="pricing" value="full"'.$yesf.'> full ';
				echo '</td>';
				echo '<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></form></tr>';				
			
		} else {
			if ($row[admin]!='not') $class=' class="warning"';
			if ($_GET[action] == 'zapisz' && $_GET[user] == $row['id']) $class=' class="info"';
        echo   '
                <tr'.$class.'>
                <td>'.$row['imie'].'</td>
				<td>'.$row['nazwisko'].'</td>				
				<td>'.$row['email'].'</td>
				<td>';
        		$pwd='nie';
				if ($row[password]!='') $pwd='tak';
				echo $pwd.'</td>
				<td>'.$row['firma'].'</td>
				<td>'.$row['adres'].'</td>
				<td>'.$row['telefon'].'</td>';
				if ($cmslang == 'pl') { echo '<td>';
				if($row[wojewodztwo]=='1')echo 'Dolnośląskie';
        		if($row[wojewodztwo]=='2')echo 'Kujawsko-Pomorskie';
        		if($row[wojewodztwo]=='14')echo 'Łódzkie';
        		if($row[wojewodztwo]=='3')echo 'Lubelskie';
        		if($row[wojewodztwo]=='4')echo 'Lubuskie';
        		if($row[wojewodztwo]=='6')echo 'Małopolskie';
        		if($row[wojewodztwo]=='5')echo 'Mazowieckie';
        		if($row[wojewodztwo]=='7')echo 'Opolskie';
        		if($row[wojewodztwo]=='8')echo 'Podkarpackie';
        		if($row[wojewodztwo]=='9')echo 'Podlaskie';
        		if($row[wojewodztwo]=='10')echo 'Pomorskie';
        		if($row[wojewodztwo]=='15')echo 'Śląskie';
        		if($row[wojewodztwo]=='16')echo 'Świętokrzyskie';
        		if($row[wojewodztwo]=='11')echo 'Warmińsko-Mazurskie';
        		if($row[wojewodztwo]=='12')echo 'Wielkopolskie';
        		if($row[wojewodztwo]=='13')echo 'Zachodniopomorskie';
				echo '</td>'; 
				}
				echo '<td>'.$row['newsletter'].'</td>
				<td>'.$row['aktywne'].'</td>
				<td>'.$row['jezyk'].'</td>
				<td>'.$row['admin'].'</td>
				<td>'.$row['pricing'].'</td>
				<td><i class="icon-edit"></i> <a href="index.php?site=userzy&sort='.$sort.'&user='.$row['id'].'&action=edytuj&page='.$page.'">Edit</a><br />
				<nowrap><i class="icon-trash"></i><a href="index.php?site=userzy&sort='.$sort.'&user='.$row['id'].'&action=usun&page='.$page.'" class="btn-danger" onClick="if(confirm(\'Chcesz usunąć tego użytkownika?\')){return true;}else{return false;}">Delete</a></nowrap></td>
				</tr>';	
				$class='';
		 
		}
    }
} else {
    // jeśli nie ma w ogóle to wyświetlamy komunikat
    echo '<h4>Niestety nie znaleziono żadnych danych.</h4>';
}
echo '</tbody></table></div>';  

// wyświetlamy stronicowanie
if($pages > 0) { 
    echo '<div class="pagination pagination-centered"><ul>';
    if($pages < 11) {
        for($i = 1; $i <= $pages; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a> ';
            } else {
                echo '<li><a href="index.php?site=userzy&page='.$i.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="index.php?site=userzy&page=1">1</a></li> ';
        echo '<li><a href="index.php?site=userzy&page=2">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=userzy&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=userzy&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=userzy&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=userzy&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=userzy&page='.$pages.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=userzy&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=userzy&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=userzy&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=userzy&page=12">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}

?>