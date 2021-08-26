<html>

<head>
    <title>Your Array</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <h1>Your Array</h1>

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
    //NOTE: Using echo in conjunction with "<br>" (or any html tags) will cause them to be used like in html, in this case to break into a new line
    echo "Your array size is: " . $rows . " x " . $columns . "<br>";
    echo "Your min. value is: " . $min . "<br>";
    echo "Your max value is: " . $max . "<br>";

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
        ?>

    </table>
    <a href="arrayDemo.html" class="button"><button>Go Back</button></a>
</body>

</html>