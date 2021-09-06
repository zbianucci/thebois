<!DOCTYPE html>
<html>
<head>
<title>Your Array</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Chatta-Soup-A</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php

    //Array of first names
    $first_names = fopen("first_names.csv", "r");

    $first_names_string = fgets($first_names);

    $first_names_array = explode(",", $first_names_string);
    $first_names_array = str_replace(array("\n", "\r"), '', $first_names_array);

    echo "First names";
    echo "<pre>";
    print_r($first_names_array);
    echo "</pre>";

    fclose($first_names);
    //End of first names

    //Array of last names
    $last_names = fopen("last_names.txt", "r");
    $last_names_array = array();

    while (!feof($last_names)) {
        $lastname = fgets($last_names);

        if (!feof($last_names)) {
            $last_names_array[] = $lastname;
        }
    }

    $last_names_array = str_replace(array("\n", "\r"), '', $last_names_array);

    echo "Last names";
    echo "<pre>";
    print_r($last_names_array);
    echo "</pre>";

    fclose($last_names);
    //End of last names

    //Array of street names
    $street_names = fopen("street_names.txt", "r");
    $street_names_string = '';

    while (!feof($street_names)) {
        $street_names_string .= fgets($street_names);
    }

    $street_names_array = explode(":", $street_names_string);
    $street_names_array = str_replace(array("\n", "\r"), '', $street_names_array);

    echo "Street names";
    echo "<pre>";
    print_r($street_names_array);
    echo "</pre>";

    fclose($street_names);
    //End of street names

    //Array of street types
    $street_types = fopen("street_types.txt", "r");
    $street_types_string = fgets($street_types);
    $street_types_array = explode("..;", $street_types_string);
    $street_types_array = str_replace(array("\n", "\r"), '', $street_types_array);

    echo "Street types";
    echo "<pre>";
    print_r($street_types_array);
    echo "</pre>";

    fclose($street_types);
    //End of street types

    //Array of domain names
    $domains = fopen("domains.txt", "r");
    $domains_string = fgets($domains);
    $first_domains_array = explode(".", $domains_string);
    $first_domains_array = str_replace(array("\n", "\r"), '', $first_domains_array);
    $domains_array = array();


    for ($i = 0; $i < count($first_domains_array); $i += 2) {
        $domains_array[] = $first_domains_array[$i] . "." . $first_domains_array[$i + 1];
    }

    echo "Domains";
    echo "<pre>";
    print_r($domains_array);
    echo "</pre>";

    fclose($domains);
    //End of domain names

    //Arrays: $first_names_array, $last_names_array, $street_names_array, $street_types_array, $domains_array
    //Copied and changed the code for our table from hw2

    //Table headers
    echo "<table><tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Address</th>
    <th>Email</th></tr>";

    //table contents
    $customers = fopen("customers.txt", "w");
    for ($i = 0; $i < 25; $i++) {
        $fname = $first_names_array[$i];
        $lname = $last_names_array[$i];
        $address = ($i+1).rand(1,99)." ".$street_names_array[$i]." ".$street_types_array[rand(0,count($street_types_array)-1)];
        $email = $first_names_array[$i].".".$last_names_array[$i]."@".$domains_array[rand(0,count($domains_array)-1)];
        
        //output to the customers.txt file
        fwrite($customers,$fname.":".$lname.":".$address.":".$email."\n");

        //output to the table
        echo "<tr>
        <td>".$fname."</td>
        <td>".$lname."</td>
        <td>".$address."</td>
        <td>".$email."</td>
        </tr>";
        }

    

    fclose($customers);
    echo "</table>";
    ?>
</body>

</html>