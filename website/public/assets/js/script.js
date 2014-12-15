$(function() {

  $.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
      }
  });

  $('.category-update').change(function(){
    var attributs = $(this).parent().parent();
    console.log(attributs.data('feed-id'));
    $.ajax({
      type: "POST",
      url: attributs.data('update-category-url'),
      data: { category_id: $(this).val(), feed_id: attributs.data('feed-id') },
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
      }
    })
  })

  $("span.togglefavorite").click(function () {
    $(this).toggleClass("glyphicon-star-empty glyphicon-star");
    var posting = $.post($('#ajax-url').data('favorite'), { id: $(this).closest('.article').attr('id') });
    posting.done(function (data) {
      $("#user-navbar").html(data);

    });
  });

  $("input.toggleread").click(function () {
    $(this).toggleClass("glyphicon-star-empty glyphicon-star");
    var unread = $(this).is(":checked");
    unread = unread ? 1 : 0;
    var posting = $.post($('#ajax-url').data('read'), { id: $(this).closest('.article').attr('id'), unread : unread });
    posting.done(function (data) {
      $("#user-navbar").html(data);

    });
  });

});