$(document).ready(function() {
    $("img[usemap]").rwdImageMaps();
    $("img[usemap]").maphilight({
        fill: false,
        strokeColor: "000000",
        strokeWidth: 3
    });
    $(".ms-name").hide();
    $(".ms-face").hover(function() {
        var e = $(this).attr("id");
        $("#ms-all").hide();
        $("#" + e + "_name").show()
    }, function() {
        $(".ms-name").hide();
        $("#ms-all").show()
    })
})