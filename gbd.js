jQuery(document).ready(function () {
  var gbdText = jQuery('[name="gbd_text"]');
  var gbdTextSize = jQuery('[name="gbd_text_size"]');
  var gbdUrl = jQuery('[name="gbd_url"]');
  var gbdUrlSize = jQuery('[name="gbd_url_size"]');
  var gbdPreviewText = jQuery("#gbdpreviewtext");
  var gbdPreviewUrl = jQuery("#gbdpreviewurl");

  gbdPreviewText.html(gbdText.val());
  gbdPreviewText.css("font-size", parseInt(gbdTextSize.val()) + 'pt');
  gbdPreviewUrl.css("font-size", parseInt(gbdUrlSize.val())+ 'pt');
  (!gbdUrl.is(":checked") ? gbdPreviewUrl.css('visibility', 'hidden') : gbdPreviewUrl.css('visibility', 'visible'));

  gbdText.add(gbdTextSize).add(gbdUrlSize).add(gbdUrl).bind("keyup change", function (e) {
    gbdPreviewText.html(gbdText.val());
    gbdPreviewText.css("font-size", parseInt(gbdTextSize.val()) + 'pt');
    gbdPreviewUrl.css("font-size", parseInt(gbdUrlSize.val()) + 'pt');
    (!gbdUrl.is(":checked") ? gbdPreviewUrl.css('visibility', 'hidden') : gbdPreviewUrl.css('visibility', 'visible'));
  });
});