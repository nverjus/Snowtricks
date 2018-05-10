$(function() {
  $('.load-more-tricks').on('click', function() {
    var data;
    $.ajax({
      type: 'GET',
      url: 'http://localhost/tricks.php' + '?id=' + $('.load-more-tricks').id,
      data: data,
      async: true,
      dataType: 'json',
      success: function(data) {
        var tricks = '';
        $.each(data, function(key, trick) {
          tricks = tricks + '<div class="col-md-2 trick"><img alt="' + trick["name"] + '" src="' + trick['image'] + '" class="img-fluid"><div class="d-flex justify-content-around trick-actions"><div class=" trick-name"><a href=trick.html>' + trick['name'] + '</a></div><div class="col-2"><a href="#" class="trick-icons"><i class="fas fa-pencil-alt"></i></a></div><div class="col-2"><a href="#" class="trick-icons"><i class="far fa-trash-alt"></i></a></div></div></div>';
        });
        $('.load-more-tricks').attr('id', $(data).last()[0]['id']);
        $(tricks).appendTo('.tricks').hide().slideDown("slow");
        $('.arrow-up').css("display", "block");

      }
    });
  });

  $('.load-more-comments').on('click', function() {
    var data;
    $.ajax({
      type: 'GET',
      url: 'http://localhost/comments.php' + '?id=' + $('.load-more-comments').id,
      data: data,
      async: true,
      dataType: 'json',
      success: function(data) {
        var comments = '';
        $.each(data, function(key, comment) {
          comments = comments + '<div class="col-md-6 offset-md-3"><div class="d-flex justify-content-between comment"><div class="col-2 user"><img class="img-fluid rounded-circle" alt="' + comment["user"]["name"] + '" src="' + comment["user"]["image"] + '"><small>' + comment["user"]["name"] + '</small></div><div class="col-10"><small>Published the ' + comment["publicationDate"] + '</small><p>' + comment["content"] + '</p></div></div></div>';
        });
        $('.load-more-comments').attr('id', $(data).last()[0]['id']);
        $(comments).appendTo('.comments').hide().slideDown("slow");

      }
    });
  });
});