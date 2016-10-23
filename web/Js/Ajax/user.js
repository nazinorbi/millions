
    $(document).ready(function() {
        $("body").on('click', '.paginBut', function() {
            var instance = $(this).attr('instance'),
                href = $(this).attr('href'),
                right = false;

            ajaxLoad(right, instance, href);
        });
    });


    function datas(href)
    {
        return {
            'page': getQueryVariable(href, 'page'),
            'ipp':  getQueryVariable(href, 'ipp'),
            'url':  getQueryVariable(href, 'url')
        }
    }

    function getQueryVariable(href, getParam)
    {
        var query = href.substring(1);
       // var query = window.location.search.substring(1);
        var vars = query.split("&");
        for(var i=0; i<vars.length; i++) {
            var pair = vars[i].split("=");
            if(pair[0] == getParam) {
                return pair[1];
            }
        }
        return false;
    }


    function user(data, status, instance) {
        this.data = data;
        this.status = status;
        this.instance = instance;

        this.setData = function(data, status, instance) {
            this.data = data;
            this.status = status;
            this.instance = instance;
        };

        this.Run = function() {
            if(this.status == true) {
                userAdd(this.data, this.instance);

            } else if(this.status == false) {
                blogError();
            }
        }
    }

    function userAdd(data, instance) {
        var data = data;
        if(data.model !== '') {
            $('.kozep').children().remove();
            $('.kozep').append(data.model);
        }
    }


   /* function add(JsonData, instanceUrl, transparency) {
        if (transparency == false) {


        // $.fn.render = Transparency.jQueryPlugin;

        var data = {users: [JsonData.model]};
        var tamlate = $('.usersDiv div')
            .first()
            .clone();
        tamlate.each(function () {
            $(this).children().empty();
        });

        $('.usersDiv').empty()
                      .append(tamlate)
                      .render({users: [JsonData.model]});
        } else {
            $('.kozep').empty()
                .append(JsonData.model);
        }


        function print_r(obj, t) {

            // define tab spacing
            var tab = t || '';

            // check if it's array
            var isArr = Object.prototype.toString.call(obj) === '[object Array]';

            // use {} for object, [] for array
            var str = isArr ? ('Array\n' + tab + '[\n') : ('Object\n' + tab + '{\n');

            // walk through it's properties
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    var val1 = obj[prop];
                    var val2 = '';
                    var type = Object.prototype.toString.call(val1);
                    switch (type) {

                        // recursive if object/array
                        case '[object Array]':
                        case '[object Object]':
                            val2 = print_r(val1, (tab + '\t'));
                            break;

                        case '[object String]':
                            val2 = '\'' + val1 + '\'';
                            break;

                        default:
                            val2 = val1;
                    }
                    str += tab + '\t' + prop + ' => ' + val2 + ',\n';
                }
            }

            // remove extra comma for last property
            str = str.substring(0, str.length - 2) + '\n' + tab;

            return isArr ? (str + ']') : (str + '}');
        };

    }*/
