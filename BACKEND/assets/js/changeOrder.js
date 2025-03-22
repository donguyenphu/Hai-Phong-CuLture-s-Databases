$(document).ready(function() {
    $('.ajax-order').on('change', function(event) {
        let id = event.target.dataset.id;
        let newOrder = event.target.value;
        $.ajax({
            type: 'GET',
            url: 'change-order.php',
            data: {
                id: id,
                order: newOrder
            }
        });
        window.location.reload(); /// reload the page 
    });
})