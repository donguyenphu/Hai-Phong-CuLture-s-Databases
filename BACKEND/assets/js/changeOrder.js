$(document).ready(function () {
    $('.ajax-order').on('change', function (event) {
        let id = event.target.dataset.id;
        let newOrder = event.target.value;
        $.ajax({
            type: 'GET',
            url: 'change-order.php',
            data: {
                id: id,
                order: newOrder
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
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
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
        //    window.location.reload(); /// reload the page 
    });

})