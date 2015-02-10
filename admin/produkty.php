<?
// sprawdzamy ile jest wszystkich produktow
$result = mysql_query("SELECT Count(id) FROM `produkty_$cmslang`");
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

// wyświetlamy stronicowanie
if($pages > 0) { 
    echo '<div class="pagination pagination-centered"><ul>';
    if($pages < 11) {
        for($i = 1; $i <= $pages; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=1">1</a></li> ';
        echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=2">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=12">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}

// jeśli jest chociaż 1 produkt to wyświetlamy
// wersja na table
if($count_prod > 0) {
	echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th>Name <a href="index.php?site=produkty&sort=nazwa_pl%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=nazwa_pl%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
                  <th>Description</th>
                  <th nowrap=1>Category <a href="index.php?site=produkty&sort=kategoria%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=kategoria%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
                  <th>Trade <a href="index.php?site=produkty&sort=branza%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=branza%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
				  <th>Features</th>
				  <th nowrap=1>New <a href="index.php?site=produkty&sort=nowosc%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=prototyp%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
				  <th nowrap=1>Proto <a href="index.php?site=produkty&sort=prototyp%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=prototyp%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
				  <th nowrap=1>Login <a href="index.php?site=produkty&sort=logowanie%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=produkty&sort=logowanie%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
				  <th style="width:200px;">Photos</th>
				  <th>Edit</th>
                </tr>
              </thead>
              <tbody>';
	if ($action == 'zapisz') {		
		for($i = 0; $i < count($_POST[nazwapl3]); $i++) { //cechy z multiple selecta poki sa
			$cechy .= $_POST[nazwapl3][$i].','; // sobie listuje z przecinkiem
		} 
		$cechy = rtrim($cechy, ','); // a ostatni wycinam
		$sql = "UPDATE `produkty_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `opis` = '".$_POST[opis]."', `kategoria` = '".$_POST[nazwapl1]."', `branza` = '".$_POST[nazwapl2]."', `cechy` = '".$cechy."', `prototyp` = '".$_POST[prototyp]."', `logowanie` = '".$_POST[logowanie]."', `nowosc` = '".$_POST[nowosc]."' ";
		$sql .= ",seo_title='".$_POST[seo_title]."' ,seo_desc='".$_POST[seo_desc]."',seo_key='".$_POST[seo_key]."' ";
		$sql .= " WHERE `id` = '".$produkt."'";
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Changes have been saved.</h5></div>';
	}
	if ($action == 'usun') {
		$sql = "DELETE FROM `produkty_$cmslang` WHERE `id` = '".$produkt."'";
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><h5>Record deleted.</h5></div>';
	}
	if ($sort == '') { $sort = 'id DESC'; } else { $sort = $_GET[sort]; }	
    $result = mysql_query("SELECT * FROM `produkty_$cmslang` ORDER BY ".$sort." LIMIT ".($per_page*($current_page-1)).", ".$per_page);
    while($row = mysql_fetch_assoc($result)) {
		$sql = "SELECT nazwa FROM `kategorie_$cmslang` WHERE `id`='".$row['kategoria']."'";
		$res1 = mysql_query($sql);		
		$row1 = mysql_fetch_assoc($res1);
		$sql = "SELECT nazwa FROM `branze_$cmslang` WHERE `id`='".$row['branza']."'";
		$res2 = mysql_query($sql);		
		$row2 = mysql_fetch_assoc($res2);
		if($row['cechy']){
			$sql = "SELECT id,nazwa,opis FROM `cechy_$cmslang` WHERE `id` IN (".$row['cechy'].")";
			$res3 = mysql_query($sql);
		}
		if (($action == 'edytuj') && ($produkt == $row['id'])) {
			echo '<tr class="warning"><form method="post" action="index.php?site=produkty&produkt='.$row['id'].'&action=zapisz&page='.$page.'">
				<td colspan=2>';
					
						echo '<input class="input-large" type="text" name="nazwa" id="nazwa" value="'.$row["nazwa"].'"><br />';
						echo '<textarea rows="4" name="opis" id="opis">'.$row["opis"].'</textarea>';
			echo '</td>';
//				<td>';
//						echo '<textarea style="font-size:12px;line-height:14px;width:90%" rows="4" id="opis" name="opis">'.$row["opis"].'</textarea><br />';
										
			echo '</td>
				<td colspan=2><select style="font-size:12px;width:auto;" name="nazwapl1">';
					$sql = "SELECT id,nazwa FROM `kategorie_$cmslang` ";
					//WHERE `widocznosc`='yes'";
					$res4 = mysql_query($sql);
					while($row4 = mysql_fetch_assoc($res4)) {					
						if ($row1['nazwa'] == $row4['nazwa'])  $sel = ' selected'; 
						echo '<option value="'.$row4['id'].'"'.$sel.'>'.$row4['nazwa'].'</option>';
						$sel = '';
					}
				echo '</select><br/>
				<b>Trade:</b><br/>
				<select style="font-size:12px;width:auto;" name="nazwapl2">';
					$sql = "SELECT id,nazwa FROM `branze_$cmslang` WHERE `widocznosc`='yes'";
					$res4 = mysql_query($sql);
					while($row4 = mysql_fetch_assoc($res4)) {					
						if ($row2['nazwa'] == $row4['nazwa'])  $sel = ' selected'; 
						echo '<option value="'.$row4['id'].'"'.$sel.'>'.$row4['nazwa'].'</option>';
						$sel = '';
					}				
				echo '</select></td>
				<td><select style="font-size:12px;width:auto;" name="nazwapl3[]" multiple size="10">';
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
				$row[nowosc]=='1'?$yesn=' checked':$non=' checked';
				echo '<td nowrap><input type="radio" name="nowosc" id="nowosc" value="0"'.$nop.'> no<br /><input type="radio" name="nowosc" id="prototyp" value="1"'.$yesp.'> yes </td>';
				$row[prototyp]=='1'?$yesp=' checked':$nop=' checked';
				echo '<td><input type="radio" name="prototyp" id="prototyp" value="0"'.$nop.'> no<br /><input type="radio" name="prototyp" id="prototyp" value="1"'.$yesp.'> yes </td>';
				$row[logowanie]=='1'?$yesl=' checked':$nol=' checked';
				echo '<td><input type="radio" name="logowanie" id="logowanie" value="0"'.$nol.'> no<br /><input type="radio" name="logowanie" id="logowanie" value="1"'.$yesl.'> yes </td>';
				echo '<td colspan=2><input type="submit" value="Save" class="btn btn-block btn-primary"></td></tr>';
				echo '<tr class="warning"><td><b>SEO Title</b></td><td colspan="2"><input class="input-xlarge" type="text" name="seo_title" id="seo_title" value="'.$row["seo_title"].'">';
				echo '<td><b>SEO Desc</b></td><td colspan="8"><textarea name="seo_desc" rows="2">'.$row["seo_desc"].'</textarea></td></tr>';
				echo '<tr class="warning"><td><b>SEO KeyWords</b></td><td colspan="9"><input class="input-xlarge" type="text" name="seo_key" id="seo_key" value="'.$row["seo_key"].'"></td></form></tr>';
		} else {
			echo '<tr>
				  <td>';
					echo $row["nazwa"].'<br />'; 
			echo '</td><td>';
					echo $row["opis"].'<br />';
					echo '<b>SEO Title</b>: '.$row["seo_title"].'<br/>';
					echo '<b>SEO Desc</b>: '.$row["seo_desc"].'<br/>';
					echo '<b>SEO KeyWords</b>: '.$row["seo_key"].'<br/>';					
			echo '</td><td>'.$row1['nazwa'].'</td>
					<td>'.$row2['nazwa'].'</td>
					<td>';
			if($res3){
				while($row3 = mysql_fetch_assoc($res3)) {
					echo $row3['nazwa'].': '.$row3['opis'].'<br />';
					}
			}
			echo	'</td>
					<td>'.$row['nowosc'].'</td>
					<td>'.$row['prototyp'].'</td>
					<td>'.$row['logowanie'].'</td>
					<td>';
				if($row['zdjecia']){
					echo '<div class="slides" style="margin: 0px -10px 0;"><ul style="margin: 0;">';
					PokazZdjeciaCms($row['zdjecia']);
					echo '</ul></div><br />';
				}
			echo   '<i class="icon-camera"></i><a href="javascript:popup(\'zdjecia_produkty.php?produkt='.$row['id'].'\')">Add/delete photos</a></td><td>
					<i class="icon-edit"></i><a href="index.php?site=produkty&sort='.$sort.'&produkt='.$row['id'].'&action=edytuj&page='.$page.'">Edit</a><br /><i class="icon-trash"></i> <a href="index.php?site=produkty&sort='.$sort.'&produkt='.$row['id'].'&action=usun&page='.$page.'" class="btn-danger" onClick="if(confirm(\'Delete this product?\')){return true;}else{return false;}">Delete</a></td>
					</tr>';			
		}
    }
} else {
    // jeśli nie ma w ogóle to wyświetlamy komunikat
    echo '<h4>No data found.</h4>';
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
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=1">1</a></li> ';
        echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=2">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=produkty&sort='.$sort.'&page=12">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}
?>