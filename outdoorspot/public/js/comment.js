/**Suppression d'un commentaire*/

$('.commentaire').on('click', function(event)
{
    var urlComment;
    var currentCommentBlockId;
    var currentCommentId;
    event.preventDefault();

    currentCommentId = this.getAttribute('id');
    currentCommentBlockId = '#comment' + currentCommentId;
    urlComment = '/comment/delete/' + currentCommentId;

    $.ajax({
        type: 'GET',
        url: urlComment,
        timeout : 3000
    })
        .done(function() {
            $(currentCommentBlockId).remove();
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });
});