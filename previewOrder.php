<?php
include 'header.php';

// GET values from ordersList.php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Order info
    $orderInfoQry = "SELECT c_orders.order_id, c_orders.client_id, last_name, first_name, father_name,
    c_orders.type_id, type_name, discount_percentage, paid_amount,
    SUM(d_orders_books.quantity) as quantity_sum,
    c_orders.creation_date, c_orders.last_edit_date
    FROM c_orders
    LEFT JOIN d_orders_books ON d_orders_books.order_id = c_orders.order_id
    INNER JOIN a_clients ON a_clients.client_id = c_orders.client_id
    INNER JOIN types ON types.type_id = c_orders.type_id
    WHERE c_orders.order_id = $order_id
    GROUP BY d_orders_books.order_id
    LIMIT 1";
    $orderInfoResult = mysqli_query($conn, $orderInfoQry);

    if ($row = mysqli_fetch_array($orderInfoResult)) {
        $order_id = $row['order_id'];

        $client_id = $row['client_id'];
        $last_name = $row['last_name'];
        $first_name = $row['first_name'];
        $father_name = $row['father_name'];

        $type_id = $row['type_id'];
        $type_name = $row['type_name'];
        $discount_percentage = $row['discount_percentage'];

        $creation_date = $row['creation_date'];
        $last_edit_date = $row['last_edit_date'];

        $paid_amount = $row['paid_amount'];
        $quantity_sum = $row['quantity_sum'];
    }
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

            <!-- 1st row -->
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">معلومات الفاتورة</legend>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p><strong>رقم الفاتورة: </strong><?php echo $order_id ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>تاريخ الفاتورة: </strong><?php echo $creation_date ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>تاريخ آخر تعديل: </strong><?php echo $last_edit_date ?></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p><strong>الزبون: </strong><?php echo $last_name . ' ' . $first_name . ' بن ' . $father_name ?>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>نسبة التخفبض: </strong><?php echo $discount_percentage ?></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>المبلغ المدفوع: </strong><?php echo $paid_amount ?></p>
                    </div>
                </div>
            </fieldset>

            <!-- 3rd row -->
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">فائمة الكتب</legend>
                <div class="row mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">عنوان الكتاب</th>
                                <th scope="col" class="text-center">سعر الشراء</th>
                                <th scope="col" class="text-center">سعر البيع</th>
                                <th scope="col" class="text-center">الكمية</th>
                                <th scope="col" class="text-center">إجمالي الشراء</th>
                                <th scope="col" class="text-center">إجمالي البيع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sale_price_sum1 = $sale_price_sum2 = 0;
                            $i = 1;
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
                            <tr>
                                <th scope="row"><?php echo $i++ ?></th>
                                <td><?php echo $row['title'] ?></td>
                                <td class="text-center"><?php echo $row['purchase_price'] ?></td>
                                <td class="text-center"><?php echo $row['sale_price'] ?></td>
                                <td class="text-center"><?php echo $row['quantity'] ?></td>
                                <td class="text-center"><?php echo $row['purchase_price'] * $row['quantity'] ?></td>
                                <td class="text-center"><?php echo $row['sale_price'] * $row['quantity'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- END 3rd row -->
                <?php while ($row2 = mysqli_fetch_array($sumQryResult)) { ?>
                <div class="row justify-content-md-end">
                    <table class="table table-hover col-md-4">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col" colspan="2" class="text-center text-danger">التفاصيل
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-danger">عدد الكتب:</th>
                                <th class="text-center"><?php echo $row2['quantity_sum'] ?></th>
                            </tr>
                            <tr>
                                <th scope="row" class="text-danger">المبلغ لإجمالي للشراء:</th>
                                <th class="text-center"><?php echo $row2['purchase_price_sum'] ?></th>
                            </tr>
                            <tr>
                                <th scope="row" class="text-danger">المبلغ الإجمالي للبيع:</th>
                                <th class="text-center"><?php echo $sale_price_sum1 + $sale_price_sum2 ?></th>

                            </tr>
                            <tr>
                                <th scope="row" class="text-danger">المبلغ الإجمالي (بالتخفيض):</th>
                                <th class="text-center">
                                    <?php echo $sale_price_sum1 - ($sale_price_sum1 * $discount_percentage / 100) + $sale_price_sum2 ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <?php } ?>


            <?php while ($row2 = mysqli_fetch_array($sumQryResult)) { ?>
            <div class="row justify-content-md-end mt-3">
                <div class="col-md-1">
                    <label for="quantity" class="form-label">المجموع</label>
                    <input type="number" class="form-control" name="quantity" id="quantity"
                        value="<?php echo $row2['quantity_sum'] ?>" disabled>
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
            </div>
        </div>
    </div>
</body>

</html>