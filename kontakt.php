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
            require_once 'classes/webpage.php';
            $strona = new Webpage();
            $strona->pokaz_naglowek();
        ?>
            <div class="tresc">
                <div class="caly">
                    <h1>Kontakt</h1>
                    
                    <div style="font-weight:bold">Publiczna szkoła podstawowa w Babinie</div>
                        Stefanów 38 pokój nr 10, 26-704 Stefanów<br/>
                        Tel:48 677 30 72<br/>
                        Email: biblioteka@pspbabin.pl
                    
                </div>
                <?php 
                    $strona->pokaz_stopke();
                ?>
            </div>
        </div>
        
    </body>
</html>
        ?>
    </body>
</html>
