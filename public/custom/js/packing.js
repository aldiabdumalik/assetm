import * as module from './module.js';
$(document).ready(function () {
    const thisUrl = new URL(window.location.href)
    const url_id = thisUrl.pathname.split('/')[2];
    console.log(url_id)
    const dt = $('#packing_table').DataTable({
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
            { data: 'jenis', name: 'jenis', className: 'text-center'},
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
            console.log(response)
            module.loading_stop();
            $('#form-packing').trigger('reset');
            $('#modal-packing').modal('hide')
            dt.ajax.reload()
            module.send_notif({
                icon: 'success',
                message: response.message
            });
        })
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

    $(document).on('click', '.delete-item', function(e) {
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

    $('#btn-add').on('click', function(){
        $('#modal-packing').modal('show')
    })

    $('#modal-packing').on('hidden.bs.modal', function(){
        $('#form-packing').attr('action', module.base_url + 'packing_list/add');
        $('#form-packing').trigger('reset');
        $('#modal-packing-title').text('Buat Packing List')
        $('#submit').text('Tambah')
    });


    const dtScan = $('#scan_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + `packing_list/${url_id}/scan/datatable`,
            headers: {'X-CSRF-TOKEN': module.header_token}
        },
        columns: [
            { data: 'barcode', name: 'barcode', className: 'text-center'},
            { data: 'jenis', name: 'jenis', className: 'text-center'},
            { data: 'merk', name: 'merk', className: 'text-center'},
            { data: 'tipe', name: 'tipe', className: 'text-center'},
            { data: 'scan_time', name: 'scan_time', className: 'text-center'},
            { data: 'user.username', name: 'user.username', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    $(document).on('submit', '#form-scan', function(e){
        e.preventDefault();
        let uri = new URL($(this).attr('action'));

        let barcode = $('#sbarcode').val(),
            url = uri.href,
            method = 'POST';
        let jsonData = {
            barcode : barcode
        }

        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            module.loading_stop();
            $('#sbarcode').val('');
            dtScan.ajax.reload()
        }).catch(err => {
            $('#sbarcode').val('');
        });
    });

    $('#sbarcode').on('keypress', function (e) {
        if(e.which === 13){
            $('#form-scan').submit();
        }
    });

    $('#sbarcode').keyup(module.delay(function (e) {
        console.log($('#sbarcode').val().length);
        if ($('#sbarcode').val().length >= 5) {
            $('#form-scan').submit();
        }
    }, 1500));

    $(document).on('click', '.btn-cancel', function(e) {
        e.preventDefault();
        let url = new URL($(this).data('action'));
        module.loading_start();
        module.callAjax(url.href, 'DELETE').then(response => {
            module.loading_stop();
            // module.send_notif({
            //     icon: 'success',
            //     message: response.message
            // });
            dtScan.ajax.reload();
        })
    });
})