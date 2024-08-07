<?php

require_once '../connection.php';

function returnJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["id"])) {
            $house = handleRead($_GET["id"]);
            returnJSON($house);
        } else {
            $houses = handleReadAll();
            returnJSON($houses);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Er is iets fout gegaan."]);
        break;
}

function handleRead($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $houseData['houses'] = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE house_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $reviewData['review'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $houseData + $reviewData;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}