<?php

require_once('../connection.php');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT image FROM house_images WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $imgData = $stmt->fetchColumn();

    header("Content-type: image/png");
    echo $imgData;
    exit();
}
?>