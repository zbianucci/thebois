<!DOCTYPE html>
<!--	Author: Mike O'Kane
		Date:	December, 2007
		File:	add-two-improved.php
		Purpose:PHP Practice
-->
<html>

<head>
    <title>Your Array</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- <PHP>
        <link rel="stylesheet" type="text/css" href="style.css">
    </PHP> -->
    <title>Chatta-Soup-A</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" type="image/png" href="images/soupLogo.png" />
</head>

<body>
    <div class="header">
        <div class="center">
            <h1>Chatta-Soup-A</h1>
        </div>
        <div class="center">
            <h2>Sweetening Your Soup Since 2021</h2>
        </div>
    </div>

    <div class="page-wrapper">

        <!-- START OF PHP -->
        <?php

        // Credit to https://stackoverflow.com/questions/21885150/stats-standard-deviation-in-php-5-2-13
        // for the standard deviation function below
        function std_deviation($arr)
        {
            $arr_size = count($arr);
            $mu = array_sum($arr) / $arr_size;
            $ans = 0;
            foreach ($arr as $elem) {
                $ans += pow(($elem - $mu), 2);
            }
            return sqrt($ans / $arr_size);
        }

        //Declaring variables from user input
        //The string in the square brackets is the name attribute given from the html form
        $rows = $_POST["rows"];
        $columns = $_POST["columns"];
        $min = $_POST["min"];
        $max = $_POST["max"];

        //Declaring array
        $array = array();
        //Printing information about the array from user input
        //NOTE: Using echo in conjunction with "<p>" (or any html tags) will cause them to be used like in html, in this case to break into a new line
        if (is_numeric($rows) && is_numeric($columns) && is_numeric($min) && is_numeric($max)) {
            if ($min < $max && $columns > 0 && $rows > 0) {
                echo "<div class=center>";
                echo "<p>Your array size is: " . $rows . " x " . $columns . "</p>";
                echo "<p>Your min. value is: " . $min . "</p>";
                echo "<p>Your max value is: " . $max . "</p></div>";


                //Assigns values to each cell according to criteria given by user
                for ($r = 0; $r < $rows; $r++) {
                    for ($c = 0; $c < $columns; $c++) {
                        $array[$r][$c] = rand($min, $max);
                    }
                }

        ?>
                <!-- END OF PHP -->

                <!-- Constructing table that displays the array -->
                <table>
                    <!-- PHP to assign values from array to table cells -->
                    <?php
                    for ($r = 0; $r < $rows; $r++) {
                        echo "<tr>";
                        for ($c = 0; $c < $columns; $c++) {
                            echo "<td>" . $array[$r][$c] . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>

                <!-- Constructing table that displays arithmetic for each table's rows -->
                <table>
                    <!-- Table headers -->
                    <tr>
                        <th>Row</th>
                        <th>Sum</th>
                        <th>Avg</th>
                        <th>Std Dev</th>
                    </tr>

                    <!-- PHP to calculate arithmetic and assign the values to table cells -->
                    <?php
                    for ($r = 0; $r < $rows; $r++) {
                        echo "<tr>";
                        echo "<td>" . $r . "</td>";
                        echo "<td>" . number_format(array_sum($array[$r]), 3);
                        echo "<td>" . number_format((array_sum($array[$r]) / count($array[$r])), 3);
                        echo "<td>" . number_format(std_deviation($array[$r]), 3);
                        echo "</tr>";
                    }
                    ?>

                </table>

                <!-- Constructing table that displays if element is positive or negative -->
                <table>
            <?php
                for ($r = 0; $r < $rows; $r++) {
                    echo "<tr>";
                    for ($c = 0; $c < $columns; $c++) {
                        echo "<td>" . $array[$r][$c] . "</td>";
                    }
                    echo "</tr>";

                    //This section is needed in order to insert another row right after a row has been printed
                    //that will show if the previous row is positive, negative, or zero
                    echo "<tr>";
                    for ($c = 0; $c < $columns; $c++) {
                        if ($array[$r][$c] > 0) {
                            echo "<td>positive</td>";
                        } elseif ($array[$r][$c] < 0) {
                            echo "<td>negative</td>";
                        } else {
                            echo "<td>zero</td>";
                        }
                    }
                    echo "</tr>";
                }
            } else {
                echo "<div class=\"center\"><p>Please make sure that the minimum value is smaller than the maximum value, and that there are at least one row and one column.</p></div>";
            }
        } else {
            echo "<div class=\"center\"><p>Please make sure all entries have a valid whole number inserted</p></div>";
        }
            ?>

                </table>
                <div class="center">
                    <a href="arrayDemo.html" class="button"><button>Go Back</button></a>
                </div>
    </div>
</body>

</html>

</html>