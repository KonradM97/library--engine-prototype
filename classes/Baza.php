<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Baza
 *
 * @author Konrad
 */
Class Baza {
    private $mysqli;

    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
    
        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n", 
                    $this->mysqli->connect_error);
            exit();
        }
        if ($this->mysqli->set_charset("utf8")) {
            //udalo sie zmienic kodowanie
        }
    }

    function __destruct() {
        $this->mysqli->close();
    }

    public function selectwithtable($sql, $pola, $uczen) {
        //parametr $sql –łańcuch zapytania select
        //parametr $pola -tablica z nazwami pol w bazie 
        $tresc = "";
        if($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pol
            $ile = $result->num_rows; //ile wierszy
            //petla po wyniku zapytania $result
            
            while ($row = $result -> fetch_object()) {
                $tresc.="<tr>";
                for($i=0; $i<$ilepol; $i++) {
                    $p = $pola[$i];
                    if($i==0)
                    {
                        //Jeżeli opcja karty ucznia lub książki
                    if($uczen==1)
                    {
                        $tresc.="<td width='200px'><a href='studentcard.php?kartaucznia=".$row->$p."'><div>".$row->$p."</div></a></td>";
                    }
                    else if($uczen==0)
                    {
                        $tresc.="<td width='200px'><a href='bookcard.php?kartaksiazki=".$row->$p."'><div>".$row->$p."</div></a></td>";
                    }
                    else
                    {
                        $tresc.="<td width='200px'><div>".$row->$p."</div></td>";
                    }
                    }
                    else {
                        $tresc.="<td width='200px'><div>".$row->$p."</div></td>";
                    }
                }
                $tresc.="<tr>";
            }
            
        }
        return $tresc;
    }
	    public function select($sql, $pola) {
        //parametr $sql –łańcuch zapytania select
        //parametr $pola -tablica z nazwami pol w bazie 
        $tresc = "";
        if($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pol
            $ile = $result->num_rows; //ile wierszy
            //petla po wyniku zapytania $result

            while ($row = $result -> fetch_object()) {
                for($i=0; $i<$ilepol; $i++) {
                    $p = $pola[$i];
                    $tresc.=$row->$p;
                }
            }
            $result->close(); //zwolnij pamiec
        }
        return $tresc;
    }
    public function getValues($pola, $sep) {
        $tresc = "(";
        for($i = 0; $i<count($pola); $i++) {
            if($pola[$i] == NULL) {$tresc .="NULL";}
            else{ $tresc .="$sep".$pola[$i]."$sep";}
            if($i+1 < count($pola)){ $tresc .=", ";}
        }
        return $tresc.=")";
    }

    public function insert($sql) {
        //parametr $sql –łańcuch zapytania select
        //parametr $pola -tablica z nazwami pol w bazie 
        if($result = $this->mysqli->query($sql)) {
             
            return true;
        }
		else
		{   
                        
			return false;
		}
    }

	public function delete($sql)
	{
		if($result = $this->mysqli->query($sql)) {
                     
            return true;
        }
		else
		{
                     
			return false;
		}
	}

    
}



?>