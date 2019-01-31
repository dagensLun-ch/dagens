<html lang="sv">
 	<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<style type="text/css">
			body
			{
				font-family: georgia ;
				font-size: 100% ;
			}
			
			a
			{
				color: #0000ff ;
				text-decoration: none ;
			}

			span
			{
				font-size: 85% ;
			}
		</style>
	</head>
	<body>
<?php
	include ("funcs.php") ;
	init() ;
	global $data ;
	
	// Skriv ut datum:	
	$svDag = array("s&ouml;n" , "m&aring;n" , "tis" , "ons" , "tors" , "fre" , "l&ouml;r") ;  // svenska veckodagar
	$svMan = array("NULL" , "januari" , "februari" , "mars" , "april" , "maj" , "juni" , "juli" , "augusti" , "september" , "oktober" , "november" , "december") ;  // svenska månader
	$bokst = ":e " ;
	if ( in_array(date('j') , array(1,2,21,22,31)) )
		$bokst = ":a " ;

	echo t(2) . '<br>' ;
	echo t(2) . date('j') . $bokst . $svMan[date('n')] . '<br>' ;
	echo t(2) . $svDag[date('w')] . "dag v. " . date('W') ;
	
	// Skriv ut datum:
	echo t(2) ;
	showTemp() ;
	echo t(2) . '<hr>' ;

	foreach ($data as $key => $i)
	{
		echo t(2) . '<a href="menus.php#' . $key . '" target="menus">' . $data[$key][0] . '</a><br>' ;
	}
	echo t(0) ;
?>

	</body>
</html>

