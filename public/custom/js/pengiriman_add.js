import * as module from './module.js';
$(document).ready(function () {
    const thisUrl = new URL(window.location.href)
    const url_id = thisUrl.pathname.split('/')[2];
    // console.log(url_id)
    const dt = $('#belum_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'pengiriman/belum_dt',
            headers: {'X-CSRF-TOKEN': module.header_token},
            // data: {id: url_id, status: 0}
        },
        columns: [
            { data: 'pl_code', name: 'pl_code', className: 'text-center'},
            { data: 'jenis', name: 'jenis', className: 'text-center'},
            { data: 'jml_item', name: 'jml_item', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });
    const dt_done = $('#sudah_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + `pengiriman/${url_id}/donedt`,
            headers: {'X-CSRF-TOKEN': module.header_token},
            // data: {id: url_id, status: 0}
            // success: function(response){
            //     console.log(response.data.length)
            // }
        },
        columns: [
            { data: 'pl_code', name: 'pl_code', className: 'text-center'},
            { data: 'jenis', name: 'jenis', className: 'text-center'},
            { data: 'jml_item', name: 'jml_item', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
        drawCallback: function(settings) {
            // console.log(settings.json.data)
            $('input[name=jmlh]').val(settings.json.data.length)
        }
    });

    $(document).on('submit', '#form-pengiriman', function(e){
        e.preventDefault();
        let uri = new URL($(this).attr('action'));

        let url = uri.href,
            method = uri.pathname === '/pengiriman/add' ? 'POST' : 'PUT';
        let jsonData = {
            tujuan: $('#tujuan').val(),
            type: $('#type_tujuan').val(),
            resi: $('#resi').val(),
            estimasi: module.convertDate($('#estimasi').val()),
        }

        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            console.log()
            module.loading_stop();
            $('#form-pengiriman').trigger('reset');
            $('#tujuan').val('').trigger('change')
            // $('#modal-pengiriman').modal('hide')
            // dt.ajax.reload()
            module.send_notif({
                icon: 'success',
                message: response.message
            }).then(() => window.location.href = response.content.redirect);
        })
    })

    $('#btn-kirim').on('click', function(e) {
        e.preventDefault();
        // console.log('test')
        module.loading_start();
        module.callAjax(module.base_url + `pengiriman/${url_id}/send_pl`, 'POST').then(response => {
            module.loading_stop();
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            window.location.reload();
            // dt.ajax.reload();
        })
    });


    $(document).on('click', '.add-pl', function(e){
        e.preventDefault();
        let url = new URL($(this).data('action'))

        module.loading_start();
        module.callAjax(url.href, "POST", {delivery_id: url_id}).then(response => {
            module.loading_stop();
            dt.ajax.reload();
            dt_done.ajax.reload();
        })
    })
});