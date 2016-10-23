/**
 * Created by nazinorbi on 2016. 10. 07..
 */

getStrati = function(select) {
    return {
        'StratiMap': select.attr('name')
    }
};

stratiAdd = function(data) {
    var i = 0;
    var newPath = [];

    $.each(data, function(index, value) {
        i++;
        newPath[i] = value;
    });

    $.each($(".single"), function(index) {
        $(this).attr('href', newPath[index]);
    });
};


stratiError = function() {
    alert('szarvan');
};