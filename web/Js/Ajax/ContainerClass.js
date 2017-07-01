/**
 * Created by nazi on 2017. 06. 26..
 */

class serviceCreate {
    constructor(instance, ajax = true, obj = null) {
        this.instance = instance;
        this.services = {};

        if(ajax && obj === null) {
            this.Data =  {
                    success: eval(instance + 'Add'),
                    getData: eval('get'+ ucFirst(instance)),
                    error: eval(instance + 'Error'),
            }
        }
        else {
            this.Data = obj;
        }

        this.services[this.instance] = {
            shared: true,
            params: {
                Container: 'container',
                Data: this.Data
            }
        };

        this.getServices = function() {
            return this.services;
        }
    }
    static ucFirst(string) {
        return string.substr(0, 1).toUpperCase() + string.substr(1).toLowerCase();
    }
}

class BaseClass {
    constructor() {
        this.Child = function () {
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
        };
        return this.Child;
    }
}

class Container {

    constructor() {
         this.services = [];
         this.definitions = [];
         this.services['container'] = this;
         this.obj = null;
    }

    setObj(obj) {
        this.obj = obj;
    }

    store(name, object) {
        this.services[name] = object;
    }

    issetDefiniton(valueName, name) {

        return(typeof(this[valueName][name]) !== 'undefined');
    }

    get(name) {
        if(typeof (this.services.name) !== 'undefined') {
            return this;
        }
        if(this.hasDefinition(name)) {
            return this.createInstanceFromDefinition(name)
        }
        alert('Service ' + name + ' nem létezik');
    }

    hasDefinition(definition) {
        return this.issetDefiniton('definitions', definition);
    }

    createInstanceFromDefinition(name) {

        let definition = this.definitions[name],
            instance = new this.obj();

        if(definition.params !== 'undefined') {

            this.callSetters(instance, definition.params);
        }

        if((definition.shared !== 'undefined') && definition.shared) {
            this.store(name, instance);
        }
        return instance;
    }

    callSetters(object, params) {
        $.each(params, function( name, value ) {
            let setterMethodeName = 'set' + (name);

            if(!$.isFunction(object[setterMethodeName])) {
                console.log('Az objektumnak nincsen ' +setterMethodeName +' nevű fügvénye')
            }

            if(typeof(value) === 'string' && value.match('/^@\w+$/')) {
                value = get(value.substr(1));
            }
            object[setterMethodeName](value);
        })
    }

    addDefinitions(definitions) {
        this.definitions = $.extend(true, [], this.definitions, definitions);
    }

    getDefinitions() {
        return this.definitions;
    }
}
