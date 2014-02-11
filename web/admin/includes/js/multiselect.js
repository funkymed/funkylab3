/**
 * @author Cyril Pereira <cyril.pereira@gmail.comt>
 * @author of control.select_multiple.js Ryan Johnson <ryan@livepipe.net>
 * @package Control.SelectMultiple
 * @license MIT
 * @url lab.cyrilpereira.com/multiselect/
 * @url of control.select_multiple.js livepipe.net/projects/control_select_multiple/
 * @version 1.0.0
 */
 
var allEventMultiSelect=new Array();
var MultiSelectObj = Class.create();
MultiSelectObj.prototype = {
	initialize: function(multi_selectOBj,init,_source,_input) {
		this._source=_source;
		this.json=multi_selectOBj;
		this.hkey=this.makeHashKey();
		
		this._input=_input;
		
		this.id_select="select_"+this.hkey;
		this.id_btnopen="btn_open"+this.hkey;
		this.id_btnclose="btn_close"+this.hkey;
		this.id_select="select_"+this.hkey;
		this.id_divtab="divtab_"+this.hkey;
		this.id_divroot="divroot_"+this.hkey;
		this.multiselectObj=new Object();
		selectList = Builder.node("select",{id:this.id_divroot,style:"position:relative;width:200px;"});
		btnMultiSelect = Builder.node("input",{id:this.id_btnopen,style:"width:100px;",value:"Multi Select",type:"button"});
		DivtableScrollMultiSelect= Builder.node("div",{style:"overflow:auto;overflow-x:hidden;background:white;height:150px;"});
		TableDivMultiSelect = Builder.node("table", {className:"select_multiple_table",style:"width:100%;",cellpadding:2,cellspacing:0,border:0});
		tbodyTableDivMultiSelect = Builder.node('tbody');
		for (rr=0;rr<multi_selectOBj.length;rr++){
			var confOption={value:multi_selectOBj[rr].value};
			if (multi_selectOBj[rr].selected){ confOption.selected="selected"; }
			optionList = Builder.node("option",confOption,multi_selectOBj[rr].label);
			selectList.appendChild(optionList);
			if (rr%2==0){ tr = Builder.node("tr",{className:"odd"}); }else{ tr = Builder.node("tr",{className:"even"}); }
			td1 = Builder.node("td",{className:"select_multiple_name"},multi_selectOBj[rr].label);
			td2 = Builder.node("td",{className:"select_multiple_checkbox"},[ Builder.node("input",{type:"checkbox",value:multi_selectOBj[rr].value})]);
			tr.appendChild(td1);
			tr.appendChild(td2);
			tbodyTableDivMultiSelect.appendChild(tr);
		}
		TableDivMultiSelect.appendChild(tbodyTableDivMultiSelect);
		DivtableScrollMultiSelect.appendChild(TableDivMultiSelect);
		DivMultiSelect= Builder.node("div",{id:this.id_divtab,className:"select_multiple_container",style:"display:none;"});
		HeadOptionSelect= Builder.node("div",{className:"select_multiple_header",type:"button"},"Select Multiple");
		DivMultiSelect.appendChild(HeadOptionSelect);
		DivMultiSelect.appendChild(DivtableScrollMultiSelect);
		FooterOptionSelect= Builder.node("div",{className:"select_multiple_submit",type:"button"});
		BtnFooterOptionSelect= Builder.node("input",{style:"width:100px;",type:"button",value:"Done",id:this.id_btnclose});
		FooterOptionSelect.appendChild(BtnFooterOptionSelect);
		DivMultiSelect.appendChild(FooterOptionSelect);
		$(this._source).appendChild(selectList);
		$(this._source).appendChild(btnMultiSelect);
		$(this._source).appendChild(DivMultiSelect);
		this.multiselectObj = new Control.SelectMultiple(this.id_divroot,this.id_divtab,{
			checkboxSelector: "table.select_multiple_table tr td input[type=checkbox]",
			nameSelector: 'table.select_multiple_table tr td.select_multiple_name',
			value:init,
			afterChange:this.onUpdatechange.bind(this)
		});
		this.multiselectObj.setSelectedRows = function(){
			this.checkboxes.each(function(checkbox){
				var tr = $(checkbox.parentNode.parentNode);
				tr.removeClassName('selected');
				if(checkbox.checked)
					tr.addClassName('selected');
			});
		}.bind(this.multiselectObj);
		this.multiselectObj.checkboxes.each(this.checkObserve.bindAsEventListener(this));
		this.multiselectObj.setSelectedRows();
		$(this.id_btnopen).observe('click',function(event){
			$(this.select).style.visibility = 'hidden';
			Position.clone($(this.container).previous().previous(),$(this.container),{setWidth:false,setHeight:false});			
			new Effect.BlindDown(this.container,{ duration: 0.3 });
			Event.stop(event);
			return false;
		}.bindAsEventListener(this.multiselectObj));
		$(this.id_btnclose).observe('click',function(event){
			$(this.select).style.visibility = 'visible';
			new Effect.BlindUp(this.container,{ duration: 0.3 });
			Event.stop(event);
			return false;
		}.bindAsEventListener(this.multiselectObj));
		this.multiselectObj.setValue(init);
		this.multiselectObj.setSelectedRows();
		$(this._input).value=this.multiselectObj.getValueForExtraOption();
	},
	checkObserve:function(objcheckbox){
		$(objcheckbox).observe('click',this.multiselectObj.setSelectedRows);
	},
	onUpdatechange:function(value){
		if(this.multiselectObj && this.multiselectObj.setSelectedRows){
			$(this._input).value=this.multiselectObj.getValueForExtraOption();
			this.multiselectObj.setSelectedRows();
		}
	},
	makeHashKey:function (){
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
}