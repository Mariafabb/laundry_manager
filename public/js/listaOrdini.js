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
                    "<td>" + value.id + "</td>" +
                    "<td>" + value.nome + "</td>" +
                    "<td>" + value.cognome + "</td>" +
                    "<td>" + new Date(JSON.stringify(value.data_ordine.date)).toLocaleDateString()  + "</td>" +
                    "<td>" + new Date(JSON.stringify(value.data_consegna.date)).toLocaleDateString()  + "</td>" +
                    "<td>" + value.utente + "</td>" +
                    "<td>" + value.totale + "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('modifica_ordine')+"/"+value.id+"\" >" +
                    "<i class='bi-pencil-square' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('elimina_ordine')+"/"+value.id+"\" > " +
                    "<i class='bi-trash' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "</tr>"
                );
            })
        });
    });
});