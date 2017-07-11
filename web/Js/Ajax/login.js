
        getLogin = function() {

            let url;

            if(location.href.split('/')[4] === '' || location.href.split('/')[4] === 'Index') {
                url = 'index';
            }

            return {
                'loginName': $(".loginName").val(),
                'loginPass': $('.loginPassword').val(),
                'url': url
            }
        };

         loginAdd = function(data, status, instance, select) {


            if(data.menu !== '') {
                $(".menuDiv").children().replaceWith(data.menu);
            }
            if(data.data.afterLogin !== false) {
                $('#'+data.data.afterLogin).after(data.data.html);
            }


            $('.login').replaceWith(data.login);
            $('.login').toggleClass('login', 'logout');
        };

         loginError = function() {
            alert('Hiba a login ban');
        };


