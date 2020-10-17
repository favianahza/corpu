	let counter = false;

	// AJAX CALL
	function ajax(content){	
		// if( counter && $('#CONTENT').children().data('loaded') == content ){
		//  alert('loaded');	
		//  return;
		// }
		$('#CONTENT').children().remove();

		$.ajax({
			 url: content,
    		 type: 'GET',
			 beforeSend: function(){			 	
			 	$('#CONTENT').append('<div id="content-loader-wrapper"></div>');
 			 }, 			
			 success: function(response){
			 	$('#CONTENT').fadeOut(200, function() {			 		
			    	$('#CONTENT').html(response);
			 	}).fadeIn(400);
			 }
		});

		// $('#CONTENT').load(content);
		counter = true;
	}



    // ALIGN MODAL
    function alignModal(){

        var modalDialog = $(this).find(".modal-dialog");

        /* Applying the top margin on modal dialog to align it vertically center */

        modalDialog.css({"margin-top": Math.max(0, ($(window).height() - modalDialog.height()) / 2),
          "transition":'.1s'
        });

    }

    // Align modal when it is displayed

    $(".modal").on("shown.bs.modal", alignModal);

    // Align modal when user resize the window

    $(window).on("resize", function(){

        $(".modal:visible").each(alignModal);

    });



    // SHOW PASSWORD FOR EDITING PASS AND PP
    var pAss = $('[id*="password_ep"]');
    var pAss_pp = $('#password_pp');

    $('#show').on('click', function(){

    if ( pAss.attr('type') == 'password') {

      pAss.attr('type', 'text');

    } else {

      pAss.attr('type', 'password');

    } });

    $('#show_pp').on('click', function(){

    if ( pAss_pp.attr('type') == 'password') {

      pAss_pp.attr('type', 'text');

    } else {

      pAss_pp.attr('type', 'password');

    } });


    // PREVIEW PICT
    function triggerClick() {
      document.getElementById('foto').click();
    }

    function preview(e) {
      if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e) {
          document.getElementById('preview-img').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }     


// UPDATE DATA PASSWORD
$(document).on("click", "#edit_pass", function() {
	$.ajax({
		url: "update_ajax.php",
		type: "POST",
		cache: false,
		data:{
			new_pass: $('#new_password_ep').val(),
			conf_pass: $('#c_password_ep').val(),
			old_pass: $('#o_password_ep').val(),
		},
		dataType: "html",
		success: function(data){
			let result = JSON.parse(data);
			if( 'FailPass' in result ){
				// Failed to Change Password
				Swal.fire(
				  'Gagal !',
				  result.FailPass,
				  'error'
				);
			} else if('Success' in result) {
				// Success to Change Password
				Swal.fire(
				  'Berhasil !',
				  result.Success,
				  'success'
				);				
				$('#changeAP').modal('hide');
				$('#changeAP #new_password_ep').val(''); 
				$('#changeAP #c_password_ep').val('');
				$('#changeAP #o_password_ep').val(''); 
			} else {
				alert(result.Failed);
			}
		}
	});
}); 


// UPDATE PROFILE PICT
$("#edit_pp").click(function(){

        var fd = new FormData();
        var files = $('#foto')[0].files[0];
        var password = $('#password_pp').val();
        fd.append('file',files);
        fd.append('pass',password);

        $.ajax({
            url: 'update_ajax.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
            	console.log(response);
				let result = JSON.parse(response);
				if( 'FailPass' in result ){
					// Failed to Verify Password
					Swal.fire(
					  'Gagal !',
					  result.FailPass,
					  'error'
					);
				} else if('Alert' in result) {
					// Uploading Problems
					Swal.fire(
					  'Gagal !',
					  result.Alert,
					  'error'
					);
				} else {
					// Success to Upload
					Swal.fire(
					  'Berhasil !',
					  result.Success,
					  'success'
					);
					$('img#miniProfile').attr("src", "../assets/img/profile/"+result.ImageName);
					if( $('#YourProfile').length > 0 ){
						$('#YourProfile').attr('src', '../assets/img/profile/'+result.ImageName);
					}
					$('#changePP').modal('hide');
					$('#changePP #password_pp').val('');
					$('#changePP #foto').val('');
				}
            },
        });
    });


// $(document).on("click", "#edit_pp", function() {
//     var fd = new FormData();
//     var files = $('#foto')[0].files[0];
//     fd.append('file',files);
// 	$.ajax({
// 		url: "update_ajax.php",
// 		type: "POST",
// 		cache: false,
// 		data:{
// 			password:$('#password_pp').val()
// 		},	
// 		success: function(data){
// 			console.log(data);
// 			// let result = JSON.parse(data);
// 			// if( 'FailPass' in result ){
// 			// 	// Failed to Change Password
// 			// 	Swal.fire(
// 			// 	  'Gagal !',
// 			// 	  result.FailPass,
// 			// 	  'error'
// 			// 	);
// 			// } else if('Success' in result) {
// 			// 	// Success to Change Password
// 			// 	Swal.fire(
// 			// 	  'Berhasil !',
// 			// 	  result.Success,
// 			// 	  'success'
// 			// 	);				
// 			// }
// 		}
// 	});
// }); 

$(function(){
	$("#loader-wrapper").fadeOut(750);	
	$("#content-loader-wrapper").fadeOut(750);	
});    