$('.like').on('click', function(event){

    event.preventDefault();

    var currentLikeId = event.target.getAttribute('id');
    var urlLike = '/like/'+currentLikeId;

    $.ajax({
        type: 'POST',
        url: urlLike,
        timeout: 3000,
        data: {id: currentLikeId,_token: token}
    })
        .done(function(msg) {
            $('#'+currentLikeId).text(msg['newlike']);
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

});

$('.map-info').on('click', function(event){

    event.preventDefault();

    var urlLike = '/like/'+currentLikeId;

    $.ajax({
        type: 'POST',
        url: '//infomap',
        timeout: 3000,
        data: {id: id,_token: token}
    })
        .done(function(msg) {
            initMap(msg.lat, msg.lng);
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

});