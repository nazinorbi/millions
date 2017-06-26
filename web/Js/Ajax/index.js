/**
 * Created by nazi on 2017. 06. 18..
 */

    getIndex = function(data) {
        return  data

    };

    indexAdd = function(data, status, instance, select) {


        data_ = JSON.parse(data);
        if(data_.sqlResponse === true) {

            $('body #index').replaceWith(select.text.indexText);
            select.ckeditor.destroy();
        }

    };

   indexError = function() {
        alert('Hiba a login ban');
    };