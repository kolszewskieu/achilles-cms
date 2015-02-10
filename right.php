<div class="box our-works">
              <header>
                  <h2><? echo ucfirst($text_nasze_realizacje[$lang]); ?></h2>
              </header>
              <ul>
                  <? 
						$sql = "SELECT id,nazwa,zdjecia FROM produkty_".$lang." WHERE kategoria='$id' LIMIT 3"; 
						$result = mysql_query($sql);
						if(mysql_num_rows($result) == 0) {
							$sql = "SELECT id,nazwa,zdjecia FROM produkty_".$lang." WHERE kategoria='1' LIMIT 3";
							$result = mysql_query($sql);
						}
						while ($row = mysql_fetch_assoc($result)) {							
							$tab = explode(',', $row['zdjecia']);
					?>                    
                          <li>                              
                      	   	<?  echo '<a href="http://'.$_SERVER[HTTP_HOST].'/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.strtolower($rowk[0]).'/'.LadneURLe($row[nazwa]).','.$id.','.$row[id].'.html">';
								$img_url="http://".$_SERVER[HTTP_HOST]."/obrazki/".LadneURLe($row[nazwa]).",".$lang.",".$tab[1].".png";
							  ?>
                              <img style="width:132px;padding:20px" src="<?=$img_url?>" alt="<? echo $row['nazwa']; ?>" />
							  </a>
                          </li>       
                    <?
						}							
					?>		
              </ul>
          </div>
          	<?	
				if($page != (LadneURLe($text_prototypy[$lang]))){
					echo '<a class="button ask" href="/'.LadneURLe($text_zapytaj[$lang]);
						if (($page == (LadneURLe($text_produkty[$lang]))) && (isset($kategoria))) { 
							echo '/'.$kategoria.','.$id;
						}          			
					echo '.html">'.ucfirst($text_zapytaj[$lang]).'</a>';
                    echo '<a href="/'.LadneURLe($text_nasze_realizacje[$lang]).'/'.$kategoria.','.$id.'.html" class="button ask">'.$text_galeria[$lang].'</a>';
                }
				mysql_close();
			?>