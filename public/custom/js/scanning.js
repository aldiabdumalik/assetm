import * as module from './module.js';
$(document).ready(function () {
    const dt = $('#scan_table').DataTable({
        // processing: true,
        // serverSide: true,
        // destroy: true,
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
});