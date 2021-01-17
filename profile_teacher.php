<?php
session_start();
if(!isset($_SESSION['zalogowany'])||($_SESSION['nauczyciel']==false&&isset($_SESSION['nauczyciel'])))
{
    header("Location: index.php");
    exit();
}
require_once 'classes/webpage.php';
        $strona = new Webpage();
        include_once("classes/Baza.php");

    $bd= new Baza("localhost", "root", "", "biblioteka");
include_once("scripts/Walidator.php");

$message ="";
//Część odpowiedzialna za wysyłanie formularzy z bloków
    //wysłanie nowej aktualnośći
    if(isset($_POST['submitakt']))
    {
        //walidacja
        if(checkAkt()['poprawny']){
            $tresc = "";
        $tytul =filter_input(INPUT_POST, 'tytul');
        $tresc .=filter_ainput(INPUT_POST, 'tresc');
        include_once("classes/Pliki.php");
        $plik = new Pliki();
        $plik->zapisz('aktualnosci.txt', $tytul,$tresc);
        $message = '<h2>Zapisano!</h2>';
        }
        else {
            $message = checkAkt()['msg'];
        }
    }
    //wysłanie nowego wypozyczenia
   if(isset($_POST['submitwypozycz']))
    {
        //walidacja
        if(checkWypozycz()['poprawny']){
            //Sprawdź czy książka dostępna
            $czydostepna = $bd->select("SELECT `dostepna` FROM `ksiazki` WHERE `nr_inw` = ".filter_input(INPUT_POST, 'id_ksiazki'), array('dostepna'));
            if (strpos($czydostepna, 'Tak') !== false)
            {
            //Wstaw nnowy rekord wypozyczenia
            
            if($bd->insert("INSERT INTO `wypozyczenia` ( `id_ucz`, `id_inw`, `data_wypozyczenia`, `data_zwrotu`, `id_nauczyciela`) VALUES ( '".filter_input(INPUT_POST, 'id_ucznia')."', '".filter_input(INPUT_POST, 'id_ksiazki')."', CURDATE(), NULL, '".$_SESSION['id']."')"))
            {
                //dodaj uczniom ilosc wypozyczonych ksiazek
                $ile = $bd->select("SELECT `ilosc_ksiazek` FROM `uczniowie` WHERE `id_ucz` =".filter_input(INPUT_POST, 'id_ucznia'), array('ilosc_ksiazek'));
                $ilek = intval($ile)+1;
                $bd->insert("UPDATE `uczniowie` SET `ilosc_ksiazek` = ".$ilek." WHERE `id_ucz` = ".filter_input(INPUT_POST, 'id_ucznia'));
                //książka staje się niedostępna
                $bd->insert("UPDATE `ksiazki` SET `dostepna` = 'Nie' WHERE `nr_inw` = ".filter_input(INPUT_POST, 'id_ksiazki'));
                $message = "Dodano!";
            }
            else
            {
                $message = "Błąd z dodaniem wypożyczenia!";
            }
            }
             else {
            $message = "<div style='color: red'>Książka niedostępna!</div>";
                }
        }
        else {
            $message = checkWypozycz()['msg'];
        }
    }
    
    //Oddawanie książki
        if(isset($_POST['submitoddaj']))
    {
        //walidacja
        if(checkOddaj()['poprawny']){
            $id = $bd->select("SELECT `id_wypozyczenia` FROM `wypozyczenia` WHERE `id_inw` = ".filter_input(INPUT_POST, 'id_ksiazki')." ORDER BY `data_wypozyczenia` DESC LIMIT 1 ", array('id_wypozyczenia'));
            $bd->insert("UPDATE `wypozyczenia` SET `data_zwrotu` = CURDATE() where id_wypozyczenia =".$id);//id_wypozzyczenia
            $bd->insert("UPDATE `ksiazki` SET `dostepna` = 'Tak' WHERE `nr_inw` = ".filter_input(INPUT_POST, 'id_ksiazki'));
             $message = "Oddano książkę o id:".filter_input(INPUT_POST, 'id_ksiazki')."!";
        }
        else {
            $message = checkOddaj()['msg'];
        }
    }
    //Dodanie ucznia
     if(isset($_POST['dodajucznia']))
     {
         //Sprawdź czy jest uczeń o tym id.
         $id = $bd->select("SELECT `id_ucz` FROM `uczniowie` WHERE `id_ucz` = ".filter_input(INPUT_POST, 'id_ucznia'), array('id_ucz'));
         if($id=="")
         {
         //walidacja
         if(checkDodajUcznia()['poprawny']){
             $password = generujHaslo();
             $message .= "Dodano nowego ucznia!<br/>";
             $message .= "Id ucznia: ".filter_input(INPUT_POST,'id_ucznia')."<br/>";
             $message .= "Nazwisko: ".filter_input(INPUT_POST,'nazwisko')."<br/>";
             $message .= "Imię: ".filter_input(INPUT_POST,'imie')."<br/>";
             $message .= "Klasa: ".filter_input(INPUT_POST,'klasa')."<br/>";
             $message .= "Data urodzenia: ".filter_input(INPUT_POST,'data_ur')."<br/>";
             $message .= "Wygenerowane hasło: ".$password;
             $password_hash = password_hash($password, PASSWORD_DEFAULT);
             $bd->insert("INSERT INTO `uczniowie` (`id_ucz`, `haslo`, `imie`, `nazwisko`, `klasa`, `ilosc_ksiazek`, `data_ur`) VALUES ('".filter_input(INPUT_POST,'id_ucznia')."', '".$password_hash."', '".filter_input(INPUT_POST,'imie')."', '".filter_input(INPUT_POST,'nazwisko')."', '".filter_input(INPUT_POST,'klasa')."', '0', '".filter_input(INPUT_POST,'data_ur')."')");
         }
         else {
            $message = checkDodajUcznia()['msg'];
        }
         }
         else {
              $message .= "<div style='color:red';>Istnieje uczeń o podanym ID!</div><br/>";
         }
     }
     
     //Usunięcie ucznia
     if(isset($_POST['submitusunucz']))
     {
         //walidacja
         if(checkUsunUcz()['poprawny']){
            if($bd->delete("DELETE FROM `uczniowie` WHERE `id_ucz` =".filter_input(INPUT_POST, 'id_ucznia'))){
                $message ="Usunięto!";
            }
            else {
                 $message ="<div style='color: red'>Nie usunięto!</div>";
            }
        }
        else {
            $message = checkUsunUcz()['msg'];
        }
     }
     //Dodanie książki
      if(isset($_POST['dodajksiazke']))
     {
         //walidacja
         if(checkDodajKsiazke()['poprawny']){
             $message .= "Dodano nową książkę!<br/>";
             $message .= "Autor: ".filter_input(INPUT_POST,'autor')."<br/>";
             $message .= "Tytuł: ".filter_input(INPUT_POST,'tytul')."<br/>";
             $message .= "Dział: ".filter_input(INPUT_POST,'dzial')."<br/>";
             $bd->insert("INSERT INTO `ksiazki` (`autor`, `tytul`, `dzial`, `data_wlaczenia`,`dostepna`) VALUES ('".filter_input(INPUT_POST,'autor')."', '".filter_input(INPUT_POST,'tytul')."', '".filter_input(INPUT_POST,'dzial')."', CURDATE(), 'Tak')");
         }
         else {
            $message = checkDodajKsiazke()['msg'];
        }
     }
         //Dodanie nauczyciela
     if(isset($_POST['dodajnauczyciela']))
     {
         //walidacja
         if(filter_input(INPUT_POST,'haslo')!=filter_input(INPUT_POST,'haslo2'))
         {
            $message .= "<div style='color: red'>Hasła nie pokrywają się!</div><br/>";
         }
         else{
         if(checkDodajNauczyciela()['poprawny']){
             $password = filter_input(INPUT_POST,'haslo');
             $message .= "Dodano nowego nauczyciela!<br/>";
             $message .= "Id nauczyciela: ".filter_input(INPUT_POST,'id_ucznia')."<br/>";
             $message .= "Nazwisko: ".filter_input(INPUT_POST,'nazwisko')."<br/>";
             $message .= "Imię: ".filter_input(INPUT_POST,'imie')."<br/>";
             $password_hash = password_hash($password, PASSWORD_DEFAULT);
             $bd->insert("INSERT INTO `nauczyciele` (`haslo`, `imie`, `nazwisko`, `PESEL`) VALUES ('".$password_hash."', '".filter_input(INPUT_POST,'imie')."', '".filter_input(INPUT_POST,'nazwisko')."', '".filter_input(INPUT_POST,'pesel')."')");
         }
         else {
            $message = checkDodajNauczyciela()['msg'];
        }
         }
     }
     if(isset($_POST['submithaslo']))
     {
         $id = $bd->select("SELECT `id_ucz` FROM `uczniowie` WHERE `id_ucz` = ".filter_input(INPUT_POST, 'id_ucznia'), array('id_ucz'));
         if($id != "")
         {
             $password = generujHaslo();
             $password_hash = password_hash($password, PASSWORD_DEFAULT);
             $bd->insert("UPDATE `uczniowie` SET `haslo` = '".$password_hash."' WHERE `id_ucz` = ".filter_input(INPUT_POST, 'id_ucznia'));
             $message = "Ustawiono nowe hasło dla ucznia o ID = ".filter_input(INPUT_POST, 'id_ucznia')."<br/>";
             $message .= "Nowe hasło: ".$password;
         }
         else{
             $message = "<div style='color: red'>Nie ma ucznia o takim ID!</div>";
         }
         
     }
     
     //Funkcja generująca hasło
     function generujHaslo()
    {
        // Konfiguracja
$config['mode'] = array(true, false, true, true); 
$config['length'] = 8;
// Alfabet
$letters = 'abcdefghijklmnopqrstuvwxyz';
$random_symbols= "";
// Liczby
if($config['mode'][0])
{
 $values = '0123456789'; // Można użyć tego: implode('', range(0, 9));
}

// Znaki specjalne
if($config['mode'][1])
{
 $values .= '`~!@#$%^&*()_-=+<>?,.|\/\'";:[]{}';
}

// Małe litery
if($config['mode'][2])
{
 $values .= $letters;
}

// Duże litery
if($config['mode'][3])
{
 $values .= strtoupper($letters);
}

for($h = 0, $length = (strlen($values) - 1); $h < $config['length']; ++$h)
{
 $random_symbols .= substr($values, mt_rand(0, $length), 1);
}

 return htmlspecialchars($random_symbols);
    }
 function showMessage($tresc)
        {
            echo "<div id='message'>";
            echo "<h2>$tresc</h2>";
            echo "</div>";
        }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <title>Strona nauczyciela</title>
    </head>
    <body>
                <div class="container">
       <?php
        
        echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'! <a href="scripts/logout.php">Wyloguj się</a></div></div>';
        ?>
            <?php
            $strona->pokaz_naglowek();
            ?>

            <div class="tresc">
               <div class='panel'>
                   <div id="blocks">
                       <?php
                       $strona->wyswietl_menu();
                       if (filter_input(INPUT_GET, 'strona'))
                       {
        $wybor = filter_input(INPUT_GET, 'strona');
        // przy wybraniu bloku wyswietlaj odpowiednie formularze
        switch ($wybor) {
            case 'wypozycz':$strona->wypozyczenie_form();
                break;
            case 'dodajucznia':$strona-> dodajucznia_form();
                break;
            case 'dodajksiazke':$strona-> dodajksiazke_form();
                break;
            case 'usunucznia': $strona -> usunucznia_form();
                break;
            case 'oddajksiazke': $strona -> oddanie_form();
                break;
            case 'aktualnosci':$strona->aktualnosci_form();
                break;
            case 'dodajnauczyciela':$strona->dodaNauczyciela_form();
                break;
            case 'nowehaslo':$strona->noweHaslo_form();
                break;
            default:header("Location: profile_teacher.php");
        }
        }
        echo showMessage($message);
        
                       ?>
                   </div>
                    <div id="wyszukaj">
                        <h1>Wyszukaj książkę</h1><br/>
                        <form action="profile_teacher.php" method="get">
                            <input type="text" name="tekstb" pattern="[0-9A-Za-z]{3,40}" title="Wyszukiwana fraza powinna miec min 3 znaki" required>
                            <input type="submit" value="Szukaj książkę" name="submitbook">
                        </form>
                        <?php
                        if (filter_input(INPUT_GET,"submitbook")){
			$akcja = filter_input(INPUT_GET, "submitbook");
                        $tekst = filter_input(INPUT_GET, "tekstb");
                        if($tekst!=""&& strlen($tekst)>=3)
                        {

                                 echo "<table><tbody>";
                                 echo "<tr><td>Nr książki</td><td>Autor</td><td>Tytuł</td><td>Dział</td><td>Czy jest dostępna?</td><td>Data włączenia</td><</tr>";
                                 echo $bd->selectwithtable("SELECT `nr_inw`,`autor`,`tytul`,`dzial`,`dostepna`,`data_wlaczenia` FROM `ksiazki` WHERE `tytul` LIKE '%".$tekst."%'",
                                         array('nr_inw','autor','tytul','dzial','dostepna','data_wlaczenia'),0);
                                 echo $bd->selectwithtable("SELECT `nr_inw`,`autor`,`tytul`,`dzial`,`dostepna`,`data_wlaczenia` FROM `ksiazki` WHERE `autor` LIKE '%".$tekst."%'",
                                         array('nr_inw','autor','tytul','dzial','dostepna','data_wlaczenia'),0);
                                 echo "</table></tbody>";
                             
                        }
                        }
                        
                        ?>
                        <h1>Wyszukaj ucznia</h1><br/>
                        <form action="profile_teacher.php" method="get">
                            <input type="text" name="teksts" pattern="[0-9A-Za-z]{3,40}" title="wyszukiwana fraza powinna miec min 3 znaki" required>
                            <input type="submit" value="Szukaj uczniów" name="submitstudent">
                        </form>
                        
                        <?php
                        if (filter_input(INPUT_GET,"submitstudent")){
			$akcja = filter_input(INPUT_GET, "submitbook");
                        $tekst = filter_input(INPUT_GET, "teksts");
                        if($tekst!=""&& strlen($tekst)>=3)
                        {

                                 echo "<table><tbody>";
                                 echo "<tr><td>Nr ucznia</td><td>Imię ucznia</td><td>Nazwisko</td><td>Klasa</td><td>Ilość wypożyczonych książek</td></tr>";
                                 echo $bd->selectwithtable("SELECT `id_ucz`,`imie`,`nazwisko`,`klasa`,`ilosc_ksiazek` FROM `uczniowie` WHERE `imie` LIKE '%".$tekst."%'",
                                         array('id_ucz','imie','nazwisko','klasa','ilosc_ksiazek'),1);
                                 echo $bd->selectwithtable("SELECT `id_ucz`,`imie`,`nazwisko`,`klasa`,`ilosc_ksiazek` FROM `uczniowie` WHERE `nazwisko` LIKE '%".$tekst."%'",
                                         array('id_ucz','imie','nazwisko','klasa','ilosc_ksiazek'),1);
                                 
                                 echo "</table></tbody>";
                             
                        }
                        else
                        {
                            echo "Zapytanie puste lub za małe!";
                        }
                        }
                        ?>
                    </div>
                </div>
             </div>
            <?php
            $strona->pokaz_stopke();
            ?>
        </div>
        
    </body>
</html>

