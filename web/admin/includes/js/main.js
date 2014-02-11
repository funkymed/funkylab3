var Debugger=new Object();
var accordeonObj=new Object();
var administration=new Object();
var currentOption;
var currentBackgroundSaved;
var winForm;
var XMLValueFile="";
var tinyMCE;
var filemanagerObj	= new Object();
this.documentBasePath = document.location.href;
if (this.documentBasePath.indexOf('?') != -1)
	this.documentBasePath = this.documentBasePath.substring(0, this.documentBasePath.indexOf('?'));
this.documentURL = this.documentBasePath;
this.documentBasePath = this.documentBasePath.substring(0, this.documentBasePath.lastIndexOf('/'));
		
var jsFiles = [
	"includes/js/functions_globals.js",
	"includes/js/debugger.js",
	"includes/js/accordeon.js",
	"includes/js/selectfile.js",
	"includes/js/selectdir.js",
	"includes/js/tablesort.js",
	"includes/js/tree_limited.js",
	"includes/js/window.js",
	"includes/js/tooltip.js",
	"includes/js/lightwindow.js",
	"includes/js/calendar_date_select.js",
	"includes/js/calendar_date_select_format_hyphen_ampm.js",
	"includes/js/yahoo.color.js",
	"includes/js/colorpicker.js",
	"includes/js/FlashTag.js",
	"includes/js/control.select_multiple.js",
	"includes/js/multiselect.js",
	"includes/js/filemanager.js",
	"includes/js/system.js"
].each(function (libraryName){document.write('<script type="text/javascript" src="'+this.documentBasePath+'/'+libraryName+'"></script>');});

var cssFiles = [	
	"css/filemanager.css",
	"css/themes/filemanager.css",
	"css/style.css",
	"css/default.css",
	"css/tree.css",
	"css/sortable.css",
	"css/lightwindow.css" ,
	"css/colorpicker.css" ,
	"css/themes/default.css",
	"css/themes/alert.css",
	"css/themes/alphacube.css",
	"css/themes/mac_os_x.css",
	"css/basic.css",
	"css/multiselect.css",
	"css/calendar_date_select.css"
].each(function (cssName){document.write('<link type="text/css" rel="stylesheet" href="'+this.documentBasePath+'/'+cssName+'" media="screen" />');});
		

tinyMCE.init({
	mode : "exact",
	theme : "advanced",
	language : "fr",
	theme_advanced_buttons1 : "undo,redo,forecolor,backcolor,bold,italic,underline,justifyleft,justifycenter,justifyright,justifyfull,link,unlink,cleanup,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	cleanup_on_startup : true,
	cleanup: true,
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
	
Event.observe(window, 'load', function() {
  		administration=new backoffice();
	}
);
