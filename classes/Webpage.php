<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Webpage
 *
 * @author Konrad
 */
 include_once("classes/Baza.php");
  include_once("classes/Pliki.php");
class Webpage {
        protected $przyciski = array( "Wypożycz" => "?strona=wypozycz",
        "Dodaj ucznia" => "?strona=dodajucznia", "Dodaj książkę" => "?strona=dodajksiazke",
        "Edytuj aktualności"=>"?strona=aktualnosci","Oddaj książkę" => "?strona=oddajksiazke"
            ,"Usuń ucznia" => "?strona=usunucznia","Dodaj nauczyciela" => "?strona=dodajnauczyciela",
            "Nowe hasło dla ucznia" => "?strona=nowehaslo");
	protected $bd;
    public function pokaz_naglowek()
	{
		$tresc= '<header>
             <a class="logo" href="index.php"><img src="img/logo.png" alt=""><h1>Wirtualna Biblioteka Publicznej Szkoły Podstawowej<br/> im. Heleny Długoszewskiej w Babinie</h1></a>
            <nav>
                <a href="https://pspbabin.szkolnastrona.pl/index.php?c=page&id=161"><img src="img/text-lines.png" alt=""><p>Strona szkoły</p></a>
                <a href="poradnik.php"><img src="img/info.png" alt=""><p>Jak korzystać ze strony</p></a>
                <a href="godziny.php"><img src="img/clock.png" alt=""><p>Godziny otwarcia biblioteki</p></a>
                <a href="kontakt.php"><img src="img/phone-call.png" alt=""><p>Kontakt</p></a>
            </nav>
         </header>';
		echo $tresc;
	}
	public function pokaz_stopke()
	{
                $tresc ="";
                $tresc .= '<div id=linki>Przydatne linki<br/>'
                        . '<a href="https://epodreczniki.pl/">E-Podręczniki</a>'
                        . '<a href="https://wolnelektury.pl/">Wolne lektury</a>'
                        . '<a href="https://portal.librus.pl/">Librus</a></div>';
		$tresc .= '<div id="stopka"> &copy; Konrad Mazur 2020r</div>';
		echo $tresc;
	}
	public function pokaz_glowna()
	{
		$bd= new Baza("localhost", "root", "", "biblioteka")
		?>
				
		                <div class='lewy'>
                    <div id="aktualnosci"><h1>Aktualności</h1>
                    <?php
                    $plik = new Pliki();
                    $present = $plik->otworz('aktualnosci.txt');
                    echo "<h2>".$present['tytul']."</h2>";
                    echo "<p>".$present['zawartosc']."</p>";
                    ?>
                    </div>
                    <div class="left"><h1>Najlepsi uczniowie</h1>
                        <?php
                            echo "<table><tbody>";
                            echo "<tr><th>Imię ucznia</th><th>Nazwisko ucznia</th><th>Ilość książek</th><th>Klasa</th></tr>";
                            echo $bd->selectwithtable("SELECT `imie`, `nazwisko`, `ilosc_ksiazek`, `klasa` FROM `uczniowie` ORDER BY `ilosc_ksiazek` DESC LIMIT 3",array('imie','nazwisko','ilosc_ksiazek','klasa'),-1);
                            echo "</table></tbody>";
                        ?>
                    </div>
                </div>
                <div class='prawy'>
                    <div class="logowanie">
                        <h2>Zaloguj się</h2>
                        <form action="scripts/login.php" method="post">
                        Login:<br/><input type="text" name="login"><br/>
                        Hasło<br/><input type="password" name="password"><br/>
                        Loguję się jako:<br/>
                        <table>
                            <tr>
                        <td><label for='teacher'>Nauczyciel</label><input type="radio" id="teacher" name="mode" value='teacher'></td>
                        <td><label for='student'>Uczeń</label><input type="radio" id="student" name="mode" value='student' checked="checked"></td>
                         </tr>
                        </table>
                        <?php
                            //w przypadku błędnego logowania
                            if(isset($_SESSION['error']))
                            {
                                echo $_SESSION['error'];
                                
                            }
                        ?>
                        <input type="submit" value="Zaloguj się">
                        
                        
            </form>
                    </div>
                </div>
             </div>
		<?php
	}
        public function wyswietl_menu() {
        echo "<div id='nav'>";
        while (list($nazwa, $url) = each($this->przyciski)) {
            echo' <a href="' . $url . '"><div class="block"><p>' . $nazwa . '</p></div></a>';
        }
        echo "</div>";
    }
    public function dodajucznia_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <table>
                <tr>
                    <td><label>Id ucznia</label></td><td><input type="text" name="id_ucznia" pattern="[0-9A-Za-z]{2,4}" title="Podaj właściwe id" required></td>
                    </tr>
                <tr>
                            <td><label>Nazwisko</label></td><td><input type="text" name="nazwisko" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ- ]{3,20}" title="Podaj właściwe nazwisko" required></td>
                    </tr>
		<tr>
                            <td><label>Imię</label></td><td><input type="text" name="imie" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ]{3,12}" title="Podaj właściwe imię" required></td>
                    </tr>
		<tr>
                            <td><label>Klasa</label></td><td><input type="text" name="klasa" pattern="[A-Za-z]{1,5}" title="Podaj właściwą klasę" required></td>
                    </tr>
                    <tr>
                            <td><label>Data urodzenia</label></td><td><input type="text" name="data_ur" placeholder="YYYY-MM-DD" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" title="Podaj datę w formacie YYYY-MM-DD"></td>
                    </tr>
                     </table>
                            <input type="submit" value="Dodaj ucznia" name="dodajucznia">
                   
       
        </form>
             </div>'
            <?php
    }
        public function dodaNauczyciela_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <table>
                <tr>
                    <td><label>Nazwisko</label></td><td><input type="text" name="nazwisko" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ- ]{3,20}" title="Podaj właściwe nazwisko" required></td>
                    </tr>
		<tr>
                            <td><label>Imię</label></td><td><input type="text" name="imie" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ]{3,12}" title="Podaj właściwe imię" required></td>
                    </tr>
		<tr>
                    <td><label>PESEL</label></td><td><input type="text" name="pesel" pattern="[0-9]{11}" title="Podaj właściwy numer PESEL" required="required"></td>
                    </tr>
                    <tr>
                        <td><label>Hasło</label></td><td><input type="password" name="haslo" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Hasło powinno mieć conajmniej 8 znaków i przynajmniej jedną cyfrę"></td>
                    </tr>
                    <tr>
                        <td><label>Powtórz hasło</label></td><td><input type="password" name="haslo2" min="8" required></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Dodaj nauczyciela" name="dodajnauczyciela"></td>
                        </tr>
                     </table>
                           
                   
       
        </form>
             </div>'
            <?php
    }
        public function dodajksiazke_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <table>
                <tr>
                            <td><label>Autor</label></td><td><input type="text" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ\. ]{3,40}" title="Podaj właściwego autora" required name="autor"></td>
                </tr>
		<tr>
                            <td><label>Tytuł</label></td><td><input type="text" pattern="[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ-\. ]{3,40}" title="Podaj właściwy tytuł" required  name="tytul"></td>
                    </tr>
		<tr>
                    <td><label>Dzial</label></td><td><input type="text" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ ]{3,15}" name="dzial" required></td>
                    </tr>
                     </table>
                            <input type="submit" value="Dodaj książkę" name="dodajksiazke">
                   
       
        </form>
             </div>'
            <?php
    }
        public function oddanie_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <tr>
                <td><label>Id ksiązki</label></td><td><input type="text" pattern="[0-9]{1,6}" name="id_ksiazki" required></td>
                    </tr>
                    <td><input type="submit" value="Oddaj książke" name="submitoddaj"></td>
        </table>
        </form>
             </div>'
            <?php
        
    }
            public function usunucznia_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <tr>
                            <td><label>Id ucznia</label></td><td><input type="text" pattern="[0-9a-zA-Z]{1,6}" name="id_ucznia" required></td>
                    </tr>
                    <td><input type="submit" value="Usuń ucznia" name="submitusunucz"></td>
        </table>
        </form>
             </div>'
            <?php
        
    }
    public function wypozyczenie_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <tr>
                <td><label>Id ucznia</label></td><td><input type="text" pattern="[0-9a-zA-Z]{1,6}" name="id_ucznia" required title="wpisz ID ucznia!"></td>
                    </tr>
                        <tr>
                            <td><label>Id ksiązki</label></td><td><input type="text"  pattern="[0-9a-zA-Z]{1,6}" name="id_ksiazki" required title="wpisz ID książki!"></td>
                    </tr>
         </table>
                    <input type="submit" value="Dodaj wypożyczenie" name="submitwypozycz">

        </form>
             </div>
            <?php
        
    }
        public function noweHaslo_form() {
        ?>
             <div id="wyszukaj">
            <form action="profile_teacher.php" method="post" >
        <table>
            <tr>
                <td><label>Id ucznia</label></td><td><input type="text" pattern="[0-9a-zA-Z]{1,6}" name="id_ucznia" required title="wpisz ID ucznia!"></td>
                    </tr>
         </table>
                    <input type="submit" value="Wygeneruj haslo" name="submithaslo">

        </form>
             </div>'
            <?php
        
    }
    public function aktualnosci_form() {
         $plik = new Pliki();
        $present = $plik->otworz('aktualnosci.txt')['zawartosc'];
        $presenttitle = $plik->otworz('aktualnosci.txt')['tytul'];

        echo '
        <h2>Aktualnosci</h2>
        
        <form action="profile_teacher.php" method="post" >
        <h3>Tytuł</h3>
        <input type="text" value="'.$presenttitle.'" name="tytul">
        <h3>Tresc aktualności</h3>
        <textarea name="tresc" cols="50" rows="10" value="prawidłowo">'.$present.' </textarea>
        <input type="submit" value="Edytuj" name="submitakt">
        </form>';
    }
    
    
}
