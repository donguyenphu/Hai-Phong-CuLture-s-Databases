$(document).ready(function() {
    $('.ajax-status').on('change', function(event) {
        let newStatusValue = $(this).prop("checked") ? 1 : 0;
        let id = event.target.dataset.id;
        $.ajax({
            type: 'GET',
            url: 'change-status.php',
            data: {
                status: newStatusValue,
                id: id
            }
        });
        window.location.reload(); /// reload the page
    });
})