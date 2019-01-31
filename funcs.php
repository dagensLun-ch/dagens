<?php

// ========================================================================================

	function init()
	{
		global $data ;
		$rest = file("rest.txt") ;
		foreach ($rest as $r)
		{
			$temp = (explode(" @ " , $r)) ;  // temp är en array av den aktuella textraden
			$key = array_shift($temp)     ;  // plocka ut första värdet
			$data[$key] = $temp           ;  // associera resterande värden till f.d. första
		}
		// Arrayen data har följande kolumner:
			// 0 = id
			// 1 = namn
			// 2 = url
			// 3 = höjd
	
	}

// ========================================================================================

	function getUrl($url)
	// Tar emot en url (sträng) och returnerar sidans källkod (sträng)
	{
		if (preg_match('/^([a-z]+):\/\/([a-z0-9-.]+)(\/.*$)/i' , $url , $matches))
		{
			$protocol = strtolower($matches[1]);
			$host = $matches[2];
			$path = $matches[3];
		}
		else  // Bad url-format
		{
			return FALSE;
		}

		if ($protocol == "http")
		{
			$socket = fsockopen($host, 80);
		}
		else  // Bad protocol
		{
			return FALSE;
		}

		if (!$socket)  // Error creating socket
		{
			return FALSE;
		}

		$request = "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";
		$len_written = fwrite($socket, $request);

		if ($len_written === FALSE || $len_written != strlen($request))  // Error sending request
		{
			return FALSE;
		}

		$response = "";
		while (!feof($socket) && ($buf = fread($socket, 4096)) !== FALSE)
		{
			$response .= $buf;
		}

		if ($buf === FALSE)  // Error reading response
		{
			return FALSE;
		}

		$end_of_header = strpos($response, "\r\n\r\n");
		return substr($response, $end_of_header + 4);
	}

// ========================================================================================

	function datum()
	// Returnerar en sträng med dagens datum
	{
		$svDag = array("s&ouml;n" , "m&aring;n" , "tis" , "ons" , "tors" , "fre" , "l&ouml;r") ;  // svenska veckodagar
		$svMan = array("NULL" , "januari" , "februari" , "mars" , "april" , "maj" , "juni" , "juli" , "augusti" , "september" , "oktober" , "november" , "december") ;  // svenska månader
		$bokst = ":e " ;
		if ( in_array(date('j') , array(1,2,21,22,31)) )
			$bokst = ":a " ;

		// Hämta temperatur (med timestamp)
	//	$temps = fetchTemp() ;
			
		// Bygg ihop och returnera datumsträng och temperatur
		return '<br><br><br>' . date('j') . $bokst . $svMan[date('n')] . '<br>' . $svDag[date('w')] . "dag v. " . date('W') . '<hr>' ;
	}

// ========================================================================================

	function t($n)
	{
		return "\n" . str_repeat("\t" , $n) ;
	}
	
// ========================================================================================

	function makeMenu($m)
	{
		global $data ;
		$menu = t(3) . '<iframe id="' . $data[$m][0] . '" src="' . $data[$m][1] . '" frameborder="0" scrolling="no" height="' . $data[$m][2]  . '"></iframe>' . t(3) .'<br>' . t(3) . '<input type="button" value="+" onClick="changeHeight(\'' . $data[$m][0] . '\' , 100)">'  . t(3) . '<input type="button" value="-" onClick="changeHeight(\'' . $data[$m][0] . '\' , -100)">' ;
		return $menu ;
	}

// ========================================================================================

    function showTemp()
    {
        date_default_timezone_set('Europe/Stockholm') ;
        
        $file = "flygtemp.html" ;
        $url  = "http://www.essk-wx.com/weather/index.htm" ;
        $txt  = '&#10;V&auml;rdet i parentes &auml;r upplevd temperatur.' ;
        
        if (!file_exists($file))                // fetch file if it doesn't exist
        {
            $html = getUrl($url) ;
            file_put_contents($file , $html) ;
        }
        
        if (time() - filemtime($file) > 1800)    // fetch file if older than 30 min
        {
            $html = getUrl($url) ;
            file_put_contents($file , $html) ;
        }
        
        if (!isset($html))                      // read file
            $html = file_get_contents($file) ;
        
        preg_match_all("/-?\d+.\d*&nbsp;&#176;C/i" , $html , $temp_A) ;    // get temperatures
        if (count($temp_A , COUNT_RECURSIVE) == 7)
            preg_match_all("/<caption>[^<]+/" , $html , $tempTime) ;
            if (count($tempTime , COUNT_RECURSIVE) == 2)
                echo '<p id="temp" title="' . substr($tempTime[0][0],34) . $txt . '">' . $temp_A[0][0] . '&nbsp;(' . $temp_A[0][4] . ')</p>' ;
    }

// ========================================================================================

	function fetchTemp($filename)
	{
	//	ob_start() ;
	//	$html = getUrl('http://www.essk-wx.com/index.htm') ;					// hämta sida med temperaturer från Rörbergs flygfält
	//	preg_match_all('/(-?\d+,?\d*&nbsp;&#176;C)/' , $html , $temp) ;				// $temp: alla temperaturer
	//	preg_match('/Page updated\s+\K\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}/' , $html , $time) ;	// $time: timestamp
	//	print_r($temp) ;
	//	echo '<hr>' ;
	//	echo count($time) ;
		return array($time[0] , $temp[0]) ;
	}

// ========================================================================================

	function getDlt($fileName)
	{
		ob_start() ;
		echo '<!DOCTYPE html><html>' . "\n" ;

		$dlt = 'http://www.dinlt.se' ;		// webbsida
		$htm = getUrl($dlt . '/valj-ratt') ;	// html-kod
		$pat = '/\/Image[\/\d]*.jpg/i' ;	// mönster
		$pat = '/([^\"\']*\.jpe?g)[\"\']/i' ;

		preg_match_all($pat , $htm , $jpg) ;	// url:er till bilder

		foreach($jpg[0] as $j)
		{
			echo '<img alt="" onerror="this.style.display=\'none\'" src="' . $dlt . $j . '" style="max-width: 240px ; height: auto ; ">' ;
		//	echo '&nbsp;' ;
			echo "\n" ;
		}

		echo '</html>' ;
		file_put_contents($fileName , ob_get_contents()) ;
		ob_end_flush() ;
	}



?>



