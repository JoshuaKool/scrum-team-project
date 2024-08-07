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
        $review = handleRead($id);
        http_response_code(201);
        returnJSON($review);
        break;
    case "GET":
        if (isset($_GET["id"])) {
            $review = handleRead($_GET["id"]);
            returnJSON($review);
        } else {
            $reviews = handleReadAll();
            returnJSON($reviews);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        handlePut($data);
        $review = handleRead($_GET["id"]);
        returnJSON($review);
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
        $stmt = $pdo->prepare("INSERT INTO reviews (rating, review, house_id, reviewer_id) VALUES (:rating, :review, :house_id, :reviewer_id)");
        $stmt->bindParam(':rating', $data["rating"]);
        $stmt->bindParam(':review', $data["review"]);
        $stmt->bindParam(':house_id', $data["house_id"]);
        $stmt->bindParam(':reviewer_id', $data["reviewer_id"]);
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
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :id");
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
        $stmt = $pdo->prepare("SELECT * FROM reviews");
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
        $stmt = $pdo->prepare("UPDATE reviews SET rating = :rating, review = :review WHERE id = :id");
        $stmt->bindParam(':rating', $data["rating"]);
        $stmt->bindParam(':review', $data["review"]);
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
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}