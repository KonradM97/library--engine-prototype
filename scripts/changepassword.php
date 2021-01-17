<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <title>Zmień hasło</title>
    </head>
    <body>
             <div id="nowehaslo">
                 <form action="changepassword.php" method="post">
            <label>Stare hasło<br/></label><input type="password" name="starehaslo" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Hasło powinno mieć conajmniej 8 znaków i przynajmniej jedną cyfrę" required><br/>
            <label>Nowe hasło<br/></label><input type="password"  name="haslo" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Hasło powinno mieć conajmniej 8 znaków i przynajmniej jedną cyfrę" required/><br/>
            <label>Powtórz nowe hasło<br/></label><input type="password" name="haslo2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Hasło powinno mieć conajmniej 8 znaków i przynajmniej jedną cyfrę" required/><br/>
            <input type="submit" value="Zmień hasło" name="submit">
                        </form>
                 <a href="../index.php">Wróć do strony</a>
             </div>
        <?php
        session_start();
        require_once '../classes/Baza.php';
            if(isset($_POST['submit']))
    {
              if(filter_input(INPUT_POST,'haslo')!=filter_input(INPUT_POST,'haslo2'))
         {
            echo "<div id='message'>Hasła nie pokrywają się!<br/></div>";
         }
        else {
            $bd = new Baza("localhost", "root", "", "biblioteka");
            if($_SESSION['nauczyciel']==false){
                $querrypassword = $bd->select("SELECT `haslo` FROM `uczniowie` WHERE `id_ucz` = ".$_SESSION['id'], array('haslo'));
                
            }
             else if($_SESSION['nauczyciel']==true)
             {
                 $querrypassword = $bd->select("SELECT `haslo` FROM `nauczyciele` WHERE `id_nauczyciel` = ".$_SESSION['id'], array('haslo'));
                 
             }
            $password = $_POST['starehaslo'];
            $password = htmlentities($password,ENT_QUOTES,"UTF-8");
            if(password_verify($password, $querrypassword))
            {
            $password = filter_input(INPUT_POST,'haslo');
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            //Czy uczeń czy nauczyciel?
            if($_SESSION['nauczyciel']==false)
            {
                $bd->insert("UPDATE `uczniowie` SET `haslo` = '".$password_hash."' WHERE `id_ucz` = ".$_SESSION['id']);
            }
            else if($_SESSION['nauczyciel']==true)
            {
                $bd->insert("UPDATE `nauczyciele` SET `haslo` = '".$password_hash."' WHERE `id_nauczyciel` = ".$_SESSION['id']);
            }
            echo "<div id='message'>Zmiana hasła zakończona sukcesem!</div>";
            }
            else {
                echo "<div id='message'>Stare hasło nie pasuje!</div>";
            }
        }

            
    }
        ?>
    </body>
</html>
