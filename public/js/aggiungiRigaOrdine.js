var i = 0;
$(document).ready(
    function() {
        $("#aggiungiCapo").click(function () {
            $("#nuovo_ordine_ordiniRows").append(
                "<div>" +
                "<input id='nuovo_ordine_ordiniRows_"+i+"' name=\"nuovo_ordine[ordiniRows]["+i+"]\" value=\'"+ $("#nuovo_ordine_nuovo_capo").val() +"\'>" +
                "<p onclick='eliminaRiga($(this))'>Elimina</p>") +
                "</div>";
            ++i;
        });
    });

    function eliminaRiga (e) {
        e.parent().remove();
    }

// var i = 0;
// $(document).ready(
//     function() {
//         $("#aggiungiCapo").click(function () {
//             $("#ordiniRow").append("<tr>" +
//                 "<td><input name='form_ordini_row_'+i value='"+ $("#nuovo_ordine_nuovo_capo").val() +"'></td>" +
//                 "<td onclick='eliminaRiga($(this))'>Elimina</td></tr>");
//             ++i;
//         });
//     });