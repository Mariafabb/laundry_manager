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

var importiCapi = [];
var i = 0;
$(document).ready(
    function() {
        var tabellaCapi = $("#nuovo_ordine_ordiniRows");
        //header tabella capi in ordine
        tabellaCapi.append("<thead>" +
            "<th>id Capo</th>" +
            "<th>Descrizione</th>" +
            "<th class=\"col\">Importo</th>" +
            "<th class=\"col\">N Capi</th>" +
            "</thead>"
        );

        //ricerca clienti
        descrizioneCliente = $("#nuovo_ordine_cliente");
        idCliente = $("#nuovo_ordine_cliente_id");
        descrizioneCliente.change(
            autoCompletition(descrizioneCliente, idCliente, 'searchClienti', descrizioneCliente.val())
        );

        //ricerca capi per aggiunta a tabella
        totale = $("#nuovo_ordine_totale");
        totaleNumerico = 0;
        descrizioneCapo = $("#nuovo_ordine_nuovo_capo");
        idCapo = $("#nuovo_ordine_nuovo_capo_id");
        numeroCapi = $("#nuovo_ordine_numero_capi");
        descrizioneCapo.change(
            autoCompletition(descrizioneCapo, idCapo, 'searchCapi', descrizioneCapo.val())
        );



        //aggiunta capo a tabella dopo ricerca
        $("#aggiungiCapo").click(function () {
            $tabellaCapiChildren = tabellaCapi.children('tr');
            $tabellaCapiChildren.each(function (){
                i = $(this).attr('numeroRiga');
            })
            i++;
            if (numeroCapi.val() == "") {
                alert("Inserire il numero di capi");
            } else if (descrizioneCapo.val() == "") {
                alert("Inserire nome capo");
            } else {
                tabellaCapi.append(
                    "<tr numeroRiga='"+i+"'>" +

                    "<td>" +
                    "<input readonly='readonly'  id='form_ordini_row_" + i + "_idCapo' name='form_ordini_row[" + i + "]" +
                    "[idCapo]' value='" + idCapo.val() + "' style='text-align: center'></td>" +

                    "<td>" +
                    "<input readonly='readonly' id='form_ordini_row_" + i + "_descrizioneCapo' name='form_ordini_row[" + i + "]" +
                    "[descrizioneCapo]' value='" + descrizioneCapo.val() + "' style='text-align: center'></td>" +

                    "<td>" +
                    "<input readonly='readonly' id='form_ordini_row_" + i + "_prezzoCapo' name='form_ordini_row[" + i + "]" +
                    "[prezzoCapo]' value='" + importoCapo + "' style='text-align: center'></div>" +

                    "<td>" +
                    "<input id='form_ordini_row_" + i + "_numeroCapi' name='form_ordini_row[" + i + "]" +
                    "[numeroCapi]' value='" + numeroCapi.val() + "' style='text-align: center'></div>" +
                    "</div>"+

                    "<td class='justify-content-center' onclick='eliminaRiga($(this))'> " +
                    "<button> Elimina </button> </td>" +
                    "</tr>");


                importiCapi[i] = importoCapo * numeroCapi.val();
                totale.val(totaleNumerico += importiCapi[i]);
                ++i;
                }
            });
    });

function eliminaRiga (e) {
    var numeroRiga = e.parent().attr('numeroRiga');
    var importo = importiCapi[numeroRiga];
    totale.val(totaleNumerico -= importo);
    e.parent().remove();
}