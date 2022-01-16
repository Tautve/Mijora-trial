$(document).ready(function () {

    // Datatable
    const omnivaDatatable = $('.omnivaDatatable');
    const subHeader = $('.sub-header');
    omnivaDatatable.DataTable({
        "language": {
            "lengthMenu": "Rodomi _MENU_ įrašai per puslapį",
            "zeroRecords": "Įrašų nerasta",
            "info": "Rodomas puslapis _PAGE_ iš _PAGES_",
            "infoEmpty": "",
            "infoFiltered": "(išfiltruota _MAX_ visų įrašų)",
            "search": "Ieškoti:",
            "paginate": {
                "previous": "Ankstesnis",
                "next": "Kitas",
            },
        },
        "processing": true
    });

    $('div#spinner').hide();
    omnivaDatatable.show();
    subHeader.show();
});
