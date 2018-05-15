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