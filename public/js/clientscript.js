$(document).ready(function() {

  $('#grab_flickr_button').on('click', function() {
    console.log('clicked');
    var text = $('#flickr_data').val();
    var url="http://localhost:8000/api/images/flickr/" + text;
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
    code = code
        + "<img src='" + data[i] + "' " + "<br>"
  }
  return code;
}

function getAllBooks() {
  var url="http://localhost:8000/api/books/";
  console.log('clicked');
  $.ajax({
    url: url,
    type: 'get',
    success: function(response) {
      console.log(response['data'][0]);
      $("#result_space").empty();
      $("#result_space").html(
        displayAllBook(response['data'])
      );
    }
  });
}

function displayAllBook(data) {
  var arrayLength = data.length;
  var code = "";

  var authors = data[0]['authors'];
  console.log(authors);

  for (var i = 0; i < arrayLength; i++) {
    code = code
        + " Name: " + data[i]['name']
        + " ISBN: " + data[i]['isbn'] + "<br>"
        + " Authors: " + showAuthors(data[i]['authors'])
        + " Image located at: " + data[i]['image'] + "<br>"
        + " Publisher: " + data[i]['publisher'] + "<br>"
        + " Subscription status: " + data[i]['sub_status'] + "<br>"
        + " Year: " + data[i]['year'] + "<br>"
        + " Updated at: " + data[i]['updated_at'] + "<br>"
        + " Created at: " + data[i]['created_at'] + "<br>"
        + "<button type='button' class='btn' onclick='showBookImage("
        + data[i]['id'] +  ")'> View this book image </button>"
        + "<div id='image_for_book_" + data[i]['id'] + "'> </div>"
        + "<br>";
  }
  return code;
}

function showAuthors(authors) {
  var arrayLength = authors.length;

  var names = "";

  for (var i = 0; i < arrayLength; i++) {
    names = names
      + authors[i]['name']
      + "<br>";
  }
  return names;
}

function showBookImage(book_id) {
  var url="http://localhost:8000/api/books/image/" + book_id;
  var select_div="#image_for_book_" + book_id;
  console.log('clicked');
  $.ajax({
    url: url,
    type: 'get',
    success: function(response) {
      console.log(response);
      $(select_div).empty();
      var image="<img src='" + response['data']['image'] + "' alt='test'>";
      $(select_div).html(
        image
      );
    }
  });
}

function getABook() {
  var isbn = $('#isbn_input option:selected').val();
  console.log(isbn);
  var url="http://localhost:8000/api/books/isbn/" + isbn;
  var select_div="#result_space";
  console.log('clicked');
  $.ajax({
    url: url,
    type: 'get',
    success: function(response) {
      console.log(response);
      $(select_div).empty();
      if (response['data'].length == 0) {
        $(select_div).html(
          "Not found"
        );
      } else {
        $(select_div).html(
          displayABook(response['data'][0])
        );
      }

    }
  });
}

function displayABook(data) {
  code = ""
      + " Name: " + data['name']
      + " ISBN: " + data['isbn'] + "<br>"
      + " Authors: " + showAuthors(data['authors']) + "<br>"
      + " Image located at: " + data['image'] + "<br>"
      + " Publisher: " + data['publisher'] + "<br>"
      + " Subscription status: " + data['sub_status'] + "<br>"
      + " Year: " + data['year'] + "<br>"
      + " Updated at: " + data['updated_at'] + "<br>"
      + " Created at: " + data['created_at'] + "<br>"
      + "<button type='button' class='btn' onclick='showBookImage("
      + data['id'] +  ")'> View this book image </button>"
      + "<div id='image_for_book_" + data['id'] + "'> </div>"
      + "<br>";
  return code;
}
