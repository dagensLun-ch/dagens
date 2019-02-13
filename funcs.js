function displayDate() {
	const svDag = ["s&ouml;n" , "m&aring;n" , "tis" , "ons" , "tors" , "fre" , "l&ouml;r"] ;                                                                        // svenska veckodagar
	const svMan = ["NULL" , "januari" , "februari" , "mars" , "april" , "maj" , "juni" , "juli" , "augusti" , "september" , "oktober" , "november" , "december"] ;  // svenska månader
	const d = new Date() ;                                                                                                                                          // datumombjekt
	const datum = d.getDate() ;                                                                                                                                     // dag i månaden
	const manad = svMan[1+d.getMonth()] ;                                                                                                                           // aktuell månad på svenska
	const dagen = svDag[d.getDay()] + "dagen den " ;                                                                                                                // aktuell veckodag på svenska                     
	const bokst = -1 == [1,2,21,22,31].indexOf(datum) ? "e" : "a" ;                                                                                                 // a eller e beroende på dag i månaden                   
	document.getElementById("date").innerHTML = dagen + datum + ":" + bokst + " " + manad ;
}

function getDoc(url) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			return this.responseText ;
		}
	} ;
	xmlhttp.open("GET" , url , true) ;
	xmlhttp.send() ;
}

function makeNavLinks() {
	var i , link ;
	for (i=0 ; i<data.length ; i++) {
		link = document.createElement("a") ;
		link.appendChild(document.createTextNode(data[i].NAM)) ;
		link.href = "menus.html#" + data[i].LAB ;
		link.target = "menus" ;	
		document.getElementById("links").appendChild(link) ;
		document.getElementById("links").innerHTML += "<br>" ;
	}
}

function makeMenu() {

}
