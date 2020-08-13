jQuery(function($) {

$(".alert").delay(5000).slideUp(300);

    $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'students_data/get_data',
        columns: [{
                data: 'name'
            },
            {
                data: 'email'
            },

            {
                data: 'mobile_number'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    function refresh() {
        var table = $('#students-table').DataTable();
        table.ajax.reload(null, false);
        console.log('refresh success');
    }


    function token() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    //create
    $(document).on('click', '.create', function (e) {
        e.preventDefault();
        $('#modalAdd').modal('show');
        $('.modal-title').text('Create Student');
    });

    //edit
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('student_id');

        token();

        $.ajax({
            url: 'students/' + id + '/edit',
            method: 'GET',
            success: function (result) {

                if (result.success) {
                    let json = jQuery.parseJSON(result.data);
                    $('.id').val(json.id);
                    $('.name').val(json.name);
                    $('.email').val(json.email);
                    $('.mobile_number').val(json.mobile_number);
                   $('#modalEdit').modal('show');
                    $('.modal-title').text('Update Student');
                }

            }
        });


    });

    //update
    $(document).on('submit', '#modalEdit', function (e) {

      var formData = $("form#formupdate").serializeArray();

        token();

        var id = formData[0].value
        var data = {
            name: formData[1].value,
            email: formData[2].value,
           mobile_number: formData[3].value
        };
        $.ajax({
            url: 'students/' + id,
            method: 'PUT',
            data: data,
            success: function (result) {
                if (result.success) {
                    refresh();
                    cleaner();
                    console.log('ajax call made');
                    $('#modalEdit').modal('hide');
                    swal(
                        'Updated!',
                        'Successfull Update!',
                        'success'
                    );
                    console.log('success update');
                }
                else{
                  console.log('failed');
                }
            }
        });
    });

    //delete data
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('student_id');

        swal({
            title: 'Are you sure?',
            text: "you want to remove this record?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                token();

                $.ajax({
                    url: 'students/' + id,
                    method: 'DELETE',
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();
                            swal(
                                'Deleted!',
                                'Successfull Deleted!',
                                'success'
                            );
                        }
                    }
                });
            }
        });

    });
});
