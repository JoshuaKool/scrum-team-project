<?php

require_once '../connection.php';

function returnJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $data = $_POST;
        handleCreate($data);
        break;
    case "GET":
        if (isset($_GET["id"])) {
            $user = handleRead($_GET["id"]);
            returnJSON($user);
        } else {
            $users = handleReadAll();
            returnJSON($users);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        handlePut($data);
        break;
    case "DELETE":
        if (isset($_GET["id"])) {
            handleDelete($_GET["id"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID parameter is required for DELETE operation"]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        break;
}

function handleCreate($data) {
    try {
        global $pdo;
        
        $requiredFields = ["role", "firstName", "lastName", "email", "phone", "password"];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(["error" => ucfirst($field) . " is required"]);
                exit();
            }
        }

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
            $imageInfo = getimagesize($_FILES['profile_image']['tmp_name']);
            if ($imageInfo['mime'] != 'image/png') {
                http_response_code(400);
                echo json_encode(["error" => "Only PNG images are allowed as profile image"]);
                exit();
            }
            $image = file_get_contents($_FILES['profile_image']['tmp_name']);
        }

        $stmt = $pdo->prepare("INSERT INTO users (role, firstName, lastName, email, phone, profile_image, password)
            VALUES (:role, :firstName, :lastName, :email, :phone, :profile_image, :password)");

        $stmt->bindParam(':role', $data["role"]);
        $stmt->bindParam(':firstName', $data["firstName"]);
        $stmt->bindParam(':lastName', $data["lastName"]);
        $stmt->bindParam(':email', $data["email"]);
        $stmt->bindParam(':phone', $data["phone"]);
        $stmt->bindParam(':profile_image', $image, PDO::PARAM_LOB);
        $stmt->bindParam(':password', password_hash($data["password"], PASSWORD_DEFAULT));

        $stmt->execute();

        $userId = $pdo->lastInsertId();
        http_response_code(201);
        returnJSON(["id" => $userId]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}

function handleRead($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
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
        $stmt = $pdo->prepare("SELECT * FROM users");
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

        $requiredFields = ["id", "role", "firstName", "lastName", "email", "phone"];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(["error" => ucfirst($field) . " is required"]);
                exit();
            }
        }

        $imageProvided = false;

        if (isset($data['profile_image']) && !empty($data['profile_image'])) {
            $imageData = base64_decode($data['profile_image']);
            if ($imageData === false) {
                throw new Exception("Failed to decode base64 image.");
            }
        
            $tempFilePath = tempnam(sys_get_temp_dir(), 'uploaded_');
            file_put_contents($tempFilePath, $imageData);
            $imageInfo = getimagesize($tempFilePath);
        
            if ($imageInfo['mime'] != 'image/png') {
                unlink($tempFilePath);
                throw new Exception("Only PNG images are allowed.");
            }
        
            $imageProvided = true;
            $image = $imageData;
        
            unlink($tempFilePath);
        }

        $sql = "UPDATE users SET role = :role, firstName = :firstName, lastName = :lastName, email = :email, phone = :phone";
        if ($imageProvided) {
            $sql .= ", profile_image = :profile_image";
        }
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $data["id"]);
        $stmt->bindParam(':role', $data["role"]);
        $stmt->bindParam(':firstName', $data["firstName"]);
        $stmt->bindParam(':lastName', $data["lastName"]);
        $stmt->bindParam(':email', $data["email"]);
        $stmt->bindParam(':phone', $data["phone"]);
        if ($imageProvided) {
            $stmt->bindParam(':profile_image', $image, PDO::PARAM_LOB);
        }

        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        $stmt->execute();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
}

function handleDelete($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        http_response_code(204);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}