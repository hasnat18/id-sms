$(document).ready(function(){
    $("form").attr('autocomplete', 'off');

    $(document).on('submit', '#login', function(event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formData,
        })
        .done(function(response){
            if(response.status){
                Swal.fire({ type: 'success',text: response.message});
                setTimeout(function(){ window.location = response.redirect; }, 1500);
            }else{
                Swal.fire({ type: 'error',text: response.message});
            }
        });
    });

    $(document).on('submit', '.create', function(event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formData,
        })
        .done(function(response){

            if(response.status){
                if(response.status == true){
                    form[0].reset();
                    Swal.fire({ type: 'success',text: response.message});
                }
                if(response.status == 'exist'){
                    Swal.fire({ type: 'error',text: response.message});
                }
            }else{
                $.each(response.errors,function(key,val){
                    var element = $('#'+key);
                    element.closest('.validate').find('.error').remove();
                    element.after("<p class='error' style='color:red'>"+val+"</p>");
                });
            }
        })
    });

    $(document).on('click', '.delete', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        var token = $(this).data('token');
        var type = $(this).data('type');

        Swal.fire({
            title: "Are you sure to delete this?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dd6b55",
            confirmButtonText: "Delete",
        }).then((confirm) => {
            if (confirm.value)
            {
                $.ajax({
                    url:site_url+"/delete",
                    method:'post',
                    data:{id:id,_token:token,type:type,_method:'DELETE'},
                    cache: false,
                    dataType: 'json',
                    success:function(response)
                    {
                        Swal.fire({ type: 'success',text: response.message});
                        setTimeout(function(){ window.location.reload() }, 1500);
                    }
                });
            }
        });
    });

    $('input, select, textarea').bind('change keyup', function() {
        if($(this).val() !== "")
        {
            $(this).closest('.validate').find('.error').remove();
        }
    });
});
