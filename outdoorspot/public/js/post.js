var currentPostId = null;
var currentPostElement = null;

$('.edit').on('click', function(event) {
    event.preventDefault();

    var description;
    currentPostId = this.getAttribute('data-postid');
    currentPostElement = this.parentNode.parentNode.parentElement.childNodes[9];
    var urlPost = '/post/'+currentPostId+'.json';

    console.log(currentPostElement);


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

$('#modal-save').on('click', function () {


    var urlEdit = '/post/edit/'+currentPostId;

    $.ajax({
        type: 'POST',
        url: urlEdit,
        timeout: 3000,
        data: {description: $('#post-body').val(), _token: token}
    })
        .done(function(msg) {
            $(currentPostElement).text(msg['newDescription']);
            $('#edit-modal').modal('hide');
        })
});

$('.map-info').on('click', function(event){

    event.preventDefault();

    currentPostId = event.target.getAttribute('data-postid');
    var urlInfoMap = '/post/'+currentPostId+'.json';
    $.ajax({
        type: 'GET',
        url: urlInfoMap,
        timeout: 3000,
    })
        .done(function(data) {
            var lat = data['latitude'];
            var lng = data['longitude'];
            initMap(lat,lng);
        })
        .fail(function () {
            alert('Impossible de charger les informations');
        });

    $('#map-modal').modal();
});