import * as module from './module.js';
$(document).ready(function () {
    let groupColumn = 0;
    const dt = $('#regional_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'regional/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token}
        },
        columns: [
            { data: 'regionalID', name: 'regionalID', className: 'text-center'},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
            { data: 'branch_name', name: 'branch_name', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
        columnDefs: [{ visible: false, targets: groupColumn }],
        order: [[groupColumn, 'asc']],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
        
            api.column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                    var arr_group = group.split('|');
                    console.log(group)
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(`
                                <tr class="group">
                                    <td colspan="3">
                                        REG ${arr_group[1]}
                                    </td>
                                </tr>
                            `);
        
                        last = group;
                    }
                });
        },
        createdRow: function( row, data, dataIndex ) {
            // $(row).attr('id', data.id);
            // $(row).attr('data-action', `${module.base_url}scanning/${data.id}/item`);
            // $(row).addClass('to_scan');
        }
    });

    $('#regional').select2({
        dropdownParent: $('#modal-wilayah'),
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
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.regional_name };
                    })
                };
            },
            cache: true
        }
    })

    $('#input_regional').on('click', function(){
        $('#modal-regional').modal('show')
    });
    $(document).on('submit', '#form-regional', function(e){
        e.preventDefault()
        let uri = new URL($(this).attr('action'));
        let method = uri.pathname == '/regional/add' ? 'POST' : 'PUT';

        let regional_name = $('#regname').val();

        module.loading_start();
        module.callAjax(uri.href, method, {regional_name: regional_name}).then(response => {
            module.loading_stop();
            $('#form-regional').trigger('reset');
            $('#modal-regional').modal('hide')
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

    $(document).on('click', '.edit-regional', function(){
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        module.loading_start();
        module.callAjax(module.base_url + `regional/detail?id=${id}&q=regional`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#regname').val(data.regional_name);
        })
        $('#modal-regional').modal('show')
        $('#form-regional').attr('action', $(this).data('href'));
        $('#modal-regional-title').text('Update Data')
        $('#submit').text('Update')
    });

    $('#modal-regional').on('hidden.bs.modal', function(){
        $('#form-regional').attr('action', module.base_url + 'regional/add');
        $('#form-regional').trigger('reset');
        $('#modal-regional-title').text('Tambah Data')
        $('#submit').text('Tambah')
    });

    $('#input_wilayah').on('click', function(){
        $('#modal-wilayah').modal('show')
    });
    $(document).on('submit', '#form-wilayah', function(e){
        e.preventDefault();
        let uri = new URL($(this).attr('action'));

        let regional_id = $('#regional').val(),
            branch_name = $('#branchname').val(),
            branch_type = $('#type').val(),
            url = uri.href,
            method = uri.pathname === '/regional/add/wilayah' ? 'POST' : 'PUT';
        let jsonData = {
            regional_id : regional_id,
            branch_name : branch_name,
            branch_type : branch_type,
        }
        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            // console.log(response)
            module.loading_stop();
            $('#form-wilayah').trigger('reset');
            $('#regional').val('').trigger('change');
            $('#modal-wilayah').modal('hide')
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

    $(document).on('click', '.edit-wilayah', function(){
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        console.log(url, id)
        module.loading_start();
        module.callAjax(module.base_url + `regional/detail?id=${id}&q=wilayah`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#branchname').val(data.branch_name);
            $('#type').val(data.branch_type);

            var regional = new Option(data.regional.regional_name, data.regional.id);
            regional.selected = true;
            $("#regional").append(regional);
            $("#regional").trigger("change");
        })
        $('#modal-wilayah').modal('show')
        $('#form-wilayah').attr('action', $(this).data('href'));
        $('#modal-wilayah-title').text('Update Data')
        $('#submit2').text('Update')
    });

    $('#modal-wilayah').on('hidden.bs.modal', function(){
        $('#form-wilayah').attr('action', module.base_url + 'regional/add/wilayah');
        $('#form-wilayah').trigger('reset');
        $('#regional').val('').trigger('change');
        $('#modal-wilayah-title').text('Tambah Data')
        $('#submit2').text('Tambah')
    });
});