
    function getTranslated(transformed) {
        var transKey = [];
        $.each(transformed, function (index) {
            transKey[index] = $(this).attr('translate');
        });
        return transKey;
    }

    langAdd = function(data, instanceUrl) {
        $.each($("[translate]"), function (index, value) {
            $(this).html(data[index]);
        });
    };

    getLang = function (select) {
        return {
            'lang': $(select).attr('lang'),
            'trans': getTranslated($("[translate]"))
        }
    };
    langError = function() {
        alert('Hiba van a lang ban');
    };
