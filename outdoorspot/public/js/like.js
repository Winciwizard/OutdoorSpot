$('.like').on('click', function(event){

    var that = this.childNodes[1];
    event.preventDefault();

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
                $(that).removeClass('far').addClass('fas');
            } else if(msg.like === 0){
                $(that).removeClass('fas').addClass('far');
            }
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

});