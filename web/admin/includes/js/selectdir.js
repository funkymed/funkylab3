// selectdir.js v1.0
//
// Copyright (c) 2007 Cyril Pereira
// Author: Cyril Pereira | http://www.cyrilpereira.com
// 
// selectdir is freely distributable under the terms of an MIT-style license.
//
/*-----------------------------------------------------------------------------------------------*/

var SelectDir = Class.create();
SelectDir.prototype = {
	initialize: function(objConfiguration) {
		this.selectDir;
		this.validExt=objConfiguration.ValidExtension;
		this.inputSelect=objConfiguration.InputId;
		this.idManager=objConfiguration.DivId;
		this.selectDirOBJ=objConfiguration.SourceObjName;
		this._source="../../../../"+objConfiguration.SourceDir; // path from the php file
		this.selectDir;
		this._currentdir  = this._source+objConfiguration.DirDefault;
		this._currentdisplay  =objConfiguration.DirDefault;
		this.contentDirJSON=new Object();
		this.Hkey=makeHashKey();
		div_display = Builder.node('div',{});
		div_select = Builder.node('div',{style:"",id:"fileBrowser_"+this.Hkey});
		div_select_container = Builder.node('div',{style:"z-index:999;position:absolute;background:white;display:none;border:1px #cbcbcb solid;height:150px;font-size:10pt;font-family:helvetica;width:200px;overflow:auto;overflow-x:hidden;",id:"fileBrowserContainer_"+this.Hkey});
		div_file = Builder.node('div',{id:"fileinput_"+this.Hkey,style:"background:url('images/back_select.gif');float:left;background-repeat:no-repeat;height:22px;padding-top:3px;padding-left:5px;width:203px;font-family:helvetica;font-size:9pt;",onClick:this.selectDirOBJ+".browseFile();"},String(this._currentdisplay.truncate(26)));
		
		div_file.onmouseover=function(){this.style.background="url('images/back_select_over.gif') no-repeat";}
		div_file.onmouseout=function(){this.style.background="url('images/back_select.gif') no-repeat";}
		
		
		div_display.appendChild(div_file);
		$(this.idManager).appendChild(div_display);
		
		
		divclear = Builder.node('div',{style:"clear:both;"});
		div_display.appendChild(divclear);
		
		div_select_container.appendChild(div_select);
		$(this.idManager).appendChild(div_select_container);
		
		this.updateDirList();
	},
	updateDirList:function(){
		new Ajax.Request('includes/php/filemanager/getjson.php', {
			method: 'post', 
			parameters:{_currentdir:this._currentdir,validExt:this.validExt},
			onComplete: this.displaydir.bind(this)
		});
	},
	enterDirectory:function(newdir){
		this._currentdisplay+=newdir+"/";
		this._currentdir  +=newdir+"/";
		$("fileinput_"+this.Hkey).update(this._currentdisplay.truncate(26));
		this.updateDirList();
	},
	parentDirectory:function(){
		this._currentdir=this.downParentPosition(this._source,this._currentdir);
		this._currentdisplay=this._currentdir.substr(this._source.length,this._currentdir.length);
		$("fileinput_"+this.Hkey).update(this._currentdisplay.truncate(26));
		this.updateDirList();
	},
	downParentPosition:function(start,dir){
		var tmpdir=dir.split("/");
		this._currentdisplay="";
		dir="";//start;
		for (aa=0;aa<tmpdir.length-2;aa++){
			dir+=tmpdir[aa]+"/";
		}
		return dir;
	},
	displaydir:function(e){
		this.contentDirJSON=eval(e.responseText)[0];
		$("fileBrowser_"+this.Hkey).update("");
		if (this._currentdir!=this._source){
			div = Builder.node('div',{onClick:this.selectDirOBJ+".parentDirectory();",style:"cursor:pointer"},"parent");
			this.makeMouseOver(div);
			$("fileBrowser_"+this.Hkey).appendChild(div);
		}
		for (aa=0;aa<this.contentDirJSON.DIR.COUNT;aa++){
			div = Builder.node('div',{onClick:this.selectDirOBJ+".enterDirectory('"+this.contentDirJSON.DIR.NAME[aa]+"');",style:"cursor:pointer"});
			this.makeMouseOver(div);
			img = Builder.node('img',{align:"left",src:"includes/php/filemanager/"+this.contentDirJSON.DIR.ICON[aa]});
			div.appendChild(img);
			div.innerHTML+=String(this.contentDirJSON.DIR.NAME[aa]).truncate(26);
			$("fileBrowser_"+this.Hkey).appendChild(div);
		}
		$(this.inputSelect).value=(this._currentdisplay);
		$("fileinput_"+this.Hkey).update(this.selectDir.truncate(26));
	},
	makeMouseOver:function(elt){
		Event.observe(elt,'mouseover', function(e){
			var elt = Event.element(e);
			elt.setStyle({
				backgroundColor:'#eee'
			});
		});
		Event.observe(elt,'mouseout', function(e){
			var elt = Event.element(e);
			elt.setStyle({
				backgroundColor:'#fff'
			});
		});
	},
	browseFile:function(){
		var objFileSelectContent="fileBrowserContainer_"+this.Hkey;
		if ($(objFileSelectContent).visible()==true){
			$(objFileSelectContent).hide();
		}else{
			$(objFileSelectContent).show();
		}
	}
};