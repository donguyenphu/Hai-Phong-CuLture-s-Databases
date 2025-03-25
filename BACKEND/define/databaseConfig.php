<?php
date_default_timezone_set("America/New_York");
$initServer = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'hai_phong_culture_database',
    'table' => 'home_section'
];
define("HOME_SECTION_DATABASE_INFO", $initServer);
$infoStorage = new Database($initServer);


$successfulText = '<script>
     setTimeout(function() {
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
    }, 100);
</script>'.'</br>';

define("SUCCESS_TEXT", $successfulText);

$failText = '<script>
    setTimeout(function() {
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
    }, 100);
</script>';

define("FAIL_TEXT",$failText);