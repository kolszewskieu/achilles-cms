<?
	echo '<div class="row-fluid" style="font-size:12px;">';
	if ($action == 'aktywuj') {
		$sql = "UPDATE `uzytkownicy` SET `aktywne` = 'yes' WHERE `id` = '".$_GET[user]."'";
		$result = mysql_query($sql);		
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>Dany użytkownik został aktywowany.</h5></div>';		
		$headers  = 'MIME-Version: 1.0'.PHP_EOL;
		$headers .= 'Content-type: text/html; charset=utf-8'.PHP_EOL;
		$headers .= 'From: Strona WWW <stronawww@achilles.pl>'.PHP_EOL;
		$headers .= 'X-Mailer: PHP/'. phpversion();
		$recipient = $_GET[email];
		$subject = 'Aktywacja konta w serwisie achilles.pl';
		$body .= '<html><head><title>Aktywacja konta w serwisie achilles.pl</title></head><body>';
		$body .= '<p><b>Witaj '.$_GET[imie].'.</b></p>';
		$body .= '<p>Twoje konto zostało aktywowane.</p>';
		$body .= '<p>Pozdrawiamy, <br />'; 
		$body .= 'Zespół Achilles Polska<br />';
		
		$body .= '</body></html>';
		if(mail($recipient, $subject, $body, $headers)){
		    mail('tomek@usable.pl', $subject, $body, $headers);
		    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h5>';
		    echo 'Mail do uzytkownika został wysłany.';
		    echo '</h5></div>';
		}
	}
	echo '<table class="table table-striped" style="border-collapse:separate">
              <thead>
                <tr class="info">
                  <th>Name</th>
                  <th>Surname</th>
                  <th>E-mail</th>				                   
				  <th>Company</th>
				  <th>Address</th>
				  <th>Telephone</th>';
				  if ($cmslang == 'pl') echo '<th>Wojewodztwo</th>';
				  echo '<th>Newsletter</th>
				  <th>Active</th>
				  <th>Language</th>
				  <th>Admin</th>				  
				  <th style="width:50px;">Edit</th>
                </tr>
              </thead>
              <tbody>';
	$sql = "SELECT * FROM `uzytkownicy` WHERE (`aktywne` = 'no' AND `jezyk` IN ('$in'))";
	$result = mysql_query($sql);	
	while($row = mysql_fetch_assoc($result)) {
		echo '<form method="post" action="index.php?site=aktywacja&user='.$row['id'].'&imie='.$row['imie'].'&email='.$row['email'].'&action=aktywuj"><tr>
                <td>'.$row['imie'].'</td>
				<td>'.$row['nazwisko'].'</td>				
				<td>'.$row['email'].'</td>
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
				<td><input type="submit" value="Aktywuj" class="btn btn-block btn-primary"></td></tr></form>';	
	}
echo '</tbody></table>';
echo '</div>';
?>