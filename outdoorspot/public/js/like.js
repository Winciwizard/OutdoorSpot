/**Gestion des likes*/

$('.like').on('click', function(event)
{
    var urlLike;
    var currentPostId;
    var currentAttrId;
    var likeCount;
    var heart;

    event.preventDefault();

    heart = this.childNodes[1];
    likeCount = this.parentElement.childNodes[1];
    currentAttrId = this.getAttribute('id');
    currentPostId = currentAttrId.slice(10);
    urlLike = '/like/' + currentPostId;

    $.ajax({
        type: 'POST',
        url: urlLike,
        timeout: 3000,
        data: {_token: token}
    })
        .done(function(msg) {
            if (msg.like === 1) {
                $(heart).removeClass('far').addClass('fas');
                $(likeCount).text(parseInt($(likeCount).text())+1);
            } else if(msg.like === 0){
                $(heart).removeClass('fas').addClass('far');
                $(likeCount).text(parseInt($(likeCount).text())-1);
            }
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

});