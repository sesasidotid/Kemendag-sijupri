function initTable() {
    $('[class^="main-table"]').each(function () {
        var table = $(this);
        if (!table.data('initialized')) {
            table.removeClass();
            table.addClass('main-table table table-hover nowrap align-middle w-100');
            table.find('thead').removeClass();
            table.find('thead').addClass('bg-primary text-white');
            table.DataTable({
                drawCallback: function (settings) {
                    var $dataTables_wrapper = $(settings.nTableWrapper);
                    var paginate_button = $dataTables_wrapper.find('.paginate_button');
                    paginate_button.addClass('ms-1 me-1 p-0');
                },
                initComplete: function (settings, json) {
                    $(this).wrap("<div style='overflow:auto; width:100%; position:relative;'></div>");
                }
            });
            table.data('initialized', true);
        }
    });

    $('[class^="dataTables_wrapper"]').each(function () {
        var $dataTables_wrapper = $(this);
        var dataTables_length = $dataTables_wrapper.find('.dataTables_length');
        dataTables_length.find('select').addClass('form-select');

        var dataTables_filter = $dataTables_wrapper.find('.dataTables_filter');
        dataTables_filter.find('input').addClass('form-control form-control-sm');
    });

    $('.secondary-table').each(function () {
        var table = $(this);
        if (!table.data('initialized')) {
            table.DataTable({
                "paging": false,
                "searching": false,
                "scrollX": true,
            });
            table.data('initialized', true);
        }
    });
}

function initTableV2() {
    $('[class^="main-table"]').each(function () {
        var table = $(this);
        table.removeClass();
        table.addClass('main-table table table-hover nowrap align-middle w-100');
        table.find('thead').removeClass();
        table.find('thead').addClass('bg-primary text-white');
        table.find('thead td').css('white-space', 'nowrap');
        table.find('thead th').css('white-space', 'nowrap');
        table.find('tbody td').css('white-space', 'nowrap');

        table.parent().addClass('table-responsive');
        table.parent().css('overflow-x', 'auto');
    });
}
