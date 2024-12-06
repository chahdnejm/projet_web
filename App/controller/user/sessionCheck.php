<?php
session_start();

if (isset($_SESSION['user'])) {
    echo json_encode([
        "loggedIn" => true,
        "user" => $_SESSION['user']
    ]);
} else {
    echo json_encode(["loggedIn" => false, "message" => "User not logged in."]);
}
?>