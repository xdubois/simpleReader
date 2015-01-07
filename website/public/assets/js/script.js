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
    if ($(this).val().length < 3) {
      return false;
    }

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

  $("button.toggleread").click(function () {
    var btn = $(this);
    var posting = $.post($('#ajax-url').data('read'), { id:   btn.closest('.article').attr('id'), unread : btn.val() });
    posting.done(function (data) {
      btn.closest('.article').data('toggled', 1);
      if (btn.val() == 1) {
        btn.val(0);
        btn.html(' Mark as read');
        btn.closest('.article').css('borderLeft', '1px solid #337ab7');
      }
      else {
        btn.val(1);
        btn.html(' Mark as unread');
        btn.closest('.article').css('borderLeft', 'none');
      }
      $("#user-navbar").html(data);
    });
  });

  var margin = $(window).height() * 0.8;
  $("#margin-item").css("height", margin);
  $("#margin-item > p").css("padding-top", margin/2);

  $('.article').waypoint(function (direction) {
    var article = $(this);
    if (direction == "down") {
      var title = article.find("h2").find("a");
      var posting = $.post($('#ajax-url').data('set-read'), { id: article.attr("id") });
      posting.done(function (data) {
        $("#user-navbar").html(data);
        if (article.data('toggled') == 0) {
          article.css('borderLeft', 'none');
        }
    });
    }
    if (direction == "up" && article.data('toggled') == 0) { 
      article.find('button').html(' Mark as unread').val(1);
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