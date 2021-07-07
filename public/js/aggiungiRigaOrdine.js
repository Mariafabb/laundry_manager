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
$(document).ready(function (){
    fieldInput = $("#nuovo_ordine_nuovo_capo");
    fieldOutput = $("#nuovo_ordine_nuovo_capo_id");
    $("#nuovo_ordine_nuovo_capo").change(
        autoCompletition(fieldInput, fieldOutput, 'searchCapi', $("#nuovo_ordine_nuovo_capo").val())
    );
});
$(document).ready(
    function() {
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