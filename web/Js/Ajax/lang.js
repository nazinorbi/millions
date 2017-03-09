
    function getTranslated(transformed) {
        var transKey = [];
        $.each(transformed, function (index) {
            transKey[index] = $(this).attr('translate');
        });
        return transKey;
    }

    langAdd = function(data, instanceUrl) {
        var parse = JSON.parse(data);
        console.log(parse);
        $.each($("[translate]"), function (index, value) {
            $(this).html(parse[index]);
        });
    };

    getLang = function (href, select) {
        return {
            'lang': $(select).attr('lang'),
            'trans': getTranslated($("[translate]"))
        }
    };
    langError = function() {
        alert('Hiba van a lang ban');
    };
