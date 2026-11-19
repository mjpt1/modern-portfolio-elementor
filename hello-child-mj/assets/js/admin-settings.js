(function ($) {
  "use strict";

  function bindMedia($root) {
    $root.on("click", ".mj-media-select", function (e) {
      e.preventDefault();
      var $field = $(this).closest(".mj-media-field");
      var frame = wp.media({
        title: "Select image",
        button: { text: "Use image" },
        multiple: false,
      });
      frame.on("select", function () {
        var att = frame.state().get("selection").first().toJSON();
        $field.find(".mj-media-id").val(att.id);
        var url = (att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url) || att.url;
        $field.find(".mj-media-field__preview").html('<img src="' + url + '" alt="" />');
      });
      frame.open();
    });

    $root.on("click", ".mj-media-clear", function (e) {
      e.preventDefault();
      var $field = $(this).closest(".mj-media-field");
      $field.find(".mj-media-id").val("0");
      $field.find(".mj-media-field__preview").html('<span class="mj-media-field__empty">—</span>');
    });
  }

  $(function () {
    bindMedia($(document));
  });
})(jQuery);
