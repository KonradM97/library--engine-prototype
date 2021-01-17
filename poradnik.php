<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <title>Godziny otwarcia</title>

    </head>
    <body>
        <div class="container">
        <?php
            session_start();
            error_reporting(E_ALL ^ E_NOTICE);
            if(($_SESSION['nauczyciel']==true&&isset($_SESSION['nauczyciel'])))
            {
                    echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'! <a href="scripts/logout.php">Wyloguj się</a></div></div>';
            }
            else if(($_SESSION['nauczyciel']==false&&isset($_SESSION['nauczyciel'])))
            {
                    echo "<div id='profil'><div id='zmienhaslo'><a href='scripts/changepassword.php'>Zmień hasło</a></div><div id='wyloguj'><p>Witaj ".$_SESSION['user'].'! <a href="scripts/logout.php">Wyloguj się</a></div></div>';
            }
            ?>
            <?php
            require_once 'classes/webpage.php';
            $strona = new Webpage();
            $strona->pokaz_naglowek();
            
        ?>
            <div class="tresc">
                <div class="caly">
                    <h1>Jak korzystać ze strony?</h1>
                    <ul>
                        <li>Strona została utworzona dla ucziów i nauczycieli szkoły.</li><br/>
                        <li>Login i hasło do kont uczniów daje nauczyciel, który wpierw je tworzy.</li><br/>
                        <li>Uczeń ma możliwość zobaczenia swoich wypożyczeń oraz może wyszukiwać książki</li><br/>
                        <li>Nauczyciel ma możliwość tworzyć nowe konta, ksiązki w bazie, wypożyczenia i oddania książek.</li><br/>
                        <li>Jeżeli jesteś uczniem naszej szkoły a nie posiadasz konta, zgłoś się w naszej bibliotece!</li><br/>
                    </ul>
                </div>
                <?php 
                    $strona->pokaz_stopke();
                ?>
            </div>
        </div>
        
    </body>
</html>
