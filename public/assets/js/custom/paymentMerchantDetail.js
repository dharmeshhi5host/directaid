$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL + '/payment-merchant-detail',
            type: 'GET',
        },
        columns: [
            {data: 'id', name: 'id'},
            // {data: 'center_id', name: 'center_id'},
            {data: 'title', name: 'title'},
            {data: 'merchant_id', name: 'merchant_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            funDataTableCheck('datable_check');
            funDataTableUnCheck('datable_check');
            funTooltip();
        },
        language: {
            processing: '<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div>'
        },
        order: [[0, 'DESC']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    })
    $(document).on('click', '#filter', function () {
        table.draw()
    });


    $(document).on('click', '.delete-single', function () {
        const value_id = $(this).data('id')

        swal({
            title: sweetalert_title,
            text: "Are you sure you want to remove this record?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonColor: "#067CBA",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                deleteRecord(value_id)
            }
        });
    })
    let $form = $('#addEditForm')
    $form.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $form.parsley().validate();
        if ($form.parsley().isValid()) {
            loaderView();
            let formData = new FormData($form[0])
            axios
                .post(APP_URL + '/payment-merchant-detail', formData)
                .then(function (response) {
                    if ($("#form-method").val() === 'add') {
                        $form[0].reset();
                        $form.removeClass('was-validated');
                    }
                    setTimeout(function () {
                        window.location.href = APP_URL + '/payment-merchant-detail'
                    }, 1000);
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    successToast(error.response.data.message, 'warning')
                });

            loaderHide();
        }
    })
    $('.dropify').dropify();

    function deleteRecord(value_id) {

        $.ajax({
            type: 'DELETE',
            url: APP_URL + '/payment-merchant-detail' + '/' + value_id,
            success: function (data) {
                successToast(data.message, 'success');
                table.draw()
                loaderHide();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }

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
        axios
            .get(APP_URL + '/payment-merchant-detail/status' + '/' + value_id + '/' + status)
            .then(function (response) {
                table.draw()
                successToast(response.data.message, 'success');
            })
            .catch(function (error) {
                successToast(error.response.data.message, 'warning')
            });
    }
})