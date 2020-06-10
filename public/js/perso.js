$(document).ready(function() {
    $('table#galeries.sorted').dataTable({
        "oLanguage": {
            "sLengthMenu": "Afficher _MENU_ galeries par page",
            "sZeroRecords": "Aucune galerie n'est enregistré pour le moment",
            "sInfo": "Affichage des galeries _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Affichage des galeries 0 à 0 sur O",
            "sInfoFiltered": "(filtre appliqué sur un total de _MAX_ galeries)",
            "sSearch": "Recherche",
        },
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [3]}
        ],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/galeries/liste",
    });
});

