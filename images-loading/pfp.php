<?php

require_once('../connection.php');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT profile_image FROM users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $imgData = $stmt->fetchColumn();

    header("Content-type: image/png");
    echo $imgData;
    exit();
}
?>