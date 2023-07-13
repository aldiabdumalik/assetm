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

    // $('#regional').select2({
    //     dropdownParent: $('#modal-igi'),
    //     placeholder: 'Pilih Regional',
    //     multiple: false,
    //     ajax: {
    //         url: module.base_url + 'api/get-regional.json',
    //         type: "get",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params) {
    //             var query = {
    //                 search: params.term
    //             }
    //             return query;
    //         },
    //         processResults: function(response) {
    //             $('#branch').empty();
    //             return {
    //                 results: $.map(response.content, function(obj) {
    //                     return { id: obj.id, text: obj.regional_name };
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // })

    // $('#branch').select2({
    //     dropdownParent: $('#modal-igi'),
    //     placeholder: 'Pilih Wilayah',
    //     multiple: false,
    //     ajax: {
    //         url: module.base_url + 'api/get-branch.json',
    //         type: "get",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params) {
    //             var query = {
    //                 search: params.term,
    //                 regional: $('#regional').val()
    //             }
    //             return query;
    //         },
    //         processResults: function(response) {
    //             return {
    //                 results: $.map(response.content, function(obj) {
    //                     return { id: obj.id, text: obj.branch_name };
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // })

    var touchtime = 0;
    $(document).on("click", ".to_scan", function() {
        if (touchtime == 0) {
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                let this_action = $(this).data('action');
                window.location.href = this_action;
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });

    $(document).on('submit', '#form-igi', function(e){
        e.preventDefault();
        let uri = new URL($(this).attr('action'));

        let branch_id = $('#branch').val(),
            regional_desc = $('#regional').text(),
            branch_desc = $('#branch').text(),
            delivery_pic = $('#dpic').val(),
            no_po = $('#po').val(),
            user_pic = $('#pic').val(),
            arrival_date = module.convertDate($('#tgl').val()),
            arrival_total = $('#total').val(),
            arrival_note = $('#note').val(),
            url = uri.href,
            method = uri.pathname === '/arrival_item' ? 'POST' : 'PUT';
        let jsonData = {
            branch_id : branch_id,
            regional_desc : regional_desc,
            branch_desc : branch_desc,
            delivery_pic : delivery_pic,
            no_po : no_po,
            user_pic : user_pic,
            arrival_date : arrival_date,
            arrival_total : arrival_total,
            arrival_note : arrival_note,
        }

        // console.log(url, method);

        // console.log(jsonData)
        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            // console.log(response)
            module.loading_stop();
            $('#form-igi').trigger('reset');
            $('#modal-igi').modal('hide')
            module.send_notif({
                icon: 'success',
                message: response.message
            }).then(() => dt.ajax.reload());
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
    })
});