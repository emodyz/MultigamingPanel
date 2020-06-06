$(document).ready(function () {
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
        bInfo: false,
        pageLength: 5,
        buttons: [
            {
                text: "<i class='feather icon-plus'></i> Create new",
                action: function () {
                    $('#createModpackModal').modal();
                },
                className: "btn-outline-primary"
            }
        ],
        initComplete: function (settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary")
        }
    });

    $('#createModpackModal').on('hidden.bs.modal', () => {
        window.location.reload();
    });


    $('.action-delete').on('click', (e) => {
        e.preventDefault();
        const requestUrl = e.currentTarget.href || null;

        if (!requestUrl) {
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                axios.delete(requestUrl)
                    .then(() => {
                        Swal.fire({
                            type: "success",
                            title: 'Deleted!',
                            text: 'Your modpack has been deleted.',
                            confirmButtonClass: 'btn btn-success',
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    })
                    .catch((err) => {
                        Swal.fire({
                            type: "error",
                            title: 'Error !',
                            text: err.response.data.message || err,
                            confirmButtonClass: 'btn btn-success',
                        })
                    })

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your modpack is safe :)',
                    type: 'error',
                    confirmButtonClass: 'btn btn-success',
                })
            }
        })
    })
})
