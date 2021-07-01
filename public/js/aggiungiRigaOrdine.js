$(document).ready(
    function() {
        $("#aggiungiCapo").click(function () {
            $("#ordiniRow").append("<tr>" +
                "<td>" + $("#nuovo_ordine_nuovo_capo").val() + "</td>" +
                "<td onclick='eliminaRiga($(this))'>Elimina</td></tr>");
        });
    });

    function eliminaRiga (e) {
        e.parent().remove();
    }