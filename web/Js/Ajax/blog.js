
    $(document).ready(function() {
        var body = 'body';
        $(body).on('click', '.paginBut', function() {
            var instance = $(this).attr('instance'),
                href = $(this).attr('href'),
                right = false;

            ajaxLoad(right, instance, href);
        });
        $(body).on('click', '.paginateToGo', function() {
            var ipp = $('.ipp').val(),
                page = $('.inputPage').val(),
                href = 'index.php&url=Blog&ipp='+ipp+'&page='+page;

            ajaxLoad(false, 'blog', href);
        })
    });

    var getBlog = function(href) {
            return {
                'page': getQueryVariable(href, 'page'),
                'ipp':  getQueryVariable(href, 'ipp'),
                'url':  getQueryVariable(href, 'url')
            }
    };

    var blogAdd = function(data, instance) {
        var data = data;
        if(data.model !== '') {
            $('.kozep').children().remove();
            $('.kozep').append(data.model);
        }
    };

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

    function blogError() {

    }