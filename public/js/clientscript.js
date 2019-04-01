$(document).ready(function() {

    $('#grab_flickr_button').on('click', function() {
        console.log('clicked');
        var text = $('#flickr_data').val();
        var url = "http://localhost:8000/api/images/flickr/" + text;
        $.ajax({
            url: url,
            type: 'get',
            success: function(response) {
                console.log(response[0]);
                $("#imageSection").html(
                    displayAllImages(response)
                );
            }
        });
    });
});

function displayAllImages(data) {
    var arrayLength = data.length;
    var code = "";

    for (var i = 0; i < arrayLength; i++) {
        code = code +
            "<img src='" + data[i] + "' " + "<br>"
    }
    return code;
}
