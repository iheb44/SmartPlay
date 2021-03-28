 $( document ).ready(function() {
    $(".navbar-nav .nav-item").on("click", function(){
        $(".nav-item").find(".active").removeClass("active");
        $(this).addClass("active");
    });
});
