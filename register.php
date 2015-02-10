<?php
include 'config.php';
 
// sprawdzamy czy user nie jest przypadkiem zalogowany
if(!$_SESSION['logged']) {
    // jeœli zostanie naciœniêty przycisk "Zarejestruj"
    if(isset($_POST['name'])) {
        // filtrujemy dane...
        $_POST['name'] = Czysc($_POST['name']);
        $_POST['password'] = Czysc($_POST['password']);
        $_POST['password2'] = Czysc($_POST['password2']);
        $_POST['email'] = Czysc($_POST['email']);
 
        // sprawdzamy czy wszystkie pola zosta³y wype³nione
        if(empty($_POST['name']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['email'])) {
            echo '<p>Musisz wype³niæ wszystkie pola.</p>';
        // sprawdzamy czy podane dwa has³a s¹ takie same
        } elseif($_POST['password'] != $_POST['password2']) {
            echo '<p>Podane has³a ró¿ni¹ siê od siebie.</p>';
        // sprawdzamy poprawnoœæ emaila
        } elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            echo '<p>Podany email jest nieprawid³owy.</p>';
        } else {
            // sprawdzamy czy s¹ jacyœ uzytkownicy z takim loginem lub adresem email
            $result = mysql_query("SELECT Count(id) FROM `uzytkownicy` WHERE `email` = '{$_POST['name']}'");
            $row = mysql_fetch_row($result);
            if($row[0] > 0) {
                echo '<p>Ju¿ istnieje u¿ytkownik z takim loginem lub adresem e-mail.</p>';
            } else {
                // jeœli nie istnieje to kodujemy haslo...
                $_POST['password'] = KodujHaslo($_POST['password']);
                // i wykonujemy zapytanie na dodanie usera
                mysql_query("INSERT INTO `uzytkownicy` (`email`, `haslo`, `datarejestr`) VALUES ('{$_POST['email']}', '{$_POST['password']}', '".time()."')");
                echo '<p>Zosta³eœ poprawnie zarejestrowany! Mo¿esz siê teraz <a href="login.php">zalogowaæ</a>.</p>';
            }
        }
    }
 
    // wyœwietlamy formularz
    echo '<form method="post" action="register.php">
        <p>
            Login:<br>
            <input type="text" value="'.$_POST['name'].'" name="name">
        </p>
        <p>
            Has³o:<br>
            <input type="password" value="'.$_POST['password'].'" name="password">
        </p>
        <p>
            Powtórz has³o:<br>
            <input type="password" value="'.$_POST['password2'].'" name="password2">
        </p>
        <p>
            E-mail:<br>
            <input type="text" value="'.$_POST['email'].'" name="email">
        </p>
        <p>
            <input type="submit" value="Zarejestruj">
        </p>
    </form>';
} else {
    echo '<p>Jesteœ ju¿ zalogowany, wiêc nie mo¿esz stworzyæ nowego konta.</p>
        <p>[<a href="index.php">Powrót</a>]</p>';
}
 
mysql_close();
?>