/**
 * Created by nazinorbi on 2017. 02. 07..
 */

    getBevkiadreport = function(href, select) {
        var  whereStart,whereEnd, kategoria,

            startDate = $('.start'),
            value = select.attr('value'),
            bevKiadType = $('.bevKiadType').val(),
            endDate = $('.end'),
            tolEv = startDate.find('.ev').val(),
            tolHonap = startDate.find('.honap').val(),
            tolNap = startDate.find('.datum').val(),
            igEv = endDate.find('.ev').val(),
            igHonap = endDate.find('.honap').val(),
            igNap = endDate.find('.datum').val(),

            mhnapTol = getMonthDay(tolEv, tolHonap),
            mhnapIg = getMonthDay(igEv, igHonap);

        kategoria = getKategValue();

        switch(value) {
            case 'ev':
                whereStart = tolEv+'-01'+'-31 00:00:00';
                whereEnd = igEv+'-12'+'-31 23:59:59';
                break;
            case 'honap':
                whereStart = tolEv +'-'+tolHonap+'-01 00:00:00';
                whereEnd = igEv+'-'+igHonap+'-'+mhnapIg+' 23:59:59';
                break;
            case 'datum':
                whereStart = tolEv+'-'+tolHonap+'-'+tolNap+' 00:00:00';
                whereEnd = igEv+'-'+igHonap+'-'+igNap+' 23:59:59';
                break;
        }

        return {
            'start': whereStart,
            'end': whereEnd,
            'kateg': kategoria,
            'bevKiadType': bevKiadType
        }
    };

    bevKiadReportAdd = function(data, status, instance) {
        $('.katBevPrint').children().remove();
        $('.katBevPrint').prepend(data);
    };

    bevKiadReportError = function() {
            alert('hiba van a bevKiadReport');
     };

    function getMonthDay(year, honap) {

        var monthDay = [
            '0', ['04', '06', '09', '11'],
            '1', ['01', '03', '05', '07', '08', '10', '12'],
            '2', [is_leap_year(year)]
        ];

        for(var i = 0; i <= 2; i++) {
            if(i == 0 && $.inArray(honap, monthDay[i])) {
                return 30;
            }
            else if(i == 1 && $.inArray(honap, monthDay[i])) {
                return 31;
            } else if ( i == 2) {
                return monthDay[i];
            }
        }
    }

    function is_leap_year($year) {

        if((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0))) {
            return '29';
        } else {
            return '28';
        }
    }

    function getKategValue() {

        var kategoria = $('.active input'),
            value = [];

        kategoria.each(function(index, element){
            if(element.value != 'multiselect-all') {
                value.push(Number(element.value));
            }
        });
        return value;
    }