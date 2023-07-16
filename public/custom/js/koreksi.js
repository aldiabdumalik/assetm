import * as module from './module.js';
$(document).ready(function () {
    $('#form-scan').on('submit', function(e){
        e.preventDefault();
        let url = new URL($(this).attr('action'));
        let barcode = $('#barcode_scan').val();
        $('#scan_table tbody').remove();
        $('#text-status').html('');
        module.loading_start();
        module.callAjax(url.href + '?barcode='+$('#barcode_scan').val(), 'GET').then(response => {
            module.loading_stop();
            $('#barcode_scan').val(null);
            $('#form-scan').hide();
            $('#form-update').removeAttr('hidden');
            $('#barcode').val(barcode);
            $('#scan_table').append(`
            <tbody>
                <tr>
                    <td>IGI</td>
                    <td>${response.content.created_at}</td>
                    <td>${response.content.user.username}</td>
                </tr>
            </tbody>
            `)

            if (response.content.uji_fungsi != null) {
                $('#scan_table').append(`
                    <tbody>
                        <tr>
                            <td>UJI FUNGSI</td>
                            <td>${response.content.uji_fungsi.created_at}</td>
                            <td>${response.content.user.username}</td>
                        </tr>
                    </tbody>
                `)
            }

            if (response.content.packing_list_item != null) {
                $('#scan_table').append(`
                    <tbody>
                        <tr>
                            <td>PACKING LIST</td>
                            <td>${response.content.packing_list_item.created_at}</td>
                            <td>${response.content.user.username}</td>
                        </tr>
                    </tbody>
                `)

                let status = response.content.packing_list_item.delivery_status;
                let status_str = ''
                if (parseInt(status) == 0) {
                    status_str = 'Belum masuk pengiriman';
                }else if (parseInt(status) == 0) {
                    status_str = 'Belum dikirim';   
                }else{
                    status_str = 'Sudah dikirim';   
                }

                $('#text-status').html(`
                    <div class="badge badge-info"> ${status_str} <div>
                `)
            }

            $('#text-status').html(`
                <div class="badge badge-danger"> Belum masuk pengiriman <div>
            `)
            let data = response.content;
            var typ = new Option(data.item_model.item_brand.item_type.type_name, data.item_model.item_brand.item_type.id);
            typ.selected = true;
            $("#jenis").append(typ);
            $("#jenis").trigger("change");

            var brd = new Option(data.item_model.item_brand.brand_name, data.item_model.item_brand.id);
            brd.selected = true;
            $("#merk").append(brd);
            $("#merk").trigger("change");

            var mdl = new Option(data.item_model.model_name, data.item_model.id);
            mdl.selected = true;
            $("#tipe").append(mdl);
            $("#tipe").trigger("change");
        })
    })

    // $('#barcode_scan').on('keypress', function (e) {
    //     if(e.which === 13){
    //         $('#form-scan').submit();
    //     }
    // });

    // $('#barcode_scan').keyup(module.delay(function (e) {
    //     // console.log($('#barcode_scan').val().length);
    //     if ($('#barcode_scan').val().length >= 5) {
    //         $('#form-scan').submit();
    //     }
    // }, 1500));

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
});