<?php
session_start();
if(!isset($_SESSION['zalogowany'])||($_SESSION['nauczyciel']==true&&isset($_SESSION['nauczyciel'])))
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
        <title>Strona ucznia</title>
    </head>
    <body>
                <div class="container">
       <?php
        
        echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'!<a href="scripts/logout.php">Wyloguj się</a></div></div>';
        ?>
            <?php
            $strona->pokaz_naglowek();
            ?>
                    
            <div class="tresc">
               <div class='panel'>
                    <div id="wyszukaj">
                        <h1>Wyszukaj książkę</h1><br/>
                        <label>Szukaj</label><form action="profile.php" method="get">
                            <input type="text" pattern="[0-9A-Za-z]{3,40}" title="Wyszukiwana fraza powinna miec min 3 znaki" required name="tekst">
                            <input type="submit" value="Szukaj" name="submit"/>
                        </form>
                        <?php
                        if (filter_input(INPUT_GET,"submit")){
			$akcja = filter_input(INPUT_GET, "submit");
                        $tekst = filter_input(INPUT_GET, "tekst");
                        if($tekst!=""|| strlen($tekst)>3)
                        {
                                echo "<table><tbody>";
                                 echo "<tr><td>Nr książki</td><td>Autor</td><td>Tytuł</td><td>Dział</td><td>Czy jest dostępna?</td></tr>";
                                 echo $bd->selectwithtable("SELECT `nr_inw`,`autor`,`tytul`,`dzial`,`dostepna`,`data_wlaczenia` FROM `ksiazki` WHERE `tytul` LIKE '%".$tekst."%'",
                                         array('nr_inw','autor','tytul','dzial','dostepna'),-1);
                                 echo $bd->selectwithtable("SELECT `nr_inw`,`autor`,`tytul`,`dzial`,`dostepna` FROM `ksiazki` WHERE `autor` LIKE '%".$tekst."%'",
                                         array('nr_inw','autor','tytul','dzial','dostepna'),-1);
                                 echo "</table></tbody>";
                        }
                        else
                        {
                            echo "Zapytanie puste lub za małe!";
                        }
                        }
                        ?>
                    </div>
                    <div id="wyszukaj"><h1>Moje wypożyczenia</h1>
                        <?php
                        //Wystukaj bazę z zapytaniem o wypozyczenia gdzie id_ucz jest id sesji
                            echo "<table><tbody>";
                            echo "<tr><td>Nr książki</td><td>Autor</td><td>Tytuł</td><td>Dział</td><td>Data wypożyczenia</td><td>Czy oddana?</td></tr>";
                            echo $bd->selectwithtable("SELECT `id_wypozyczenia`,`autor`,`tytul`,`dzial`,`data_wypozyczenia`,`dostepna` FROM `wypozyczenia` INNER JOIN `ksiazki` ON `ksiazki`.`nr_inw`=`wypozyczenia`.`id_inw` WHERE `id_ucz`='".$_SESSION['id']." '",
                                    array('id_wypozyczenia','autor','tytul','dzial','data_wypozyczenia','dostepna'),-1);
                            echo "</table></tbody>";
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

