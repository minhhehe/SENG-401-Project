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

    $('#flickr_data').keypress(function(e){
      if(e.keyCode==13)
      $('#grab_flickr_button').click();
    });
});

function displayAllImages(data) {
    var arrayLength = data.length;
    var code = "";

    for (var i = 0; i < arrayLength; i++) {
        code = code +
            "<div><img id='thumb_"+ i +"'style='width:100px;height:100px;'src='" + data[i] + "' onclick=\"swapBackround('"+data[i]+"')\"></div>"
    }
    // code = code + "</div>";
    return code;
}

function swapBackround(url) {
    console.log('swapBackround clicked');

      $("#model_backdrop").attr("src",url);
}
