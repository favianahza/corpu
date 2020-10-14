    /*jslint unparam: true */
    /*global window, $ */

    var max_uploads = 5

    $(function () {
        'use strict';

        // Change this to the location of your server-side upload handler:
        var url = 'server/upload.php';

        $('#Submit').on('click', function(){
            $('#fileupload').fileupload({
                url: url,
                dataType: 'html',
                done: function (e, data) {

                    if(data['result'] == 'FAILED'){
                        alert('Invalid File');
                    }else{
                        $('#uploaded_file_name').val(data['result']);
                        $('#uploaded_images').append('<img src="server/uploads/'+data['result']+'" / style="width: 100px;  height: 100px;">');
    // <div class="uploaded_image"> <input type="text" value="'+data['result']+'" name="uploaded_image_name[]" id="uploaded_image_name" hidden> <img src="server/uploads/'+data['result']+'" / style="width: 100px;  height: 100px;"> <a href="#" class="img_rmv btn btn-danger"><i class="fa fa-times-circle" style="font-size:24px;color:red"></i></a> </div>
                        if($('.uploaded_image').length >= max_uploads){
                            $('#select_file').hide();
                        }else{
                            $('#select_file').show();
                        }
                    }

                    $('#progress .progress-bar').css(
                        'width',
                        0 + '%'
                    );

                    $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo('#files');
                    });

                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');            
            });        
    });

    $( "#uploaded_images" ).on( "click", ".img_rmv", function() {
        $(this).parent().remove();
        if($('.uploaded_image').length >= max_uploads){
            $('#select_file').hide();
        }else{
            $('#select_file').show();
        }
    });