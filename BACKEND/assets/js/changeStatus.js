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
            },
            success: function (data) {
                if (data === 'success') {
                    Toastify({
                        text: "✅ Operation Successful!",
                        duration: 3000,
                        gravity: "top", // "top" or "bottom"
                        position: "right", // "left", "center", "right"
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                            color: "#fff",
                            fontSize: "16px",
                            borderRadius: "8px",
                            padding: "10px 20px"
                        }
                    }).showToast();
                } else if (data === 'fail') {
                    Toastify({
                        text: "❌ Operation Failed!",
                        duration: 3000,
                        gravity: "top", // "top" or "bottom"
                        position: "right", // "left", "center", "right"
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            color: "#fff",
                            fontSize: "16px",
                            borderRadius: "8px",
                            padding: "10px 20px",
                            boxShadow: "0px 0px 10px rgba(0, 0, 0, 0.2)"
                        }
                    }).showToast();
                }
            }
        });
    });
})