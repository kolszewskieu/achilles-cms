<?
$testGD = get_extension_funcs("gd"); // Grab function list 
if (!$testGD){ echo "GD not even installed."; exit; }

	$plik_tmp = $_FILES['plik']['tmp_name'];

	if(is_uploaded_file($plik_tmp)) {
		if(getimagesize($plik_tmp)==false)
		{
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h5>This is not image.</h5></div>';
			exit();
		}
		$plik_nazwa = strtolower(Czysc($_FILES['plik']['name']));
		if ($_POST['nazwa']) $plik_nazwa = strtolower(Czysc($_POST['nazwa']).'.png');
		//echo 'plik_nazwa '.$plik_nazwa;		
		if (($_FILES['plik']['type'] == "image/gif") || ($_FILES['plik']['type'] == "image/jpeg") || ($_FILES['plik']['type'] == "image/jpg")) {
			$image = imagecreatefromjpeg($plik_tmp);			
			imagepng($image, $plik_tmp);
			imagedestroy($image);
			$plik_nazwa = str_replace('.jpeg', '.png', $plik_nazwa);
			$plik_nazwa = str_replace('.jpg', '.png', $plik_nazwa);
			$plik_nazwa = str_replace('.gif', '.png', $plik_nazwa);
		}
		if($_POST[group]=="product"){$nh=300;$nw=300;$snh=290;$pnh=310;$snw=290;$pnw=310;}
		if($_POST[group]=="category"){$nh=334;$nw=500;$snh=330;$pnh=340;$snw=510;$pnw=490;}
//echo $_DIR_IMG;
		list($width, $height) = getimagesize($plik_tmp);
		if($width > $snw || $width<$pnw || $height>$snh && $height<$pnh){
			//echo $plik_tmp;
			$thumb = imagecreatetruecolor($nw,$nh);
			$source = imagecreatefrompng($plik_tmp);
			imagecopyresized($thumb, $source, 0, 0, 0, 0,$nw,$nh, $width, $height);
			imagepng($thumb, $plik_tmp);
			imagedestroy($thumb);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>';
			echo '<h5>Image resize to '.$nw.' x '.$nh.'. You can improve the quality. Upload file sizes '.$nw.' x '.$nh.'</h5>';
			echo '</div>';
		}
		function check_file_name($name){
			global $_DIR_IMG;
			global $plik_nazwa_n;
			if (file_exists($_DIR_IMG."/".$name)){
				$f=str_replace(".png","",$name);
				$ff=$f."_".$f.".png";
				check_file_name($ff);
			}else{
				$plik_nazwa_n=$name;
			}
		}
		check_file_name($plik_nazwa);		
		if ($plik_nazwa_n){
			move_uploaded_file($plik_tmp, $_DIR_IMG."/".$plik_nazwa_n);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Photo <i>'.$plik_nazwa_n.'</i> has been added.</h5></div>';
		}
		/*		move_uploaded_file($plik_tmp, "../img/tmp/$plik_nazwa");
			$sql="INSERT INTO zdjecia (plik) VALUES ('".$plik_nazwa."')";
			mysql_query($sql);
			$sql="SELECT MAX(id) FROM zdjecia WHERE plik='".$plik_nazwa."'";
			$res=mysql_query($sql);
			list($file_id)=mysql_fetch_row($res);
			if(!$file_id){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h5>Problem with add <i>'.$plik_nazwa.'</i></h5></div>';
				exit();
			}else{
				if(move_uploaded_file($plik_tmp, "../img/tmp/$plik_nazwa")){
					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Photo <i>'.$plik_nazwa.'</i> has been added.</h5></div>';
				}else{
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h5>Problem with add <i>'.$plik_nazwa.'</i></h5></div>';
					exit();
				}
			}
		*/			
	}
