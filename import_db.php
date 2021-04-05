<?php
include 'check.php';
//ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
set_time_limit(600); //used to temporarily extend the time limit.

if (isset($_FILES['db'])) {
    $file = $_FILES['db'];
    $file_name = $_FILES['db']['name'];
    $file_type = $_FILES['db']['type'];
    $file_size = $_FILES['db']['size'];
    $file_temp = $_FILES['db']['tmp_name'];
    move_uploaded_file($file_temp, "$file_name");


    function restoreDatabaseTables($servername, $username, $password, $dbname, $filePath)
    {
        $conn = mysqli_connect($servername, $username, $password);

        //drop existing db
        $sql_drop_db = "DROP DATABASE $dbname";
        if (mysqli_query($conn, $sql_drop_db)) {
            echo "db droped successfully";
        }

        $db_selected = mysqli_select_db($conn, $dbname);
        if (!$db_selected) {
            //create new DB if it dosn't exist.
            $sql = "CREATE DATABASE $dbname";
            if (mysqli_query($conn, $sql)) {
                echo "Database $dbname created successfully\n";
            } else {
                echo 'Error creating database: ' . mysqli_error($conn) . "\n";
            }
        }

        // Connect & select the database
        $db = new mysqli($servername, $username, $password, $dbname);

        // Temporary variable, used to store current query
        $templine = '';

        // Read in entire file
        $lines = file($filePath);

        $error = '';

        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            // Add this line to the current segment
            $templine .= $line;

            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                if (!$db->query($templine)) {
                    $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
                }

                // Reset temp variable to empty
                $templine = '';
            }
        }
        return !empty($error) ? $error : true;
    }


    $filePath   = $file_name;
    if (
        restoreDatabaseTables($servername, $username, $password, $dbname, $filePath)
        and $file_name != ""
    ) {
        unlink("$file_name");
        echo "<script>alert('تمت إضافة قاعدة البيانات بنجاح!')</script>";
        echo '<script>window.location.href = "settings.php#settings"</script>'; // redirect to home.php
    } else {
        echo "<script>alert('حدثت مشكلة: لم يتم إضافة قاعدة البيانات!')</script>";
        echo '<script>window.location.href = "settings.php#settings"</script>'; // redirect to home.php
    }
}