Event.observe(window, 'load', function() {
	var win = new Window({
		className: "alphacube", 
		title: "", width:640, height:150,
		minimizable:false,
		maximizable:false,
		closable:false,
		draggable:false,
		resizable:false
	}); 
	win.setAjaxContent("includes/php/login/login.html",{
		method:'get',
		onComplete:function(e){
			setTimeout(function(){
				Form.focusFirstElement('EditFormItems')
			},100);
		}
	}, true, true);
});

function loginAdmin(){
	var obj=$('EditFormItems').serialize(true);
	new Ajax.Request('includes/php/login/login.php', {
		parameters:obj,
		onComplete: function(e){
			if (e.responseText=="1"){
				$('error').update('connexion...');
				document.location="home.php"
			}else{
				$('error').update(e.responseText);
			}
			Effect.Appear('error');
		}
	});
}