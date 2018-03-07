$('.commentaire').on('click', function(event){

    event.preventDefault();

    var currentCommentId = event.target.getAttribute('id');
    var currentCommentBlockId = '#comment'+currentCommentId
    var urlComment = '/comment/delete/'+currentCommentId;

    $.ajax({
        type: 'GET',
        url: urlComment,
        timeout : 3000
    })
        .done(function(data) {
            message = data['message'];
            $(currentCommentBlockId).remove();
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });
});