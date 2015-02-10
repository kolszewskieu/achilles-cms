<?
// sprawdzamy ile jest wszystkich rekordow
$result = mysql_query("SELECT Count(id) FROM `kategorie_$cmslang`");
$row = mysql_fetch_row($result);
$count_kateg = $row[0];
 
// ustawiamy ile ma być wyników na 1 strone
$per_page = 20;
 
// obliczamy ilość stron
$pages = ceil($count_kateg / $per_page);
 
// aktualna strona - jeśli nie została podana to = 1
// jeśli została podana to filtrujemy ją i rzutujemy na int
$current_page = !isset($_GET['page']) ? 1 : (int)Czysc($_GET['page']);
 
// jeśli ktoś poda stronę mniejszą niż 1 lub większą niż ilość stron to zmieniamy ją na 1
if($current_page < 1 || $current_page > $pages) {
    $current_page = 1;
}

// jeśli jest chociaż 1 rekord to wyświetlamy
// wersja na table
if($count_kateg > 0) {
	echo '<div class="row-fluid" style="font-size:12px;">
		<table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
					<th style="width:8%">Prio <a href="index.php?site=kategorie&sort=prio%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=kategorie&sort=prio%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>
					<th style="width:20%">Name <a href="index.php?site=kategorie&sort=nazwa%20ASC&page=1"><i class="icon-arrow-up"></i></a> <a href="index.php?site=kategorie&sort=nazwa%20DESC&page=1"><i class="icon-arrow-down"></i></a></th>			
					<th style="width:10%">Visible</th>	  
					<th style="width:40%">Description </th>
					<th style="width:15%;min-width:200px;">Photos</th>
					<th style="width:10%;min-width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
	if($_GET[prio_up]){
		$prio_tmp=$count_kateg+1;
		$new_prio=$_GET[prio_up]-1;
		$sql="UPDATE `kategorie_$cmslang` SET prio='$prio_tmp' WHERE prio=".$_GET[prio_up]."";
		mysql_query($sql);
		$sql="UPDATE `kategorie_$cmslang` SET prio='".$_GET[prio_up]."' WHERE prio=$new_prio";
		mysql_query($sql);
		$sql="UPDATE `kategorie_$cmslang` SET prio='$new_prio' WHERE prio=".$prio_tmp."";
		mysql_query($sql);
	}
	if($_GET[prio_down]){
		$prio_tmp=$count_kateg+1;
		$new_prio=$_GET[prio_down]+1;
		$sql="UPDATE `kategorie_$cmslang` SET prio='$prio_tmp' WHERE prio=".$_GET[prio_down]."";
		mysql_query($sql);
		$sql="UPDATE `kategorie_$cmslang` SET prio='".$_GET[prio_down]."' WHERE prio=$new_prio";
		mysql_query($sql);
		$sql="UPDATE `kategorie_$cmslang` SET prio='$new_prio' WHERE prio=".$prio_tmp."";
		mysql_query($sql);	
	}
	if ($action == 'zapisz') {		
		$_POST['nazwa'] = Czysc($_POST['nazwa']);		
		$_POST['opis'] = Czysc($_POST['opis']);	
		$sql = "UPDATE `kategorie_$cmslang` SET `nazwa` = '".$_POST[nazwa]."', `opis` = '".$_POST[opis]."', `widocznosc` = '".$_POST[widocznosc]."'";
		$sql .= ",seo_title='".$_POST[seo_title]."' ,seo_desc='".$_POST[seo_desc]."',seo_key='".$_POST[seo_key]."' ";
		$sql .= " WHERE `id` = '".$kategoria."'";		
		$result = mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Changes have been saved.</h5></div>';	
	}
	if ($action == 'usun') {		
		$sql = "DELETE FROM `kategorie_$cmslang` WHERE `id` = '".$kategoria."'";		
		$result = mysql_query($sql);
		$sql = "UPDATE `kategorie_$cmslang` SET prio=prio-1 WHERE id>'".$kategoria."'";
		mysql_query($sql);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Rekord deleted.</h5></div>';	
	}
	if ($sort == '') { $sort = 'prio ASC'; } else { $sort = $_GET[sort]; }
    $result = mysql_query("SELECT * FROM `kategorie_$cmslang` ORDER BY ".$sort." LIMIT ".($per_page*($current_page-1)).", ".$per_page);
    while($row = mysql_fetch_assoc($result)) {
    	if (($action == 'edytuj') && ($kategoria == $row['id'])) {    		
    		$row[widocznosc]=='yes'?$yes=' checked':$no=' checked';    	
    		echo '<tr><form method="post" action="index.php?site=kategorie&kategoria='.$row['id'].'&action=zapisz&page='.$_GET[page].'">
				<td></td>
				<td><input style="font-size:12px;" type="text" name="nazwa" id="nazwa" value="'.$row['nazwa'].'"></td>
				<td><input type="radio" name="widocznosc" id="widocznosc" value="yes"'.$yes.'> yes <br /><input type="radio" name="widocznosc" id="widocznosc" value="no"'.$no.'> no </td>
				<td><textarea style="font-size:12px;line-height:14px;width:90%" rows="5" id="opis" name="opis">'.$row['opis'].'</textarea></td>
				<td rowspan="3"><div class="slides" style="margin: 0px -10px 0;"><ul style="margin: 0;">';
				PokazZdjeciaCms($row['zdjecia']);
				echo   '</ul></div><br /><i class="icon-camera"></i> <a href="javascript:popup(\'zdjecia_produkty.php?kategoria='.$row['id'].'\')">Add/delete photos</a></td>
				<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></tr>';
				echo '<tr class="warning"><td><b>SEO Title</b></td><td><input class="input-xlarge" type="text" name="seo_title" id="seo_title" value="'.$row["seo_title"].'"></td>';
				echo '<td><b>SEO Desc</b></td><td colspan="8"><textarea name="seo_desc" rows="2">'.$row["seo_desc"].'</textarea></td></tr>';
				echo '<tr class="warning"><td><b>SEO KeyWords</b></td><td colspan="9"><input class="input-xlarge" type="text" name="seo_key" id="seo_key" value="'.$row["seo_key"].'"></td></form></tr>';
    	} else {
    	
        echo  '<tr class="success"><td>'.$row['prio'].' ';
		if($row[prio]>1){
			echo '<a href="index.php?site=kategorie&sort='.$_GET[sort].'&prio_up='.$row[prio].'"><i class="icon-hand-up"></i></a>';
		}
		echo'&nbsp;';	
		if($row[prio]<$count_kateg){
			echo '<a href="index.php?site=kategorie&sort='.$_GET[sort].'&prio_down='.$row[prio].'"><i class="icon-hand-down"></i></a>';
		}
		echo  '</td><td>'.$row['nazwa'].'<br/>';
		echo '<b>SEO Title</b>: '.$row["seo_title"].'<br/>';
		echo '<b>SEO Desc</b>: '.$row["seo_desc"].'<br/>';
		echo '<b>SEO KeyWords</b>: '.$row["seo_key"].'<br/>';	
		echo '</td>';
		
		echo '<td style="width:80px;"';
				$dodaj = '';
				if ($row['widocznosc']=='no') { $dodaj = ' style="background-color:#FF0000"'; }
		echo    $dodaj.'>'.$row['widocznosc'].'</td>				
				<td>'.$row['opis'].'</td>
				<td><div class="slides" style="margin: 0px -10px 0;"><ul style="margin: 0;">';
        PokazZdjeciaCms($row['zdjecia']);
		echo   '</ul></div><br /><i class="icon-camera"></i> <a href="javascript:popup(\'zdjecia_produkty.php?kategoria='.$row['id'].'\')">Add/delete photos</a></td><td>
				<i class="icon-edit"></i> <a href="index.php?site=kategorie&sort='.$sort.'&kategoria='.$row['id'].'&action=edytuj&page='.$page.'">Edit</a><br /><i class="icon-trash"></i> <a href="index.php?site=kategorie&sort='.$sort.'&kategoria='.$row['id'].'&action=usun" class="btn-danger" onClick="if(confirm(\'Delete this rekord?\')){return true;}else{return false;}">Delete</a></td>				
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
                echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
    } elseif($current_page > 10) {
        echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page=1">1</a></li> ';
        echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page=2">2</a></li> ';
        echo '[...] ';
        for($i = ($current_page-3); $i <= $current_page; $i++) {
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        for($i = ($current_page+1); $i <= ($current_page+3); $i++) {
            if($i > ($pages)) break;
            if($i == $current_page) {
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($current_page < ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($current_page == ($pages-4)) {
            echo '[...] ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        }
    } else {
        for($i = 1; $i <= 11; $i++) {
            if($i == $current_page) {
                if($i > ($pages)) break;
                echo '<li class="active"><a href="#">'.$current_page.'</a></li> ';
            } else {
                echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$i.'">'.$i.'</a></li> ';
            }
        }
        if($pages > 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.($pages-1).'">'.($pages-1).'</a></li> ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page='.$pages.'">'.$pages.'</a></li> ';
        } elseif($pages == 12) {
            echo '[...] ';
            echo '<li><a href="index.php?site=kategorie&sort='.$sort.'&page=12">12</a></li> ';
        }
    }
    echo ' </ul></div>';
}
?>