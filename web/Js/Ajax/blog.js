
     getBlog = function(href) {
        if(href == '') {
            return false;
        }
        else {
            return {
                'url':  $.url(href).param('url'),
                'page':  $.url(href).param('page'),
                'ipp':   $.url(href).param('ipp')
            }
        }

    };

     blogAdd = function(data, status, instance) {
         $('.centerSide').children().remove();
         $('.centerSide').prepend(data);
    };

     blogError = function() {
        alert('Hiba van a blogon');
    };