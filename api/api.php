<?php

require_once("../connection.php");

if ($pdo) {
    GetHouses();
    GetUsers();
    GetRente();
    GetReviews();
    GetHouseImages();
} else {
    echo "Connection failed";
}

function GetHouses() {
    global $pdo;
    $response = array();
    $stmt = $pdo->prepare("SELECT * FROM houses");
    $stmt->execute();
    if ($stmt) {
        $i = 0;
        while ($row = $stmt->fetch()) {
            $response[$i]['id'] = $row['id'];
            $response[$i]['house_type'] = $row['house_type'];
            $response[$i]['country'] = $row['country'];
            $response[$i]['place'] = $row['place'];
            $response[$i]['seller_id'] = $row['seller_id'];
            $response[$i]['price'] = $row['price'];
            $response[$i]['rating'] = $row['rating'];
            $response[$i]['description'] = $row['description'];
            $response[$i]['rooms'] = $row['rooms'];
            $response[$i]['pets_allowed'] = $row['pets_allowed'];
            $response[$i]['parkingplace'] = $row['parkingplace'];
            $response[$i]['accessible_disabled_people'] = $row['accessible_disabled_people'];
            $response[$i]['smoking_allowed'] = $row['smoking_allowed'];
            $response[$i]['garden'] = $row['garden'];
            $response[$i]['balcony'] = $row['balcony'];
            $response[$i]['created_at'] = $row['created_at'];
            $response[$i]['updated_at'] = $row['updated_at'];
            $i++;
        }
        header("Content-Type: application/json");
        echo json_encode(array("House" => $response), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

function GetUsers() {
    global $pdo;
    $response = array();
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    if ($stmt) {
        $i = 0;
        while ($row = $stmt->fetch()) {
            $response[$i]['id'] = $row['id'];
            $response[$i]['role'] = $row['role'];
            $response[$i]['firstName'] = $row['firstName'];
            $response[$i]['lastName'] = $row['lastName'];
            $response[$i]['email'] = $row['email'];
            $response[$i]['phone'] = $row['phone'];
            $response[$i]['password'] = $row['password'];
            $response[$i]['profile_image'] = base64_encode($row['profile_image']);
            $i++;
        }
        echo json_encode(array("User" => $response), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

function GetRente() {
    global $pdo;
    $response = array();
    $stmt = $pdo->prepare("SELECT * FROM rented");
    $stmt->execute();
    if ($stmt) {
        $i = 0;
        while ($row = $stmt->fetch()) {
            $response[$i]['id'] = $row['id'];
            $response[$i]['start_date'] = $row['start_date'];
            $response[$i]['end_date'] = $row['end_date'];
            $response[$i]['house_id'] = $row['house_id'];
            $response[$i]['renter_id'] = $row['renter_id'];
            $response[$i]['created_at'] = $row['created_at'];
            $response[$i]['updated_at'] = $row['updated_at'];
            $i++;
        }
        echo json_encode(array("Rent" => $response), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

function GetReviews() {
    global $pdo;
    $response = array();
    $stmt = $pdo->prepare("SELECT * FROM reviews");
    $stmt->execute();
    if ($stmt) {
        $i = 0;
        while ($row = $stmt->fetch()) {
            $response[$i]['id'] = $row['id'];
            $response[$i]['rating'] = $row['rating'];
            $response[$i]['review'] = $row['review'];
            $response[$i]['house_id'] = $row['house_id'];
            $response[$i]['reviewer_id'] = $row['reviewer_id'];
            $response[$i]['created_at'] = $row['created_at'];
            $response[$i]['updated_at'] = $row['updated_at'];
            $i++;
        }
        echo json_encode(array("Review" => $response), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

function GetHouseImages() {
    global $pdo;
    $response = array();
    $stmt = $pdo->prepare("SELECT * FROM house_images");
    $stmt->execute();
    if ($stmt) {
        $i = 0;
        while ($row = $stmt->fetch()) {
            $response[$i]['id'] = $row['id'];
            $response[$i]['house_id'] = $row['house_id'];
            $response[$i]['created_at'] = $row['created_at'];
            $response[$i]['image'] = base64_encode($row['image']);
            $i++;
        }
        echo json_encode(array("House Image" => $response), JSON_PRETTY_PRINT) . PHP_EOL;
    }
}