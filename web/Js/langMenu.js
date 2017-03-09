/**
 * Created by nazinorbi on 2017. 03. 05..
 */
/**
 * Created by nazinorbi on 2016. 09. 18..
 */
$(document).ready(function () {
    $("ul.langMenu   li:last-child").css("margin-right", 0);
    $("body").on('click', ".fa-language", function () {
        var elem = $('.langMenu ul');
            //$(this).css({"background-image": "url(arrow_up.png) no-repeat"});
            //elem.children("li").css({"-webkit-transform": "translate( -25px, 15px)"});
            elem.slideDown("slow");
            elem.parent().hover(
                function () {
                },
                function () {
                    elem.slideUp('slow');

                    //$(this).parent().find("li#almenu").css({"background-image": "url(arrow_down.png) no-repeat"});
                }
            );
        }
    );
});