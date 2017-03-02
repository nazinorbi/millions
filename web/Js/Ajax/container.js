
function extend(ChildClass, ParentClass) {
    ChildClass.prototype = new ParentClass();
    ChildClass.prototype.constructor = ChildClass;
}

function ServicesCreatur(instance) {
    this.instance = instance;
    this.services = {};

    this.services[this.instance] = {
        shared: true,
        params: {
            Container: 'container',
            Data: {
                success: eval(instance + 'Add'),
                error: eval(instance + 'Error'),
                getData: eval('get'+ ucFirst(instance))
            }
        }
    };

    this.getServices = function() {
        return this.services;
    };
}
function ucFirst(string) {
    return string.substr(0, 1).toUpperCase() + string.substr(1).toLowerCase();
}

var BaseClass = function() {
    this.name = null;
    // function-ok
    this.success  = null;
    this.error = null;
    this.getData = null;
    this.container = null;

    this.setContainer = function(container) {
        this.container = container;
    };

    this.setData = function(data) {
        this.success = data.success;
        this.error = data.error;
        this.getData = data.getData;
    };

    this.setName = function(name) {
        this.name = name;
    };
    this.getName = function() {
        return this.name;
    };

    /*this.Run = function() {
        if(this.status) {
            this.success(this.creatur.data, this.creatur.instance);
        } else {
            this.error();
        }
    }*/
};

function container() {
    this.definitions = [];
    this.services = [];
    this.services['container'] = this;
    this.obj = null;

    this.setObj = function(obj) {
        this.obj = obj;
    };

    this.store = function(name, object) {
        this.services[name] = object;
    };

    this.issetDefiniton = function(valueName, name) {

        return(typeof(this[valueName][name]) != 'undefined');
    };

    this.get = function(name) {

        if(typeof(this.services[name]) != 'undefined') {
            return this.services[name];
        }

        if(this.hasDefinition(name)) {
            return this.createInstanceFromDefinition(name)
        }
        alert('Service ' + name + ' nem létezik');
    };

    this.hasDefinition = function(definition) {
        return this.issetDefiniton('definitions', definition);
    };

    this.createInstanceFromDefinition = function(name) {

        var definition = this.definitions[name],
            instance = new this.obj();

        if(definition.params != 'undefined') {
            this.callSetters(instance, definition.params);
        }

        if((definition.shared != 'undefined') && definition.shared) {
            this.store(name, instance);
        }
        return instance;
    };

    this.callSetters = function(object, params) {
        $.each(params, function( name, value ) {
            var setterMethodeName = 'set' + (name);

            if(!$.isFunction(object[setterMethodeName])) {
                alert('Az objektumnak nincsen ' +setterMethodeName +' nevű fügvénye')
            }

            if(typeof(value) == 'string' && value.match('/^@\w+$/')) {
                value = get(value.substr(1));
            }
            object[setterMethodeName](value);
        });
    };

    this.addDefinitions = function(definitions) {
        this.definitions = $.extend(true, [], this.definitions, definitions);
    };

    this.getDefinitions = function() {
        return this.definitions;
    }
}