
     getBlog = function(href) {
         return {
            'url':  $.url(href).param('url').toLowerCase(),
            'page':  $.url(href).param('page'),
            'ipp':   $.url(href).param('ipp')
        }
    };

     blogAdd = function(data, status, instance) {
         $('.centerSide').children().remove();
         $('.centerSide').prepend(data);
    };

     blogError = function() {
        alert('szarvan a blogon');
    };