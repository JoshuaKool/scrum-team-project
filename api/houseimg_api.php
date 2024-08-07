<?php

require_once '../connection.php';

function returnJSON($data)
{
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = $_POST;
        }
        $id = handleCreate($data);
        break;
    case "GET":
        if (isset($_GET["id"])) {
            $house_img = handleRead($_GET["id"]);
            returnJSON($house_img);
        } else {
            $house_images = handleReadAll();
            returnJSON($house_images);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        handlePut($data);
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

function handleCreate($data)
{
    try {
        $image = null;

        if (isset($data['image'])) {
            $imageData = base64_decode($data['image']);
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
            $image = $imageData;
            unlink($tempFilePath);
        } else if (isset($_FILES['image'])) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode(["error" => "Upload error: " . $_FILES['image']['error']]);
                exit();
            }
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            if ($imageInfo['mime'] != 'image/png') {
                http_response_code(400);
                echo json_encode(["error" => "Only PNG images are allowed as profile image"]);
                exit();
            }
            $image = file_get_contents($_FILES['image']['tmp_name']);
        }

        if ($image === null) {
            http_response_code(400);
            echo json_encode(["error" => "Image is required"]);
            exit();
        }

        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO house_images (image, house_id) VALUES (:image, :house_id)");
        $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
        $stmt->bindParam(':house_id', $data["house_id"]);
        $stmt->execute();
        $new_image = $pdo->lastInsertId();
        http_response_code(201);
        returnJSON(["id" => $new_image]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}

function handleRead($id) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM house_images WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && $data['image']) {
            $base64Image = base64_encode($data['image']);
            $data['image'] = 'data:image/png;base64,' . $base64Image;
            return $data;
        } else {
            http_response_code(404);
            return ["error" => "Image not found"];
        }
    } catch (PDOException $e) {
        http_response_code(500);
        return ["error" => $e->getMessage()];
    }
}

function handleReadAll() {
    try {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM house_images");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            foreach ($data as $key => $row) {
                if (isset($row['image']) && $row['image'] !== null) {
                    $base64Image = base64_encode($row['image']);
                    $data[$key]['image'] = 'data:image/png;base64,' . $base64Image;
                } else {
                    unset($data[$key]['image']);
                }
            }
            return $data;
        } else {
            http_response_code(404);
            return ["error" => "Image not found"];
        }
    } catch (PDOException $e) {
        http_response_code(500);
        return ["error" => $e->getMessage()];
    }
}

function handlePut($data) {
    try {
        global $pdo;

        $imageProvided = false;

        if (isset($data['image']) && !empty($data['image'])) {
            $imageData = base64_decode($data['image']);
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

        $sql = "UPDATE house_images SET house_id = :house_id";
        if ($imageProvided) {
            $sql .= ", image = :image";
        }
        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $data["id"]);
        $stmt->bindParam(':house_id', $data["house_id"]);
        if ($imageProvided) {
            $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
        }

        $stmt->execute();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
}

function handleDelete($id)
{
    try {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM house_images WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}