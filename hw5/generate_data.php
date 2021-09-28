<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php 
        //Source: generate_data.php from Data.sql example
        function get_array_data($fileName) {
            $handle = fopen($fileName,"r");
            while (!feof($handle)) {
                $value = fgets($handle); //read a value (one line)
                $value = str_replace(array("\n", "\r"), '', $value);  //remove newlines
                if(!feof($handle)) {
                    $values[] = $value;		
                }
            }
            fclose($handle);
            return $values;
        }

        //Source: generate_data.php from Data.sql example
        //$handle - file handle open for writing
		//$database - name of database to write to, as a string
		//$table - name of the table to write to, as a string
		//$columns - list of names of columns, 1D array, (Strings)
		//$values - 2D array, one record per row, of the values that actually go into the database. Note*** The values in this array must already have the single quotes around each value. Note2*** Int's do not require a quote around the value - so don't put a quote around it in your array.
        function write_table($handle, $database, $table, $columns, $values) {
            fwrite($handle, "use $database;\n\n");
            fwrite($handle, "SET AUTOCOMMIT=0;\n\n");
            //from DBeaver
            //INSERT INTO moviestore4.actor (first_name,last_name) VALUES ('Fred','Schwab');
            fwrite($handle, "INSERT INTO $database.$table (");
            for($i = 0; $i < sizeof($columns); $i++) {
                fwrite($handle, $columns[$i]);
                if($i!= sizeof($columns)-1) { // if not the last value, print comma
                    fwrite($handle, ",");
                }
            }
            fwrite($handle, ") VALUES\n");
            
            for($i = 0; $i < sizeof($values); $i++) {
                fwrite($handle, "(");
                for($j = 0; $j < sizeof($values[$i]); $j++) {
                    fwrite($handle, $values[$i][$j]);
                    if($j != sizeof($values[$i]) - 1) { //if not at last value, print comma
                       fwrite($handle, ","); 
                    }
                }
                if($i != sizeof($values)-1) { //not at last one
                    fwrite($handle, "),\n");
                } else {
                    fwrite($handle, ");\n\nCOMMIT;");
                }

            }
        }

        //Arrays of data
        $street_names = get_array_data("street_names.txt");
        $street_types = get_array_data("street_types.txt");
        $cities = get_array_data("cities.txt");
        $states = get_array_data("states.txt");
        $first_names = get_array_data("first_names.txt");
        $last_names = get_array_data("last_names.txt");
        $domains = get_array_data("domains.txt");
        $product_names = get_array_data("products.txt");

        //Table column names for inserting
        $customer_columns = array("first_name", "last_name", "email", "phone", "address_id");
        $order_columns = array("customer_id", "address_id");
        $product_columns = array("product_name", "description", "weight", "base_cost");
        $order_item_columns = array("order_id", "product_id", "quantity", "price");
        $address_columns = array("street", "city", "state", "zip");
        $warehouse_columns = array("name", "address_id");
        $product_warehouse_columns = array("product_id", "warehouse_id");

        //Constants for # of rows of data in each table
        const NUM_CUSTOMER = 100;
        const NUM_ORDER = 350;
        const NUM_PRODUCT = 750;
        const NUM_ORDER_ITEM = 550;
        const NUM_ADDRESS = 150;
        const NUM_WAREHOUSE = 25;
        const NUM_PRODUCT_WAREHOUSE = 1250;
        /*echo "<pre>";
        print_r($street_names);
        print_r($street_types);
        print_r($cities);
        print_r($states);
        print_r($first_names);
        print_r($last_names);
        print_r($domains);
        print_r($products);
        echo "</pre>";
        */

        //Creating $values arrays for the write_table function
        //Address
        for($i = 0; $i < NUM_ADDRESS; $i++) {
            $temp_street = rand(1,9999)." ".$street_names[rand(0, sizeof($street_names) - 1)]." ".$street_types[rand(0, sizeof($street_types) - 1)];

            $addresses[$i][0] = "'".$temp_street."'";
            $addresses[$i][1] = "'".$cities[rand(0, sizeof($cities) - 1)]."'";
            $addresses[$i][2] = "'".$states[rand(0, sizeof($states) - 1)]."'";
            $addresses[$i][3] = "'".rand(10000, 99999)."'";
        }

        //Customer
        for($i = 0; $i < NUM_CUSTOMER; $i++) {
            $temp_fname = $first_names[rand(0, sizeof($first_names) - 1)];
            $temp_lname = $last_names[rand(0, sizeof($last_names) - 1)];

            $customers[$i][0] = "'".$temp_fname."'";
            $customers[$i][1] = "'".$temp_lname."'";
            $customers[$i][2] = "'".$temp_fname.".".$temp_lname.$domains[rand(0, sizeof($domains) - 1)]."'";
            //CHECK: is this code for generating a phone number ok?
            $customers[$i][3] = "'(".rand(100, 999).")".rand(100, 999)."-".rand(1000, 9999)."'";
            $customers[$i][4] = "'".rand(1, NUM_ADDRESS)."'";
        }
        
        //Order
        for($i = 0; $i < NUM_ORDER; $i++) {
            $orders[$i][0] = "'".rand(1, NUM_CUSTOMER)."'";
            $orders[$i][1] = "'".rand(1, NUM_ADDRESS)."'";
        }

        //Product
        for($i = 0; $i < NUM_PRODUCT; $i++) {
            $temp_product_name = $product_names[rand(0, sizeof($product_names) - 1)];
            $products[$i][0] = "'".$temp_product_name."'";
            $products[$i][1] = "'A wonderful".$temp_product_name."for you to enjoy.'";
            //IMPLEMENT: weight as Decimal(6,2)
            //possibly use number_format($rand_price, 2, ".", "");
            //the number_format below makes a number that is 6 digits long, 2 of those decimal
            $products[$i][2] = "'".number_format(rand(101,999999)/100, 2, ".", "")."'";
            //IMPLEMENT: base_cost as Decimal(13,2)
            //using 101 as a boundary because it will create 1.01 as the lowest value instead of 0 or 1, which are not decimal values
            $products[$i][3] = "'".number_format(rand(101,999999999999999)/100, 2, ".", "")."'";
        }

        //Warehouse
        for($i = 0; $i < NUM_WAREHOUSE; $i++) {
            //NOTE: just used the format Warehouse0, Warehouse1, Warehouse2, etc for warehouse names
            $warehouses[$i][0] = "'Warehouse".$i."'";
            $warehouses[$i][1] = "'".rand(1, NUM_ADDRESS)."'";
        }

        //Order_item
        for($i = 0; $i < NUM_ORDER_ITEM; $i++) {
            $temp_quantity = rand(1, 99);
            $order_items[$i][0] = "'".rand(1, NUM_ORDER)."'";
            $order_items[$i][1] = "'".rand(1, NUM_PRODUCT)."'";
            $order_items[$i][2] = "'".$temp_quantity."'";
            //IMPLEMENT: how to multiply base_cost of Product table with quantity?
            $order_items[$i][2] = "'[PLACEHOLDER 3]'";
        }

        //Product_warehouse
        for($i = 0; $i < NUM_PRODUCT_WAREHOUSE; $i++) {
            $product_warehouses[$i][0] = "'".rand(1, NUM_PRODUCT)."'";
            $product_warehouses[$i][1] = "'".rand(1, NUM_WAREHOUSE)."'";
        }

        echo "<pre>";
        echo "ADDRESSES";
        print_r($addresses);
        echo "CUSTOMERS";
        print_r($customers);
        echo "ORDERS";
        print_r($orders);
        echo "PRODUCTS";
        print_r($products);
        echo "WAREHOUSES";
        print_r($warehouses);
        echo "ORDER_ITEMS";
        print_r($order_items);
        echo "PRODUCT_WAREHOUSES";
        print_r($product_warehouses);
        echo "</pre>";


        //TABLE CREATION

        //ADDRESS
        
        //CUSTOMER

        //ORDER

        //PRODUCT

        //WAREHOUSE

        //ORDER_ITEM

        //PRODUCT_WAREHOUSE

        

        
        
        ?>
    </body>
</html>