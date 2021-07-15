$(document).ready(function (){


    $("#search-box").change(function (){

        $("#listaCapi").children().remove();

        $.ajax({
                url: Routing.generate('aux_utility'),
                dataType: "json",
                data: {
                    "action": "searchListaCapi",
                    "filter": $("#search-box").val()
                },
                error: function (jqxhr, status, exception) {
                    alert('Exception:', exception);
                }
            }
        ).done(function (data){
            jQuery.each(data, function (index, value){
                $("#listaCapi").append(
                    "<tr> " +
                    "<td>" + value.tipo + "</td>" +
                    "<td>" + value.sottotipo + "</td>" +
                    "<td>" + value.descrizione + "</td>" +
                    "<td>" + value.prezzo + "</td>" +
                    "<td>" + value.giorni_lavorazione + "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('modifica_capo')+"/"+value.id+"\" >" +
                    "<i class='bi-pencil-square' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "<td>" + "<a href=\""+Routing.generate('elimina_capo')+"/"+value.id+"\" > " +
                    "<i class='bi-trash' style='padding: 8px ; background-color: white; border-style: solid; " +
                    "border-color: darkorange; color: darkorange; font-size: 25px'></i></a>" +
                    "</td>" +
                    "</tr>"
                );
            })
        });
    });
});