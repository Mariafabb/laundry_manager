// $( "#dialog" ).dialog({ autoOpen: false });
// $( "#confirm" ).dialog({ autoOpen: false });
//
// $( ".opener" ).click(function() {
//     var actionUrl = url+"?"+this.id;
//     $( "#dialog" ).dialog({
//         resizable: false,
//         height: "auto",
//         width: 400,
//         modal: true,
//         buttons: {
//             "Si": function() {
//                 $.ajax({
//                     url: actionUrl
//                 }).done(function () {
//                     $("#confirm").dialog({
//                         text: "Azione eseguita!"
//                     })
//                 });
//                 $("#confirm").dialog(" open ");
//                 $( this ).dialog( "close" );
//             },
//             "No": function() {
//                 $( this ).dialog( "close" );
//             }
//         }
//     })
//     $( "#dialog" ).dialog( "open" );
// });

function confirmDelete(){
    $.confirm({
        title: 'Confirm!',
        content: 'Simple confirm!',
        buttons: {
            confirm: function () {
                $.alert('Confirmed!');
            },
            cancel: function () {
                $.alert('Canceled!');
            },
            somethingElse: {
                text: 'Something else',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    $.alert('Something else?');
                }
            }
        }
    });
}