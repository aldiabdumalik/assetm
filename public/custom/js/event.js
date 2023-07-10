import * as module from './module.js';
$(document).ready(function () {
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-success',
        cancelClass: 'btn-light',
        autoApply: true,
        opens: 'center',
        locale: {
            format: 'DD/MM/YYYY'
        },
        autoUpdateInput: false
    }).on("apply.daterangepicker", function (e, picker) {
        let value = `${picker.startDate.format(picker.locale.format)} - ${picker.endDate.format(picker.locale.format)}`
        picker.element.val(value);
    });
    const dt = $('#event_table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        lengthChange: false,
        ajax: {
            method: "POST",
            url: module.base_url + 'event/datatable',
            headers: {'X-CSRF-TOKEN': module.header_token},
        },
        columns: [
            { data: 'event_name', name: 'event_name' },
            { data: 'event_start', name: 'event_start' },
            { data: '_color', name: '_color' },
            { data: 'event_category', name: 'event_category' }
        ],
        ordering: false
    });

    const resetForm = () => {
        $('#form-event').trigger('reset')
        $('#submit').text('Create Event')
        $('#color').removeAttr('style')
        $('#id').val(0)
        module.isHidden('#delete', true)
        $('#form-event select, button[type="submit"], input[name=date]').prop('disabled', false);
        $('#form-event input').not('input[type=hidden]').prop('readonly', false);
    }

    let touchtime = 0;
    $('#event_table tbody').on('click', 'tr', function () {
        if (touchtime == 0) {
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                let data = dt.row( this ).data();
                if (data != undefined) {
                    resetForm();
                    module.isHidden('#delete', false)
                    let start = data.event_start.split('/').reverse().join('-'),
                        end = (data.event_end == null) ? '' : ' - ' + data.event_end.split('/').reverse().join('-'),
                        date = `${start}${end}`;

                    $('#id').val(data.id);
                    $('#name').val(module.htmlDecode(data.event_name));
                    $('#date').val(date);
                    $('#color').val(data.event_color);
                    $('#type').val(data.event_category);

                    $("#color").css({background: data.event_color, color: 'white'});
                    $('#submit').text('Update Event');

                    if (data.from_api == 1) {
                        $('#form-event select, button[type="submit"], input[name=date]').prop('disabled', true);
                        $('#form-event input').prop('readonly', true);
                        module.send_notif({
                            icon: 'warning',
                            message: 'You can only modify manually generated events, but you can delete it'
                        })
                    }
                }
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });

    $('#form-event').submit(function (event) {
        event.preventDefault();
        module.loading_start();

        let url = module.base_url + 'event/' + $('#id').val() + '/detail',
            method = "GET",
            date = $('#date').val().split(' '),
            data = {
                name: $('#name').val(),
                start: date[0].split('/').reverse().join('-'),
                end: date[2].split('/').reverse().join('-'),
                color: $('#color').val(),
                category: $('#type').val()
            }

        module.callAjax(url, method).then(response => {
            if (parseInt(response.message) == 1) {
                method = "PUT"
                url = module.base_url + `event/${$('#id').val()}/update`
            }else{
                method = "POST"
                url = module.base_url + `event/save`
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

    $('#cancel').click(function() {
        resetForm()
    });

    $('#delete').click(function() {
        swal({
            title: 'Are you sure?',
            text: "This event will be deleted permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger mt-2',
            cancelButtonClass: 'btn btn-scondary ml-2 mt-2',
            confirmButtonText: 'Yes, delete it!'
        }).then((answers) => {
            if (answers == true) {
                module.loading_start();
                let url = module.base_url + 'event/' + $('#id').val() + '/delete',
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
    });

    $('#color').change(function(){
        var color = $("option:selected", this).val();
        $("#color").css({background: color, color: 'white'});
    });

    $('#form-event-generate').submit(function (e) {
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "You will delete the event from the previous API and replace it with a new one!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger mt-2',
            cancelButtonClass: 'btn btn-scondary ml-2 mt-2',
            confirmButtonText: 'Yes, generate it!'
        }).then((answers) => {
            if (answers == true) {
                module.loading_start();
                let url = module.base_url + 'event/generate',
                    method = 'POST',
                    data = {
                        year: $('#year').val()
                    }
                module.callAjax(url, method, data).then(response => {
                    module.loading_stop();
                    dt.ajax.reload();
                    module.send_notif({
                        icon: 'success',
                        message: response.message
                    });
                });
            }
        });
    });
});