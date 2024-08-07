<?php

include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

</head>
<body class= buttons>
    <div class="container">
        <h1>Welkom bekijk hier alle data!</h1>
        <a href="view.php" class="button">bekijk data</a>
        <a href="seeder/seeder.php" class="button">voer seeder uit</a>    
        <a href="test2.php" class="button">bekijk api</a>

  <?php 
    if (isset($_GET['seeder'])) :    ?>  
  <h1>seeder uitgevoerd!</h1>
    <?php endif;
    ?>
    </div>
</body>
</html>
