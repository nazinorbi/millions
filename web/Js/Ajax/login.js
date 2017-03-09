
        getLogin = function(href) {
            return {
                'loginName': $(".loginName").val(),
                'loginPass': $('.loginPassword').val()
            }
        };

         loginAdd = function(data, instanceUrl) {
            var parse = JSON.parse(data);
            if(data.menu !== "") {
                $(".menuDiv").children().replaceWith(data.menu);
            }
            $('.login').remove();
            $('nav').prepend(parse.login);

         /*   var pathName = window.location.pathname.split( '/' );

            if(pathName[2] == "Blog") {
                $('.blogEdit').show();
            }*/
        };

         loginError = function() {
            alert('Hiba a login ban');
        };


