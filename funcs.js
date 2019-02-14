Date.prototype.getWeekNumber = function() {
	var d = new Date(Date.UTC(this.getFullYear(), this.getMonth(), this.getDate()));
	var dayNum = d.getUTCDay() || 7;
	d.setUTCDate(d.getUTCDate() + 4 - dayNum);
	var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
	return Math.ceil((((d - yearStart) / 86400000) + 1)/7)
} ;

/* ~~~ */

function displayDate() {
	const svDag = ["s&ouml;n" , "m&aring;n" , "tis" , "ons" , "tors" , "fre" , "l&ouml;r"] ;                                                                        // svenska veckodagar
	const svMan = ["NULL" , "januari" , "februari" , "mars" , "april" , "maj" , "juni" , "juli" , "augusti" , "september" , "oktober" , "november" , "december"] ;  // svenska månader
	const d = new Date() ;                                                                                                                                          // datumombjekt
	const datum = d.getDate() ;                                                                                                                                     // dag i månaden
	const manad = svMan[1+d.getMonth()] ;                                                                                                                           // aktuell månad på svenska
	const dagen = svDag[d.getDay()] + "dag " ;                                                                                                                // aktuell veckodag på svenska                     
	const bokst = -1 == [1,2,21,22,31].indexOf(datum) ? "e" : "a" ;                                                                                                 // a eller e beroende på dag i månaden                   
	const vecka = d.getWeekNumber() ;
	document.getElementById("date").innerHTML = datum + ":" + bokst + " " + manad + "<br>" + dagen + "v. " + vecka ;
}

/* ~~~ */

function changeHeight(id , factor) {
	document.getElementById(id).height = parseInt(document.getElementById(id).height) + factor ;
}

/* ~~~ */

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

/* ~~~ */

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

/* ~~~ */

function makeMenus() {
	var i , menu , legd , ifrm , butp , butm ;
	for (i=0 ; i<data.length ; i++) {
		menu = document.createElement("fieldset") ;
		menu.id = data[i].LAB ;
			legd = document.createElement("legend") ;
			legd.appendChild(document.createTextNode(data[i].NAM)) ;
		menu.appendChild(legd) ;
			ifrm = document.createElement("iframe") ;
			ifrm.scrolling = "no" ;
			ifrm.frameborder = "0" ;
			ifrm.id = data[i].NAM ;
			ifrm.src = data[i].URL ;
			ifrm.height = data[i].HGT ;
		menu.appendChild(ifrm) ;
			butp = document.createElement("input") ;
			butp.type = "button" ;
			butp.value = "+" ;
			butp.onClick = "changeHeight(" + data[i].NAM + " , 100)" ;		
		menu.appendChild(butp) ;
		document.body.appendChild(menu) ;
		document.body.innerHTML += "<br>" ;
	}
}

/* ~~~ */

function getMenu(rest) {
	const page = getDoc("http://racines.se/meny/") ;
	alert(page) ;

}

/* ~~~ */

/*
Hämta NAM där LAB=Cor:

  var r = data.filter(
      function(data) {
        return data.LAB == "Cor";
      }
  )[0];

console.log(r.NAM);

*/
