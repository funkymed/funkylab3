//-------------------------------------------------------------------------------
// Functions globals
//-------------------------------------------------------------------------------
function makeHashKey(){
	var KeyH = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	var HK = "";
	for (var bb = 0; bb<6; bb++) {
		var rand = Math.round(Math.random()*KeyH.length-2);
		if (rand<0) {
			rand = 0;
		} else if (rand>KeyH.length-2) {
			rand = KeyH.length-2;
		}
		HK += KeyH[rand];
	}
	return HK;
}

function blurred(o) {
   o.setStyle({
		backgroundColor:'#aaa',
		border:'2px #eee solid',
		color:'white'
	});
}
function focused(o) {
   o.setStyle({
		backgroundColor:'#ffffff',
		border:'2px #00bbff solid',
		color:'black'
	});
}

function tabover(o) {
	currentBackgroundSaved=o.style.background;
	o.setStyle({
		backgroundColor:'#00bbff',
		color:'white'
	});
}
function tabout(o) {
	o.setStyle({
		backgroundColor:currentBackgroundSaved,
		color:'black'
	});
}
