import * as module from './module.js';
$(document).ready(function () {
    const thisUrl = new URL(window.location.href)
    const url_id = thisUrl.pathname.split('/')[2];
    const dt = $('#scan_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'scanning/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
            data: {id: url_id}
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
            { data: 'scan_time', name: 'scan_time', className: 'text-center'},
            { data: 'scan_sn', name: 'scan_sn', className: 'text-center'},
            { data: 'scan_mac', name: 'scan_mac', className: 'text-center'},
            { data: 'jenis', name: 'jenis', className: 'text-center'},
            { data: 'merk', name: 'merk', className: 'text-center'},
            { data: 'tipe', name: 'tipe', className: 'text-center'},
            { data: 'scan_box', name: 'scan_box', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    });

    $('#form-scan').on('submit', function(e) {
        e.preventDefault();
        let url = new URL($(this).attr('action'));
        let method = 'POST';
        let type_id = $('#jenis').val(),
            brand_id = $('#merk').val(),
            model_id = $('#tipe').val(),
            scan_box = $('#box').val(),
            scan_sn = $('#sn').val(),
            scan_mac = $('#mac').val();
        let jsonData = {
            type_id: type_id,
            brand_id: brand_id,
            model_id: model_id,
            scan_box: scan_box,
            scan_sn: scan_sn,
            scan_mac: scan_mac,
        }

        // console.log(jsonData);
        module.loading_start();
        module.callAjax(url.href, method, jsonData).then(response => {
            module.loading_stop();
            resetForm();
            dt.ajax.reload()
            // module.send_notif({
            //     icon: 'success',
            //     message: response.message
            // }).then(() => dt.ajax.reload());
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

    $(document).on('click', '.btn-cancel', function(e){
        e.preventDefault();
        let url = new URL($(this).data('action'));
        module.loading_start();
        module.callAjax(url.href, 'DELETE').then(response => {
            module.loading_stop();
            dt.ajax.reload()
        })
    })

    $('#mac').on('keypress', function (e) {
        if(e.which === 13){
            $('#form-scan').submit();
        }
    });

    $('#jenis').select2({
        placeholder: 'Pilih Jenis',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-jenis.json',
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
                $('#merk').empty();
                $('#tipe').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.type_name };
                    })
                };
            },
            cache: true
        }
    })
    $('#merk').select2({
        placeholder: 'Pilih Merk',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-merk.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term,
                    type: $('#jenis').val()
                }
                return query;
            },
            processResults: function(response) {
                $('#tipe').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.brand_name };
                    })
                };
            },
            cache: true
        }
    })
    $('#tipe').select2({
        placeholder: 'Pilih Tipe',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-tipe.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term,
                    brand: $('#merk').val()
                }
                return query;
            },
            processResults: function(response) {
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.model_name };
                    })
                };
            },
            cache: true
        }
    })

    function resetForm() {
        $('#form-scan').trigger('reset');
        $('#jenis').val('').trigger('change');
        $('#merk').val('').trigger('change');
        $('#tipe').val('').trigger('change');
    }
});