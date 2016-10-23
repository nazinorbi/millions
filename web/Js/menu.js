/**
 * Created by nazinorbi on 2016. 09. 18..
 */
$(document).ready(function () {
    $("ul#menu   li:last-child").css("margin-right", 0);
    $("body").on('click', "li#almenu", function () {
            $(this).css({"background-image": "url(arrow_up.png) no-repeat"});
            $(this).children("li ul li ul ").css({"-webkit-transform": "translate( 105px, -20px)"});
            $(this).children("ul#almenu").slideDown("slow");
            $(this).parent().hover(
                function () {
                },
                function () {
                    $(this).parent().find("ul#almenu").slideUp('slow'),

                        $(this).parent().find("li#almenu").css({"background-image": "url(arrow_down.png) no-repeat"});
                }
            );
        }
    );
});