<!DOCTYPE html>
<html>
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="pragma" content="no-cache" />

<head>
    <title>Homework 8</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" type="image/png" href="images/soupLogo.png" />
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
    <?php
    echo "<div class=\"page-wrapper\">";
    echo "<div class=\"center\"><a href=\"manager.html\"><button>Return</button></a></div>";
    //taken from example code in class and modified to fit this assignment
    //open a connection - give address, user name, password, database
    $mysqli = new mysqli("localhost", "root", "", "sakila");
    if ($mysqli->connect_error) {
        exit('Error connecting to database'); //Should be a message a typical user could understand in production
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli->set_charset("utf8mb4");
    $stmt = $mysqli->prepare("SELECT first_name, last_name, address.address, city.city, address.district, address.postal_code, customer.customer_id, film.title
    FROM customer
    INNER JOIN address on customer.address_id = address.address_id
    INNER JOIN city ON address.city_id = city.city_id
    INNER JOIN rental ON customer.customer_id = rental.customer_id
    INNER JOIN inventory ON rental.inventory_id = inventory.inventory_id 
    INNER JOIN film ON inventory.film_id = film.film_id
    ORDER BY last_name;");
    $stmt->execute(); //submit the query to DB
    $result = $stmt->get_result(); //get the results
    if ($result->num_rows === 0) exit('No rows');

    //html table header output
    echo "<div class=\"center\"><h4>CUSTOMERS</h4></div>";
    echo "<table><tr><th>Last Name</th>
            <th>First Name</th>
            <th>Address</th>
            <th>City</th>
            <th>District</th>
            <th>Postal Code</th>
            <th>List of Films</th></tr>";

    //arrays to hold the database values
    $first_name = [];
    $last_name = [];
    $address = [];
    $city = [];
    $district = [];
    $postal_code = [];
    $customer_id = [];
    $movies = [];
    /*each array is filled with its associated statistics. 
    The query used has repeats of the same customer with a different movie title,
     so the if/else statement takes care of that*/
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row['customer_id'], $customer_id, true)) {
            array_push($first_name, $row['first_name']);
            array_push($last_name, $row['last_name']);
            array_push($address, $row['address']);
            array_push($city, $row['city']);
            array_push($district, $row['district']);
            array_push($postal_code, $row['postal_code']);
            array_push($customer_id, $row['customer_id']);
            array_push($movies, $row['title']);
        } else {
            //adds each movie individually separated by a comma
            $movies[count($movies) - 1] = $movies[count($movies) - 1] . "," . $row['title'];
        }
    }
    //table data output of the arrays
    for ($i = 0; $i < count($first_name); $i++) {
        echo "<tr><td>" . $last_name[$i] . "</td>
        <td>" . $first_name[$i] . "</td>
        <td>" . $address[$i] . "</td>
        <td>" . $city[$i] . "</td>
        <td>" . $district[$i] . "</td>
        <td>" . $postal_code[$i] . "</td>
        <td>" . $movies[$i] . "</td></tr>";
    }


    print("</table>");
    echo "</div>";
    $stmt->close();
    $mysqli->close();
    //close the html tags and close the sql server connections
    ?>
</body>

</html>