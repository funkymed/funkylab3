var MenuOption=new Array();
var accordeon = Class.create();
accordeon.prototype = {
	initialize: function(jSON,divSource,callbackFunction) {
		if (callbackFunction){
			this.callbackFunction=callbackFunction;
		}
		this.MainUL = Builder.node('ul');
		this.countItem=0;
		this.speed=0.3;
		this.SelectId=null;
		this.AllAccordeon=new Array();
		this.divSource=divSource;
		jSON.each(this.addItem.bind(this));
		
		this.MainUL.appendChild(this.makeToolBar());
		this.MainUL.appendChild(this.makeDeconnexion());
		$(this.divSource).appendChild(this.MainUL);
		
	},
	
	makeToolBar:function(){
		li= Builder.node('li');
		a = Builder.node('a',{onclick:'javascript:filemanagerObj.openFileManager();',href:"javascript:void(0)"});
		img = Builder.node('img',{align:"middle",src:'images/hdd.png',alt:'iconMenu'});
		a.appendChild(img);
		a.innerHTML+="File Manager<br />";
		li.appendChild(a);
		return li;
	},
	
	makeDeconnexion:function(){
		li= Builder.node('li');
		a = Builder.node('a',{onclick:'javascript:administration.deconnexion();',href:"javascript:void(0)"});
		img = Builder.node('img',{align:"middle",src:'images/quit.png',alt:'iconMenu'});
		a.appendChild(img);
		a.innerHTML+="Deconnexion<br />";
		li.appendChild(a);
		return li;
	},
	
	
	addItem: function(s){
		this.countItem++;
		li = Builder.node('li',{style:"clear:both"});
		a = Builder.node('a',{onclick:'javascript:accordeonObj.openClose('+this.countItem+');',href:"javascript:void(0)"});
		img = Builder.node('img',{align:"middle",src:'images/listclose.png',alt:'iconMenu',id:'accordeonIcon'+this.countItem,style:'margin:5px;'});
		a.appendChild(img);
		
		img = Builder.node('img',{align:"middle",src:s.Icon,alt:s.Titre});
		a.appendChild(img);
		
		a.innerHTML+=s.Titre;
		li.appendChild(a);
		this.MainUL.appendChild(li);
		ul = Builder.node('ul',{style:"display:none;",id:'menu'+this.countItem});
		this.MainUL.appendChild(ul);
		s.Content.each(this.addSubItem.bindAsEventListener(this,ul));
		this.AllAccordeon.push(
			{
				icon:'accordeonIcon'+this.countItem,
				content:'menu'+this.countItem,
				id:this.countItem
			}
		);
	},
	
	ActionOpenClose:function(id,e){
		this.SelectId=id;
		var optionAcc={duration:this.speed,queue: {position:'end', scope: 'accordeonAnim'}};
		
		if (e.id==this.SelectId && $(e.content).visible()==false){
			$(e.icon).src="images/listopen.png";
			new Effect.BlindDown(e.content,optionAcc);
		}else if (e.id==this.SelectId && $(e.content).visible()==true){
			this.SelectId=null;
			$(e.icon).src="images/listclose.png";
			new Effect.BlindUp(e.content,optionAcc);
		}else if ($(e.content).visible()==true){
			$(e.icon).src="images/listclose.png";
			new Effect.BlindUp(e.content,optionAcc);
		}
	},
	openClose:function(id){
		this.AllAccordeon.each(this.ActionOpenClose.bind(this,id));
	},
	addSubItem: function(s,ul){
		//Debugger.DEBUG($H(s.Config).toQueryString());
		
		MenuOption.push(s.Config);
		a = Builder.node('a',{id:'menuBTN_'+(MenuOption.length-1),href:'javascript:void(0)'});
		img = Builder.node('img',{align:"middle",src:s.Icon,alt:s.Titre});
		
		a.appendChild(img);
		
		a.innerHTML+=s.Titre+"<br/>";
		Event.observe(a,'click', this.callbackFunction);
		
		ul.appendChild(a);
		
	}
};