
<?php
//logowanie///////część komend będzie w klasie baza
 session_start();
 if(!isset($_POST['login'])||!isset($_POST['password']))
 {
     header("Location: ../index.php");
    exit();
 }
 require_once 'connect.php';
 $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

 if($polaczenie->connect_errno!=0)
 {
     echo "error: ".$polaczenie->connect_errno;
 }
 else {
      $polaczenie->query('SET NAMES utf8');
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    $mode =$_POST['mode'];
   //zabezpieczenie użyj filtrów
    $login = htmlentities($login,ENT_QUOTES,"UTF-8");
    $password = htmlentities($password,ENT_QUOTES,"UTF-8");
	//jeśli nauczyciel
	if($mode == "teacher")
	{

		if($result = @$polaczenie->query(sprintf("SELECT * FROM nauczyciele WHERE PESEL='%s'"
				,mysqli_real_escape_string($polaczenie, $login),)));
		{
		  $count_users =  $result->num_rows;
		   if($count_users>0)
		   {
                            $verse = $result->fetch_assoc();//pobierz rezultat
                            if(password_verify($password, $verse['haslo']))
                            {
                                $_SESSION['zalogowany']=true;
                                  $_SESSION['nauczyciel']=true;

                                 $_SESSION['id']=$verse['id_nauczyciel'];
                                 $_SESSION['user'] = $verse['imie'];//sesia wymaga session_start
                                 unset($_SESSION['blad']);//usun blad
                                 $result->close();
                                 header('Location: ../profile_teacher.php'); 
                            }
                        else {
                                $_SESSION['error'] = '<span style = "color:red">Nieprawidłowy login lub hasło nauczyciela!</span>';
				header('Location: ../index.php');
                            }
		   }
		   else //jezeli zle zalogowany
		   {
			   $_SESSION['error'] = '<span style = "color:red">Nieprawidłowy login lub hasło nauczyciela!</span>';
				header('Location: ../index.php');
		   }
		}
	}
        //Jeśli uczeń
	else if($mode == "student")
	{
		if($result = @$polaczenie->query(sprintf("SELECT * FROM uczniowie WHERE `id_ucz`='%s'"
				,mysqli_real_escape_string($polaczenie, $login))));
		{
		   $count_users =  $result->num_rows;
		   if($count_users>0)
		   {
                            $verse = $result->fetch_assoc();//pobierz rezultat
                            if(password_verify($password, $verse['haslo']))
                            {
                                $_SESSION['zalogowany']=true;
                                  $_SESSION['nauczyciel']=false;

                                 $_SESSION['id']=$verse['id_ucz'];
                                 $_SESSION['user'] = $verse['imie'];//sesia wymaga session_start
                                 unset($_SESSION['blad']);//usun blad
                                 $result->close();
                                 header('Location: ../profile.php'); 
                            }
                        else {
                                $_SESSION['error'] = '<span style = "color:red">Nieprawidłowe hasło ucznia!</span>';
				header('Location: ../index.php');
                            }
		   }
		   else //jezeli zle zalogowany
		   {
			   $_SESSION['error'] = '<span style = "color:red">Nieprawidłowy login!</span>';
				header('Location: ../index.php');
		   }
		}
		
	}
	$polaczenie->close();
 }
 
 
?>