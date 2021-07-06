// const routes = require('../../public/js/fos_js_routes.json');
// import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
//
// Routing.setRoutingData(routes);
// Routing.generate('rep_log_list');
var numeroMastro;
function autoCompletition (fieldInput,  fieldOutput, action, search = null) {
    fieldInput.autocomplete(
        {
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    // url: '/auxiliary/utility',
                    url: Routing.generate('aux_utility'),
                    dataType: "json",
                    data: {
                        "action": action,
                        "filter": request.term
                    },
                    success: function (data) {
                        response(data);
                    },
                    error: function (jqxhr, status, exception) {
                        alert('Exception:', exception);
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                fieldInput.val(ui.item.label); // display the selected text
                fieldOutput.val(ui.item.value);
                numeroMastro = ui.item.value;

                if(action == "getFinanziamentiPratica")
                    $("#sottoconti_descrizione").val(ui.item.descrizione);
                else if(action == "searchUtenti" && ui.item.descrizione != "")
                    $("#registrazioni_descrizione").val(ui.item.descrizione);

                if(search != null){
                    window.location.href = window.location.href.split('?')[0]+"?search="+ui.item.value;
                }
                return false;
            }
        }
    );
};

function split(val) {
    return val.split(/,\s*/);
}

function extractLast(term) {
    return split(term).pop();
}