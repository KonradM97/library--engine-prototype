<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
 <?php
        session_start();
        //jezeli zalogowany login.php 20 linijka
        if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)&&($_SESSION['nauczyciel']==false)){
            header('Location: profile.php');
            exit();//zeby nie ladowal html'a
        }
        else if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)&&($_SESSION['nauczyciel']==true))
        {
            header('Location: profile_teacher.php');
            exit();//zeby nie ladowal html'a
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
        <title>Wirtualna biblioteka</title>
    </head>
    <body>
        <div class="container">
            <?php
            $strona->pokaz_naglowek();
            ?>

            <div class="tresc">

            <?php
            $strona->pokaz_glowna();
            $strona->pokaz_stopke();
            ?>
            </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
<!--<div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>