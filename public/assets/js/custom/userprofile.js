$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    let $profileInfoForm = $('#profileInfoForm')
    $profileInfoForm.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $profileInfoForm.parsley().validate();
        if ($profileInfoForm.parsley().isValid()) {
            loaderView();
            let formData = new FormData($profileInfoForm[0])
            axios
                .post(APP_URL + '/register/saveProfileInfo', formData)
                .then(function (response) {

                    if (response.data.success == false) {
                        successToast(response.data.errors.message, 'warning')
                        return false;
                    }
                    $profileInfoForm[0].reset();
                    $("#basic_info").hide();
                    $("#profile_info").hide();
                    $("#education").show();
                    $("#certificate_user_id").val(response.data.user_id);
                    $("#degree_user_id").val(response.data.user_id);

                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    console.log(error)
                    // successToast(error.response.data.message, 'warning')
                });

            loaderHide();
        }
    })
})