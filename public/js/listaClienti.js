$(document).ready(function (){


    $("#search-box").change(function (){

        $("#listaClienti").children().remove();

        $.ajax({
                url: Routing.generate('aux_utility'),
                dataType: "json",
                data: {
                    "action": "searchListaClienti",
                    "filter": $("#search-box").val()
                },
                error: function (jqxhr, status, exception) {
                    alert('Exception:', exception);
                }
            }
        ).done(function (data){
            jQuery.each(data, function (index, value){
                $("#listaClienti").append(
                    "<tr> " +
                    "<td>" + value.nome + "</td>" +
                    "<td>" + value.cognome + "</td>" +
                    "<td>" + value.indirizzo + "</td>" +
                    "<td>" + value.provincia + "</td>" +
                    "<td>" + value.telefono + "</td>" +
                    "<td>" + value.cellulare + "</td>" +
                    "<td>" + value.email + "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('modifica_cliente')+"/"+value.id+"\" >" +
                    "<i class='bi-pencil-square' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('elimina_cliente')+"/"+value.id+"\" > " +
                    "<i class='bi-trash' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "</tr>"
                );
            })
        });
    });
});