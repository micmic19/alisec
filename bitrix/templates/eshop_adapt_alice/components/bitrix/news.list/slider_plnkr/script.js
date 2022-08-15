$(function() {

  $('#myCarousel').carousel({
    interval: 10000
  })
  console.log($('.item'))
  $('.item').each(function() {
  
    var next = $(this).next();
    console.log(next);
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    if (next.next().length > 0) {
      next.next().children(':first-child').clone().appendTo($(this));
    } else {
      $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
  });
});