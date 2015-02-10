if($_GET[druk_typ_oklejka]){
										//$b0 =!(($_GET[format_x] <= 1000 || $_GET[format_y] <=1000) && ($_GET[format_x] <= 700 || $_GET[format_y] <=700));
										$b0 = TRUE;
										$sql="SELECT * FROM drukarnie ";
                                        //$sql.="WHERE typ='$_GET[typ]' AND druk_typ='$_GET[druk_typ_oklejka]' AND ";
                                        $sql.="WHERE id='$_GET[drukarnia]'";
                                        $sql.=" LIMIT 0,1";
                                        list($id, $name, $local, $standard)=mysql_fetch_row(mysql_query($sql));
										if ($standard == 0) {
										$result = calculate_toolprint($_GET[druk_typ_oklejka], $_GET[sheetsize], $sheets, $_GET[drukarnia]);
                                        if ($result['name']){
                                            echo "<pre>";
                                            echo "<span class='label label-success'>";
                                            SL("print_type",$_GET[pricing_lang]);
                                            echo ": </span>&nbsp;<strong>";
                                            echo $result['print_type']." ";
                                            echo "<span class='label label-success'>";
                                            //SL("print_type",$_GET[pricing_lang]);
                                            echo 'Koszt-'; echo $result['name'];
                                            echo ": </span>&nbsp;";
                                            echo "PLN ".$result['cost'];
                                            echo "</strong>&nbsp;";
                                            //if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
                                            echo "</strong>";
                                            echo "</pre>";
                                            } else {
                                                echo "<span class='label label-warning'>";
                                        SL("no_price",$_GET[pricing_lang]);
                                        echo "</span>";
                                            }
									}else{ //B0
										
										//$sql="SELECT id_printhouse, print_type, sheetsize, price_range, price, currency, name, local, standard FROM druk_zakres JOIN drukarnie ON id_printhouse = drukarnie.id ";
										//$sql.="WHERE print_type='$_GET[druk_typ_oklejka]' AND ";
										//$sql.="sheetsize ='$_GET[sheetsize]' AND id_printhouse='$_GET[drukarnia]' AND ";
										//$sql.="$sheets<=price_range ORDER BY price_range";
										//$sql.="szt_od<='".$_GET[liczba]."' AND szt_do='0') ";
										//$sql.=" LIMIT 0,1";
										//list($id, $print_type, $sheetsize, $price_range, $price, $currency, $name, $local, $standard)=mysql_fetch_row(mysql_query($sql));
										$result = calculate_print($_GET[druk_typ_oklejka], $_GET[sheetsize], $sheets, $_GET[drukarnia]);
										if ($result['name']){
											echo "<pre>";
											echo "<span class='label label-success'>";
											SL("print_type",$_GET[pricing_lang]);
											echo ": </span>&nbsp;<strong>";
											echo $result['print_type']." ";
											echo "<span class='label label-success'>";
											//SL("print_type",$_GET[pricing_lang]);
											echo 'Koszt-'; echo $result['name'];
											echo ": </span>&nbsp;";
											echo "PLN ".$result['cost'];
											echo "</strong>&nbsp;";
											//if($cena_szt>0){echo "+ ".$cena_szt." ".$waluta."/szt. ".$cena_typ;}
											echo "</strong>";
											echo "</pre>";
											} else {
												echo "<span class='label label-warning'>";
										SL("no_price",$_GET[pricing_lang]);
										echo "</span>";
											}
									     } //b0
                                    }else{
										echo "<span class='label label-warning'>";
										SL("product_without_out_sticker_print",$_GET[pricing_lang]);
										echo "</span>";
									}
									
									?>
