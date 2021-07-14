//variabili globali usate in aggiungicapoOrdineRow, solo per acrion = "searchCapi"
var importoCapo = 0;
var totaleCapi = 0;

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

                if(action == "searchCapi") {
                    importoCapo = ui.item.prezzo;
                }

                // if(search != null){
                //     window.location.href = window.location.href.split('?')[0]+"?search="+ui.item.value;
                // }
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