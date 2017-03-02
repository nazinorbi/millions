/**
 * Created by nazinorbi on 2017. 02. 04..
 */

    getKassza = function(href, select) {

        return {
            'checkName':  $('.checkName').val(),
            'checkPassworld': $('.checkPassworld').val(),
            'checkPass': true,
            'katId': $('.kat').val(),
            'osszeg': $('.osszeg').val(),
            'type': $('.type').val(),
            'comment': $('.comment').val()
        }
    };

    kasszaAdd = function(data, status, instance) {

        var passworldStatus = data.data.getPassworldStatus,
            error = data.data.error;

        if (data.data.passworldStatus == true  && data.data.error == true ) {
            $('.jelszo').css('display', 'block');
        }
        else if (data.data.passworldStatus == true && data.data.error != '') {
            $.each(error, function (index, value) {
                alert(value);
            });
        }
        else if (data.data.passworldStatus == false && data.data.error == null) {
            $('.query').children().remove();
            $('.query').prepend(data.data.html_);
        }
    };

    kasszaError = function(jqXHR) {
        alert('Hiba van a kasszaában');
    };