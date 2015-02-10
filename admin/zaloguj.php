<? 
if(isset($_POST['email'])) {

	// czyszczenie
	$_POST['email'] = Czysc($_POST['email']);
	$_POST['password'] = Czysc($_POST['password']);
	// i kodujemy hasło
	$_POST['password'] = KodujHaslo($_POST['password']);

	// sprawdzam czy dane ok
	$sql="SELECT `id`,`imie`,`admin`,`pricing` FROM `uzytkownicy` WHERE `email` = '{$_POST['email']}' AND `password` = '{$_POST['password']}' AND `aktywne` = 'yes' AND (`admin` != 'not' OR `pricing` != 'no') LIMIT 1";

	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0) {
		// jeśli tak to ustawiamy sesje "logged" na true oraz do sesji "user_id" wstawiamy id usera
		$row = mysql_fetch_assoc($result);		
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['admin'] = $row['admin'];	
		$_SESSION['pricing'] = $row['pricing'];	
		$_SESSION['imie'] = $row['imie'];
		$userid = $row['id'];
		$lang_cms = explode(',', $_SESSION['admin']);
		//$logowanie='0,1';
		if($_POST[src]){
		    if(strpos($_POST[src],"?") === false){$u="?";}else{$u="&";}
		    header ('Location: '.$_POST[src].''.$u.'cmslang='.$lang_cms[0]);
		}else{
		    header ('Location: /admin/index.php?cmslang='.$lang_cms[0]);
		}
		exit();
		echo '<p>'.$text_logowanie_poprawne[$lang].'.</p>';
			
	} else {
		echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><h5>Wrong password or no permission to page.</h5></div>';
	}
}

// wyświetlamy komunikat na zalogowanie się


?>
			<div class="row-fluid" style="font-size:12px;">
				<div class="span4">
				</div>
				<div class="span4">
                <form method="post" action="index.php?site=zaloguj">				
                <input type="hidden" name="src" value="<?=$_GET[src];?>">
                    <dl>
                        <dt>
                            <label for="login">Login (e-mail)</label>
                        </dt>
                        <dd>
                            <input required type="email" name="email" id="email" value="<? echo $_POST['email']; ?>" />
                        </dd>
                        
                        <dt>
                            <label for="password">Password</label>
                        </dt>
                        <dd>
                            <input required type="password" name="password" id="password" value="<? echo $_POST['password']; ?>" />
                        </dd>
                    </dl>
                    <footer>                        
                        <input id="submit" type="submit" value="Login" />												
                    </footer>
                </form>
               	</div>
               	<div class="span4">
               	</div>
            </div>