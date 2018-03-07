$('.like').on('click', function(event){
    event.preventDefault();

    var heart = this.childNodes[1];
    var likeCount = this.parentElement.childNodes[1];

    var currentAttrId = this.getAttribute('id');
    var currentPostId = currentAttrId.slice(10)

    var urlLike = '/like/'+currentPostId;

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