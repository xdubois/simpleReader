$(function() {

  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
    }
  });

  $('.category-update').change(function(){
    var attributs = $(this).parent().parent();
    $.ajax({
      type: "POST",
      url: attributs.data('update-category-url'),
      data: { category_id: $(this).val(), feed_id: attributs.data('feed-id') }
    }).done(function(data) {
      $("#user-navbar").html(data);
    });
  })

  $('.feed-name-update').bind('input', function() {
    var attributs = $(this).parent().parent();
    $.ajax({
      type: "POST",
      url: attributs.data('update-feed-name'),
      data: { name: $(this).val(), feed_id: attributs.data('feed-id') }
    }).done(function(data) {
      $("#user-navbar").html(data);
    });
  });

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

  var margin = $(window).height() * 0.8;
  $("#margin-item").css("height", margin);
  $("#margin-item > p").css("padding-top", margin/2);

  $('.article').waypoint(function (direction) {
    if (direction == "down") {
      var title = $(this).find("h2").find("a");
      var posting = $.post($('#ajax-url').data('set-read'), { id: $(this).attr("id") });
      posting.done(function (data) {
       $("#user-navbar").html(data);
       if (data != "") {
        title.css("color", "black");
      }
    });


    }
  });

  $(".item-click").click(function () {
    $.post($('#ajax-url').data('item-click'));
  });


  $('.mark-all-read').click(function(){
    $.ajax({
      type: "POST",
      url: $('#ajax-url').data('set-all-read')
    }).done(function(data) {
      $("#user-navbar").html(data);
    });
  })

});