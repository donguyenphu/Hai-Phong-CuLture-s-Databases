$(document).ready(function() {
    $('.ajax-name').on('change', function(event) {
        let newValue = event.target.value;
        let id = event.target.dataset.id;
        $.ajax({
            type: 'GET',
            url: 'change-name.php',
            data: {
                id: id,
                name: newValue
            }
        });
        window.location.reload(); /// reload the page
    })
})
