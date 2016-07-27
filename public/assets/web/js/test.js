var main = (function () {
    doConstruct = function () {
        this.init_callbacks = [];
    };
    doConstruct.prototype = {
        add_init_callback : function (func) {
            if (typeof(func) == 'function') {
                this.init_callbacks.push(func);
                return true;
            }
            else {
                return false;
            }
        }
    };
    return new doConstruct;
})();
$(document).ready(function () {
    $.each(main.init_callbacks, function (index, func) {
        func();
    });
});

//change table information 
var promise_sell = (function () {
    var doConstruct = function () {
        main.add_init_callback(this.change_table);

    };
    doConstruct.prototype = {
        change_table: function (){


        }
    };
    return new doConstruct;
})();

function show_data(id) {

    $.ajax({
        url: './test/show',
        type: "post",
        data: {'user_id':id},
        success: function(data){
            

            switch (data.success){       //needed array cell
                case true:            //if return true
                    var label = '';
                    $.each(data.label, function (index, value) { //push label data to string and then add to description data
                        label += '<tr>'+'<th>'+value+'</th>'+'<td>'+''+'</td>'+'<tr>';
                    });
                    //display table row detailes
                    var description =
                        '<td>'+
                        '<table>'+
                        '<tr>'+
                        '<th>'+'icon'+'</th>'+
                        '<td>'+''+'</td>'+
                        '</tr>'+
                        '<tr>' +
                        '<th>'+'date'+'</th>'+
                        '<td>'+data.message.date+'</td>'+
                        '</tr>'+

                        '<tr>' +
                        '<th>'+'name'+'</th>'+
                        '<td>'+data.message.name+'</td>'+
                        '</tr>'+
                        '<tr>' +
                        '<th>'+'phone'+'</th>'+
                        '<td>'+data.message.phone+'</td>'+
                        '</tr>'+
                        '<tr>' +
                        '<th>'+'email'+'</th>'+
                        '<td>'+data.message.email+'</td>'+
                        '</tr>'+
                        label+ //add label data
                        '</table>';
                       // +'</td>';
                    $('#u-r-'+data.message.id).html(description); //add user description to html
                   
                    break;
                case false:        //if return false
                    console.log(data.message);

                    break;
            }
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
            // Render the errors with js ...
        }
    });
}







