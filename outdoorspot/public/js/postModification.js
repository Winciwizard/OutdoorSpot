$('.edit').on('click', function(event) {
    event.preventDefault();

    var description;
    var currentPostId = event.target.getAttribute('data-postid');
    var urlPost = '/post/'+currentPostId+'.json';


    $.ajax({
        type: 'GET',
        url: urlPost,
        timeout : 3000
    })
        .done(function(data) {
            description = data['description'];
            $('#post-body').val(description);
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

    $('#edit-modal').modal();
});