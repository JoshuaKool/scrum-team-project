<?php

$stmt = $pdo->prepare("INSERT INTO `house_images` (house_id, image)
    VALUES (:house_id, :image)");

$house_id = 1;
$image = file_get_contents("../test-house-image/house_two.png");

$stmt->bindParam(':house_id', $house_id);
$stmt->bindParam(':image', $image);

$stmt->execute();

$house_id = 2;
$image = file_get_contents("../test-house-image/house_one.png");

$stmt->bindParam(':house_id', $house_id);
$stmt->bindParam(':image', $image);

$stmt->execute();
?>