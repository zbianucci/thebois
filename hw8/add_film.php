<!DOCTYPE html>
<html>

<head>
    <title>Add Film</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Homework 8</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="header">
        <div class="center">
            <h1>Homework 8</h1>
        </div>
        <div class="center">
            <h2>Abiezer DeJesus & Zach Bianucci</h2>
        </div>
    </div>

    <div class="page-wrapper">

        <?php
        $title = $_POST["title"];
        $description = $_POST["description"];
        $release_year = $_POST["release_year"];
        $language_id = $_POST["language_id"];
        $rental_duration = $_POST["rental_duration"];
        $rental_rate = $_POST["rental_rate"];
        $length = $_POST["length"];
        $replacement_cost = $_POST["replacement_cost"];
        $rating = $_POST["rating"];
        $special_features = $_POST["special_features"];

        $mysqli = new mysqli("localhost", "root", "", "sakila");
        if ($mysqli->connect_error) {
            exit('Error connecting to database'); //Should be a message a typical user could understand in production
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli->set_charset("utf8mb4");


        try {
            $stmt = $mysqli->prepare("INSERT INTO sakila.film(title, description, release_year, language_id, rental_duration,
            rental_rate, length, replacement_cost, rating, special_features)
            VALUES ('$title', '$description', $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, '$rating', '$special_features');");
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            echo "Success!";
        } catch (mysqli_sql_exception) {
            echo "There was an error inserting the row.";
        }

        echo "<div class=\"center\"><a href=\"manager.html\"><button>Return</button></a></div>";
        ?>

    </div>
</body>

</html>

</html>