
     getBlog = function(href) {
         return {
            'url':  $.url(href).param('url'),
            'page':  $.url(href).param('page'),
            'ipp':   $.url(href).param('ipp')
        }
    };

     blogAdd = function(data, instance) {

        if(data !== '') {
            $('.centerSide').children().remove();
            $('.centerSide').append(data);
        }
    };

    function blogError() {

    }