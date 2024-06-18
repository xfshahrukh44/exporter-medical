$('.slider2').owlCarousel({
    loop: true,
    nav: true,
    margin: 10,
    dots: false,

    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 7
        }
    }
})

$('.slider3').owlCarousel({
    loop: true,
    nav: true,
    margin: 10,
    dots: false,

    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 6
        }
    }
})





$(document).ready(function(){
    
    $("#mobrespon").on('toggle', function(){
        $("#mobshow").show();
    });

  
});


$('.playbutton').click(function(){
$('video')[0].paused?$('video')[0].play():$('video')[0].pause();
});


$(document).ready(function(){
  setTimeout(function(){
    $('.loadermain').fadeOut();
  }, 3500);


});

$(".img_producto_container")
  // tile mouse actions
  .on("mouseover", function() {
    $(this)
      .children(".img_producto")
      .css({ transform: "scale(" + $(this).attr("data-scale") + ")" });
  })
  .on("mouseout", function() {
    $(this)
      .children(".img_producto")
      .css({ transform: "scale(1)" });
  })
  .on("mousemove", function(e) {
    $(this)
      .children(".img_producto")
      .css({
        "transform-origin":
          ((e.pageX - $(this).offset().left) / $(this).width()) * 100 +
          "% " +
          ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +
          "%"
      });
  });



  let data = 0;

document.getElementById("counter").value = data;

function increment(){
  data = data + 1;
  document.getElementById("counter").value = data;
};

function decrement() {
  data = data - 1;
  document.getElementById("counter").value = data;
}
