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

        //ricerca clienti

        //ricerca capi per aggiunta a tabella
        descrizioneCapo = $("#nuovo_ordine_nuovo_capo");
        idCapo = $("#nuovo_ordine_nuovo_capo_id");
        $("#nuovo_ordine_nuovo_capo").change(
            autoCompletition(descrizioneCapo, idCapo, 'searchCapi', $("#nuovo_ordine_nuovo_capo").val())
        );

        //aggiunta capo a tabella dopo ricerca
        $("#aggiungiCapo").click(function () {
            $("#nuovo_ordine_ordiniRows").append("<div class='row'>" +
                "<div class='col'><input value='"+ $("#nuovo_ordine_nuovo_capo").val() +"'></div>" +
                "<div class='col'><input id='form_ordini_row_"+i+"' name='form_ordini_row["+i+"]' value='"+ $("#nuovo_ordine_nuovo_capo_id").val() +"'></div>" +
                "<div class='col' onclick='eliminaRiga($(this))'>Elimina</div>" +
                "</div>");
            ++i;
        });



    });

function eliminaRiga (e) {
    e.parent().remove();
}