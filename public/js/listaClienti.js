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
                    "<td>" + value.modifica + "</td>" +
                    "<td>" + value.email + "</td>" +
                    "</tr>"
                );
            })
        });
    });
});