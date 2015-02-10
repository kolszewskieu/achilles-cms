<?
function show_photos($arr,$page_variable_name,$page=1,$on_page=20,$typ=array()){
	global $_DIR_IMG;
	global $_GET;
	global $cmslang;
	if(!$page)$page=1;
	$count_arr=count($arr);
	if($count_arr > 0) {
		$i=1;$count=1;
		$start=$on_page*($page-1);
		$stop=$on_page*($page-1)+$on_page;
		$count_page=($count_arr/$on_page)+1;
		if($count_arr > $on_page){
			echo '<div class="pagination pagination-centered"><ul>';
			for($a=1;$a<=$count_page;$a++){
				if($_SERVER[QUERY_STRING]){
					$url=$_SERVER[QUERY_STRING]."&";
				}
				$url_del=$page_variable_name."=".$page;
				$url_del=array("?".$page_variable_name."=".$page,"&".$page_variable_name."=".$page,"?add=".$_GET[add],"&add=".$_GET[add]);
				$url=str_replace($url_del,"",$url);
				//$url=str_replace("&".$url_del,"",$url);
				//$url=str_replace("?".$url_del,"",$url);
				$url.=$page_variable_name."=".$a;
				echo '<li';
				if($a==$page)echo ' class="active" ';
				echo '><a href="'.$_SERVER[SCRIPT_NAME].'?'.$url.'" >'.$a.'</a></li>';
			}
			echo "</ul></div>";
		}
		echo '<div class="row-fluid">';
		foreach($arr as $key => $val){
			if($count>=$start && $count<=$stop){
				$sql = "SELECT id,nazwa FROM `produkty_".$cmslang."` WHERE zdjecia LIKE '%,".str_replace(".png","",$val).",%'";
				$result = mysql_query($sql);
				$prod_with_file=array();
				while($row=mysql_fetch_array($result)){
					$prod_with_file[$row[id]][nazwa]=$row[nazwa];
				}
				$sql = "SELECT nazwa,zdjecia FROM `kategorie_".$cmslang."` WHERE zdjecia LIKE '%,".str_replace(".png","",$val).",%'";
				$result = mysql_query($sql);
				$cat_with_file=array();
				while($row=mysql_fetch_array($result)){
					$cat_with_file[$row[id]][nazwa]=$row[nazwa];
				}
				if($i==1){
					echo '<ul class="thumbnails">';
				}
					echo '<li class="span2">';
						echo '<div class="thumbnail">';
						echo '<img class="img-polaroid" width="150" src="'.$_DIR_IMG.'/'.$val.'" alt="'.$val.'">';
						echo '<h6>'.$val.'</h6>';
						if(in_array("add_to_product",$typ)){
							echo '<a class="btn btn-mini btn-success" href="'.$_SERVER[SCRIPT_NAME].'?produkt='.$_GET[produkt].'&file_page='.$_GET[file_page].'&file_prod_page='.$_GET[file_prod_page].'&add='.$val.'">Add</a>';
						}
						if(in_array("del_from_product",$typ)){
							echo '<a class="btn btn-mini btn-danger" href="'.$_SERVER[SCRIPT_NAME].'?produkt='.$_GET[produkt].'&file_page='.$_GET[file_page].'&file_prod_page='.$_GET[file_prod_page].'&disconect='.$val.'">disconnect</a>';
						}
						if(in_array("add_to_category",$typ)){
							echo '<a class="btn btn-mini btn-success" href="'.$_SERVER[SCRIPT_NAME].'?kategoria='.$_GET[kategoria].'&file_page='.$_GET[file_page].'&file_prod_page='.$_GET[file_prod_page].'&add='.$val.'">Add</a>';
						}
						if(in_array("del_from_category",$typ)){
							echo '<a class="btn btn-mini btn-danger" href="'.$_SERVER[SCRIPT_NAME].'?kategoria='.$_GET[kategoria].'&file_page='.$_GET[file_page].'&disconect='.$val.'">disconnect</a>';
						}
						if(in_array("del_file",$typ)){
							echo '<a class="btn btn-mini btn-danger" href="'.$_SERVER[SCRIPT_NAME].'?site=dodaj_zdjecie&file_page='.$_GET[file_page].'&del='.$val.'">delete file</a>';
						}
						echo "<br/><br/>";
						foreach($cat_with_file as $key => $val){
							echo '<span class="label">'.$val[nazwa].'</span>';
						}
						echo "<br>";
						foreach($prod_with_file as $key => $val){
							echo '<span class="label label-warning">'.$val[nazwa].'</span>';
						}
						echo '</div>';
					echo '</li>';
				if($i==6){
					echo "</ul>";
					$i=1;
				}else{
					$i++;
				}
			}
			$count++;
		}
		echo '</div>';
		if($count_arr > $on_page){
			echo '<div class="pagination pagination-centered"><ul>';
			for($a=1;$a<=$count_page;$a++){
				if($_SERVER[QUERY_STRING]){
					$url=$_SERVER[QUERY_STRING]."&";
				}
				$url_del=$page_variable_name."=".$page;
				$url=str_replace("&".$url_del,"",$url);
				$url=str_replace("?".$url_del,"",$url);
				$url.=$page_variable_name."=".$a;
				echo '<li';
				if($a==$page)echo ' class="active" ';
				echo '><a href="'.$_SERVER[SCRIPT_NAME].'?'.$url.'" >'.$a.'</a></li>';
			}
			echo "</ul></div>";
		}
	}else{
		// jeśli nie ma w ogóle to wyświetlamy komunikat
		echo '<h4>No files.</h4>';
	}
}
?>