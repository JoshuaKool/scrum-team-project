<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Form</title>
</head>
<body>

<?php
function makeRequest($url, $params = [])
{
    $queryString = http_build_query($params);
    $finalUrl = $url . '?' . $queryString;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $finalUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
    $params = [
        'place' => $_GET['place'],
        'country' => $_GET['country'],
        'minPrice' => $_GET['minPrice'],
        'maxPrice' => $_GET['maxPrice'],
        'minRating' => $_GET['minRating'],
        'maxRating' => $_GET['maxRating'],
        'minrooms' => $_GET['minrooms'],
        'maxrooms' => $_GET['maxrooms'],
        'pets_allowed' => $_GET['pets_allowed'],
        'parkingplace' => $_GET['parkingplace'],
        'accessible_disabled_people' => $_GET['accessible_disabled_people'],
        'smoking_allowed' => $_GET['smoking_allowed'],
        'garden' => $_GET['garden'],
        'balcony' => $_GET['balcony'],
        'house_type' => explode(',', $_GET['house_type'])
    ];

    $response = makeRequest('http://localhost/scrum/Lets-Scrum-8039b527780e-d180480f8ee4/api/search_api.php', $params);
}
?>

<form action="" method="GET">
    <label for="place">Plaatsnaam:</label>
    <input type="text" id="place" name="place"><br><br>

    <label for="country">Land:</label>
    <input type="text" id="country" name="country"><br><br>

    <label for="minPrice">Minimumprijs:</label>
    <input type="number" id="minPrice" name="minPrice"><br><br>

    <label for="maxPrice">Maximumprijs:</label>
    <input type="number" id="maxPrice" name="maxPrice"><br><br>

    <label for="minRating">Minimum rating:</label>
    <input type="number" id="minRating" name="minRating"><br><br>

    <label for="maxRating">Maximum rating:</label>
    <input type="number" id="maxRating" name="maxRating"><br><br>

    <label for="minrooms">Minimum aantal kamers:</label>
    <input type="number" id="minrooms" name="minrooms"><br><br>

    <label for="maxrooms">Maximum aantal kamers:</label>
    <input type="number" id="maxrooms" name="maxrooms"><br><br>

    <label for="pets_allowed">Huisdieren:</label>
    <select id="pets_allowed" name="pets_allowed">
        <option value="">Beide</option>
        <option value="no">Niet toegestaan</option>
        <option value="yes">Toegestaan</option>
    </select><br><br>

    <label for="parkingplace">Parkeerplek:</label>
    <select id="parkingplace" name="parkingplace">
        <option value="">Beide</option>
        <option value="no">Niet</option>
        <option value="yes">Wel</option>
    </select><br><br>

    <label for="accessible_disabled_people">Betreedbaar voor minder valide:</label>
    <select id="accessible_disabled_people" name="accessible_disabled_people">
        <option value="">Beide</option>
        <option value="no">Niet</option>
        <option value="yes">Wel</option>
    </select><br><br>

    <label for="smoking_allowed">Roken toegestaan:</label>
    <select id="smoking_allowed" name="smoking_allowed">
        <option value="">Beide</option>
        <option value="no">Niet toegestaan</option>
        <option value="yes">Toegestaan</option>
    </select><br><br>

    <label for="garden">Tuin:</label>
    <select id="garden" name="garden">
        <option value="">Beide</option>
        <option value="no">Niet</option>
        <option value="yes">Wel</option>
    </select><br><br>

    <label for="balcony">Balkon:</label>
    <select id="balcony" name="balcony">
        <option value="">Beide</option>
        <option value="no">Niet</option>
        <option value="yes">Wel</option>
    </select><br><br>

    <label for="house_type">Type huis:</label>
<select id="house_type" name="house_type">
    <option value="">Any</option>
    <option value="flat">Flat</option>
    <option value="villa">Villa</option>
    <option value="rijtjeshuis">Rijtjeshuis</option>
    <option value="appartment">Appartement</option>
</select><br><br>

    <input type="submit" value="Search">
</form>

<?php     
    echo "<h2>Search Results:</h2>";
    $jsonResponse = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo '<pre>' . json_encode($jsonResponse, JSON_PRETTY_PRINT) . '</pre>';
} else {
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>
</body>
</html>
