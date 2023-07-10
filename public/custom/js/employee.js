import * as module from './module.js';
$(document).ready(function () {
    let dt = $('#employee_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        lengthChange: false,
        ajax: {
            method: "POST",
            url: module.base_url + 'employee/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nik', name: 'nik' },
            { data: 'name', name: 'name' },
            { data: 'whatsapp', name: 'whatsapp' },
            { data: '_color', name: '_color' },
        ],
        dom: "<'row'<'col-sm-12 col-md-6' <'trash-view'>><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        initComplete: function() {
            $("div.trash-view").html('<button type="button" id="trash-table" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Trash Table</button>');
        }
    });

    const resetForm = () => {
        $('#form-employee').trigger('reset');
        $('#form-employee input').prop('readonly', false);
        colors();
        $('#color').removeAttr('style');
        $('#submit').text('Save');
        module.isHidden('#delete', true);
    }
    
    const colors = () => {
        return new Promise((resolve, reject) => {
            module.callAjax(module.base_url + 'employee/get_colors', 'GET').then(response => {
                $('#color').html('<option value="">Select color</option>');
                $.each(response.content, function (idx, $data) {
                    $('#color').append($('<option>', { 
                        value: $data.code,
                        text: $data.code
                    })); 

                    $(`#color option[value="${$data.code}"]`).css({background: $data.code, color: 'white'});
                });
                resolve(response);
            });
        });
    }

    colors();

    $('#color').change(function(){
        var color = $("option:selected", this).val();
        console.log(color);
        $("#color").css({background: color, color: 'white'});
    });

    $('#nik').on('change click keyup input paste', function(){
        $(this).val(function (index, value) {
            return value.replace(/(?!\.)\D/g, "");
        });
    });
    $('#whatsapp').on('change click keyup input paste', function(){
        $(this).val(function (index, value) {
            return value.replace(/(?!\.)\D/g, "");
        });
    });

    $(document).on('click', '#trash-table', function () {
        resetForm();
        dt = $('#employee_table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            lengthChange: false,
            ajax: {
                method: "POST",
                url: module.base_url + 'employee/datatable',
                headers: {'X-CSRF-TOKEN': module.header_token},
                data: {
                    trash: true
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'whatsapp', name: 'whatsapp' },
                { data: '_color', name: '_color' },
            ],
            dom: "<'row'<'col-sm-12 col-md-6' <'active-view'>><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function() {
                $("div.active-view").html('<button type="button" id="active-table" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Active Table</button>');
            }
        });
    });

    $(document).on('click', '#active-table', function () {
        resetForm();
        dt = $('#employee_table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            lengthChange: false,
            ajax: {
                method: "POST",
                url: module.base_url + 'employee/datatable',
                headers: {'X-CSRF-TOKEN': module.header_token},
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'whatsapp', name: 'whatsapp' },
                { data: '_color', name: '_color' },
            ],
            dom: "<'row'<'col-sm-12 col-md-6' <'trash-view'>><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function() {
                $("div.trash-view").html('<button type="button" id="trash-table" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Trash Table</button>');
            }
        });
    });

    let touchtime = 0;
    $('#employee_table tbody').on('click', 'tr', function () {
        if (touchtime == 0) {
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                let data = dt.row( this ).data();
                if (data != undefined) {
                    $('#color').append($('<option>', { 
                        value: data.color,
                        text: data.color
                    })); 

                    $('#nik').val(data.nik);
                    $('#nik').prop('readonly', true);

                    $('#name').val(data.name);
                    $('#whatsapp').val(data.whatsapp);
                    $('#color').val(data.color);
                    
                    let active = 0;
                    if (data.deleted_at == null) {
                        active = 1;
                    }else{
                        active = 0;
                        module.isHidden('#delete', false);
                    }
                    console.log(data.deleted_at);
                    $('#status').val(active);

                    $("#color").css({background: data.color, color: 'white'});
                    $('#submit').text('Update');
                }
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });

    $('#cancel').click(function() {
        resetForm()
    });
    
    $('#form-employee').submit(function (e) {
        e.preventDefault();
        module.loading_start();

        let url = module.base_url + 'employee/' + $('#nik').val() + '/detail',
            method = "GET",
            data = {
                nik: $('#nik').val(),
                name: $('#name').val(),
                whatsapp: $('#whatsapp').val(),
                color: $('#color').val(),
                active: $('#status').val(),
            }

        module.callAjax(url, method).then(response => {
            if (parseInt(response.message) == 1) {
                method = "PUT"
                url = module.base_url + `employee/${data.nik}/update`
            }else{
                method = "POST"
                url = module.base_url + `employee/save`
            }
            module.callAjax(url, method, data).then(response => {
                module.loading_stop();
                resetForm();
                dt.ajax.reload();
                module.send_notif({
                    icon: 'success',
                    message: response.message
                });
            });
        });
    });

    $('#delete').click(function () {
        let nik = $('#nik').val();
        if (nik == "") {
            module.send_notif({
                icon: 'warning',
                message: 'Data not found!'
            });
        }else{
            swal({
                title: 'Are you sure?',
                text: "This employee will be deleted permanently!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-danger mt-2',
                cancelButtonClass: 'btn btn-scondary ml-2 mt-2',
                confirmButtonText: 'Yes, delete it!'
            }).then((answers) => {
                if (answers == true) {
                    module.loading_start();
                    let url = module.base_url + 'employee/' + $('#nik').val() + '/delete',
                        method = "DELETE"
                    module.callAjax(url, method).then(response => {
                        module.loading_stop();
                        resetForm();
                        dt.ajax.reload();
                        module.send_notif({
                            icon: 'success',
                            message: response.message
                        });
                    });
                }
                console.clear();
            })
        }
    });

});