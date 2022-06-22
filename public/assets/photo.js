jQuery(document).ready(function($){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    
    /*
        1. set value to add
        2. clear any previous form data
        3. open modal
    */
    jQuery('#btn-add').click(function () {
        $('#btn-save').html('Upload photo');
        jQuery('#btn-save').val("add");
        jQuery('#modalFormData').trigger("reset");
        //reset user photo
        $('.user_photo').val('').trigger('change');
        jQuery('#linkEditorModal').modal('show');
        jQuery('#linkEditorModalLabel').html('upload photo');

        //reset errors
        $('#photo_error').html('');
        $('#user_id_error').html('');
    });


      // Clicking the save button on the open modal for both CREATE and UPDATE
    /*
        1. csrf token
        2. prevent form from submitting
        3. place in formData variables
        4. save value from save button which can either be update or save
        5. variable save type -> post & link_id & ajaxUrl
        6. if for when it is updated change type variable to PUT and ajaxUrl - for update

    */
        $('#modalFormData').submit(function(e) {
            e.preventDefault();
            var actionType=$('#btn-save').val();
            
            
          
            $('#btn-save').html('Sending..');
            var formData = new FormData(this);

            console.log(formData)
            $.ajax({
                type: "POST",
                url: '/photos',
                data: formData,
                dataType: 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                  

                    //console.log(data.error);
                    if(data.error){
                        console.log(data.error[0]);
                        $('#photo_error').html(data.error[0]);
                        $('#user_id_error').html(data.error[1]);
                        
                    }else{
                        location.reload()
                    }
                    
                    
                    
                  
                },
                error: function (data) {
                    if (data.status == 422) { // when status code is 422, it's a validation issue
                        console.log(data);
                    }
                    
                }
                
            });        
          })  

});