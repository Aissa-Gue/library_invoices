<?php
include 'header.php';
include 'lists.php';

// Select last (client_id)
$lastOrderIdQry = "SELECT max(order_id) FROM `c_orders`";
$lastOrderIdResult = mysqli_query($conn, $lastOrderIdQry);
$rowOrderId = mysqli_fetch_row($lastOrderIdResult);
$lastOrderIdKey = $rowOrderId[0];

// Select all order books
$OrderBooksQry = "SELECT c_orders.order_id, c_orders.client_id, c_orders.type_id, type_name, 
discount_percentage, d_orders_books.book_id, title, d_orders_books.quantity, 
d_orders_books.purchase_price, d_orders_books.sale_price, paid_amount,  c_orders.creation_date, c_orders.last_edit_date
FROM c_orders
INNER JOIN d_orders_books ON d_orders_books.order_id = c_orders.order_id
INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
INNER JOIN a_clients ON a_clients.client_id = c_orders.client_id
INNER JOIN types ON types.type_id = c_orders.type_id
WHERE c_orders.order_id = 1";

// Insert Order
if (isset($_POST['insertOrder'])) {
    $order_id = $_POST['order_id'];

    $client_explode = explode(' # ', $_POST['client_name']);
    $client_id = $client_explode[0]; // multi

    $type_id = $_POST['type_id'];
    $discount_percentage = $_POST['discount_percentage'];
    $paid_amount = $_POST['paid_amount'];

    $book_explode = explode(' # ', $_POST['book_title']);
    $book_id = $book_explode[0]; // multi

    $quantity = $_POST['quantity'];

    $purchase_price = $_POST['purchase_price'];
    $sale_price = $_POST['sale_price'];

    $creation_date = $date;
    $last_edit_date = $date;

    $insertOrderQry = "INSERT INTO c_orders VALUES ('$order_id', '$client_id', '$type_id', '$discount_percentage', '$paid_amount', '$creation_date', '$last_edit_date')";
    $insertOrderBookQry = "INSERT INTO d_orders_books
    (SELECT $order_id, $book_id, $quantity, purchase_price, sale_price
    FROM b_books WHERE book_id = $book_id)";
    // $insertOrderBookQry = "INSERT INTO d_orders_books VALUES ($order_id, $book_id, $quantity, $purchase_price, $sale_price)";

    /* Tell mysqli to throw an exception if an error occurs */
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    /* Start transaction */
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, $insertOrderQry);
        mysqli_query($conn, $insertOrderBookQry);

        mysqli_commit($conn);
        echo "<script>alert('تم إضافة الفاتورة: $order_id بنجاح')</script>";
        echo '<script>window.location.href = "insertOrder.php#insertOrder"</script>';
    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($conn);
        throw $exception;
        echo "<script>alert('فشلت عملية إضافة الفاتورة')</script>";
        echo '<script>window.location.href = "insertOrder.php#insertOrder"</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $ProjTitle ?></title>
</head>

<body class="my_bg">
    <!-- START row -->
    <div class="container-fluid mt-5 py-2">

        <?php include "sideBar.php" ?>

        <div class="col-10 my_mr_sidebar">
            <div class="tab-content" id="tabContent">
                <!-- Insert client -->
                <div class="tab-pane fade mt-3" id="insertOrder">

                    <div class="alert alert-primary text-center" role="alert">
                        <h4>إضافة فاتورة</h4>
                    </div>
                    <form action="" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="order_id">رقم الفاتورة</label>
                                <input type="number" class="form-control text-center" name="order_id" id="order_id"
                                    value="<?php echo $lastOrderIdKey + 1 ?>" placeholder="أدخل رقم الفاتورة">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="type_id">نوع الفاتورة</label>
                                <select class="custom-select" name="type_id" id="type_id">
                                    <option value="1">بيع</option>
                                    <option value="2">معرض</option>
                                    <option value="3">إهداء</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="client_name">الزبون</label>
                                <input list="clients" class="form-control" name="client_name" id="client_name"
                                    placeholder="أدخل اسم الزبون" required>
                                <datalist id="clients">
                                    <?php
                                    for ($i = 0; $i <= $lastClientKey; $i++) { ?>
                                    <option
                                        value="<?php print_r($rowsClient[$i]['client_id'] . ' # ' . $rowsClient[$i]['last_name'] . ' ' . $rowsClient[$i]['first_name'] . ' بن ' . $rowsClient[$i]['father_name']) ?>">
                                        <?php  } ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="discount_percentage">نسبة التخفيض</label>
                                <input type="number" class="form-control" name="discount_percentage"
                                    id="discount_percentage" placeholder="أدخل نسبة التخفيض">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="paid_amount">المبلغ المدفوع</label>
                                <input type="number" class="form-control" name="paid_amount" id="paid_amount"
                                    placeholder="أدخل المبلغ المدفوع">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-5">
                                <label for="book_title">عنوان الكتاب</label>
                            </div>
                            <div class="col-md-1">
                                <label for="quantity">الكمية</label>
                            </div>
                            <div class="col-md-2">
                                <label for="purchase_price">سعر الشراء</label>
                            </div>
                            <div class="col-md-2">
                                <label for="sale_price">سعر البيع</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <input list="books" class="form-control" name="book_title" id="book_title"
                                    placeholder="أدخل عنوان الكتاب" required>
                                <datalist id="books">
                                    <?php
                                    for ($i = 0; $i <= $lastBookKey; $i++) { ?>
                                    <option
                                        value="<?php print_r($rowsBooks[$i]['book_id'] . ' # ' . $rowsBooks[$i]['title']) ?>">
                                        <?php  } ?>
                                </datalist>
                            </div>

                            <div class="form-group col-md-1">
                                <input type="number" class="form-control text-center" name="quantity" id="quantity"
                                    placeholder="أدخل الكمية" required>
                            </div>

                            <div class="form-group col-md-2">
                                <input type="number" class="form-control text-center" value="<?php ?>"
                                    name="purchase_price" id="purchase_price">
                            </div>

                            <div class="form-group col-md-2">
                                <input type="number" class="form-control text-center" value="<?php?>" name="sale_price"
                                    id="sale_price">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-success" name="insertOrder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z" />
                                    </svg>
                                </button>
                                <a class="btn btn-outline-danger"
                                    href="delete.php?del_order_book_id=<?php echo $row['order_id'] ?>&book_id=<?php echo $row['book_id'] ?>&title=<?php echo $row['title'] ?>'"
                                    onclick="return confirm('هل أنت متأكد؟')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="form-row justify-content-end">
                            <div class="form-group col-md-2">
                                <button type="submit" name="insertOrderr"
                                    class="btn btn-success btn-block btn-lg rounded-pill">إضافة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
scrollTop();
storeSelectedTab();
</script>

</html>