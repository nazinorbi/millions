/**
 * Created by nazinorbi on 2017. 02. 05..
 */


getKuszob = function(href) {
    return {
        'kuszob':  $('.kuszob').val()
    }
};

kuszobAdd = function(data, status, instance) {
   alert('A küszönb módósítva lett');
};

kuszobError = function() {
    alert('Hiba van a küszöbben');
};