<? include 'header.php' ?>

<div id="content" role="main">
       <div class="breadcrumbs">
            <a href="/">Achilles.pl</a> &gt; <span>Zapytaj</span>
        </div>

          
        <div class="box" id="question-form">
            <header>
                <h2>Zapytaj</h2>
            </header>
            <div class="content">
			<?	
			
			
				//if ($act != 'x') {  
			?>
                <form action="zapytaj2.php" method="post" enctype="text/plain">
                    <dl>
                        <dt>
                            <label for="name">Imię</label>
                        </dt>
                        <dd>
                            <input required type="text" name="name" id="name" />
                            wymagane
                        </dd>
                        
                        <dt>
                            <label for="surname">Nazwisko</label>
                        </dt>
                        <dd>
                            <input required type="text" name="surname" id="surname" />
                            wymagane
                        </dd>
                        
                        <dt>
                            <label for="company">Firma</label>
                        </dt>
                        <dd>
                            <input type="text" name="company" id="company" />
                        </dd>
                        
                        <dt>
                            <label for="question_email">E-mail</label>
                        </dt>
                        <dd>
                            <input type="email" name="question_email" id="question_email" />
                            ten adres e-mail będzie wymagany do logowania
                        </dd>
                        
                        <dt>
                            <label for="phone">Telefon</label>
                        </dt>
                        <dd>
                            <input type="text" name="phone" id="phone" />
                        </dd>
                    </dl>
                    <label for="question">Twoje uwagi i komentarze dotyczące prototypowego produktu</label>
                    <textarea name="question" id="question">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </textarea>
                    <footer>
                        <a href="#submit" class="button more">Wyślij</a>
						<input id="act" name="act" type="hidden" value="x" />
                        <input id="submit" type="submit" value="wyślij" />
                    </footer>
                </form>
				<?
					/*	}
					else {
						echo "wyslane";
						} */
				?>
            </div>
        </div>

  </div>
<? include 'footer.php' ?>