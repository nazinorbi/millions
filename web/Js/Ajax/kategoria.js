/**
 * Created by nazinorbi on 2017. 02. 05..
 */


    getKategoria = function(href, select) {
        var value = select.attr('value');

        if(value == 'katAdd') {
            return {
                'kategoria' : $('.katAddValue').val(),
                'action' : 'insert'
            }
        } else if(value == 'katDel') {
            return {
                'katId' : select.attr('id'),
                'action' : 'delete'
            }
        }
    };

    kategoriaAdd = function(data, status, instance, select) {
        var parse = JSON.parse(data);
        console.log(select);
        //console.log(data.0);
        if(parse.data.delete == 'true' ) {
            select.parent().parent().remove();
        } else if(parse.data.id > 0) {
            var newkateg ='<tr>'+
                '<th><input type="checkbox" value='+parse.data.id+' ></th><th>'+parse.data.kateg+'</th><th><a class="ajaxBut" value="katDel" id='+parse.data.id+' instance="kategoria" name="katDel">Törlés</a></th>'+
                '</tr>';

            $('.kategoria tr').last().after(newkateg);
        }


    };

    kategoriaError = function() {
        alert('Hiba van a kategóriában');
    };


