$(document).ready(function() {
    "use strict"
    // init list view datatable
    const dataListView = $(".data-list-view").DataTable({
        responsive: false,
        columnDefs: [
            {
                orderable: true,
                targets: 0,
                checkboxes: false
            }
        ],
        dom:
            '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        aLengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
        order: [
            [3, "desc"]
        ],
        bInfo: false,
        pageLength: 5,
        buttons: [
            {
                text: "<i class='feather icon-plus'></i> Create new",
                action: function() {
                    window.location = '/servers/create';
                },
                className: "btn-outline-primary"
            }
        ],
        initComplete: function(settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary")
        }
    });

    dataListView.on('draw.dt', function(){
        setTimeout(function(){
            if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
            }
        }, 50);
    });

    // mac chrome checkbox fix
    if (navigator.userAgent.indexOf("Mac OS X") != -1) {
        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
    }
})
