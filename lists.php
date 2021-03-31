<?php
include 'check.php';

//Select all clients
$selectClientsQry = "SELECT client_id, last_name, first_name, father_name FROM a_clients";
$ClientsListResult = mysqli_query($conn, $selectClientsQry);
$rowsClient = mysqli_fetch_all($ClientsListResult, MYSQLI_ASSOC);
$lastClientKey = key(array_slice($rowsClient, -1, 1, true));

//Select all books
$selectBooksQry = "SELECT book_id, title FROM b_books";
$booksListResult = mysqli_query($conn, $selectBooksQry);
$rowsBooks = mysqli_fetch_all($booksListResult, MYSQLI_ASSOC);
$lastBookKey = key(array_slice($rowsBooks, -1, 1, true));