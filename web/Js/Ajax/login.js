
        getLogin = function(href) {
            return {
                'loginName': $(".loginName").val(),
                'loginPass': $('.loginPassword').val()
            }
        };

         loginAdd = function(data, status, instance, select) {

            if(data.menu !== '') {
                $(".menuDiv").children().replaceWith(data.menu);
            }

            $('.login').replaceWith(data.login);
            $('.login').toggleClass('login', 'logout');
        };

         loginError = function() {
            alert('Hiba a login ban');
        };


