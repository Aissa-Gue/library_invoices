<?php
include 'check.php';
include 'header.php';

// GET values from ordersList.php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $client_id = $_GET['client_id'];
    $type = $_GET['type'];
    $discount_percentage = $_GET['discount_percentage'];
    $paid_amount = $_GET['paid_amount'];
    $creation_date = $_GET['creation_date'];
    $last_edit_date = $_GET['last_edit_date'];
    $last_name = $_GET['last_name'];
    $first_name = $_GET['first_name'];
    $father_name = $_GET['father_name'];
}

// Get data from d_orders-books table
$ordersBooksQry = "SELECT d_orders_books.order_id ,
d_orders_books.book_id,
d_orders_books.quantity,
d_orders_books.purchase_price,
d_orders_books.sale_price,
b_books.book_id,
b_books.title,
b_books.discount
FROM d_orders_books, b_books
WHERE order_id = $order_id AND d_orders_books.book_id = b_books.book_id";

$sumQry = "SELECT
SUM(d_orders_books.quantity) as quantity_sum,
SUM(d_orders_books.quantity * d_orders_books.purchase_price) as purchase_price_sum
-- SUM(d_orders_books.quantity * d_orders_books.sale_price) as sale_price_sum
FROM d_orders_books, b_books
WHERE order_id = $order_id AND d_orders_books.book_id = b_books.book_id
GROUP BY d_orders_books.order_id";

$ordersBooksResult = mysqli_query($conn, $ordersBooksQry);

$sumQryResult = mysqli_query($conn, $sumQry);

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $ProjTitle ?></title>
</head>

<body class="my_bg">
    <div class="container-fluid mt-5 py-2">

        <?php include "sideBar.php" ?>

        <div class="col-10 my_mr_sidebar pt-3">
            <div class="alert alert-warning text-center h4" role="alert">
                معلومات الفاتورة
            </div>

            <form action="editOrder.php" method="post" enctype="multipart/form-data">
                <!-- 1st row -->
                <div class="row mt-3">
                    <div class="col-md-2 ">
                        <label for="order_id" class="form-label">رقم الفاتورة</label>
                        <input type="number" class="form-control text-center" value="<?php echo $order_id ?>"
                            name="order_id" id="order_id" disabled>
                        <input type="number" class="form-control text-center" value="<?php echo $order_id ?>"
                            name="prev_id" hidden>
                    </div>

                    <div class="col-md-3">
                        <label for="creation_date" class="form-label">تاريخ الفاتورة</label>
                        <input type="text" class="form-control" value="<?php echo $creation_date ?>" id="creation_date"
                            disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="last_edit_date" class="form-label">تاريخ آخر تعديل</label>
                        <input type="text" class="form-control" value="<?php echo $last_edit_date ?>"
                            id="last_edit_date" disabled>
                    </div>
                </div>
                <!-- 2nd row -->
                <div class="row mt-3">
                    <div class="col-md-5">
                        <label for="client_id" class="form-label">الزبون</label>
                        <input type="text" class="form-control"
                            value="<?php echo $last_name . ' ' . $first_name . ' بن ' . $father_name ?>"
                            name="client_id" id="client_id" disabled>
                    </div>
                    <div class="col-md-2">
                        <label for="discount_percentage" class="form-label">نسبة التخفيض</label>
                        <input type="text" class="form-control" value="<?php echo '% ' . $discount_percentage ?>"
                            name="discount_percentage" id="discount_percentage" disabled>
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount" class="form-label">المبلغ المدفوع</label>
                        <input type="text" class="form-control" value="<?php echo $paid_amount ?>" name="paid_amount"
                            id="paid_amount" disabled>
                    </div>
                </div>

                <!-- 3rd row -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="title" class="form-label">عنوان الكتاب</label>
                    </div>

                    <div class="col-md-2">
                        <label for="purchase_price">سعر الشراء</label>
                    </div>
                    <div class="col-md-2">
                        <label for="sale_price">سعر البيع</label>
                    </div>

                    <div class="col-md-1">
                        <label for="quantity">الكمية</label>
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount">السعر الإجمالي للشراء</label>
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount">السعر الإجمالي للبيع</label>
                    </div>
                </div>

                <?php
                $sale_price_sum1 = $sale_price_sum2 = 0;

                while ($row = mysqli_fetch_array($ordersBooksResult)) {
                    //calculate sum
                    if ($row['discount'] == 1) {
                        // sum of discounted books
                        $sale_price_sum1 = $sale_price_sum1 + $row['sale_price'] * $row['quantity'];
                    } else {
                        // sum of undiscounted books
                        $sale_price_sum2 = $sale_price_sum2 + $row['sale_price'] * $row['quantity'];
                    }
                ?>
                <div class="row mt-1">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="title" id="title"
                            value="<?php echo $row['title']; ?>" disabled>
                    </div>

                    <div class="col-md-2">
                        <input type="number" class="form-control" name="purchase_price" id="purchase_price"
                            value="<?php echo $row['purchase_price']; ?>" disabled>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="sale_price" id="sale_price"
                            value="<?php echo $row['sale_price']; ?>" disabled>
                    </div>

                    <div class="col-md-1">
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            value="<?php echo $row['quantity']; ?>" disabled>
                    </div>

                    <div class="col-md-2">
                        <input type="text" class="form-control" name="total_purchase_price" id="total_purchase_price"
                            value="<?php echo $row['purchase_price'] * $row['quantity'] ?>" disabled>
                    </div>

                    <div class="col-md-2">
                        <input type="text" class="form-control" name="total_sale_price" id="total_sale_price"
                            value="<?php echo $row['sale_price'] * $row['quantity']; ?>" disabled>
                    </div>
                </div>
                <?php } ?>

                <?php while ($row2 = mysqli_fetch_array($sumQryResult)) { ?>
                <div class="row justify-content-md-end mt-3">
                    <div class="col-md-1">
                        <label for="quantity" class="form-label">المجموع</label>
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            value="<?php echo $row2['quantity_sum']; ?>" disabled>
                    </div>
                    <div class="col-md-2">
                        <label for="purchase_price_sum" class="form-label">المبلغ الإجمالي</label>
                        <input type="text" class="form-control" name="purchase_price_sum" id="purchase_price_sum"
                            value="<?php echo $row2['purchase_price_sum']; ?>" disabled>
                    </div>

                    <div class="col-md-2">
                        <label for="sale_price_sum" class="form-label">المبلغ بالتخفيض</label>
                        <input type="text" class="form-control" name="sale_price_sum" id="sale_price_sum"
                            value="<?php echo $sale_price_sum1 - ($sale_price_sum1 * $discount_percentage / 100) + $sale_price_sum2; ?>"
                            disabled>
                    </div>
                </div>
                <?php } ?>

                <div class="form-row justify-content-md-end mt-3">
                    <div class="form-group my_col_btn">
                        <button type="button" class="btn btn-danger btn-block btn-lg rounded-pill"
                            onclick="window.history.go(-1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                            </svg>
                            رجوع
                        </button>
                    </div>
            </form>
        </div>
    </div>
</body>

</html>