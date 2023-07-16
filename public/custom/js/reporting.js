import * as module from './module.js';
$(document).ready(function () {
    $('.this_datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
    })

    $('.btn-download').on('click', function(e) {
        e.preventDefault();
        console.log(module.base_url + `reporting/download?q=${$(this).data('download')}&start=${$('#start').val()}&end=${$('#end').val()}`)
        window.location.href = module.base_url + `reporting/download?q=${$(this).data('download')}&start=${$('#start').val()}&end=${$('#end').val()}`
    })
});