if($_GET[del] || $_GET[del_true]){
	$file_del=$_GET[del].$_GET[del_true];
	$sql = "SELECT id,nazwa,zdjecia FROM `produkty_".$cmslang."` WHERE `zdjecia` LIKE '%,".str_replace(".png","",$file_del).",%'";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$prod_with_file[$row[id]][nazwa]=$row[nazwa];
		$prod_with_file[$row[id]][zdjecia]=$row[zdjecia];
	}

	$sql = "SELECT id,nazwa,zdjecia FROM `kategorie_".$cmslang."` WHERE `zdjecia` LIKE '%,".str_replace(".png","",$file_del).",%'";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$cat_with_file[$row[id]][nazwa]=$row[nazwa];
		$cat_with_file[$row[id]][zdjecia]=$row[zdjecia];
	}
	if(($prod_with_file || $cat_with_file) && $_GET[del]){
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
		echo '<h4>File you want to delete</h4>';	
			if($prod_with_file){
				echo '<h5>is connect with products:</h5>';
				echo '<ol>';
					foreach($prod_with_file as $key => $val){
						echo '<li><a target="_blank" href="#'.$key.'">'.$val[nazwa].'</a></li>';
					}
				echo '</ol>';	
			}
			if($cat_with_file){
				echo '<h5>is connect with categories:</h5>';
				echo '<ol>';
					foreach($cat_with_file as $key => $val){
						echo '<li><a target="_blank" href="#'.$key.'">'.$val[nazwa].'</a></li>';
					}
				echo '</ol>';
			}
		echo '<a class="btn btn-small btn-success" href="'.$_SERVER[SCRIPT_NAME].'?site=dodaj_zdjecie&file_page='.$_GET[file_page].'&del_true='.$_GET[del].'">Delete file and disconect from objects</a>&nbsp;';
		echo '<a class="btn btn-small btn-danger" href="'.$_SERVER[SCRIPT_NAME].'?site=dodaj_zdjecie&file_page='.$_GET[file_page].'">Cenecel delete</a>';
		echo '</div>';
	}else{
		$_GET[del_true]=$_GET[del];
	}
	if($_GET[del_true]){
		if($prod_with_file){
			foreach($prod_with_file as $key => $val){
				$zdjecia_new=str_replace(",".str_replace(".png","",$_GET[del_true]).",",",",$val[zdjecia]);
				$sql="UPDATE produkty_".$cmslang." SET zdjecia='".$zdjecia_new."' WHERE id=".$key;
				if(mysql_query($sql)){
					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>';
					echo '<h5>Disconnect from product '.$val[nazwa].'</h5>';
					echo '</div>';				
				}else{
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
					echo '<h5>Problem with disconnect from product '.$val[nazwa].'</h5>';
					echo '</div>';
				}
			}
		}
		if($cat_with_file){
			foreach($cat_with_file as $key => $val){
				$zdjecia_new=str_replace(",".str_replace(".png","",$_GET[del_true]).",",",",$val[zdjecia]);
				$sql="UPDATE kategorie_".$cmslang." SET zdjecia='".$zdjecia_new."' WHERE id=".$key;
				if(mysql_query($sql)){
					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>';
					echo '<h5>Disconnect from category '.$val[nazwa].'</h5>';
					echo '</div>';				
				}else{
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
					echo '<h5>Problem with disconnect from category '.$val[nazwa].'</h5>';
					echo '</div>';
				}
			}
		}
		if(file_exists($_DIR_IMG."/".$_GET[del_true])){
			if(unlink($_DIR_IMG."/".$_GET[del_true])){
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>';
				echo '<h5>File '.$_GET[del_true].' deleted</h5>';
				echo '</div>';
			}else{
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
				echo '<h5>Problem with delete file '.$_GET[del_true].'</h5>';
				echo '</div>';
			}
		}
	}

}

  	echo '<div class="row-fluid" style="font-size:12px;"><table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th style="width:40%">Browse</th>
				  <th style="width:40%">Change name (optional)</th>
				  <th style="width:40%">Type</th>
				  <th style="width:20%;min-width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
	echo '<tr><form enctype="multipart/form-data" method="post" action="index.php?site=dodaj_zdjecie">
				<td><input name="plik" type="file" /></td>
				<td><input style="font-size:12px;" type="text" name="nazwa" id="nazwa"></td>
				<td>';
				?>
					<input type="radio" name="group" id="group1" value="product" checked>&nbsp;Product (300 x 300)<br/>
					<input type="radio" name="group" id="group2" value="category">&nbsp;Category (500 x 334)
				<?
				echo '</td>				
				<td><input type="submit" value="Upload" class="btn btn-block btn-primary"></td>
				</form></tr>';
	echo '</tbody></table></div>';
	include('photo_gallery.php');
	foreach (glob($_DIR_IMG."/*.png") as $filename){
		$files_list[filectime($filename)."_".$filename]=basename($filename); // or just $filename
	}
	krsort($files_list);
	$count_foto=count($files_list);
	?>
	<h3>Files (<?=$count_foto?>)</h3>
	<div class="row-fluid">
		<?show_photos($files_list,"file_page",$_GET[file_page],"30",array("del_file"));?>
	</div>