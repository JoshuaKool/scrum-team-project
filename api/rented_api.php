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
        $booking = handleRead($id);
        http_response_code(201);
        returnJSON($booking);
        break;
    case "GET":
        if (isset($_GET["id"])) {
            $booking = handleRead($_GET["id"]);
            returnJSON($booking);
        } else {
            $bookings = handleReadAll();
            returnJSON($bookings);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        handlePut($_GET["id"], $data);
        $booking = handleRead($_GET["id"]);
        returnJSON($booking);
        break;
    case "DELETE":
        handleDelete($_GET["id"]);
        http_response_code(204);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Er is iets fout gegaan."]);
        break;
}

function handleCreate($data) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO rented (start_date, end_date, house_id, renter_id) VALUES (:start_date, :end_date, :house_id, :renter_id)");
        $stmt->bindParam(':start_date', $data["start_date"]);
        $stmt->bindParam(':end_date', $data["end_date"]);
        $stmt->bindParam(':house_id', $data["house_id"]);
        $stmt->bindParam(':renter_id', $data["renter_id"]);
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
        $stmt = $pdo->prepare("SELECT * FROM rented WHERE id = :id");
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
        $stmt = $pdo->prepare("SELECT * FROM rented");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handlePut($id, $data) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE rented SET start_date = :start_date, end_date = :end_date, house_id = :house_id, renter_id = :renter_id WHERE id = :id");
        $stmt->bindParam(':start_date', $data["start_date"]);
        $stmt->bindParam(':end_date', $data["end_date"]);
        $stmt->bindParam(':house_id', $data["house_id"]);
        $stmt->bindParam(':renter_id', $data["renter_id"]);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handleDelete($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM rented WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}