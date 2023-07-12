import * as module from './module.js';
$(document).ready(function () {

    const dt = $('#scan_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'uji_fungsi/scan/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
            data: {status_scan: 0}
        },
        columns: [
            { data: 'scan_time', name: 'scan_time', className: 'text-center'},
            { data: 'barcode', name: 'barcode', className: 'text-center'},
            { data: 'type_desc', name: 'type_desc', className: 'text-center'},
            { data: 'brand_desc', name: 'brand_desc', className: 'text-center'},
            { data: 'model_desc', name: 'model_desc', className: 'text-center'},
            { data: 'result', name: 'result', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    $('#sn').on('keypress', function (e) {
        if(e.which === 13){
            $('#form-ujiscan').submit();
        }
    });

    $('#form-ujiscan').on('submit', function(e) {
        e.preventDefault();

        let url = module.base_url + 'uji_fungsi/scan';
        let method = 'POST';

        let barcode = $('#sn').val();
        let status = $('#sts').val();
        let box_ok = $('#bok').val();
        let box_nok = $('#bon').val();

        let jsonData = {
            barcode: barcode,
            status: status,
            box_ok: box_ok,
            box_nok: box_nok,
        }

        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            module.loading_stop();
            $('#form-ujiscan').trigger('reset');
            dt.ajax.reload()
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

    $(document).on('click', '.btn-cancel', function(e){
        e.preventDefault();
        let url = new URL($(this).data('action'));
        module.loading_start();
        module.callAjax(url.href, 'DELETE').then(response => {
            module.loading_stop();
            dt.ajax.reload()
        })
    })
});