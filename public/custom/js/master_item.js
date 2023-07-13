import * as module from './module.js';
$(document).ready(function () {
    const dt = $('#item_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'item/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
            { data: 'model_name', name: 'model_name', className: 'text-center'},
            { data: 'merk', name: 'merk', className: 'text-center'},
            { data: 'jenis', name: 'jenis', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    $(document).on('submit', '#form-type', function(e){
        e.preventDefault();
        let url = new URL($(this).attr('action'));
        let method = url.pathname == '/item/add/type' ? 'POST' : 'PUT';
        let jsonData = {
            type_name: $('#tname').val()
        }

        module.loading_start();
        module.callAjax(url.href, method, jsonData).then(response => {
            module.loading_stop();
            $('#form-type').trigger('reset');
            $('#modal-type').modal('hide')
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            dt.ajax.reload();
        })
    })

    $(document).on('click', '.edit-type', function(e){
        e.preventDefault();
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        // console.log(url, id)
        module.loading_start();
        module.callAjax(module.base_url + `item/detail?id=${id}&q=type`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#tname').val(data.type_name);
        })
        $('#modal-type').modal('show')
        $('#form-type').attr('action', $(this).data('href'));
        $('#modal-type-title').text('Update Data')
        $('#submit-type').text('Update')
    });
    $(document).on('click', '.delete-type', function(e) {
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

    $('#input_type').click(function(e) {
        e.preventDefault();
        $('#modal-type').modal('show');
    })
    $('#input_brand').click(function(e) {
        e.preventDefault();
        $('#modal-brand').modal('show');
    })
    $('#input_model').click(function(e) {
        e.preventDefault();
        $('#modal-model').modal('show');
    })

    $('#modal-type').on('hidden.bs.modal', function(){
        $('#form-type').attr('action', module.base_url + 'item/add/type');
        $('#form-type').trigger('reset');
        // $('#regional').val('').trigger('change');
        $('#modal-type-title').text('Tambah Data')
        $('#submit-type').text('Tambah')
    });
});