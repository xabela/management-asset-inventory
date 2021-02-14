<?php

// header("Content-Type : application/json; charset=UTF-8");
$view = [
    'content' => file_get_contents("app/view/login.html"),
    'js' => file_get_contents("app/js/login.js")
];

echo json_encode($view);
?>