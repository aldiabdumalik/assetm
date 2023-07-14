import * as module from './module.js';
$(document).ready(function () {
    const dt = $('#packing_table').dataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'packing_list/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token}
        },
        columns: [
            { data: 'pl_code', name: 'pl_code', className: 'text-center'},
            { data: 'jml_item', name: 'jml_item', className: 'text-right'},
            { data: 'pl_type', name: 'pl_type', className: 'text-center'},
            { data: 'proses', name: 'proses', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    $(document).on('submit', '#form-packing', function(e){
        e.preventDefault();
        let uri = new URL($(this).attr('action'));

        let pl_type = $('#jenis').val(),
            url = uri.href,
            method = uri.pathname === '/packing_list/add' ? 'POST' : 'PUT';
        let jsonData = {
            pl_type : pl_type
        }

        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            // console.log(response)
            module.loading_stop();
            $('#form-packing').trigger('reset');
            $('#modal-packing').modal('hide')
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
    })

    $(document).on('click', '.edit-item', function(){
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        module.loading_start();
        module.callAjax(module.base_url + 'packing_list/detail?id='+id, 'GET').then(response => {
            let data = response.content;
            $('#jenis').val(data.pl_type);
            module.loading_stop();
        })
        $('#modal-packing').modal('show')
        $('#form-packing').attr('action', $(this).data('href'));
        $('#modal-packing-title').text('Update Packing List')
        $('#submit').text('Update')
    });

    $('#btn-add').on('click', function(){
        $('#modal-packing').modal('show')
    })

    $('#modal-packing').on('hidden.bs.modal', function(){
        $('#form-packing').attr('action', module.base_url + 'packing_list/add');
        $('#form-packing').trigger('reset');
        $('#modal-packing-title').text('Buat Packing List')
        $('#submit').text('Tambah')
    })
})