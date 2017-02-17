
     getLogout = function(href) {
            return {
                'Logout': true
            }
    };

     logoutAdd = function(data, instanceUrl)
    {

        if(data.menu !== '') {
            $(".menuDiv").children().replaceWith(data.menu);
        }
        $('.logout').remove();
        $('nav').prepend(data.login);

       /* var pathName = window.location.pathname.split( '/' );

        if(pathName[2] == "Blog") {
            $('.blogEdit').hide();
        }*/
    };

     logoutError = function() {
        alert('szarvan');
    };

