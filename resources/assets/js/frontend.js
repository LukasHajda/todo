$(function () {
    $('.select2-selection--multiple').select2();
    initOpenEditModal();
    initRedirectEditClose();
    initShowModalEvent();
})

function initRedirectEditClose(){
    $('.edit-modal').on('hidden.bs.modal', function(){
        window.location.href = $(this).data('route');
    });

    $('.show-modal').on('hidden.bs.modal', function(){
        window.location.href = $(this).data('route');
    });

    $('.close-edit-modal').on('click', function () {
        $('#edit-form').modal('hide');
    })

    $('.show-modal-close').on('click', function () {
        $('#showModal').modal('hide');
    })
}

function initOpenEditModal() {
    $('.edit-modal').modal('show');
}

function initShowModalEvent() {
    $('.show-modal').modal('show');
}