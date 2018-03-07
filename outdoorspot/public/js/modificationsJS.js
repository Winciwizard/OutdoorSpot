var postID = null;
var postBodyElement = null;


$('.edit').on('click', function (event) {

    event.preventDefault();

    postBodyElement = event.target.parentNode.parentNode.childNodes[3].textContent;

    postID = event.target.getAttribute('data-postid');

    var postTitle = event.target.parentNode.parentNode.childNodes[1].textContent;


    $('#post-title').val(postTitle);

    $('#post-body').val(postBodyElement);

    $('#edit-modal').modal();
});

$("#modal-save").on('click', function () {

    var title = $("#post-title").val();

    var body = $("#post-body").val();




    var header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };


    var data = {body: body, title: title, postID: postID};


    $.ajax({

        headers: header,

        type: 'POST',

        url: '/edit/{post_id}',

        data: data


    })
        .done(function () {

            $('#view-title').text(title);
            $('#view-body').text(body) ;
            $('#edit-modal').modal('hide');
        })
        .fail(function (msg) {
            msg("erreur édition impossible");
        })


});