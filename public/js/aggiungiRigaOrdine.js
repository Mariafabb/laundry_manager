// var i = 0;
// $(document).ready(
//     function() {
//         $("#aggiungiCapo").click(function () {
//             $("#nuovo_ordine_ordiniRows").append(
//                 "<div>" +
//                 "<input id='nuovo_ordine_ordiniRows_"+i+"' name=\"nuovo_ordine[ordiniRows]["+i+"]\" value=\'"+ $("#nuovo_ordine_nuovo_capo").val() +"\'>" +
//                 "<p onclick='eliminaRiga($(this))'>Elimina</p>") +
//                 "</div>";
//             ++i;
//         });
//     });


var i = 0;
$(document).ready(
    function() {
        var tabellaCapi = $("#nuovo_ordine_ordiniRows");
        //header tabella capi in ordine
        tabellaCapi.append("<div class=\"row\">" +
            "<div class=\"col\">id Capo</div>" +
            "<div class=\"col\">Descrizione</div>" +
            "<div class=\"col\">N Capi</div>" +
            "<div class=\"col\">Elimina</div></div>"
        );

        //ricerca clienti
        descrizioneCliente = $("#nuovo_ordine_cliente");
        idCliente = $("#nuovo_ordine_cliente_id");
        descrizioneCliente.change(
            autoCompletition(descrizioneCliente, idCliente, 'searchClienti', descrizioneCliente.val())
        );

        //ricerca capi per aggiunta a tabella
        totale = $("#nuovo_ordine_totale");
        descrizioneCapo = $("#nuovo_ordine_nuovo_capo");
        idCapo = $("#nuovo_ordine_nuovo_capo_id");
        numeroCapi = $("#nuovo_ordine_numero_capi");
        descrizioneCapo.change(
            autoCompletition(descrizioneCapo, idCapo, 'searchCapi', descrizioneCapo.val())
        );

        //aggiunta capo a tabella dopo ricerca
        $("#aggiungiCapo").click(function () {
            if (numeroCapi.val() == "") {
                alert("Inserire il numero di capi");
            } else if (descrizioneCapo.val() == "") {
                alert("Inserire nome capo");
            } else {
                tabellaCapi.append("<div class='row'>" +
                    "<div class='col'><input readonly='readonly'  id='form_ordini_row_" + i + "_idCapo' name='form_ordini_row[" + i + "][idCapo]' value='" + idCapo.val() + "' style=' background-color: #00cc00'></div>" +
                    "<div class='col'><input readonly='readonly' id='form_ordini_row_" + i + "_descrizioneCapo' name='form_ordini_row[" + i + "][descrizioneCapo]' value='" + descrizioneCapo.val() + "'></div>" +
                    "<div class='col'><input id='form_ordini_row_" + i + "_numeroCapi' name='form_ordini_row[" + i + "][numeroCapi]' value='" + numeroCapi.val() + "'></div>" +
                    "<button class='btn btn-primary' onclick='eliminaRiga($(this))'>Elimina</button>" +
                    "</div>");
                ++i;
                }
            });



    });

function eliminaRiga (e) {
    e.parent().remove();
}