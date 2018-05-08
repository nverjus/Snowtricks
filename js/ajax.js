$(function() {
  $('.load-more').on('click', function() {
    var data;
    $.ajax({
      type: 'GET',
      url: 'http://localhost/tricks.php' + '?id=' + $('.load-more').id,
      data: data,
      async: true,
      dataType: 'json',
      success: function(data) {
        var tricks = '';
        console.log($(data).last())
        $.each(data, function(key, trick) {
          tricks = tricks + '<div class="col-md-2 trick"><img alt="' + trick["name"] + '" src="' + trick['image'] + '" class="img-fluid"><div class="d-flex justify-content-around trick-actions"><div class=" trick-name"><a href=trick.html>' + trick['name'] + '</a></div><div class="col-2"><a href="#" class="trick-icons"><i class="fas fa-pencil-alt"></i></a></div><div class="col-2"><a href="#" class="trick-icons"><i class="far fa-trash-alt"></i></a></div></div></div>';
        });
        $('.load-more').attr('id', $(data).last()[0]['id']);
        $(tricks).appendTo('.tricks').hide().slideDown("slow");
        $('.arrow-up').css("display", "block");

      }
    });
  });
});