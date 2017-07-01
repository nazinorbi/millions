
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
        $('.logout').replaceWith(data.login);
        $('.logout').toggleClass('logout', 'logout');
    };

     logoutError = function() {
        alert('Hiba van a logoutban');
    };

