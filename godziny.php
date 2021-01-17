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
                    

                <table>
                    <tbody>
                        <tr>
                            <th>Poniedziałek</th><th>Wtorek</th><th>Środa</th><th>Czartek<th><th>Piątek</th>
                        </tr>
                        <tr>
                            <td>9:15-14:00</td><td>8:30-10:30</td><td>8:00-13:00</td><td>8:00-12:00<td><td>9:15-13:00</td>
                        </tr>
                        <tr>
                            <td></td><td>12:00-13:00</td><td></td><td>13:15-14:00<td><td></td>
                        </tr>
                        
                    </tbody>
                </table>
                                    </div>
                <?php 
                    $strona->pokaz_stopke();
                ?>
            </div>
        </div>
        
    </body>
</html>
