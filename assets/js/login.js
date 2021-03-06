$(window).on('load', function() {
    // When the page has loaded
    $("#loader-wrapper").fadeOut(750); 

    function toggleResetPswd(e){
        e.preventDefault();
        $('#logreg-forms .form-signup').toggle() // display:block or none
        $('#logreg-forms .form-reset').toggle() // display:block or none
    }

    function toggleSignUp(e){
        e.preventDefault();
        $('#logreg-forms .form-signin').toggle(); // display:block or none
        $('#logreg-forms .form-signup').toggle(); // display:block or none
    }

    $('#show').on('click', function(){
        if ($('#user-pass').attr('type') == 'password' && $('#user-repeatpass').attr('type') == 'password' ) {
           $('#user-pass').attr('type', 'text'); $('#user-repeatpass').attr('type', 'text');
        } else {
           $('#user-pass').attr('type', 'password'); $('#user-repeatpass').attr('type', 'password');
        }
    });

    $(()=>{
        // Login Register Form
        $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
        $('#logreg-forms #cancel_reset').click(toggleResetPswd);
        $('#logreg-forms #btn-signup').click(toggleSignUp);
        $('#logreg-forms #cancel_signup').click(toggleSignUp);
    })

})