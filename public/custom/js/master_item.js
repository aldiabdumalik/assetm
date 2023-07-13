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

    $(document).on('submit', '#form-brand', function(e){
        e.preventDefault();
        let url = new URL($(this).attr('action'));
        let method = url.pathname == '/item/add/brand' ? 'POST' : 'PUT';
        let jsonData = {
            type_id: $('#bjenis').val(),
            brand_name: $('#bname').val(),
        }

        module.loading_start();
        module.callAjax(url.href, method, jsonData).then(response => {
            module.loading_stop();
            $('#form-brand').trigger('reset');
            $('#bjenis').val('').trigger('change');
            $('#modal-brand').modal('hide')
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            dt.ajax.reload();
        })
    })

    $(document).on('click', '.edit-brand', function(e){
        e.preventDefault();
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        // console.log(url, id)
        module.loading_start();
        module.callAjax(module.base_url + `item/detail?id=${id}&q=brand`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#bname').val(data.brand_name);
            var typ = new Option(data.item_type.type_name, data.item_type.id);
            typ.selected = true;
            $("#bjenis").append(typ);
            $("#bjenis").trigger("change");
        })
        $('#modal-brand').modal('show')
        $('#form-brand').attr('action', $(this).data('href'));
        $('#modal-brand-title').text('Update Data')
        $('#submit-brand').text('Update')
    });
    $(document).on('click', '.delete-brand', function(e) {
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

    $(document).on('submit', '#form-model', function(e){
        e.preventDefault();
        let url = new URL($(this).attr('action'));
        let method = url.pathname == '/item/add/model' ? 'POST' : 'PUT';
        let jsonData = {
            type_id: $('#mjenis').val(),
            brand_id: $('#mbrand').val(),
            model_name: $('#mname').val(),
        }

        module.loading_start();
        module.callAjax(url.href, method, jsonData).then(response => {
            module.loading_stop();
            $('#form-model').trigger('reset');
            $('#mjenis').val('').trigger('change');
            $('#mbrand').val('').trigger('change');
            $('#modal-model').modal('hide')
            module.send_notif({
                icon: 'success',
                message: response.message
            });
            dt.ajax.reload();
        })
    })
    $(document).on('click', '.edit-model', function(e){
        e.preventDefault();
        let url = new URL($(this).data('href'));
        let id = url.pathname.split('/')[2];
        module.loading_start();
        module.callAjax(module.base_url + `item/detail?id=${id}&q=model`, 'GET').then(response => {
            let data = response.content;
            module.loading_stop();
            $('#mname').val(data.model_name);
            var typ = new Option(data.item_brand.item_type.type_name, data.item_brand.item_type.id);
            typ.selected = true;
            $("#mjenis").append(typ);
            $("#mjenis").trigger("change");

            var brd = new Option(data.item_brand.brand_name, data.item_brand.id);
            brd.selected = true;
            $("#mbrand").append(brd);
            $("#mbrand").trigger("change");
        })
        $('#modal-model').modal('show')
        $('#form-model').attr('action', $(this).data('href'));
        $('#modal-model-title').text('Update Data')
        $('#submit-model').text('Update')
    });
    $(document).on('click', '.delete-model', function(e) {
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
    $('#modal-brand').on('hidden.bs.modal', function(){
        $('#form-brand').attr('action', module.base_url + 'item/add/brand');
        $('#form-brand').trigger('reset');
        $('#bjenis').val('').trigger('change');
        $('#modal-brand-title').text('Tambah Data')
        $('#submit-brand').text('Tambah')
    });
    $('#modal-model').on('hidden.bs.modal', function(){
        $('#form-model').attr('action', module.base_url + 'item/add/model');
        $('#form-model').trigger('reset');
        $('#mjenis').val('').trigger('change');
        $('#mbrand').val('').trigger('change');
        $('#modal-model-title').text('Tambah Data')
        $('#submit-model').text('Tambah')
    });

    $('#bjenis').select2({
        dropdownParent: $('#modal-brand'),
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
                // $('#merk').empty();
                // $('#tipe').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.type_name };
                    })
                };
            },
            cache: true
        }
    })
    $('#mjenis').select2({
        dropdownParent: $('#modal-model'),
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
                $('#mbrand').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.type_name };
                    })
                };
            },
            cache: true
        }
    })
    $('#mbrand').select2({
        dropdownParent: $('#modal-model'),
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
                    type: $('#mjenis').val()
                }
                return query;
            },
            processResults: function(response) {
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.brand_name };
                    })
                };
            },
            cache: true
        }
    })
});