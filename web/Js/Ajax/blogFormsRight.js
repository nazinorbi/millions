
    function blogFormsRight(data, status, instance) {
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
                blogFormsRightAdd(this.data, this.instance);

            } else if(this.status == false) {
                blogFormsRightError();
            }
        }
    }

    function blogFormsRightError() {

    }

    function  blogFormsRightAdd(data) {
        addNewTerm('.radio-category', 'radio', 'termsCategory', 'termsLabel');
        addNewTerm('.checkbox-category', 'checkbox', 'checkbox-termsCategory', 'checkbox-termsLabel');

        function addNewTerm(select, type, className, labelName) {
            var select = select,
                type = type,
                className = className,
                labelName = labelName,
                parentCategoryVal = $('.parent-category'),
                name = $('.newCategory'),
                text = [],
                plus = 0,
                lastParent;

            $(select).find('label').each(function() {
                ++plus;
                text[plus] = $(this).text();
            });

            if((name.val()).length <= 0) {
                name.val('Üres a mező').css("color", "#8B0000").attr('error', 'empty');
                return false;
            }
            if(($.inArray(name.val() ,text))>= 0) {
                name.val('Hiba már szerepel ez a név').css("color", "#8B0000").attr('error', 'second');
                return false;
            } else {
                if(parentCategoryVal.val().length <= 0) {
                    lastParent = $(select).find('li').last();
                    lastParent.after(createAppendTerm(type, className, labelName, name.val(), data));
                } else {
                    var parentsLi = $(select).find('label[name='+parentCategoryVal.attr('text')+']').parents().eq(0);
                    // var parentsLi = $(select).find('input:checked').parents().eq(0);

                    if(parentsLi.find('ul').length <= 0) {
                        lastParent = parentsLi.children().last();
                        lastParent.after('<ul>' + createAppendTerm(type, className, labelName, name.val(), data) + '</ul>');
                        parentsLi.switchClass('leaf', 'expanded');
                        addAnchor(parentsLi);
                    } else {
                        lastParent = parentsLi.find('ul').eq(0).children().last();
                        lastParent.after(createAppendTerm(type, className, labelName, name.val(), data));
                        parentsLi.switchClass('collapsed', 'expanded');
                        parentsLi.find('ul').eq(0).css('display', 'block');
                        addAnchor(parentsLi);
                    }
                }
            }
        }

        function createAppendTerm(type, className, labelName, name, data) {

            var term_id = data.term_data.term_id,
                parent_id = data.term_data.parent_id,
                slug = data.term_data.slug;

            return '<li class="leaf">' +
                '<span class="daredevel-tree-anchor"></span>' +
                '<input type='+type+' class='+className+' name='+className+' children = "true" value='+term_id+' parent_id='+parent_id+' slug='+slug+' >' +
                '<label name='+name+' class='+labelName+'>' + $('.newCategory').val() + '</label>' +
                '</li>';
        }

        function addAnchor(parentsLi) {
            parentsLi.children().first().switchClass('ui-icon-triangle-1-e','ui-icon ui-icon-triangle-1-se')
                .addClass('daredevel-tree-anchor')
                .css({'background-position': '-48px -16px',
                    'background-image': 'url("http://localhost/WebMillions/css/jqueryUiThemes_1.11.2/ui-lightness/images/ui-icons_222222_256x240.png")',
                    'cursor': 'default',
                    'position': 'absolute',
                    'top': '1px',
                    'left': '-16px',
                    'color': '#000',
                    'width': '16px',
                    'height': '16px'});
        }
    }


    function datas(href) {
        return {
            'parentid': $('.parent-category').attr('parentid'),
            'newCategory': $('.newCategory').val()
        }
    }

    function add(data, instanceUrl) {

        if(data.menu !== "") {
            $(".menuDiv").replaceWith(data.menu);
        }

        $('.login').remove();
        $('nav').append(data.model);
    }

