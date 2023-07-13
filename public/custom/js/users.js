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
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
            { data: 'username', name: 'username', className: 'text-center'},
            { data: 'email', name: 'email', className: 'text-center'},
            { data: 'reg', name: 'reg', className: 'text-center'},
            { data: 'wilayah', name: 'wilayah', className: 'text-center'},
            { data: 'level', name: 'level', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    const resetForm = () => {
        $('#form-user').trigger('reset');
        $('#regional').val('').trigger('change')
        $('#branch').val('').trigger('change')
    }

    $(document).on('submit', '#form-user', function (event) {
        event.preventDefault();
        let url = new URL($(this).attr('action'))
        let method = url.pathname == '/user/add' ? 'POST' : 'PUT';
        let name = $('#uname').val();
        let username = $('#usname').val();
        let email = $('#umail').val();
        let level = $('#ulevel').val();
        let regional_id = $('#regional').val();
        let branch_id = $('#branch').val();
        let jsonData = {
            name: name,
            username: username,
            email: email,
            level: level,
            regional_id: regional_id,
            branch_id: branch_id,
        }

        // console.log(jsonData, url.href, method)
        module.loading_start();
        module.callAjax(url.href, method, jsonData).then(response => {
            // console.log(response)
            module.loading_stop();
            resetForm
            $('#modal-user').modal('hide')
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            dt.ajax.reload();
        }).catch(err => {
            if ('errors' in err.responseJSON) {
                const arrError = err.responseJSON.errors;
                const errr = Object.keys(arrError)
                errr.map(i => {
                    let id = '#'+i;
                    $(id).find('span.text-danger').remove();
                    $(id).addClass('validation_error')
                    $(id).append(`<span class="text-danger font-italic">${arrError[i][0]}</span>`)
                })
            }
        });
    });

    $(document).on('click', '.edit-user', function(e) {
        e.preventDefault();
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        module.loading_start();
        module.callAjax(module.base_url + `user/detail?id=${id}`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            console.log(data)
            $('#uname').val(data.name);
            $('#usname').val(data.username);
            $('#umail').val(data.email);
            $('#ulevel').val(data.level);

            var reg = new Option(data.user_info.branch.regional.regional_name, data.user_info.branch.regional.id);
            var brc = new Option(data.user_info.branch.branch_name, data.user_info.branch.id);
            reg.selected = true;
            brc.selected = true;

            $("#regional").append(reg);
            $("#regional").trigger("change");

            $("#branch").append(brc);
            $("#branch").trigger("change");
        })
        $('#modal-user').modal('show')
        $('#form-user').attr('action', $(this).data('href'));
        $('#modal-user-title').text('Update Data')
        $('#submit').text('Update')
    });
    $('#modal-user').on('hidden.bs.modal', function(){
        $('#form-user').attr('action', module.base_url + 'user/add');
        resetForm();
        $('#modal-user-title').text('Tambah Data')
        $('#submit').text('Tambah')
    });
    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault();
        let url = new URL($(this).data('href'));
        module.loading_start();
        module.callAjax(url.href, 'DELETE').then(response => {
            module.loading_stop();
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            dt.ajax.reload();
        })
    });

    $('#add-user').click(function() {
        $('#modal-user').modal('show')
    })

    $('#regional').select2({
        dropdownParent: $('#modal-user'),
        placeholder: 'Pilih Regional',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-regional.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term
                }
                return query;
            },
            processResults: function(response) {
                $('#branch').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.regional_name };
                    })
                };
            },
            cache: true
        }
    })

    $('#branch').select2({
        dropdownParent: $('#modal-user'),
        placeholder: 'Pilih Wilayah',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-branch.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term,
                    regional: $('#regional').val()
                }
                return query;
            },
            processResults: function(response) {
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.branch_name };
                    })
                };
            },
            cache: true
        }
    })
});