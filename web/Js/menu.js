/**
 * Created by nazinorbi on 2016. 09. 18..
 */
;
(function ($) {
    let settings, obj,
        menuDiv = $('menu'),
        isClickedMenuToggleBars = false;

    _setParameters =  function (_settings, _obj) {
        settings = _settings;
        obj = _obj;
    };

    _start = function () {
        let className = obj.attr('class').split(' ');

        $.each(className, function (index, value) {
            switch (value) {
                case value = 'menu':
                    menuControl();
                    break;
                case value = 'langMenu':
                    langMenu(obj);
                    break;
            }
        });

        function menuControl() {

            $('.menuToggleBars').click(function () {
                isClickedMenuToggleBars = true;

                $('menu').addClass('flex-last')
                    .css('display', 'block');
                $('#menu').slideDown('slow');
            });

            $('ul#menu li').click(function () {
                let visibleSubmenu = $('.submenu ul:visible');

                if(visibleSubmenu.length === 2) {
                    visibleSubmenu.not($(this).children('ul')).slideUp('slow');
                    visibleSubmenu.not($(this).children('ul')).parent('li').toggleClass('fa-caret-up fa-caret-down');
                    $(this).slideDown('slow');
                } else {
                    $(this).slideDown('slow');
                }
            });

            $('ul#menu p').click(function () {
                let ulId = $(this).parents('ul').attr('id'),
                    parentUlnumber = $(this).parent().find('ul').length;

                if($(this).parent('li').filter('.submenu').length === 1 ) {
                    $(this).parent('li').toggleClass('fa-caret-down fa-caret-up');
                }

                if(!parentUlnumber) {
                    if(isClickedMenuToggleBars) {
                        let obj = $(this);
                             $.when().then(function () {
                                 if(typeof ulId === 'undefined') {
                                     obj.parents('ul').slideUp(500);
                                 }
                             }).then(function () {
                                 $('menu').slideUp(550).removeClass('flex-last')
                             }).then(function () {
                                 obj.parents('ul').removeClass('active').removeAttr( 'style' );
                                 obj.parents('li.submenu').toggleClass('fa-caret-up fa-caret-down');
                            });
                    }
                    else {
                        $('.submenu').find('ul').slideUp('slow');
                        $(this).parents('li.submenu').toggleClass('fa-caret-up fa-caret-down');
                    }
                } else {
                    $(this).parent().find('ul').slideDown('slow').addClass('active');
                }
            });
        }

        function langMenu(obj) {
            obj.click(function () {
                obj.children().slideToggle('slow');
            });

            obj.children('p').click(function () {
                obj.children().slideToggle('slow');
            });
        }
    };

    $.fn.menu = function (options) {
      let obj = $(this);
      _setParameters($.extend(true, defaults, options), obj);
      _start();
    };

    let defaults = {

    }
})(jQuery);

/*$(document).ready(function () {
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
});*/
