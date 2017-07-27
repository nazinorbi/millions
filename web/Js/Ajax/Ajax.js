
    function loadJS(instance, src) {
        let jsLink,
            functionSelect = $(".function");

        let head = functionSelect.find("#"+instance);
        if (head.length <= 0 ) {
            if (src) {
                 jsLink = $("<script type='text/javascript' id=" + instance + " src='" + src + "'>");
            } else {

                src = ('/Millions/web/Js/Ajax/' + instance + '.js');
                jsLink = $("<script type='text/javascript' id=" + instance + " src='" + src + "'>");
            }
            functionSelect.prepend(jsLink);
        }
    }

    function loadCss(instance, src) {
        let cssLink,
            cssSelect =  $(".css");

        let head = cssSelect.find("#"+instance);
        if (head.length <= 0 ) {
            if (src) {
                cssLink = $("<link rel='stylesheet' type='text/css' id=" + instance + " href='" + src + "'>");
            } else {

                src = ('/Millions/web/Css/' + instance + '.css');
                cssLink = $("<link rel='stylesheet' type='text/css' id=" + instance + " href='" + src + "'>");
            }
            cssSelect.prepend(cssLink);
        }
    }

    function dependency(instance) {
        loadJS('ucFirst', '/Millions/web/Js/Functions/ucFirst.js');

        let Services = new serviceCreate(instance, true, null);

        if(this.serviceContainer && instance !== 'lang') {
            this.serviceContainer.setObj(new BaseClass());
            this.serviceContainer.addDefinitions(Services.getServices());
            return this.serviceContainer;
        } else {
            this.serviceContainer = new Container();
            this.serviceContainer.setObj(new BaseClass());
            this.serviceContainer.addDefinitions(Services.getServices());
            return this.serviceContainer;
        }
    }

    function ajaxLoad(rightF, instanceF, href, select, data) {

        let right = setDefaultValue(rightF),
            processData = true,
            contentType = true,
            instance = instanceF,
            depend = dependency(instance, select),
            ajaxData = setAjaxData(instance, setDataIn(depend, data, href, select));

        $.ajax({
            xhr: function () {
                let xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (e) {
                    console.log(Math.floor(e.loaded / e.total * 100) + '%');
                };
                return xhr;
            },
            type: 'POST',
            url: '/Millions/ajax',
            enctype: 'multipart/form-data',
            dataType: 'json',
            processData: processData,
            contentType: contentType,
            data: ajaxData,

            success: function(data) {
                let status = true;
                //alert(status);
                depend.get(instance).success(data, status, instance, select);
            },
            error: function(jqXHR) {
                let status = false;
               // alert(status + ' error de 200ok');
                depend.get(instance).error(jqXHR, status, instance);
            }
        });

        function setDataIn(depend, data, href, select) {
            if(data.length > 0) {
                return data;
            }
            else {
                return depend.get(instance).getData(data, href, select);
            }
        }

        function setAjaxData(instance, dataIn) {
            if(instance === 'reg') {
                processData = false;
                contentType = false;
                return dataIn;
            }
            else {
                return {
                    ajax: true,
                    right: right,
                    instance: instance,
                    data: dataIn
                }
            }
        }

       /* function realtypeof (obj) {
            switch (typeof(obj)) {
                // object prototypes
                case 'object':
                    if (obj instanceof Array)
                        return '[object Array]';
                    else if (obj instanceof Date)
                        return '[object Date]';
                    else if (obj instanceof RegExp)
                        return '[object regexp]';
                    else if (obj instanceof String)
                        return '[object String]';
                    else if (obj instanceof Number)
                        return '[object Number]';

                    else
                        return 'object';
                // object literals
                default:
                    return typeof(obj);
            }
        }*/
    }


    function setDefaultValue(value) {
        let values;

        if(value === 'true' || value === true) {
           values = value;
        } else {
           values = false;
        }

        if(values === false || values.length <= 0){
            return false;
        } else {
            return values;
        }
    }

    function print_r(obj, t) {

        // define tab spacing
        let tab = t || '';

        // check if it's array
        let isArr = Object.prototype.toString.call(obj) === '[object Array]';

        // use {} for object, [] for array
        let str = isArr ? ('Array\n' + tab + '[\n') : ('Object\n' + tab + '{\n');

        // walk through it's properties
        for (let prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                let val1 = obj[prop];
                let val2 = '';
                let type = Object.prototype.toString.call(val1);
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
    }

