<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pliki
 *
 * @author Konrad
 */


class Pliki {
    
    function otworz($adres)
	{
        $text = array('tytul' => "", 'zawartosc' => "");
        if(file_exists($adres)){
        $lines = file($adres);
        foreach ($lines as $line_num => $line) {
            if($line_num == 0)
            {
                $text['tytul'] = htmlspecialchars($line);
            }
            else
            {
                $text['zawartosc'] .=  htmlspecialchars($line) . "\n";
            }
        }
       // $text = mb_convert_encoding($text, 'UTF-8', "ISO-8859-15");
        }
        return $text;
	}
    function zapisz($adres,$tytul,$dane)
    {
         if(file_exists($adres)){
        $plik = fopen($adres,"w");
        fwrite($plik,$tytul);
        fwrite($plik, "\n");
	fwrite($plik,$dane);
         }
    }
    
}
