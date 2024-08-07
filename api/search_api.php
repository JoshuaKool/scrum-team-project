<?php
$conditions = [];
$params = [];
require_once '../connection.php';

function returnJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $houses = handleReadAll();
        returnJSON($houses);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed."]);
        break;
}

function handleReadAll() {
    try {
        global $pdo, $params, $conditions;

        assignValue('country', $conditions, $params);
        assignValue('place', $conditions, $params);
        assignValue('pets_allowed', $conditions, $params);
        assignValue('parkingplace', $conditions, $params);
        assignValue('accessible_disabled_people', $conditions, $params);
        assignValue('smoking_allowed', $conditions, $params);
        assignValue('garden', $conditions, $params);
        assignValue('balcony', $conditions, $params);

        AssignMin('price', $conditions, $params, 'minPrice');
        AssignMax('price', $conditions, $params, 'maxPrice');
        AssignMin('rating', $conditions, $params, 'minRating');
        AssignMax('rating', $conditions, $params, 'maxRating');
        
        handleRoomRanges($conditions, $params);

        AssignMulti('house_type', $conditions, $params, 'house_type');
        AssignMulti('country', $conditions, $params, 'locations');

        $sql = "SELECT * FROM houses";
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();
        $houseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $houseData;

    } catch (PDOException $e) {
        http_response_code(500);
        returnJSON(["error" => $e->getMessage()]);
    }
}

function assignValue($parameter, &$conditions, &$params) {
    if (!empty($_GET[$parameter])) {
        $conditions[] = "$parameter = :$parameter";
        $params[":$parameter"] = $_GET[$parameter];
    }
}

function AssignMax($parameter, &$conditions, &$params, $getArgument) {
    if (!empty($_GET[$getArgument])) {
        $conditions[] = "$parameter <= :$getArgument";
        $params[":$getArgument"] = $_GET[$getArgument];
    }
}

function AssignMin($parameter, &$conditions, &$params, $getArgument) {
    if (!empty($_GET[$getArgument])) {
        $conditions[] = "$parameter >= :$getArgument";
        $params[":$getArgument"] = $_GET[$getArgument];
    }
}

function AssignMulti($parameter, &$conditions, &$params, $getArgument) {
    if (isset($_GET[$getArgument]) && is_array($_GET[$getArgument])) {
        $values = array_filter($_GET[$getArgument], fn($value) => $value !== '');
        if (!empty($values)) {
            $placeholders = [];
            foreach ($values as $key => $value) {
                $placeholder = ":{$getArgument}_{$key}";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $conditions[] = "$parameter IN (" . implode(', ', $placeholders) . ")";
        }
    }
}

function assignCheckbox($parameter, &$conditions, &$params, $getArgument) {
    if (!empty($_GET[$getArgument])) {
        $conditions[] = "$parameter = 1";
    }
}

function handleRoomRanges(&$conditions, &$params) {
    $roomRanges = [];
    if (!empty($_GET['roomRanges'])) {
        foreach ($_GET['roomRanges'] as $range) {
            switch ($range) {
                case '0-5':
                    $roomRanges[] = "(rooms >= 0 AND rooms <= 5)";
                    break;
                case '5-10':
                    $roomRanges[] = "(rooms >= 5 AND rooms <= 10)";
                    break;
                case '10-20':
                    $roomRanges[] = "(rooms >= 10 AND rooms <= 20)";
                    break;
                case '20-30':
                    $roomRanges[] = "(rooms >= 20 AND rooms <= 30)";
                    break;
                case '30plus':
                    $roomRanges[] = "rooms >= 30";
                    break;
            }
        }
        if (!empty($roomRanges)) {
            $conditions[] = "(" . implode(" OR ", $roomRanges) . ")";
        }
    }
}