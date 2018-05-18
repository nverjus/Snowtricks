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