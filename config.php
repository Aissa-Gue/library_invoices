<?php
//ignore php errors
//error_reporting(E_ERROR | E_PARSE);
// variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_invoices_db";


$con = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($con, $dbname);

if (!$db_selected) {
    $createDb = "CREATE DATABASE library_invoices_db";
    mysqli_query($con, $createDb);
    include 'create_empty_db.php';
}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo 'Failed to connect to database' . mysqli_connect_error();
}

// current date
$date = date('Y-m-d H:i:s', time());

//arabic lang chars
mysqli_set_charset($conn, 'utf8');
$ProjTitle = "برنامج الفواتير";