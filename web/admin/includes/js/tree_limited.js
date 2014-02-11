var TreeManager= Class.create();
TreeManager.prototype = {
	initialize: function(sourceDiv,nameInstance,callbackFunction,imageArbo,phpArbo,ajaxOption) {
		if (callbackFunction){
			this.callbackFunction=callbackFunction;
		}
		
		
		
		this.TreeAddtree=ajaxOption.addtree;
		this.TreeRemovetree=ajaxOption.removetree;
		this.TreeSource=ajaxOption.source;
		this.TreeRename=ajaxOption.rename;
		this.TreeDrop=ajaxOption.drop;
		this.TreeRemove=ajaxOption.remove;
		this.TreeAdd=ajaxOption.add;
		this.TreeOpenclose=ajaxOption.openclose;
		this.ImageDirectory=imageArbo;//"images/tree/";
		this.PhpDirectory=phpArbo;//"includes/php/tree/";
		this.sourceDiv=sourceDiv;
		this.struct=null;
		this.selectedItem=null;
		this.level=0;
		this.Lastlevel=0;
		this.childNB=1;
		this.count=new Array();
		this.DirPost=new Array();
		this.treeInfo=new Array();
		this.CurrentParent=new Array();
		this.FoundObj=0;
		this._imgMinus=['minus2.gif','minus3.gif','minus5.gif'];
		this._imgPlus=['plus2.gif','plus3.gif','plus5.gif'];
		this.nameInstance=nameInstance;
		this.initTree();
		$('ajaxloader').show();
	},
	initTree:function(){
		new Ajax.Request(this.PhpDirectory+this.TreeSource,
			{
				onComplete: this.createTree.bind(this)
			}
		);
		this.initHTML();
	},
	initHTML:function(){
		menuDiv = Builder.node('div',{id:this.sourceDiv+"_menu",className:""});
		Input = Builder.node('input',{type:"button",onClick:this.nameInstance+".refresh();",value:"refresh"});
		menuDiv.appendChild(Input);
		Input = Builder.node('input',{type:"button",onClick:this.nameInstance+".expend();",value:"open"});
		menuDiv.appendChild(Input);
		Input = Builder.node('input',{type:"button",onClick:this.nameInstance+".collapse();",value:"close"});
		menuDiv.appendChild(Input);
		if (this.TreeAddtree=='Y'){
			Input = Builder.node('input',{type:"button",onClick:this.nameInstance+".addBranch();",value:"+"});
			menuDiv.appendChild(Input);
		}
		if (this.TreeRemovetree=='Y'){
			Input = Builder.node('input',{type:"button",onClick:this.nameInstance+".removeBranch();",value:"-"});
			menuDiv.appendChild(Input);
		}
		$(this.sourceDiv).appendChild(menuDiv);
		treeDiv = Builder.node('div',{id:this.sourceDiv+"_tree",className:"treeListPage"});
		$(this.sourceDiv).appendChild(treeDiv);
	},
	myClick:function (branch) {
		if ($('editInPlace')){
			this.saveEditInPlace();
		}
		this.resetClick();
		this.selectedItem=branch;
		branch.setStyle({
			backgroundColor: '#00bbff',
  			color:'white'
		});
		var page_index=branch.id.split("_")[1];
		if (this.callbackFunction){
			this.callbackFunction(this.treeInfo[page_index].id,this.treeInfo[page_index].txt);
		}
	},
	resetClick:function(){
		if (this.selectedItem){
			this.selectedItem.setStyle({
				backgroundColor: 'transparent',
	  			color:'black'
			});
		}
	},
	createTree:function(e){
		this.struct=eval(e.responseText);
		this.struct.each(this.parseContent.bindAsEventListener(this,null));
		$('ajaxloader').hide();
	},
	addBranch:function(){
		if (confirm("Vous allez ajouter une page")){
			if (this.selectedItem){
				var page_index=this.selectedItem.id.split("_")[1];
				new Ajax.Request(
				this.PhpDirectory+this.TreeAdd,{
					parameters:{branch_id:this.treeInfo[page_index].id},
					onComplete: this.refresh.bindAsEventListener(this)
				});
			}
		}
	},
	removeBranch:function(){
		if (confirm("Vous allez effacer une page")){
			if (this.selectedItem){
				var page_index=this.selectedItem.id.split("_")[1];
				new Ajax.Request(
				this.PhpDirectory+this.TreeRemove,{
					parameters:{branch_id:this.treeInfo[page_index].id},
					onComplete: this.refresh.bindAsEventListener(this)
				});
			}
		}
	},
	
	parseContent:function(branch,Parent,nb){
		this.count[this.level]++;
		if (nb){
			this.childNB=nb;
		}
		if (Parent!=null){
			div= Builder.node('div',{id:'treediv_'+branch.id,style:"border:0px solid;",className:"arboTree_row"});
		}else{
			div= Builder.node('div',{id:'treediv_'+branch.id,style:"border:0px solid;",className:"arboTree_root"});
		}
		Contenair=this.createBranch(branch.id,branch.txt,branch.items,branch.open);
		div.appendChild(Contenair);
		if (Parent!=null){
			Parent.appendChild(div);
		}else{
			$(this.sourceDiv+"_tree").appendChild(div);
		}
		if(branch.items){
			this.level+=1;
			this.count[this.level]=0;
			branch.items.each(this.parseContent.bindAsEventListener(this,div,branch.items.length));
			this.DirPost[this.level]=null;
			this.level-=1;
			if (branch.open==0){
				$('treediv_'+branch.id).descendants().each(function(e){
					if(e.id.indexOf("treediv_")!=-1){
						if (e.visible()){
							e.hide();
						}else{
							e.show();
						}
					}
				});
			}
		}
	},
	expend:function(){
		var arrayDescendants=$('treediv_0').descendants();
		for(var tt=0;tt<arrayDescendants.length;tt++){
			var e=arrayDescendants[tt];
			if(e.src){
				imgSrc=e.src.split("/").last();
				if (this._imgPlus.indexOf(imgSrc)!=-1){
					
					var tabId=e.alt.split("_");
					this.openCloseDescendants(tabId[0],e,tabId[1]);
				}
			}
		}
	},
	collapse:function(){
		var arrayDescendants=$('treediv_0').descendants();
		for(var tt=0;tt<arrayDescendants.length;tt++){
			var e=arrayDescendants[tt];
			if(e.src){
				imgSrc=e.src.split("/").last();
				if (this._imgMinus.indexOf(imgSrc)!=-1){
					var tabId=e.alt.split("_");
					if (tabId[0]!=0){
						this.openCloseDescendants(tabId[0],e,tabId[1]);
					}
				}
			}
		}
	},
	createBranch:function(id,txt,child,openFolder){
		if(child){
			var gotChild=true;
			this.CurrentParent[this.level]=id;
			
		}else{
			var gotChild=false;
		}
		if (this.CurrentParent[this.level]){
			var CurentParent=this.CurrentParent[this.level];
			if (this.CurrentParent[this.level]==CurentParent){
				var CurentParent=this.CurrentParent[this.level-1];
			}
		}else{
			var CurentParent=this.CurrentParent[this.level-1];
		}
		if (!CurentParent){
			CurentParent=0;
		}
		this.treeInfo.push(
			{
				'id':id,
				'table':'treetable_'+id,
				'txt':txt,
				'div':'treediv_'+id,
				'child':gotChild,
				'parent':CurentParent,
				'drag':null
			}
		);
		table = Builder.node('table',{id:'treetable_'+id});
		tbody = Builder.node('tbody');
		tr = Builder.node('tr');
		for (xx=0;xx<this.level;xx++){
			if (this.DirPost[xx]!=true){
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+"empty.gif",alt:""})]);
			}else{
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+"line1.gif",alt:""})]);
			}
			tr.appendChild(td);
		}
		this.DirPost[this.level]=false;
		
		if (openFolder==1){
			var SourceArrayImg=this._imgMinus;
		}else{
			var SourceArrayImg=this._imgPlus;
		}
		if (this.level==0){
			td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+"empty.gif",onclick:this.nameInstance+'.openCloseDescendants('+id+',this,'+(this.treeInfo.length-1)+');'})]);
			this.DirPost[this.level]=false;
		}else if (child){
			if (this.count[this.level]==this.childNB){
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+""+SourceArrayImg[0],alt:id+"_"+(this.treeInfo.length-1),onclick:this.nameInstance+'.openCloseDescendants('+id+',this,'+(this.treeInfo.length-1)+');'})]);
				this.DirPost[this.level]=false;
			}else{
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+""+SourceArrayImg[1],alt:id+"_"+(this.treeInfo.length-1),onclick:this.nameInstance+'.openCloseDescendants('+id+',this,'+(this.treeInfo.length-1)+');'})]);
				this.DirPost[this.level]=true;
			}
		}else{
			if(this.count[this.level]==this.childNB || this.count[this.level]>this.childNB){
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+"line2.gif",alt:""})]);
			}else{
				td = Builder.node('td',[ Builder.node('img',{src:this.ImageDirectory+"line3.gif",alt:""})]);
			}
		}
		
		tr.appendChild(td);
		
		if (child){
			if (openFolder==1){
				img = Builder.node('img',{className:'handlesortable',src:this.ImageDirectory+"folderopen.gif",alt:""});
			}else{
				img = Builder.node('img',{className:'handlesortable',src:this.ImageDirectory+"folder.gif",alt:""});
			}
		}else{
			img = Builder.node('img',{className:'handlesortable',src:this.ImageDirectory+"page.gif",alt:""});
		}
		this.treeInfo[this.treeInfo.length-1].img=img;
		td = Builder.node('td');
		td.appendChild(img);		
		tr.appendChild(td);		
		td = Builder.node('td',{className:'arboTreecanevas'});
		_div = Builder.node('div',{onclick:this.nameInstance+'.myClick(this);',id:'page_'+(this.treeInfo.length-1),className:'arboTreecontent arboTreedrag',onDblClick:this.nameInstance+'.renameInPlace(this);'},txt);
		this.treeInfo[this.treeInfo.length-1].drag=new Draggable(_div,{revert:true});
		Droppables.add(_div,{
			
			accept:'arboTreedrag',
			hoverclass:'arboTreedragOver',
			onDrop: this.dropAction.bind(this)
		});
		td.appendChild(_div);
		tr.appendChild(td);
		tbody.appendChild(tr);
		table.appendChild(tbody);
		this.Lastlevel=this.level;
		return table;
	},
	dropAction:function(drag,drop){
		var DragObj_index=drag.id.split("_")[1];
		var DropObj_index=drop.id.split("_")[1];
		new Ajax.Request(
		this.PhpDirectory+this.TreeDrop,{
			parameters:{drag_id:this.treeInfo[DragObj_index].id,drop_id:this.treeInfo[DropObj_index].id},
			onComplete: this.refresh.bindAsEventListener(this)
		})
	},
	refresh:function(e){
		$('ajaxloader').show();
		for (xx=this.treeInfo.length-1;xx>=0;xx--){ 
			//Debugger.DEBUG("treediv_"+this.treeInfo[xx].id);
			$("treediv_"+this.treeInfo[xx].id).remove();
 		}
  		$(this.sourceDiv+"_tree").remove();	
  		$(this.sourceDiv+"_menu").remove();	
  		this.treeInfo.clear();
  		this.initTree();	
	},
	openCloseDescendants:function(id,img,idTree){
		imgSrc=img.src.split("/").last();
		if (this._imgMinus.indexOf(imgSrc)!=-1){
			img.src=this.ImageDirectory+this._imgPlus[this._imgMinus.indexOf(imgSrc)];
			this.treeInfo[idTree].img.src=this.ImageDirectory+"folder.gif";
			var valueOpenClose=0;
		}else if (this._imgPlus.indexOf(imgSrc)!=-1){
			img.src=this.ImageDirectory+this._imgMinus[this._imgPlus.indexOf(imgSrc)];
			this.treeInfo[idTree].img.src=this.ImageDirectory+"folderopen.gif";
			var valueOpenClose=1;
		}
		new Ajax.Request(this.PhpDirectory+this.TreeOpenclose,{
			parameters:{openclose:valueOpenClose,branch_id:id}
		});
		
		this.openCloseItems('treediv_'+id);
	},
	openCloseItems:function(id){
		$(id).descendants().each(function(e){
			if(e.id.indexOf("treediv_")!=-1){
				if (e.visible()){
					e.hide();
				}else{
					e.show();
				}
			}
		});
	},
	renameInPlace:function(id){
		if ($('editInPlace')){
			this.saveEditInPlace();
		}
		this.saveEditIntPlaceValue=id.innerHTML;	
		this.saveEditIntPlaceId=id;
		id.update("");
		Input = Builder.node('input',{type:'text',style:'border: 1px solid #333;background-color: #555;font-size:7pt;color:white;',id:'editInPlace',value:this.saveEditIntPlaceValue,onBlur:this.nameInstance+'.saveEditInPlace();'});
		id.appendChild(Input);		
		$('editInPlace').focus();
		$('editInPlace').select();
	},
	saveEditInPlace:function(){
		var newvalue=$F('editInPlace');
		$('editInPlace').remove();
		this.saveEditIntPlaceId.update(newvalue);
		NodeInfo=$(this.saveEditIntPlaceId).id.split("_")[1];
		if (newvalue.strip()!=""){
			new Ajax.Request(this.PhpDirectory+this.TreeRename,{
				parameters:{new_value:newvalue,branch_id:this.treeInfo[NodeInfo].id},
				onComplete: function(e){
					//Debugger.DEBUG(e.responseText);
				}}
			)
		}else{
			this.saveEditIntPlaceId.update(this.saveEditIntPlaceValue);
		}
	}
};