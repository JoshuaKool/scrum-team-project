    <?php

    // Connect to the database
    require_once("connection.php");

    $id = htmlspecialchars($_GET['id']);
    $table = htmlspecialchars($_GET['table']);
    $edited = false;
    $valid_tables = ['houses', 'users', 'rented', 'reviews'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Kills script when it detects the wrong table
    if (!in_array($table, $valid_tables)) {
        die("Invalid table specified. <br> <a href=view.php><input type='button', value='Go back'></a>");
    }

    // Fetch data based on the table
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Checks to see if there is a Post request and initialised some variables
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $columns = array_keys($data[0]);
        $set_clause = [];
        $params = [];

        // Loop through each value and see if there is a post request associated to it
        foreach ($columns as $column) {
            if ($column != 'id' && isset($_POST[$column])) {
                if ($column == 'password') { // If password, encrypt!
                    if (!empty($_POST[$column])) {
                        $hashed_password = password_hash($_POST[$column], PASSWORD_DEFAULT);
                        $set_clause[] = "$column = :$column";
                        $params[":$column"] = $hashed_password;
                    }
                } elseif ($column == 'profile_image' && ($_FILES['profile_image']['size'] != 0)) { // Handle profile image upload

                    if ($column == 'profile_image' && $_FILES['profile_image']['size'] >= 500000 || !in_array($_FILES['profile_image']['type'], $allowedTypes)) {
                        die("Foto is te groot of van verkeerde type. <br> Selecteer een bestand van max 500KB. <br> <a href='view.php'> <input type='button' value='Terug'> </a> <br> Huidig bestandstype: " . htmlspecialchars($_FILES['profile_image']['type']));
                    }

                    $profile_image_data = file_get_contents($_FILES['profile_image']['tmp_name']);
                    $set_clause[] = "$column = :$column";
                    $params[":$column"] = $profile_image_data;
                } elseif ($column == 'profile_image' && ($_FILES['profile_image']['size'] == 0)) {
                    // Do nothing if no image was given
                } elseif ($column == 'updated_at') {
                    // Do nothing to organically update update time
                } else {
                    $set_clause[] = "$column = :$column";
                    $params[":$column"] = $_POST[$column];
                }
            }
        }

        // Insert the found values into a prepared statement and then execute that with the processed information from the previous loop
        if (!empty($set_clause)) {
            $update_sql = "UPDATE $table SET " . implode(", ", $set_clause) . " WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            foreach ($params as $param => $value) {
                $update_stmt->bindValue($param, $value);
            }
            $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($update_stmt->execute()) {
                $edited = true; // Makes sure the user knows what they did
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Data</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <?php if (!empty($data) & $edited == false) : ?>

            <form method="POST" enctype="multipart/form-data">
                <table border="1">
                    <tr>
                        <?php foreach (array_keys($data[0]) as $key) : ?>
                            <?php if ($key != "id") : ?>
                                <th>
                                    <?= htmlspecialchars($key); ?>
                                </th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($data as $info) : ?>
                        <tr>
                            <?php foreach ($info as $key => $value) : ?>
                                <!-- Hidden information -->
                                <?php if ($key == "id") : ?>
                                    <!-- Do nothing -->
                                <?php elseif ($key == "updated_at") : ?>
                                    <td>Mag niet aangepast worden</td>
                                <?php elseif ($key == "created_at") : ?>
                                    <td>Mag niet aangepast worden</td>

                                    <!-- Sensitive information -->
                                <?php elseif ($key == "password") : ?>
                                    <td><input type="password" placeholder="Nieuw wachtwoord" name="<?= $key; ?>"></td>

                                    <!-- Images -->
                                <?php elseif ($key == "profile_image") : ?>
                                    <td><input type="file" name="<?= $key; ?>"></td>

                                    <!-- Lists -->
                                <?php elseif ($key == "role") : ?>
                                    <td><select id="role" name="role" required>
                                            <option value="buy" <?= $value == 'buy' ? 'selected' : ''; ?>>Koper</option>
                                            <option value="sell" <?= $value == 'sell' ? 'selected' : ''; ?>>Verkoper</option>
                                            <option value="admin" <?= $value == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        </select></td>
                                <?php elseif ($key == "house_type") : ?>
                                    <td><select id="house_type" name="house_type" required>
                                            <option value="flat" <?= $value == 'flat' ? 'selected' : ''; ?>>Flat</option>
                                            <option value="villa" <?= $value == 'villa' ? 'selected' : ''; ?>>Villa</option>
                                            <option value="rijtjeshuis" <?= $value == 'rijtjeshuis' ? 'selected' : ''; ?>>Rijtjeshuis</option>
                                            <option value="appartment" <?= $value == 'appartment' ? 'selected' : ''; ?>>Appartament</option>
                                        </select></td>
                                <?php elseif ($key == "pets_allowed") : ?>
                                    <td><select id="pets_allowed" name="pets_allowed" required>
                                            <option value="yes" <?= $value == 'yes' ? 'selected' : ''; ?>>Toegestaan</option>
                                            <option value="no" <?= $value == 'no' ? 'selected' : ''; ?>>Verboden</option>
                                        </select></td>
                                <?php elseif ($key == "parkingplace") : ?>
                                    <td><select id="parkingplace" name="parkingplace" required>
                                            <option value="yes" <?= $value == 'yes' ? 'selected' : ''; ?>>Beschikbaar</option>
                                            <option value="no" <?= $value == 'no' ? 'selected' : ''; ?>>Niet beschikbaar</option>
                                        </select></td>
                                <?php elseif ($key == "accessible_disabled_people") : ?>
                                    <td><select id="accessible_disabled_people" name="accessible_disabled_people" required>
                                            <option value="yes" <?= $value == 'yes' ? 'selected' : ''; ?>>Toegankelijk</option>
                                            <option value="no" <?= $value == 'no' ? 'selected' : ''; ?>>Niet toegankelijk</option>
                                        </select></td>

                                    <!-- Numbers -->
                                <?php elseif ($key == "seller_id") : ?>
                                    <td><input type="number" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "house_id") : ?>
                                    <td><input type="number" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "renter_id") : ?>
                                    <td><input type="number" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "reviewer_id") : ?>
                                    <td><input type="number" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "price") : ?>
                                    <td><input type="number" step=".01" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "rating") : ?>
                                    <td><input type="number" step=".01" min="0" max="10" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "rooms") : ?>
                                    <td><input type="number" min="0" name="<?= $key; ?>" value="<?= $value; ?>" required></td>

                                    <!-- Dates -->
                                <?php elseif ($key == "start_date") : ?>
                                    <td><input type="date" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php elseif ($key == "end_date") : ?>
                                    <td><input type="date" name="<?= $key; ?>" value="<?= $value; ?>" required></td>

                                    <!-- Email -->
                                <?php elseif ($key == "email") : ?>
                                    <td><input type="email" name="<?= $key; ?>" value="<?= $value; ?>" required></td>

                                    <!-- Text -->
                                <?php else : ?>
                                    <td><input type="text" name="<?= $key; ?>" value="<?= $value; ?>" required></td>
                                <?php endif; ?>

                            <?php endforeach; ?>
                            <td><input type=submit value="Submit changes"></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>

        <?php elseif ($edited = true) : ?>

            <h1>Succesfully updated data!</h1>
            <a href='view.php'><input type=button value='Click here to go back'></a>

        <?php else : ?>

            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley">
                <h1>Error displaying table, please select a table to display</h1>
            </a>

        <?php endif; ?>



    </body>
    </html>