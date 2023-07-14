import * as module from './module.js';
$(document).ready(function () {
    let groupColumn = 0;
    const dt2 = $('#uji_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'uji_fungsi/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
        },
        columns: [
            { data: 'regional_name', name: 'regional_name', className: 'text-center'},
            { data: 'type_name', name: 'type_name', className: 'text-center'},
            { data: 'status_1_count', name: 'status_1_count', className: 'text-center'},
            { data: 'status_0_count', name: 'status_0_count', className: 'text-center'},
            { data: null, className: 'text-center', render: function(data, type, row, meta) {
                return parseInt(data.status_1_count) + parseInt(data.status_0_count);
            }},
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
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(`
                                <tr class="group to_scan">
                                    <td colspan="4">
                                        REG ${group}
                                    </td>
                                </tr>
                            `);
        
                        last = group;
                    }
                });
        },
    });

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

    $('#sn').keyup(module.delay(function (e) {
        if ($('#sn').val().length >= 5) {
            $('#form-ujiscan').submit();
        }
    }, 1500));

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
    });

    var touchtime = 0;
    $(document).on("click", ".to_scan", function() {
        if (touchtime == 0) {
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                // let this_action = $(this).data('action');
                window.location.href = module.base_url + 'uji_fungsi/scan';
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });
});