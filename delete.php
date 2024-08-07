<?php

// Connect to the database
require_once("connection.php");

$getId = htmlspecialchars($_GET['id']);
$table = htmlspecialchars($_GET['table']);
$edited = false;
$valid_tables = ['houses', 'users', 'rented', 'reviews'];

// Kills script when it detects the wrong table
if (!in_array($table, $valid_tables)) {
    die("Invalid table specified. <br> <a href=view.php><input type='button', value='Go back'></a>");
}

// Fetch data based on the table
$stmt = $pdo->prepare("SELECT * FROM $table WHERE id = :id");
$stmt->bindParam(':id', $getId, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If nuclear button is pressed delete entry from database
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<h1>Record deleted successfully!</h1><br><a href='view.php?table=$table'><input type='button' value='Go back'></a>";
        exit();
    } else {
        echo "<h1>Failed to delete the record.</h1><br><a href='view.php?table=$table'><input type='button' value='Go back'></a>";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Are you certain you want to delete this entry?</h1>

    <table border="1">
        <tr>
            <?php foreach (array_keys($data[0]) as $key) : ?>
                        <th>
                            <?= htmlspecialchars($key); ?>
                        </th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($data as $info) : ?>
                <tr>
                    <?php foreach ($info as $key => $value) : ?>
                <?php if ($key != "password") : ?>
                    <?php if ($key == "profile_image") : ?>
                        <td><img src="data:image/png;base64,<?= base64_encode($value); ?>" alt="Profile Image" style="width:22px; height:22px;"></td>
                    <?php else : ?>
                        <td><?= htmlspecialchars($value); ?></td>
                    <?php endif; ?>
                <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>

            <!-- Nuclear button -->
        <p><a href="view.php"><input type=button value='go back'></a></p>
        <form method="POST">
            <input type="hidden" value="<?= $getId; ?>" name='id'>
            <input class="delete" type="submit" value="DELETE">
        </form>


</body>
</html>