<?php

require_once '../connection.php';

function returnJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $id = handleCreate($data);
        $house = handleRead($id);
        http_response_code(201);
        returnJSON($house);
        break;
    case "GET":
        if (isset($_GET["id"])) {
            $house = handleRead($_GET["id"]);
            returnJSON($house);
        } else {
            $houses = handleReadAll();
            returnJSON($houses);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        handlePut($data);
        $house = handleRead($_GET["id"]);
        returnJSON($house);
        break;
    case "DELETE":
        handleDelete($_GET["id"]);
        http_response_code(204);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Sorry er is een fout opgetreden"]);
        break;
}

function handleCreate($data) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO houses (house_type, country, place, seller_id, price, rating, description, rooms, pets_allowed, parkingplace, accessible_disabled_people, smoking_allowed, garden, balcony)
            VALUES (:house_type, :country, :place, :seller_id, :price, :rating, :description, :rooms, :pets_allowed, :parkingplace, :accessible_disabled_people, :smoking_allowed, :garden, :balcony)");
        $stmt->bindParam(':house_type', $data["house_type"]);
        $stmt->bindParam(':country', $data["country"]);
        $stmt->bindParam(':place', $data["place"]);
        $stmt->bindParam(':seller_id', $data["seller_id"]);
        $stmt->bindParam(':price', $data["price"]);
        $stmt->bindParam(':rating', $data["rating"]);
        $stmt->bindParam(':description', $data["description"]);
        $stmt->bindParam(':rooms', $data["rooms"]);
        $stmt->bindParam(':pets_allowed', $data["pets_allowed"]);
        $stmt->bindParam(':parkingplace', $data["parkingplace"]);
        $stmt->bindParam(':accessible_disabled_people', $data["accessible_disabled_people"]);
        $stmt->bindParam(':smoking_allowed', $data["smoking_allowed"]);
        $stmt->bindParam(':garden', $data["garden"]);
        $stmt->bindParam(':balcony', $data["balcony"]);
        $stmt->execute();
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handleRead($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handleReadAll() {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM houses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handlePut($data) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE houses SET house_type = :house_type, country = :country, place = :place, seller_id = :seller_id, price = :price, rating = :rating, description = :description, rooms = :rooms, pets_allowed = :pets_allowed, parkingplace = :parkingplace, accessible_disabled_people = :accessible_disabled_people, smoking_allowed = :smoking_allowed, garden = :garden, balcony = :balcony WHERE id = :id");
        $stmt->bindParam(':house_type', $data["house_type"]);
        $stmt->bindParam(':country', $data["country"]);
        $stmt->bindParam(':place', $data["place"]);
        $stmt->bindParam(':seller_id', $data["seller_id"]);
        $stmt->bindParam(':price', $data["price"]);
        $stmt->bindParam(':rating', $data["rating"]);
        $stmt->bindParam(':description', $data["description"]);
        $stmt->bindParam(':rooms', $data["rooms"]);
        $stmt->bindParam(':pets_allowed', $data["pets_allowed"]);
        $stmt->bindParam(':parkingplace', $data["parkingplace"]);
        $stmt->bindParam(':accessible_disabled_people', $data["accessible_disabled_people"]);
        $stmt->bindParam(':smoking_allowed', $data["smoking_allowed"]);
        $stmt->bindParam(':garden', $data["garden"]);
        $stmt->bindParam(':balcony', $data["balcony"]);
        $stmt->bindParam(':id', $data["id"]);
        $stmt->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handleDelete($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM houses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}