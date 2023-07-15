import * as module from './module.js';
$(document).ready(function () {
    const thisUrl = new URL(window.location.href)
    const url_id = thisUrl.pathname.split('/')[2];
    // console.log(url_id)
    const dt = $('#pengiriman_table').DataTable({})

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