<?php

// Initialises page to the users table
if (empty($_GET['table'])) {
    header("Location: view.php?table=users");
    exit();
}

// Set sortType and sortOrder defaults
$sortType = $_GET['sortType'] ?? 'id';
$sortOrder = $_GET['sortOrder'] ?? 'desc';
$sortNext = $sortOrder === 'asc' ? 'desc' : 'asc';
$sortSymbol = $sortOrder === 'desc' ? '↓' : '↑';
$table = $_GET['table'] ?? '';
$valid_tables = ['houses', 'users', 'rented', 'reviews'];

// Kills script when it detects the wrong table
if (!in_array($table, $valid_tables)) {
    die("Invalid table specified. <br> <a href=view.php><input type='button', value='Go back'></a>");
}

// Connect to the stmtbase
require_once("connection.php");

if ($_GET['table'] == "houses") {
    // Fetch house information
    $stmt = $pdo->prepare("SELECT * FROM houses ORDER BY $sortType $sortOrder");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($_GET['table'] == "users") {
    // Fetch user information
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY $sortType $sortOrder");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($_GET['table'] == "rented") {
    // Fetch rented days
    $stmt = $pdo->prepare("SELECT * FROM rented ORDER BY $sortType $sortOrder");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($_GET['table'] == "reviews") {
    // Fetch rented days
    $stmt = $pdo->prepare("SELECT * FROM reviews ORDER BY $sortType $sortOrder");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- Navbar where you can select which table to look at -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="view.php?table=users">Gebruikers</a>
        <a href="view.php?table=houses">Huizen</a>
        <a href="view.php?table=rented">Verhuurd</a>
        <a href="view.php?table=reviews">Reviews</a>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley"></a>
    </div><br>

    <body>

        <!-- Small section to add an entry -->
        <h1>Voeg data toe</h1>

        <form method="post" action="add.php" enctype="multipart/form-data">
        <input type="hidden" name="table" value="<?= htmlspecialchars($table); ?>">
        <table border="1">
            <tr>
                <?php foreach (array_keys($data[0]) as $key) : ?>
                    <th>
                        <?= htmlspecialchars($key); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach (array_keys($data[0]) as $key) : ?>

                    <!-- Hidden information -->
                    <?php if ($key == "id") : ?>
                        <td></td>
                    <?php elseif ($key == "updated_at") : ?>
                        <td>Mag niet aangepast worden</td>
                    <?php elseif ($key == "created_at") : ?>
                        <td>Mag niet aangepast worden</td>

                    <!-- Sensitive information -->
                    <?php elseif ($key == "password") : ?>
                        <td><input type="password" placeholder="Wachtwoord" name="<?= $key; ?>" required></td>

                    <!-- Images -->
                    <?php elseif ($key == "profile_image") : ?>
                        <td><input type="file" name="<?= $key; ?>"></td>

                    <!-- Lists -->
                    <?php elseif ($key == "role") : ?>
                        <td><select id="role" name="role"required>
                            <option value="buy">Koper</option>
                            <option value="sell">Verkoper</option>
                            <option value="admin">Admin</option>
                        </select></td>
                    <?php elseif ($key == "house_type") : ?>
                        <td><select id="house_type" name="house_type"required>
                            <option value="flat">Flat</option>
                            <option value="villa">Villa</option>
                            <option value="rijtjeshuis">Rijtjeshuis</option>
                            <option value="appartment">Appartament</option>
                        </select></td>
                    <?php elseif ($key == "pets_allowed") : ?>
                        <td><select id="pets_allowed" name="pets_allowed"required>
                            <option value="yes">Toegestaan</option>
                            <option value="no">Verboden</option>
                        </select></td>
                    <?php elseif ($key == "parkingplace") : ?>
                        <td><select id="parkingplace" name="parkingplace"required>
                            <option value="yes">Beschikbaar</option>
                            <option value="no">Niet beschikbaar</option>
                        </select></td>
                    <?php elseif ($key == "accessible_disabled_people") : ?>
                        <td><select id="accessible_disabled_people" name="accessible_disabled_people"required>
                            <option value="yes">Toegankelijk</option>
                            <option value="no">Niet toegankelijk</option>
                        </select></td>
                    <?php elseif ($key == "smoking_allowed") : ?>
                        <td><select id="smoking_allowed" name="smoking_allowed"required>
                            <option value="yes">Toegestaan</option>
                            <option value="no">Verboden</option>
                        </select></td>
                    <?php elseif ($key == "garden") : ?>
                        <td><select id="garden" name="garden"required>
                            <option value="yes">Aanwezig</option>
                            <option value="no">Niet aanwezig</option>
                        </select></td>
                    <?php elseif ($key == "balcony") : ?>
                        <td><select id="balcony" name="balcony"required>
                            <option value="yes">Aanwezig</option>
                            <option value="no">Niet aanwezig</option>
                        </select></td>
                    <?php elseif ($key == "country") : ?>
                        <td><select id="country" name="country"required>
                            <option value="Nederland">Nederland</option>
                            <option value="België">België</option>
                            <option value="Duitsland">Duitsland</option>
                            <option value="Frankrijk">Frankrijk</option>
                            <option value="Spanje">Spanje</option>
                            <option value="Italië">Italië</option>
                            <option value="Verenigd Koninkrijk">Verenigd Koninkrijk</option>
                            <option value="Verenigde Staten">Verenigde Staten</option>
                            <option value="China">China</option>
                            <option value="Japan">Japan</option>
                            <option value="Zuid-Korea">Zuid-Korea</option>
                            <option value="Australië">Australië</option>
                            <option value="Nieuw-Zeeland">Nieuw-Zeeland</option>
                            <option value="Brazilië">Brazilië</option>
                            <option value="Zuid-Afrika">Zuid-Afrika</option>
                        </select></td>

                    <!-- Numbers -->
                    <?php elseif ($key == "seller_id") : ?>
                        <td><input type="number" min="0" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "house_id") : ?>
                        <td><input type="number" min="0" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "renter_id") : ?>
                        <td><input type="number" min="0" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "reviewer_id") : ?>
                        <td><input type="number" min="0" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "price") : ?>
                        <td><input type="number" step=".01" min="0" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "rating") : ?>
                        <td><input type="number" step=".01" min="0" max="10" name="<?= $key; ?>"required></td>
                    <?php elseif ($key == "rooms") : ?>
                        <td><input type="number" min="0" name="<?= $key; ?>"required></td>
                        
                    <!-- Dates -->
                    <?php elseif ($key == "start_date") : ?>
                        <td><input type="date" name="<?= $key; ?>" required></td>
                    <?php elseif ($key == "end_date") : ?>
                        <td><input type="date" name="<?= $key; ?>" required></td>

                    <!-- Email -->
                    <?php elseif ($key == "email") : ?>
                        <td><input type="email" name="<?= $key; ?>"required></td>

                    <!-- Text -->
                    <?php else : ?>
                        <td><input type="text" name="<?= $key; ?>"required></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><input type="submit" value="Voeg data toe"></td>
            </tr>
        </table>
    </form>



    <!-- Checks which table is selected and displays selected table -->
    <?php if (!empty($data)) : ?>

        <h1><?= $_GET['table']; ?></h1>
        <table border="1">
            <tr>
                <?php foreach (array_keys($data[0]) as $key) : ?>
                    <?php if ($key != "password") : ?>
                        <th>
                            <?= htmlspecialchars($key); ?>
                            <a href="view.php?table=<?= $_GET['table']; ?>&sortType=<?= $key; ?>&sortOrder=<?= $sortNext; ?>"><?= $sortSymbol; ?></a>
                        </th>
                    <?php endif; ?>
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
                    <?php foreach ($info as $key => $value) : ?>
                        <?php if ($key == "id") : ?>
                            <td><a href="edit.php?table=<?= htmlspecialchars($table); ?>&id=<?= htmlspecialchars($value); ?>"><input type="button" value=" Edit "></a></td>
                            <td><a href="delete.php?table=<?= htmlspecialchars($table); ?>&id=<?= htmlspecialchars($value); ?>"><input type="button" value=" Delete "></a></td>
                            <?php if ($table == "houses") { ?>
                                <td><a href="reviews_page.php?house_id=<?= htmlspecialchars($value); ?>"><input type="button" value="Review"></a></td>
                            <?php } ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else : ?>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley"><h1>Error displaying table.</h1></a>
    <?php endif; ?>
</body>

</html>
