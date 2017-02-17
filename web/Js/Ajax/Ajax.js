
    function loadJS(instance, src) {
        var jsLink;

        var head = $(".function").find("#"+instance);
        if (head.length <= 0 ) {
            if (src) {
                 jsLink = $("<script type='text/javascript' id=" + instance + " src='" + src + "'>");
            } else {

                src = ('/Millions/web/Js/Ajax/' + instance + '.js');
                jsLink = $("<script type='text/javascript' id=" + instance + " src='" + src + "'>");
            }
            $(".function").prepend(jsLink);
        }
    }

    function loadCss(instance, src) {
        var cssLink;

        var head = $(".css").find("#"+instance);
        if (head.length <= 0 ) {
            if (src) {
                cssLink = $("<link rel='stylesheet' type='text/css' id=" + instance + " href='" + src + "'>");
            } else {

                src = ('/Millions/web/Css/' + instance + '.css');
                cssLink = $("<link rel='stylesheet' type='text/css' id=" + instance + " href='" + src + "'>");
            }
            $(".css").prepend(cssLink);
        }
    }

    function dependency(instance) {
        loadJS('ucFirst', '/Millions/web/Js/Functions/ucFirst.js');

        var Services = new ServicesCreatur(instance);
        extend( ExtendName = function() {}, BaseClass);

        if(this.serviceContainer && instance != 'lang') {
            this.serviceContainer.setObj(ExtendName);
            this.serviceContainer.addDefinitions(Services.getServices());
            return this.serviceContainer;
        } else {
            this.serviceContainer = new container();
            this.serviceContainer.setObj(ExtendName);
            this.serviceContainer.addDefinitions(Services.getServices());
            return this.serviceContainer;
        }
    }


    function ajaxLoad(rightF, instanceF, hrefF, select) {

        var right = setDefaultValue(rightF),
            instance = instanceF,
            href = hrefF,
            dataType = this.dataType(instance),
            depend = dependency(instance, select);

        $.ajax({
            type: 'POST',
            url: '/Millions/ajax',
            dataType: dataType,
            data : {
                ajax: true,
                right: right,
                instance: instance,
                data: depend.get(instance).getData(href, select)
            },
            success: function(data) {
                var status = true;
               // alert(status);
                depend.get(instance).success(data, status, instance);
            },
            error: function(jqXHR) {
                var status = false;
               // alert(status + ' error de 200ok');
                depend.get(instance).error(jqXHR, status, instance);
            }
        });
    }

    function dataType(instance) {
        if(instance == 'login' || instance == 'logout') {
            return 'json';
        } else {
            return 'html';
        }
    }

    function setDefaultValue(value) {
        var values;

        if(value == 'true' || value == true) {
           values = value;
        } else {
           values = false;
        }

        if(values == false || values.length <= 0){
            return false;
        } else {
            return values;
        }
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

