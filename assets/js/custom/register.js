$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let $form = $('#basicInfoForm')
    $form.on('submit', function (e) {
        e.preventDefault()
        $form.parsley().validate();
        if ($form.parsley().isValid()) {
            show_loader();
            var from = $("#from").val()
            let formData = new FormData($form[0])

            if($("#mobile_number").val() !== undefined) {
                var phone_number = $.trim($("#mobile_number").val().replace(/ /g,''));
            }

            formData.append('mobile_no', phone_number);
            formData.append('country_code', $(".iti__selected-dial-code").html());

            $(".submitBnt").addClass('disabled').attr('disabled');

            axios
                .post(APP_URL + '/register/saveBasicInfo', formData)
                .then(function (response) {
                    hide_loader();
                    if (response.data.success == false) {           
                        successToast(response.data.message, 'error')
                        return false;
                    }                   
                    $form[0].reset();
                   
                    successToast(response.data.message, 'success');

                    if (from != '') {
                        window.location.href = APP_URL + '/checkout/';    
                    } else {
                       // window.location.href = APP_URL + '/user/profile/';
                       window.location.href = APP_URL + '/home';
                    }
                })
                .catch(function (error) {
                   
                    //successToast(error.data.message, 'warning')
                });

            
        }
    })


    let $profileInfoForm = $('#profileInfoForm')
    $profileInfoForm.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $profileInfoForm.parsley().validate();
        if ($profileInfoForm.parsley().isValid()) {
            show_loader();
            $('.profile-button').prop('disabled', true);
            let formData = new FormData($profileInfoForm[0])
            axios
                .post(APP_URL + '/register/saveProfileInfo', formData)
                .then(function (response) {
                    hide_loader();
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
                    $('.profile-button').prop('disabled', false);        
                   
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {      
                    console.log(error) 
                    // successToast(error.response.data.message, 'warning')
                });
        }
    })

    let $certificateForm = $('#certificateForm')
    $certificateForm.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $certificateForm.parsley().validate();
        if ($certificateForm.parsley().isValid()) {
            show_loader();
            $('.add_certificate_sbt').prop('disabled', true);
            let formData = new FormData($certificateForm[0])
            axios
                .post(APP_URL + '/register/saveCertificate', formData)
                .then(function (response) {
                   
                    $certificateForm[0].reset();
                    $("#basic_info").hide();
                    $("#profile_info").hide();
                    $("#education-list").show();
                    getCertificatInfo(response.data.user_id);
                    getDegreeInfo(response.data.user_id);
                    //$("#experience").show();
                    $("#exp_user_id").val(response.data.user_id);
                    $('.add_certificate_sbt').prop('disabled', false);
                    hide_loader();
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    hide_loader();
                    successToast(error.response.data.message, 'warning')
                });

        }
    })

    let $degreeForm = $('#degreeForm')
    $degreeForm.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $degreeForm.parsley().validate();
        if ($degreeForm.parsley().isValid()) {
            show_loader();
            $('.add_degree_sbt').prop('disabled', true);
            let formData = new FormData($degreeForm[0])
            axios
                .post(APP_URL + '/register/savedegree', formData)
                .then(function (response) {
                   
                    $degreeForm[0].reset();
                    $("#basic_info").hide();
                    $("#profile_info").hide();
                    $("#education-list").show();
                    getCertificatInfo(response.data.user_id);
                    getDegreeInfo(response.data.user_id);
                    //$("#experience").show();
                    $("#exp_user_id").val(response.data.user_id);
                    $('.add_degree_sbt').prop('disabled', false);        
                   
                    hide_loader();
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    hide_loader();
                    successToast(error.response.data.message, 'warning')
                });

        }
    })

    let $experienceForm = $('#experienceForm')
    $experienceForm.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $experienceForm.parsley().validate();
        if ($experienceForm.parsley().isValid()) {
            show_loader();
            $('.add_experience_sbt').prop('disabled', true);
            let formData = new FormData($experienceForm[0])
            axios
                .post(APP_URL + '/register/saveExperience', formData)
                .then(function (response) {
                   
                        $experienceForm[0].reset();
                        $("#basic_info").hide();
                        $("#profile_info").hide();
                        $("#education").hide();
                        $("#education-list").hide();
                        $("#experience").show();
                        $("#exp-list").show();
                        
                        
                        getExperienceInfo(response.data.user_id);
                        
                        //$("#experience").show();
                       $("#exp_user_id").val(response.data.user_id);
                       $('.add_experience_sbt').prop('disabled', false);
                       hide_loader();
                        successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    successToast(error.response.data.message, 'warning')
                });

        }
    })

    $(document).on('click', '.delete-single', function () {
        const value_id = $(this).data('id')

        swal({
            title: sweetalert_title,
            text: sweetalert_text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#067CBA",
            confirmButtonClass: "btn-danger",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                deleteRecord(value_id)
            }
        });
    })

    $(".add-new").click(function(){
      
        show_loader();
        $.ajax({
            type: 'POST',
            url: APP_URL + '/getExperience',
            data:{id:'1'},
            dataType: 'html',
            success: function (data) {
                var row =data;
                $("#row_id").append(row);
               // var inc = parseInt($("#count_row_id").val()) + 1;
               // $("#count_row_id").val(inc);
                hide_loader();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
     
    });

    $(document).on("click", ".delete", function(){
       
        $(this).parents(".cl_row").remove();

    });

    function deleteRecord(value_id) {
        $.ajax({
            type: 'DELETE',
            url: APP_URL + '/job-seekers' + '/' + value_id,
            success: function (data) {
                successToast(data.message, 'success');
                table.draw()
                hide_loader();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }

    $(document).on('click', '.user-details', function () {
        const value_id = $(this).data('id');

        show_loader();
        let effect = $(this).attr('data-effect');
        $('#globalModal').addClass(effect).modal('show');

        $.ajax({
            type: 'GET',
            url: APP_URL + '/jobSeekerDetails' + '/' + value_id,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#globalModalTitle").html(data.data.globalModalTitle);
                $("#globalModalDetails").html(data.data.globalModalDetails);
                hide_loader();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    })



    $(document).on('click', '.edit-certificate', function () {
        const value_id = $(this).data('id');        
        let effect = $(this).attr('data-effect');
        $('#globalModal').addClass(effect).modal('show');

        $.ajax({
            type: 'GET',
            url: APP_URL + '/editCertificat' + '/' + value_id,
            dataType: 'json',
            success: function (data) {
                $("#globalModalTitle").html(data.data.globalModalTitle);
                $("#globalModalDetails").html(data.data.globalModalDetails);
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    })

    if ($('.dropify').length > 0)  {
        $('.dropify').dropify();
    }

    // integerOnly();


    $(document).on('click', '.status-change', function () {
        const value_id = $(this).data('id');
        const status = $(this).data('status');

        swal({
            title: status,
            text: status_msg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#067CBA",
            confirmButtonClass: "btn-danger",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                changeStatus(value_id, status)
            }
        });
    });

    function changeStatus(value_id, status) {
        $.ajax({
            type: 'GET',
            url: APP_URL + '/job-seekers/status/' + value_id + '/' + status,
            success: function (data) {
                successToast(data.message, 'success');
                table.draw()
                hide_loader();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }

})

function getExperienceInfo(user_id){
     
        $.ajax({
            type: 'GET',
            url: APP_URL + '/register/getExperienceInfo/'+user_id,
            dataType: 'html',
            success: function (data) {
                var row =data;
                $("#experience-list").html(row);
                
                $('#add_experience').modal('toggle');
                $('#add_experience').modal('hide');
                $("#education_text").hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop.show').css('opacity','0');
                $('.modal-backdrop').css('z-index','-1')
               
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
}


function getDegreeInfo(user_id){
     
        $.ajax({
            type: 'GET',
            url: APP_URL + '/register/getDegreeInfo/'+user_id,
            dataType: 'html',
            success: function (data) {
                var row =data;
                $("#degree-list").html(row);
                $('#add_degree').modal('toggle');
                $('#add_degree').modal('hide');
                $("#education_text").hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop.show').css('opacity','0');
                $('.modal-backdrop').css('z-index','-1')
               
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
}

function getCertificatInfo(user_id){
    
    $.ajax({
        type: 'GET',
        url: APP_URL + '/register/getCertificatInfo/'+user_id,
        
        dataType: 'html',
        success: function (data) {
            var row = data;
            $("#certificate-list").html(row);
            $("#education_text").hide();
            $('#add_certificate').modal('toggle');
            $('#add_certificate').modal('hide');
            
            $('body').removeClass('modal-open');
            $('.modal-backdrop.show').css('opacity','0');
            $('.modal-backdrop').css('z-index','-1')
            
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
}

function skipnext(step){
   
    if(step == '3'){
        $("#education").hide();
        $("#education-list").hide();
        $("#experience").show();
        
    }
    if(step == '4'){
       var user_id =  $("#user_id").val();
        setTimeout(function () {
            window.location.href = APP_URL + '/register/login/'+user_id
        }, 1000);
    }
    return false;
}

var degree_count = 1;
$(document).on('click', '.add_degrees', function (e) {
    e.preventDefault();
    show_loader();
    $.ajax({
        type: 'POST',
        url: APP_URL + '/register/getDegree',
        data : {count : degree_count},
        dataType: 'json',
        success: function (data) {
            degree_count++;
            $(".degree-section-main").append(data.data.view);
            $('.datepicker-here').datepicker({
                position: 'top left'
            });
            hide_loader();
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
})

$(document).on('click', '.remove-degree', function (e) {
    degree_count--;
    $(this).parents('.col-12').remove();
});

var certificate_count = 1;
$(document).on('click', '.add_certificate', function (e) {
    e.preventDefault();
    show_loader();
    $.ajax({
        type: 'POST',
        data : {count : certificate_count},
        url: APP_URL + '/register/getCertificate',        
        dataType: 'json',
        success: function (data) {    
            certificate_count++;        
            $(".certificate-section-main").append(data.data.view);
            $('.datepicker-here').datepicker({
                position: 'top left',
                maxDate: new Date('2005-12-31')
            });
            hide_loader();
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
})

$(document).on('click', '.remove-certificate', function (e) {
    certificate_count--;
    $(this).parents('.col-12').remove();
});

var experience_count = 1;
$(document).on('click', '.add_experience', function (e) {
    e.preventDefault();
    show_loader();
    $.ajax({
        type: 'POST',
        url: APP_URL + '/register/getExperience',
        data : {count : experience_count},
        dataType: 'json',
        success: function (data) {
            experience_count++;
            $(".experience-section-main").append(data.data.view);
            $('.datepicker-here').datepicker({
                position: 'top left'
            });
            hide_loader();
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
})

$(document).on('click', '.remove-experience', function (e) {
    experience_count--;
    $(this).parents('.col-12').delay(350).fadeOut('slow').remove();
});

var skill_count = 1;
$(document).on('click', '.add_skill', function (e) {
    e.preventDefault();
    show_loader();
    $.ajax({
        type: 'POST',
        url: APP_URL + '/register/getSkill',
        data : {count : skill_count},
        dataType: 'json',
        success: function (data) {
            skill_count++;
            $(".skill-section-main").append(data.data.view);
            hide_loader();
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
})

$(document).on('click', '.remove-skill', function (e) {
    skill_count--;
    $(this).parents('.col-12').delay(350).fadeOut('slow').remove();
});

$(document).on('click', '.currently_studying', function (e) {
    if ($(this).is(':checked')) {
        $(this).parent().parent().parent().parent('.row').find(".to_date_id").hide();
    } else {
        $(this).parent().parent().parent().parent('.row').find(".to_date_id").show();
    }
});

$(document).on('click', '.credential_expired', function (e) {
    if ($(this).is(':checked')) {
        $(this).parent().parent().parent().parent('.row').find(".to_date_id").hide();
    } else {
        $(this).parent().parent().parent().parent('.row').find(".to_date_id").show();
    }
});

$(document).on('click', '.currently_working', function (e) {
    if ($(this).is(':checked')) {
        $(this).parent().parent().parent().parent('.row').find(".exp_to_date").hide();
    } else {
        $(this).parent().parent().parent().parent('.row').find(".exp_to_date").show();
    }
});


