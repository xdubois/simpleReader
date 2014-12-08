$(function() {

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
});