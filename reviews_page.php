<?php

require_once("connection.php");

$sthhouse = $pdo->prepare("SELECT * FROM `house_images` WHERE house_id = :house_id");
$sthhouse->bindParam(':house_id', $_GET['house_id'], PDO::PARAM_INT);
$sthhouse->execute();
$houseImages = $sthhouse->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Review</title>
    </head>
    <body>
        <nav class="ReviewpageNavbar">
            <a href="index.php">Home</a>
            <a href="view.php?table=houses">Houses</a>
            <a href="loguit.php">Loguit</a>
        </nav>
        <h1>Review</h1>
        <div class="review">
            <?php if (empty($houseImages)) { ?>
                <p>Sorry, er zijn geen plaatjes gevonden van dit huis</p>
            <?php } else { ?>    
                <?php foreach ($houseImages as $image) { ?>
                    <img src="./images-loading/house_pfp.php?id=<?= htmlspecialchars($image['id']); ?>" alt="House Foto">
                <?php } ?>
            <?php } ?>
            <form method="POST">
                <p><label for="rating">Rating (tussen de 0 en de 10):</label></p>
                <p><input type="number" id="rating" name="rating" step="0.01" min="0" max="10" required></p>
                <p><label for="review">Comment:</label></p>
                <p><textarea id="review" name="review" required></textarea></p>
                <p><input type="hidden" name="house_id" value="<?= htmlspecialchars($_GET['house_id']); ?>"></p>
                <p><input type="hidden" name="reviewer_id" value="<?= 27; ?>"></p>
                <p><input type="submit" value="Submit"></p>
            </form>    
        </div>
        <script>
            document.querySelector("form").addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());
                try {
                    const response = await fetch("api/reviews_api.php", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    if (response.ok) {
                        window.location.href = "view.php?table=reviews";
                    } else {
                        const errorData = await response.json();
                        throw new Error(errorData.error || 'Server responded with an error');
                    }
                } catch (error) {
                    alert("Er is iets fout gegaan: " + error.message);
                }
            });
        </script>
    </body>
</html>