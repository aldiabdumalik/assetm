import * as module from './module.js';
$(document).ready(function () {
    const thisUrl = new URL(window.location.href)
    const url_id = thisUrl.pathname.split('/')[2];
    // console.log(url_id)
    const dt = $('#pengiriman_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            method: "POST",
            url: module.base_url + 'pengiriman/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
            // data: {id: url_id, status: 0}
        },
        columns: [
            { data: 'tujuan', name: 'tujuan', className: 'text-center'},
            { data: 'jml_pl', name: 'jml_pl', className: 'text-center'},
            { data: 'delivery_resi', name: 'delivery_resi', className: 'text-center'},
            { data: 'status_string', name: 'status_string', className: 'text-center'},
            { data: 'action', name: 'action', className: 'text-center'},
        ],
    })

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
            // console.log()
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
    });

    $(document).on('click', '.edit-item', function(){
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        module.loading_start();
        module.callAjax(module.base_url + `pengiriman/${id}/detail`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#type_tujuan').val(data.branch_delivery.branch_type);
            $('#estimasi').val(module.convertDate(data.estimasi, 'Y-m-d'));
            $('#resi').val(data.delivery_resi);
            var tujuan = new Option(data.branch_delivery.branch_name, data.branch_delivery.id);
            tujuan.selected = true;
            $("#tujuan").append(tujuan);
            $("#tujuan").trigger("change");
        })
        $('#modal-pengiriman').modal('show')
        $('#form-pengiriman').attr('action', $(this).data('href'));
        $('#modal-pengiriman-title').text('Update Pengiriman')
        $('#submit').text('Update')
    });

    $('#modal-pengiriman').on('hidden.bs.modal', function(){
        $('#form-pengiriman').attr('action', module.base_url + 'pengiriman/add');
        $('#form-pengiriman').trigger('reset');
        $('#tujuan').val('').trigger('change')
        $('#modal-pengiriman-title').text('Buat Pengiriman')
        $('#submit').text('Buat')
    })


    $('#btn-add').on('click', function(){
        $('#modal-pengiriman').modal('show')
    });

    $('#tujuan').select2({
        dropdownParent: $('#modal-pengiriman'),
        placeholder: 'Pilih Tujuan',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-branch-type.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term,
                    branch_type: $('#type_tujuan').val()
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