$(function () {
    $('.select2-selection--multiple').select2();
    initOpenEditModal();
    initRedirectEditClose();
})

function initRedirectEditClose(){
    $('.edit-modal').on('hidden.bs.modal', function(){
        window.location.href = $(this).data('route');
    });

    $('.close-edit-modal').on('click', function () {
        $('#edit-form').modal('hide');
    })
}

function initOpenEditModal() {
    $('.edit-modal').modal('show');
}