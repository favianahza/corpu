	let counter = false;

	// AJAX CALL
	function ajax(content){	
		if( counter && $('#CONTENT').children().data('loaded') == content ){
		 alert('loaded');	
		 return;
		}
		$('#CONTENT').children().remove();
		$('#CONTENT').load(content);
		counter = true;
	}


$(function(){
	$("#loader-wrapper").fadeOut(750);	
	$("#content-loader-wrapper").fadeOut(750);	
});