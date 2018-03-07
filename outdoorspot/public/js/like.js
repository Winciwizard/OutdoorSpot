$('.like').on('click', function(event){

    event.preventDefault();

    var currentAttrId = this.getAttribute('id');
    var currentPostId = currentAttrId.slice(10)

    var urlLike = '/like/'+currentPostId;

    console.log(urlLike);

    $.ajax({
        type: 'POST',
        url: urlLike,
        timeout: 3000,
        data: {_token: token}
    })
        .done(function(msg) {
            if (msg.like === 1) {
                this.removeClass("").addClass("");
            } else if(msg.like === 0){
                this.removeClass("").addClass("");
            }
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

});