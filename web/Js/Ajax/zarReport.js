/**
 * Created by nazinorbi on 2017. 02. 06..
 */

    getZarreport = function(href, select) {
        var value = select.attr('value'),
            ev = $('.ev').val(),
            honap = $('.honap').val(),
            mhnap = getMonthDay(ev, honap),
            nap = $('.nap').val(),
            whereStart,whereEnd;

        switch(value) {
            case 'ev':
                whereStart = ev+'-01'+'-01 00:00:00';
                whereEnd = ev+'-12'+'-31 23:59:59';
            break;
            case 'honap':
                whereStart = ev+'-'+honap+'-01 00:00:00';
                whereEnd = ev+'-'+honap+'-'+mhnap+' 23:59:59';
            break;
            case 'datum':
                whereStart = ev+'-'+honap+'-'+nap+' 00:00:00';
                whereEnd = ev+'-'+honap+'-'+mhnap+' 23:59:59';
            break;
        }

        return {
            'whereStart': whereStart,
            'whereEnd': whereEnd
        }
    };

    zarReportAdd = function(data, instanceUrl) {
        $('.zarResult').children().remove();
        $('.zarResult').prepend(data);
    };

    zarReportError = function() {
        alert('Hiba van a Reportban');
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