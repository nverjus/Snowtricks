$(function() {

  $(".load-more-tricks").on("click", function() {
    var data;
    var page = $(".load-more-tricks").attr("id");
    $.ajax({
      type: "GET",
      url: "/" + page,
      data: data,
      async: true,
      dataType: "json",
      success: function(data) {
        var tricks = "";
        $.each(data["tricks"], function(key, trick) {
          tricks = tricks + '<div class="col-md-2 trick"><a href="/trick-' + trick['id'] + '"><img alt="' + trick["name"] + '" src="img/tricks/' + trick['photo'] + '" class="img-fluid"></a><div class="d-flex justify-content-around trick-actions"><div class=" trick-name"><a href="/trick-' + trick['id'] + '">' + trick['name'] + '</a></div><div class="col-2"><a href="#" class="trick-icons"><i class="fas fa-pencil-alt"></i></a></div><div class="col-2"><a href="#" class="trick-icons"><i class="far fa-trash-alt"></i></a></div></div></div>';
        });
        $(tricks).appendTo(".tricks").hide().slideDown("slow");
        $(".arrow-up").css("display", "block");

        page = Number(page) + 1;
        $(".load-more-tricks").attr("id", page);
        if (page >= data["nbPages"]) {
          $(".load-more-tricks").hide();
        }
      }
    });
  });

  $(".load-more-comments").on("click", function() {
    var data;
    var trickId = $(".comments").attr("id");
    var page = $(".load-more-comments").attr("id");

    $.ajax({
      type: "GET",
      url: "/trick-" + trickId + "/" + page,
      data: data,
      async: true,
      dataType: "json",
      success: function(data) {
        var comments = "";
        $.each(data["comments"], function(key, comment) {
          comments = comments + '<div class="col-md-6 offset-md-3"><div class="d-flex justify-content-between comment"><div class="col-2 user"><img class="img-fluid rounded-circle" alt="' + comment["user"]["name"] + '" src="img/users/' + comment["user"]["photo"] + '"><small>' + comment["user"]["name"] + '</small></div><div class="col-10"><small>Published the ' + comment["publicationDate"] + '</small><p>' + comment["content"] + '</p></div></div></div>';
        });
        $(comments).appendTo(".comments").hide().slideDown("slow");
        page = Number(page) + 1;
        $(".load-more-comments").attr("id", page);
        if (page >= data["nbPages"]) {
          $(".load-more-comments").hide();
        }
      }
    });
  });
});