<?php
session_start();
if(!isset($_SESSION['zalogowany'])||($_SESSION['nauczyciel']==false&&!isset($_SESSION['nauczyciel'])))
{
    header("Location: index.php");
    exit();
}
require_once 'classes/webpage.php';
        $strona = new Webpage();
include_once("classes/Baza.php");
    $bd= new Baza("localhost", "root", "", "biblioteka");
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <title>Karta ksiązki</title>
    </head>
    <body>
        
                <div class="container">
                    <?php
                     $strona->pokaz_naglowek();
                     ?>
                    <div class="karta">
                    
       <?php
        
        echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'! <a href="scripts/logout.php">Wyloguj się</a></div></div>';
       
        if(filter_input(INPUT_GET, 'kartaksiazki'))
        {
            $id = filter_input(INPUT_GET, 'kartaksiazki');
            echo "<h1>Książka</h1>";
            echo "<table>";
                  echo "<tr><td>Nr książki</td><td>Autor</td><td>Tytuł</td><td>Dział</td><td>Czy jest dostępna?</td></tr>";
                                 echo $bd->selectwithtable("SELECT `nr_inw`,`autor`,`tytul`,`dzial`,`dostepna`,`data_wlaczenia` FROM `ksiazki` WHERE `nr_inw` = '".$id."'",
                                         array('nr_inw','autor','tytul','dzial','dostepna'),-1);
             echo "</table><br/>".
                     "<h2>Wypożyczenia</h2>";
              echo "<table>";
                         echo "<tr><th>Id Ucznia</th><th>Id wypożyczenia</td><th>Imię ucznia</th><th>Nazwisko</th><th>Klasa</th><th>Data wypożyczenia</th><th>Data zwrotu</th></tr>";
                      echo $bd->selectwithtable("SELECT `wypozyczenia`.`id_ucz`,`id_wypozyczenia`,`imie`,`nazwisko`,`klasa`,`data_wypozyczenia`,`data_zwrotu` FROM `wypozyczenia` INNER JOIN `uczniowie` ON `uczniowie`.`id_ucz`=`wypozyczenia`.`id_ucz` WHERE `id_inw`='".$id."'",
                                              array('id_ucz','id_wypozyczenia','imie','nazwisko','klasa','data_wypozyczenia','data_zwrotu'),1);
            echo "</table>";
        }
        ?>
                </div>
                </div>
    </body>
</html>
