<?
// ustawiamy ile ma być wyników na 1 strone
$per_page = 30;
 
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
echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
		  <thead>
			<tr class="info">
			  <th>Page</th>
			  <th>SEO title</th>
			  <th>SEO desc</th>
			  <th>SEO keywords</th>
			  <th>From category</th>
			  <th>From product</th>
			  <th style="width:60px;">Edit</th>
			</tr>
		  </thead>
		  <tbody>';
if ($action == 'zapisz') {		
	$sql = "UPDATE `seo_tags_$cmslang` SET `seo_title` = '".$_POST[seo_title]."', `seo_desc` = '".$_POST[seo_desc]."', `seo_key` = '".$_POST[seo_key]."', `category` = '".$_POST[category]."', `product` = '".$_POST[product]."' WHERE `page` = '".$produkt."'";
	$result = mysql_query($sql);
	echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Changes have been saved.</h5></div>';
}
if ($sort == '') { $sort = 'id DESC'; } else { $sort = $_GET[sort]; }	
$result = mysql_query("SELECT * FROM `seo_tags_$cmslang` ");
//ORDER BY ".$sort." LIMIT ".($per_page*($current_page-1)).", ".$per_page);
while($row = mysql_fetch_assoc($result)) {
	if (($action == 'edytuj') && ($produkt == $row['page'])) {
		echo '<tr><form method="post" action="index.php?site=seo_tags&produkt='.$row['page'].'&action=zapisz">';
		echo '<tr>';
		echo '<td>'.$row[page].'</td>';
		echo '<td><input type="text" name="seo_title" id="seo_title" value="'.$row["seo_title"].'">';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" name="seo_key" id="seo_key" value="'.$row["seo_key"].'">';
		echo '</td>';
		echo '<td>';
		echo '<textarea rows="4" id="seo_desc" name="seo_desc">'.$row["seo_desc"].'</textarea>';
		echo '</td>';
		echo '<td>';
		echo '<input type="radio" name="category" value="1" '.($row[category]==1?'checked':'').'>yes &nbsp;';
		echo '<input type="radio" name="category" value="0" '.($row[category]==0?'checked':'').'>no';
		echo '</td>';
		echo '<td>';
		echo '<input type="radio" name="product" value="1" '.($row[product]==1?'checked':'').'>yes &nbsp;';
		echo '<input type="radio" name="product" value="0" '.($row[product]==0?'checked':'').'>no';
		echo '</td>';
		echo '<td><input type="submit" value="Save" class="btn btn-block btn-primary"></td></form></tr>';		
	} else {
		echo '<tr><td>'.$row[page].'</td>';
		echo '<td>'.$row[seo_title].'</td>';
		echo '<td>'.$row[seo_key].'</td>';
		echo '<td>'.$row[seo_desc].'</td>';
		echo '<td>'.($row[category]==1?'yes':'no').'</td>';
		echo '<td>'.($row[product]==1?'yes':'no').'</td>';

		echo '<td><i class="icon-edit"></i> <a href="index.php?site=seo_tags&sort='.$sort.'&produkt='.$row['page'].'&action=edytuj&page='.$page.'">Edit</a></td>';
		echo '</tr>';		 
	}
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