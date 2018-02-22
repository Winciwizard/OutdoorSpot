$('.edit').on('click', function(event) {
    event.preventDefault();

    console.log('click edit');

    $('#edit-modal').modal();
});