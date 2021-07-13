$(document).ready(function (){


    $("#search-box").change(function (){

        $("#listaOrdini").children().remove();

        $.ajax({
                url: Routing.generate('aux_utility'),
                dataType: "json",
                data: {
                    "action": "searchListaOrdini",
                    "filter": $("#search-box").val()
                },
                error: function (jqxhr, status, exception) {
                    alert('Exception:', exception);
                }
            }
        ).done(function (data){
            jQuery.each(data, function (index, value){
                $("#listaOrdini").append(
                    "<tr> " +
                    "<td>" + value.c_nome + "</td>" +
                    "<td>" + value.c_cognome + "</td>" +
                    "<td>" + value.data_ordine + "</td>" +
                    "<td>" + value.data_consegna + "</td>" +
                    "<td>" + value.note + "</td>" +
                    "<td>" + value.u + "</td>" +
                    "<td>" + value.totale + "</td>" +
                    "</tr>"
                );
            })
        });
    });
});