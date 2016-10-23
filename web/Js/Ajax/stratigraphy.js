
    $(document).ready(function() {
        $('body').on('click', '.ajaxBut', function() {

            var instance = $(this).attr('instance'),
                href = $(this).attr('href'),
                right = false;

            ajaxLoad(right, instance, href);
        })
    });

    function blog(data, status, instance) {
        this.data = data;
        this.status = status;
        this.instance = instance;

        this.setData = function(data, status, instance) {
            this.data = data;
            this.status = status;
            this.instance = instance;
        };

        this.Run = function() {
            if(this.status == true) {
                addData(this.data, this.instance);

            } else if(this.status == false) {
                error();
            }
        };
    }

    function getData(href) {
        this.href = href;

        this.setData = function(href) {
            this.href = href;
        };

        this.getData = function() {
            return {
                'StratiName': $('.StratiName').val(),
                'StratiStart':  $('StratiStart').val(),
                'StratiEnd':  $('StratiEnd').val(),
                'stratiColor': $('stratiColor').val(),

            }
        }
    }

    function addData(data, instance) {
       alert('ok');
    }

    function getQueryVariable(href, getParam)
    {
        var query = href.substring(1);
        // var query = window.location.search.substring(1);
        var vars = query.split("&");
        for(var i=0; i<vars.length; i++) {
            var pair = vars[i].split("=");
            if(pair[0] == getParam) {
                return pair[1];
            }
        }
        return false;
    }

    function error() {

    }