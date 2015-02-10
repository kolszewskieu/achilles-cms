<?
// sprawdzamy ilu jest wszystkich userów
$result = mysql_query("SELECT Count(id) FROM `cechy_$cmslang`");
$row = mysql_fetch_row($result);
$count_cechy = $row[0];
 
// ustawiamy ile ma być wyników na 1 strone
$per_page = 10;
 
// obliczamy ilość stron
$pages = ceil($count_cechy / $per_page);
 
// aktualna strona - jeśli nie została podana to = 1
// jeśli została podana to filtrujemy ją i rzutujemy na int
$current_page = !isset($_GET['page']) ? 1 : (int)Czysc($_GET['page']);
 
// jeśli ktoś poda stronę mniejszą niż 1 lub większą niż ilość stron to zmieniamy ją na 1
if($current_page < 1 || $current_page > $pages) {
    $current_page = 1;
}

// jeśli jest chociaż 1 user to wyświetlamy
// wersja na table
if($count_cechy > 0) {
	echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th style="width:60%;min-width:200px;">Name <a href="index.php?site=cechy&sort=nazwa%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=cechy&sort=nazwa%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>			
			      <th style="width:20%">Visible</th>                  
				  <th style="width:20%;">Edit</th>
                </tr>
              </thead>
              <tbody>';
	if ($action == 'zapisz') {
		$sql = "UPDATE `cechy_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `opis` = '".$_POST[opis]."', `widocznosc` = '".$_POST[widocznosc]."' WHERE `id` = '".$cecha."'";
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Changes have been saved.</h5></div>';
	}
	if ($action == 'usun') {
		$sql = "DELETE FROM `cechy_$cmslang` WHERE `id` = '".$cecha."'";
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Rekord deleted.</h5></div>';
	}
	if ($sort == '') { $sort = 'id ASC'; } else { $sort = $_GET[sort]; }
    $result = mysql_query("SELECT * FROM `cechy_$cmslang` ORDER BY ".$sort." LIMIT ".($per_page*($current_page-1)).", ".$per_page);
    while($row = mysql_fetch_assoc($result)) {
    	if (($action == 'edytuj') && ($cecha == $row['id'])) {    	
    		$row[widocznosc]=='yes'?$yes=' checked':$no=' checked';   
    		echo '<tr><form method="post" action="index.php?site=cechy&cecha='.$row['id'].'&action=zapisz&page='.$page.'">
    		<td><input style="font-size:12px;" type="text" name="nazwa" id="nazwa" value="'.$row['nazwa'].'"> <input style="font-size:12px;" type="text" name="opis" id="opis" value="'.$row['opis'].'"></td>
    		<td><input type="radio" name="widocznosc" id="widocznosc" value="yes"'.$yes.'> yes <br /><input type="radio" name="widocznosc" id="widocznosc" value="no"'.$no.'> no </td>
    		<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></form></tr>';
    	} else {
    		echo '<tr>
    		<td>'.$row['nazwa'].': '.$row['opis'].'</td><td style="width:80px;"'; echo $row[widocznosc]==no?' style="background-color:#FF0000"':''; echo '>'.$row['widocznosc'].'</td>    		
    		<td>
    		<i class="icon-edit"></i> <a href="index.php?site=cechy&sort='.$sort.'&cecha='.$row['id'].'&action=edytuj&page='.$page.'">Edit</a><br /><i class="icon-trash"></i> <a href="index.php?site=cechy&sort='.$sort.'&cecha='.$row['id'].'&action=usun&page='.$page.'" class="btn-danger" onClick="if(confirm(\'Delete this rekord?\')){return true;}else{return false;}">Delete</a></td>
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
                echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page=1">1</a></li> ';
        echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page=2">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=cechy&sort='.$sort.'&page=12">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}
?>