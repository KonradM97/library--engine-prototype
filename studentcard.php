<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <title>Karta ucznia</title>
    </head>
    <body>
        
                <div class="container">
                    <?php
                     $strona->pokaz_naglowek();
                     ?>
                    <div class="karta">
                    
       <?php
        
        echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'! <a href="scripts/logout.php">Wyloguj się</a></div></div>';
       
        if(filter_input(INPUT_GET, 'kartaucznia'))
        {
            $id = filter_input(INPUT_GET, 'kartaucznia');
            echo "<h1>Uczeń</h1><br/>";
            echo "<table>";
                   echo "<tr><th>Nr ucznia</td><th>Imię ucznia</th><th>Nazwisko</th><th>Klasa</th><th>Ilość wypożyczonych książek</th></tr>";
                echo $bd->selectwithtable("SELECT `id_ucz`,`imie`,`nazwisko`,`klasa`,`ilosc_ksiazek` FROM `uczniowie` WHERE `id_ucz` = '".$id."'",
                                             array('id_ucz','imie','nazwisko','klasa','ilosc_ksiazek'),-1);
             echo "</table><br/>".
                     "<h2>Wypożyczenia</h2>";
              echo "<table>";
                         echo "<tr><th>Nr książki</th><th>Nr wypożyczenia</th><th>Autor</th><td>Tytuł</th><th>Dział</th><th>Data wypożyczenia</th><th>Czy oddana?</th></tr>";
                      echo $bd->selectwithtable("SELECT `ksiazki`.`nr_inw`,`id_wypozyczenia`,`autor`,`tytul`,`dzial`,`data_wypozyczenia`,`dostepna` FROM `wypozyczenia` INNER JOIN `ksiazki` ON `ksiazki`.`nr_inw`=`wypozyczenia`.`id_inw` WHERE `id_ucz`='".$id." '",
                                              array('nr_inw','id_wypozyczenia','autor','tytul','dzial','data_wypozyczenia','dostepna'),0);
            echo "</table>";
        }
        ?>
                </div>
                </div>
    </body>
</html>
