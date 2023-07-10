import * as module from './module.js';
$(document).ready(function () {
    const dt = $('#user_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        lengthChange: false,
        ajax: {
            method: "POST",
            url: module.base_url + 'user/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nik', name: 'nik' },
            { data: 'name', name: 'name' },
            { data: '_password', name: '_password', className: 'text-center font-italic'}
        ],
    });

    const resetForm = () => {
        $('#form-user').trigger('reset');
    }

    let touchtime = 0;
    $('#user_table tbody').on('click', 'tr', function () {
        if (touchtime == 0) {
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                let data = dt.row( this ).data();
                if (data != undefined) {

                    $('#nik').val(data.nik);
                    $('#name').val(data.name);
                }
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });

    $('#form-user').submit(function (event) {
        event.preventDefault();
        let nik = $('#nik').val(),
            url = module.base_url + 'user/' + nik + '/reset_password',
            method = 'PUT',
            data = {
                nik: nik,
                password: $('#password').val()
            }
        module.loading_start()
        if (data.password != $('#password2').val()) {
            module.loading_stop()
            module.send_notif({
                icon: 'error',
                message: 'Password tidak sama'
            })
        }else{
            module.callAjax(url, method, data).then(response => {
                module.loading_stop();
                resetForm();
                dt.ajax.reload();
                module.send_notif({
                    icon: 'success',
                    message: response.message
                });
            });
        }
    });

    $('#cancel').click(function() {
        resetForm()
    });
});