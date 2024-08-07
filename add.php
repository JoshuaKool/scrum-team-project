<?php
// Ensure a valid table is selected
if (empty($_POST['table'])) {
    die("No table specified. <br> <a href='view.php'><input type='button' value='Go back'></a>");
}

// Connect to the database
require_once("connection.php");

// Required fields for different tables
$required_fields = [
    'users' => ['role', 'firstName', 'lastName', 'email', 'phone', 'password'],
    'houses' => ['house_type', 'country', 'place', 'seller_id', 'price', 'rating', 'description', 'rooms', 'pets_allowed', 'parkingplace', 'accessible_disabled_people', 'smoking_allowed', 'garden', 'balcony'],
    'rented' => ['start_date', 'end_date', 'house_id', 'renter_id'],
    'reviews' => ['rating', 'review', 'house_id', 'reviewer_id']
];

// Validate table and required fields
$table = $_POST['table'];
if (!array_key_exists($table, $required_fields)) {
    die("Invalid table specified. <br> <a href='view.php'><input type='button' value='Go back'></a>");
}

// Check for missing required fields
foreach ($required_fields[$table] as $field) {
    if (!isset($_POST[$field])) {
        die("Field '$field' is required. <br> <a href='view.php?table=$table'><input type='button' value='Go back'></a>");
    }
}

// Prepare SQL query dynamically
$columns = array_keys($_POST);
if ($table == 'users') {
    array_push($columns, "profile_image");
}
$columns = array_filter($columns, fn($col) => $col !== 'table');
$placeholders = array_map(fn($col) => ":$col", $columns);
$insert_query = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

// Prepare the SQL statement
$stmt = $pdo->prepare($insert_query);

// Bind the data dynamically
foreach ($columns as $column) {
    if ($column == "password") {
        // Hash the password
        $stmt->bindValue(":$column", password_hash($_POST[$column], PASSWORD_DEFAULT));
    } elseif ($column == 'profile_image') {
        // Do nothing and let the statement underneath handle this
    } else {
        $stmt->bindValue(":$column", $_POST[$column]);
    }
}


// Bind profile image separately if it exists (only for users table)
if ($table === 'users') {
    if ($_FILES['profile_image']['size'] == 0) {
        // No file uploaded, use default image
        $defaultImagePath = 'default_profile/default.png';
        $imageData = file_get_contents($defaultImagePath);
    } else {
        //File uploaded, use the uploaded file
        $imageData = file_get_contents($_FILES['profile_image']['tmp_name']);
    }
    $stmt->bindValue(":profile_image", $imageData);
}

// Execute the statement and check for errors
try {
    if ($stmt->execute()) {
        echo "<h1>Data toegevoegd aan de database!</h1>";
        echo "<a href='view.php?table=$table'><input type='button' value='Terug'></a>";
    } else {
        echo "<h1>Er is iets fout gegaan bij het toevoegen van data.</h1>";
        echo "<a href='view.php?table=$table'><input type='button' value='Terug'></a>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<br><a href='view.php?table=$table'><input type='button' value='Terug'></a>";
}
?>
