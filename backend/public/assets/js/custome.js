function show_toast(title, message) {
 console.log("toast message");

    let color = '';
    if(title == "Success"){
        color = 'green'
    }
    else{
        color = 'red'
    }
    $('.toast').addClass('show');
    $('.toast').css('background-color',color)
    $('.toast-header strong').text(title);
    $('.toast-body').text(message);

    setTimeout(function(){
        $('.toast').removeClass('show');
    },3000);
}

$(document).ready(function() {
            $(document).on('click', '.preview-profile', function() {
                $('#profile').click()
            })
            $(document).on('change', '#profile', function() {
                var formData = new FormData();
                // console.log( $('#profile'));
                // console.log( $('#profile')[0]);
                // console.log($('#profile')[0].files);
                // console.log($('#profile')[0].files[0]);
                var profile = $('#profile')[0].files[0];
                formData.append('profile', profile)

                $.ajax({
                    url: '/upload-file',
                    // url: "{{ route('uploadFile') }}",
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    caches: false,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('#show-profile').attr(
                            'src',
                            '{{asset("assets/images/teacher/")}}'+'/'+response
                        );
                        $('#profile_name').val(response);
                    }
                });
            })
        })
