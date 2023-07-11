import * as module from './module.js';
$(document).ready(function () {
    console.log(moment())
    $('#modal-igi').modal('show')
    $('.this_datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
    })
    const dt = $('#arrival_table').DataTable({
        
    });

    $('#regional').select2({
        dropdownParent: $('#modal-igi'),
        placeholder: 'Pilih Regional',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-regional.json',
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
                $('#branch').empty();
                return {
                    results: $.map(response.content, function(obj) {
                        return { id: obj.id, text: obj.regional_name };
                    })
                };
            },
            cache: true
        }
    })

    $('#branch').select2({
        dropdownParent: $('#modal-igi'),
        placeholder: 'Pilih Wilayah',
        multiple: false,
        ajax: {
            url: module.base_url + 'api/get-branch.json',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    search: params.term,
                    regional: $('#regional').val()
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

    $(document).on('submit', '#form-igi', function(e){
        e.preventDefault();

        let branch_id = $('#branch').val(),
            regional_desc = $('#regional').text(),
            branch_desc = $('#branch').text(),
            delivery_pic = $('#dpic').val(),
            user_pic = $('#pic').val(),
            arrival_date = module.convertDate($('#tgl').val()),
            arrival_total = $('#total').val(),
            arrival_note = $('#note').val(),
            url = module.base_url + 'arrival_item',
            method = 'POST';
        let jsonData = {
            branch_id : branch_id,
            regional_desc : regional_desc,
            branch_desc : branch_desc,
            delivery_pic : delivery_pic,
            user_pic : user_pic,
            arrival_date : arrival_date,
            arrival_total : arrival_total,
            arrival_note : arrival_note,
        }

        // console.log(jsonData)
        module.loading_start();
        module.callAjax(url, method, jsonData).then(response => {
            // console.log(response)
            // module.loading_stop();
            // $('#login-form').trigger('reset');
            // // window.localStorage.setItem('email', email);
            // module.send_notif({
            //     icon: 'success',
            //     message: response.message
            // }).then((msg) => {
            //     window.location.href = module.base_url;
            // });
        }).catch(err => {
            if ('errors' in err.responseJSON) {
                const errr = Object.keys(err.responseJSON.errors)
                errr.map(i => {
                    let id = '#'+i;
                    // console.log('i', i)
                    // // return i;
                    $(id).addClass('validation_error')
                    $(id).append(`<span class="text-danger font-italic">harus diisi</span>`)
                })
                console.log(errr)
            }
        });
    })

    $('#add-item').on('click', function(){
        $('#modal-igi').modal('show')
    })
});