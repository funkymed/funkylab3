var MenuOpen=false;
var allObj={
	id:[],
	obj:[],
};

var frontAdmin = Class.create();
frontAdmin.prototype = {
	initialize: function() {
		var tabAllCol=new Array();
		$$('.colWidget').each(function(e){tabAllCol.push(e.id);});
		this.dropzone=tabAllCol;
		$$('#menu .obj').each(function(e){new Draggable(e,{revert:true});});
		$$('.colWidget').each(this.createSort.bindAsEventListener(this));
	},
	resetAllColumn:function(){
		$$('.colWidget').each(function(e){Sortable.destroy(e.id);});
		$$('.colWidget').each(this.createSort.bindAsEventListener(this,this.dropzone));
	},
	destroy:function(e){
		Sortable.destroy(e.id);
	},
	createSort:function (e){
		Debugger.DEBUG(e.id);
		Sortable.create(e.id,{
 			dropOnEmpty:true,
 			handle:'drag',
 			tag:'div',
 			containment:this.dropzone,
 			constraint:false
 		});
		Droppables.add(e.id,{
			accept:'obj',
			hoverclass:'droppableItem',
			onDrop: this.addDrop.bindAsEventListener(this,e)
		});
	},
	addDrop:function(e,b){
		if (e.id){
			this.add(e.id,b);
		}else{
			this.add(e,b);
		}
	},
	add:function(e,b){
		var id="obj_"+this.makeHashKey();
		allObj.id.push(id);
		allObj.obj.push(new editWidget(id,b,e,this));
		this.resetAllColumn();
 		Debugger.DEBUG($H(allObj).inspect());
	},
	makeHashKey:function (){
		var KeyH = new Array(
			"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", 
			"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
		);
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
};


var editWidget = Class.create();
editWidget.prototype = {
	initialize: function(id,dropped,dragg,objsource) {
		this.divID=id;
 		var ObjHTML='<img src="http://www.bonvga.net/files/images/radio_test_02.jpg" width="192" height="192" />';
 		var boxString='<div id="'+id+'"><div class="drag">'+id+'-'+dragg+' <a href="javascript:allObj.obj['+(allObj.obj.length)+'].remove();">[x]<\/a><\/div><div class="box">'+ObjHTML+'<\/div><\/div>';
 		new Insertion.Bottom(dropped, boxString);
	},
	remove:function (){
		$(this.divID).remove();
		allObj.id[allObj.id.indexOf(this.divID)]=null;
		allObj.obj[allObj.obj.indexOf(this)]=null;
		var found=false;
		for (tt=0;tt<allObj.id.length;tt++){
			if(allObj.id[tt]!=null){
				found=true;
			}
		}
		if (found!=true){
			allObj.id.clear();
			allObj.obj.clear();
		}
		Debugger.DEBUG($H(allObj).inspect());
	}
};

function toggleMenu(){
 	var optionAnimMenu={duration:0.8,transition: Effect.Transitions.sinoidal,queue: {position:'end', scope: 'toggleMenuAnim'}};
 	if(MenuOpen==true){
     	MenuOpen=false;
     	optionAnimMenu.x=-92;
     	new Effect.Move('menu', optionAnimMenu);
     	$$('#menu .btn')[0].update(">>");
 	}else if(MenuOpen==false){
     	MenuOpen=true;
     	$$('#menu .btn')[0].update("<<");
     	optionAnimMenu.x=92;
     	new Effect.Move('menu', optionAnimMenu);
 	}
}