<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    function checkAkt()
	{
            $wynik = array('poprawny' => true,'msg'=>"");
		$args = array(
			'tresc' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ!., \r\n]{1,400}$/']
			],
                        'tytul' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ!., \r\n]{1,30}$/']
			]);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
                                $wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'>Nie poprawna treść</div>";
				return $wynik;
			}
	}
        function checkWypozycz()
	{
            $wynik = array('poprawny' => true,'msg'=>"");
		$args = array(
			'id_ucznia' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ-]{1,4}$/']
			],
			'id_ksiazki' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[0-9]{1,6}$/']
                  ]);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
                            $wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'> Niepoprawne dane w:</div> ".$errors;
				return $wynik;
			}
        }
        function checkOddaj()
	{
                $wynik = array('poprawny' => true,'msg'=>"");
		$args = array(
			'id_ksiazki' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[0-9]{1,6}$/']
                  ]);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
                            $wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'>Niepoprawne dane w:</div> ".$errors;
				return $wynik;
			}
        }
        function checkDodajUcznia()
        {
            $wynik = array('poprawny' => true,'msg'=>"");
            $args = array(
                        'id_ucznia' => ['filter' => FILTER_VALIDATE_REGEXP,
                                                        'options' => ['regexp' => '/^[0-9A-Za-z]{1,6}$/']
                        ],
			'nazwisko' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ-]{1,25}$/']
			],
			'imie' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ ]{1,25}$/']
                  ],
			'klasa' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[0-9A-Za-z]{1,4}$/']
                  ]
			);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
                            $wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'>Niepoprawne dane w: </div>".$errors;
				return $wynik;
			}
        }
        function checkUsunUcz(){
            $wynik = array('poprawny' => true,'msg'=>"");
            $args = array(
			'id_ucznia' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-z]{1,6}$/']]);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
                            $wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'> Niepoprawne dane w:</div> ".$errors;
				return $wynik;
			}
        }
        function checkDodajKsiazke()
        {
            $wynik = array('poprawny' => true,'msg'=>"");
            $args = array(
			'autor' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ\!\,\. ]{1,25}$/']
			],
			'tytul' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ\!\,\. ]{1,25}$/']
                  ],
			'dzial' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[0-9A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ!\., ]{1,15}$/']
                  ],
			);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
				$wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'> Niepoprawne dane w:</div> ".$errors;
				return $wynik;
			}
        }
                function checkDodajNauczyciela()
        {
                    $wynik = array('poprawny' => true,'msg'=>"");
            $args = array(
                        
			'nazwisko' => ['filter' => FILTER_VALIDATE_REGEXP,
							'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżóĄĘŁŃÓŚŹŻ]{1,25}$/']
			],
			'imie' => ['filter' => FILTER_VALIDATE_REGEXP,
                      'options' => ['regexp' => '/^[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ ]{1,25}$/']
                  ],
			'haslo' => ['filter' => FILTER_VALIDATE_REGEXP,
                    'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó-]{8,25}$/']
                   ]
			);
			$dane = filter_input_array(INPUT_POST, $args);
			//var_dump($dane);
			$errors = "";
			foreach ($dane as $key => $val)
			{
				if ($val === false or $val === NULL)
				{
						$errors .= $key . " ";
				}
			}
			if ($errors === "") {
				return $wynik;
			}
			else {
				$wynik['poprawny']=false;
				$wynik['msg'] = "<div style='color:red'> Niepoprawne dane w:</div> ".$errors;
				return $wynik;
			}
        }
?>

