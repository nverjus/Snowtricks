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
          tricks = tricks + '<div class="col-md-2 trick"><a href="/trick/' + trick['id'] + '"><img alt="' + trick["name"] + '" src="img/tricks/' + trick['photo'] + '" class="img-fluid"></a><div class="d-flex justify-content-around trick-actions"><div class=" trick-name"><a href="/trick-' + trick['id'] + '">' + trick['name'] + '</a></div><div class="col-2"><a href="#" class="trick-icons"><i class="fas fa-pencil-alt"></i></a></div><div class="col-2"><a href="#" class="trick-icons"><i class="far fa-trash-alt"></i></a></div></div></div>';
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
      url: "/trick/" + trickId + "/" + page,
      data: data,
      async: true,
      dataType: "json",
      success: function(data) {
        var comments = "";
        $.each(data["comments"], function(key, comment) {
          comments = comments + '<div class="col-md-6 offset-md-3"><div class="d-flex justify-content-between comment"><div class="col-2 user"><img class="img-fluid rounded-circle" alt="' + comment["user"]["name"] + '" src="/img/users/' + comment["user"]["photo"] + '"><small>' + comment["user"]["name"] + '</small></div><div class="col-10"><small>Published the ' + comment["publicationDate"] + '</small><p>' + comment["content"] + '</p></div></div></div>';
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
$(function() {

  $("a[href*='#content']").click(function() {
    if (
      location.hostname === this.hostname &&
      this.pathname.replace(/^\//, "") === location.pathname.replace(/^\//, "")
    ) {
      var anchor = $(this.hash);
      anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) + "]");
      if (anchor.length) {
        $("html, body").animate({
          scrollTop: anchor.offset().top
        }, 800);
      }
    }
  });

  $(".show-medias").click(function() {
    $(".medias").css("display", "block");
    $(".show-medias").css("display", "none");
  });

});
$(function() {
  var container = $("div#trick_trickPhotos");

  var index = container.find(":input").length;

  $("#add_photo").click(function(e) {
    addPhoto(container);


    e.preventDefault();
    return false;
  });

  if (index == 0) {
    addPhoto(container);
  } else {
    container.children("div").each(function() {
      addDeleteLink($(this));
    });
  }

  function addPhoto(container) {
    var template = container.attr("data-prototype", "<fieldset class=\"form-group\"><div id=\"trick_trickPhotos___name__\"><div class=\"form-group\"><input type=\"file\" id=\"trick_trickPhotos___name___adress\" name=\"trick[trickPhotos][__name__][adress]\" class=\"form-control-file\"></div></div></fieldset>");

    var template = container.attr("data-prototype")
      .replace(/__name__/g, index);

    var $prototype = $(template);

    addDeleteLink($prototype);

    container.append($prototype);

    index++;
  }

  function addDeleteLink($prototype) {
    var $deleteLink = $("<a href=\"#\" class=\"btn btn-danger\">Delete</a>");

    $prototype.append($deleteLink);

    $deleteLink.click(function(e) {
      $prototype.remove();

      e.preventDefault();
      return false;
    });
  }
});

$(function() {
  var container = $("div#trick_videos");

  var index = container.find(":input").length;
  $("#add_video").click(function(e) {
    addVideo(container);


    e.preventDefault();
    return false;
  });

  if (index == 0) {
    addVideo(container);
  } else {
    container.children("div").each(function() {
      addDeleteLink($(this));
    });
  }

  function addVideo(container) {
    var template = container.attr('data-prototype', "<fieldset class=\"form-group\"><div id=\"trick_videos___name__\"><div class=\"form-group\"><input type=\"text\" id=\"trick_videos___name___iframe\" name=\"trick[videos][__name__][iframe]\" class=\"form-control\" /></div></div></fieldset>");

    var template = container.attr("data-prototype")
      .replace(/__name__/g, index);

    var $prototype = $(template);

    addDeleteLink($prototype);

    container.append($prototype);

    index++;
  }

  function addDeleteLink($prototype) {
    var $deleteLink = $("<a href=\"#\" class=\"btn btn-danger\">Delete</a>");

    $prototype.append($deleteLink);

    $deleteLink.click(function(e) {
      $prototype.remove();

      e.preventDefault();
      return false;
    });
  }
});