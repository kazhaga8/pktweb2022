
$(".list-product x-button").click(function(){
  $(this).addClass("active");
  $(this).siblings().removeClass("active");
});

let isRotated = false;

$(".list-product x-button").on("click", function() {
  if (!isRotated) {
    isRotated = true;

    //add one class and remove the other
    $(".img-circle").addClass("rotate-180");
    $(".img-circle").removeClass("rotate-180back");
  } else {
    isRotated = false;

    //add one class and remove the other
    $(".img-circle").addClass("rotate-180back");
    $(".img-circle").removeClass("rotate-180");
  }
});
