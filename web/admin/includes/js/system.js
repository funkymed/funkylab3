var backoffice = Class.create();
backoffice.prototype = {
  initialize: function() {
    this.modeRefresh=true;
    this.xmlfile="";
    this.id;
    this.TimeCode=makeHashKey();
    this.version="1.0";
    this.arboID;
    this.arboTitre;
    this.arboxmlfile="";
    this.winForm;
    currentRichTextEditor=null;
    currentTextareaRichTextEditor=null;
    Debugger=new debugg();
    Debugger.toggleDebug();
    new Ajax.Request('includes/php/menujson.php', {
      onComplete: this.InitAccordeon.bind(this)
    });

    //var contentFormOnglet = Builder.node('div',{id:"contentFormOnglet",style:"height:100%;border:0px red solid;overflow:hidden;"});
    //$('main').appendChild(contentFormOnglet);
    console.debug($('main'))
    $('ajaxloader').hide();
    filemanagerObj	= new filemanager("filediv");

  },
  InitAccordeon:function(e){
    this.AccordeonJSON=eval(e.responseText);
    accordeonObj=new accordeon(this.AccordeonJSON,'accordeon',this.selectFromAccordeon);
  },
  deconnexion:function(){
    new Ajax.Request('includes/php/login/deconnexion.php', {
      onComplete: function(){
        document.location="index.html";
      }
    });
  },
  arboClickItem:function(a,b){
    administration.arboID=a;
    administration.arboTitre=b;
    administration.arboxmlfile=currentOption.xml;
    $('ajaxloader').show();
    new Ajax.Request(administration.arboxmlfile+'/treePageEdit.php', {
      parameters:{id:a,titre:b,xmlfile:currentOption.xml},
      onComplete: function(o){
        $('ajaxloader').hide();
        $('pagecontent').update(o.responseText);
      }
    });
  },
  getVersion:function(){
    return this.version;
  },
  resetFormContener:function(){
    if ($("arbotree")){
      $("arbotree").remove();
    }
    if ($("contentFormOnglet")){
      $("contentFormOnglet").remove();
    }
  },

  selectFromAccordeon:function(option){
    administration.selectMenu(MenuOption[Event.element(option).id.split("_")[1]]);
  },

  removeTinyMCE:function(){
    if (currentRichTextEditor!=null) {
      var saveCurentRichTextHTML=tinyMCE.getContent(currentTextareaRichTextEditor);
      tinyMCE.execCommand('mceFocus', false, currentTextareaRichTextEditor);
      tinyMCE.execCommand('mceRemoveControl', false,currentTextareaRichTextEditor);
      $(currentTextareaRichTextEditor).innerHTML=saveCurentRichTextHTML;
      tinyMCE.idCounter=0;
      currentRichTextEditor=null;
      currentTextareaRichTextEditor=null;
    }
  },

  initRichEditor:function(o){
    this.removeTinyMCE();
    currentTextareaRichTextEditor=o.id;
    tinyMCE.execCommand('mceAddControl', false,o.id);
    currentRichTextEditor=tinyMCE.getEditorId(currentTextareaRichTextEditor);
  },

  selectMenu:function(ObjTmp){
    if (ObjTmp!=currentOption){
      Obj=ObjTmp;
      currentOption=Obj;
    }
    $('ajaxloader').show();
    switch(currentOption.TYPE){
      case "tree":

        if ($('tableauEditable')){ $('tableauEditable').remove(); }

        new Ajax.Request(Obj.xml+'/treeContainer.php',
          {
            parameters:{xmlfile:Obj.xml},
            onComplete: function(e){
              $('ajaxloader').hide();
              var tableauEditable = Builder.node('div',{id:"tableauEditable",style:"padding:15px;display:none;"});
              $('main').appendChild(tableauEditable);
              $('tableauEditable').update(e.responseText);
              //new Effect.Appear('tableauEditable',{duration:0.6});
              $('tableauEditable').show();
            }
          }
        );

        break;
      case "display":
        if ($('tableauEditable')){ $('tableauEditable').remove(); }

        new Ajax.Request(Obj.xml+"/"+Obj.SCRIPT,
          {
            parameters:{xmlfile:Obj.xml},
            onComplete: function(e){

              var tableauEditable = Builder.node('div',{id:"tableauEditable",style:"padding:15px;display:none;"});
              $('main').appendChild(tableauEditable);
              $('tableauEditable').update(e.responseText);
              //new Effect.Appear('tableauEditable',{duration:0.6});
              $('tableauEditable').show();
              $('ajaxloader').hide();
            }
          }
        );
        break;
      case "server":
        if (Obj.CONFIRM){
          if (confirm(Obj.CONFIRM)){ new Ajax.Request(Obj.xml+"/"+Obj.SCRIPT, {onComplete: function(e){eval(e.responseText);}});}else{$('ajaxloader').hide();}
        }else{
          new Ajax.Request(Obj.xml+"/"+Obj.SCRIPT, {onComplete: function(e){$('ajaxloader').hide();eval(e.responseText);}});
        }
        break;
      case "tableau":

        administration.xmlfile=Obj.xml;
        if ($('tableauEditable')){ $('tableauEditable').remove(); }
        new Ajax.Request('includes/php/tablejson.php',
          {
            parameters:{xmlfile:Obj.xml},
            onComplete: function(e){
              $('ajaxloader').hide();
              var tableauEditable = Builder.node('div',{id:"tableauEditable",style:"padding:15px;display:none;"});
              $('main').appendChild(tableauEditable);
              $('tableauEditable').update(e.responseText)
              SortableTable.load();
              SortableTable.sort($('tableEdit'),1,1);
              //new Effect.Appear('tableauEditable',{duration:0.6});
              $('tableauEditable').show();
              myLightWindow = new lightwindow();
            }
          }
        );
        break;
    }

  },

  refreshCurrentOption:function(){
    $('ajaxloader').hide();
    this.selectMenu(currentOption);
  },

  editForm:function(xmlfile,id){
    this.xmlfile=xmlfile;
    this.id=id;
    this.winForm = new Window(
      {
        className: "alphacube",
        title: "",
        draggable:false,
        width:640, height:400,
        resizable:false,
        minimizable:false,
        maximizable:false,
        destroyOnClose: true,
        showEffectOptions:{duration:0.1},
        hideEffectOptions:{duration:0.1},
        onClose:this.closeForm.bind(this)
      }
    );

    $('ajaxloader').show();
    this.winForm.setAjaxContent("includes/php/editform.php",{
      parameters:{xmlfile:xmlfile,id:id},
      onComplete:function(e){$('ajaxloader').hide();Form.focusFirstElement('EditFormItems');}
    }, true, true);
  },

  addItemPage:function(){
    this.editForm("modules/"+$F('treeMediaSelect'),'new');
  },

  closeForm:function(){
    this.removeTinyMCE();
    if ($('colorpicker')){
      $('colorpicker').hide();
    }
  },

  submitForm:function(){
    if ($('colorpicker')){ $('colorpicker').hide(); }
    this.removeTinyMCE();
    var obj=$('EditFormItems').serialize(true);
    obj.xmlfile=this.xmlfile;
    obj.id=this.id;
    this.winForm.destroy();
    $('ajaxloader').show();

    new Ajax.Request('includes/php/submitform.php', {
      parameters:obj,
      onComplete: this.updateAfterSubmitForm.bind(this)
    });
  },

  updateAfterSubmitForm:function(e){
    Windows.closeAllModalWindows();
    if($('arbotree')!=null){
      var objLink=e.responseText.split(",");
      if (this.modeRefresh==true){
        new Ajax.Request("includes/php/linkarbomedia.php",
          {
            parameters:{
              xmlfile:this.arboxmlfile,
              pere:this.arboID,
              child:objLink[0],
              table:objLink[1]
            },
            onComplete: function(e){
              Debugger.DEBUG(e.responseText);
            }
          }
        );
      }
      this.arboClickItem(this.arboID,this.arboTitre);
    }else{
      this.refreshCurrentOption();
    }

    $('ajaxloader').hide();

  },
  deleteItem:function(xmlfile,id){
    if(confirm("Etes vous sur de vouloir supprimer ?")){
      var obj=new Object();
      obj.xmlfile=xmlfile;
      obj.id=id;
      $('ajaxloader').show();
      new Ajax.Request('includes/php/deleteitem.php', {
        parameters:obj,
        onComplete: this.refreshCurrentOption.bind(this)
      });
    }else{
      $('ajaxloader').hide();
    }
  },
  deleteTreeItem:function(xmlfile,id,div){

    if(confirm("Etes vous sur de vouloir supprimer ?")){
      $(div).remove();

      var obj=new Object();
      obj.xmlfile=xmlfile;
      obj.id=id;
      obj.linkdelete='';
      new Ajax.Request(this.arboxmlfile+'/deleteitem.php', {
        parameters:obj,
        onComplete: function(e){
          administration.arboClickItem(administration.arboID,administration.arboTitre);
        }
      });

    }else{
      $('ajaxloader').hide();
    }
  },
  pagination:function(tab,move,limit){
    new Ajax.Request('includes/php/pagesession.php', {
      parameters:{tab:tab,move:move,limit:limit},
      onComplete: this.refreshCurrentOption.bind(this)
    });
  },
  paginationGoto:function(tab,o){
    new Ajax.Request('includes/php/pagesessiongoto.php', {
      parameters:{tab:tab,goto:$F(o)},
      onComplete: this.refreshCurrentOption.bind(this)
    });
  }

};

