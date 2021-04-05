<?php
include 'header.php';
include 'lists.php';

// GET values from ordersList.php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Order info
    $orderInfoQry = "SELECT c_orders.order_id, c_orders.client_id, last_name, first_name, father_name,
    c_orders.type_id, type_name, discount_percentage, paid_amount,
    SUM(d_orders_books.quantity) as quantity_sum,
    c_orders.creation_date, c_orders.last_edit_date
    FROM c_orders
    INNER JOIN d_orders_books ON d_orders_books.order_id = c_orders.order_id
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

    // d_orders-books table
    $ordersBooksQry = "SELECT d_orders_books.book_id, title, d_orders_books.quantity, 
    d_orders_books.purchase_price, d_orders_books.sale_price
    FROM c_orders
    INNER JOIN d_orders_books ON d_orders_books.order_id = c_orders.order_id
    INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
    WHERE c_orders.order_id = $order_id
    GROUP BY d_orders_books.book_id
    ORDER BY title";

    $ordersBooksResult = mysqli_query($conn, $ordersBooksQry);

    // discountable Price Sum
    $discountableSumQry = "SELECT SUM(d_orders_books.quantity * d_orders_books.purchase_price) as purchase_price_sum_discountable,
    SUM(d_orders_books.quantity * d_orders_books.sale_price) as sale_price_sum_discountable    
    FROM d_orders_books
    INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
    WHERE d_orders_books.order_id = $order_id and b_books.discount = 1
    GROUP BY d_orders_books.order_id";
    $discountableSumResult = mysqli_query($conn, $discountableSumQry);
    while ($row = mysqli_fetch_array($discountableSumResult)) {
        $purchase_price_sum_discountable = $row['purchase_price_sum_discountable'];
        $sale_price_sum_discountable = $row['sale_price_sum_discountable'];
    }

    $NonDiscountableSumQry = "SELECT SUM(d_orders_books.quantity * d_orders_books.purchase_price) as purchase_price_sum_NonDiscountable,
    SUM(d_orders_books.quantity * d_orders_books.sale_price) as sale_price_sum_NonDiscountable
    FROM d_orders_books
    INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
    WHERE d_orders_books.order_id = $order_id and b_books.discount = 0";
    $NonDiscountableSumResult = mysqli_query($conn, $NonDiscountableSumQry);
    while ($row = mysqli_fetch_array($NonDiscountableSumResult)) {
        $purchase_price_sum_NonDiscountable = $row['purchase_price_sum_NonDiscountable'];
        $sale_price_sum_NonDiscountable = $row['sale_price_sum_NonDiscountable'];
    }
}

// Edit order Info
if (isset($_POST['editOrderInfo'])) {
    $order_id = $_POST['order_id'];

    $client_explode = explode(' # ', $_POST['client_name']);
    $client_id = $client_explode[0]; // multi

    $type_id = $_POST['type_id'];
    $discount_percentage = $_POST['discount_percentage'];
    $paid_amount = $_POST['paid_amount'];
    $last_edit_date = $date;

    $editOrderQry = "INSERT INTO c_orders(order_id, client_id, type_id, discount_percentage, paid_amount, last_edit_date) 
    VALUES ('$order_id', '$client_id', '$type_id', '$discount_percentage', '$paid_amount', '$last_edit_date')
    ON DUPLICATE KEY UPDATE order_id = '$order_id', client_id= '$client_id', type_id= '$type_id', discount_percentage= '$discount_percentage', paid_amount= '$paid_amount', last_edit_date= '$last_edit_date'";
    if (mysqli_query($conn, $editOrderQry)) {
        echo "<script>alert('تم تعديل معلومات الفاتورة بنجاح')</script>";
    } else {
        echo "<script>alert('فشلت عملية تعديل معلومات الفاتورة')</script>";
    }
}

// Insert Order book
if (isset($_POST['insertOrderBook'])) {

    $book_explode = explode(' # ', $_POST['title']);
    $book_id = $book_explode[0]; // multi

    $quantity = $_POST['quantity'];

    $last_edit_date = $date;

    $insertOrderBookQry = "INSERT INTO d_orders_books
    (SELECT $order_id, $book_id, $quantity, purchase_price, sale_price
    FROM b_books WHERE book_id = $book_id)
    ON DUPLICATE KEY UPDATE book_id = '$book_id', quantity= $quantity";

    if (mysqli_query($conn, $insertOrderBookQry)) {
        header('location: editOrder.php?order_id=' . $order_id);
    } else {
        echo "<script>alert('فشلت عملية إضافة الفاتورة')</script>";
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
    <div class="container-fluid mt-5 py-2">

        <?php include "sideBar.php" ?>

        <div class="col-10 my_mr_sidebar pt-3">
            <div class="alert alert-warning text-center h4" role="alert">
                تعديل معلومات الفاتورة
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">معلومات الفاتورة</legend>
                    <!-- 1st row -->
                    <div class="row">
                        <div class="col-md-2 ">
                            <label for="order_id" class="form-label">رقم الفاتورة</label>
                            <input type="number" name="order_id" class="form-control text-center"
                                value="<?php echo $order_id ?>" name="order_id" id="order_id" readonly>
                            <input type="number" class="form-control text-center" value="<?php echo $order_id ?>"
                                name="prev_id" hidden>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="type_id">نوع الفاتورة</label>
                            <select class="custom-select" name="type_id" id="type_id">
                                <option value="1">بيع</option>
                                <option value="2">معرض</option>
                                <option value="3">إهداء</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="creation_date" class="form-label">تاريخ الفاتورة</label>
                            <input type="text" class="form-control" value="<?php echo $creation_date ?>"
                                id="creation_date" disabled>
                        </div>
                    </div>
                    <!-- 2nd row -->
                    <div class="row">
                        <div class="col-md-5">
                            <label for="client_id" class="form-label">الزبون</label>
                            <input list="clients" class="form-control" name="client_name" id="client_name"
                                value="<?php echo $client_id . ' # ' . $last_name . ' ' . $first_name . ' بن ' . $father_name ?>"
                                placeholder="أدخل اسم الزبون" required>
                            <datalist id="clients">
                                <?php
                                for ($i = 0; $i <= $lastClientKey; $i++) { ?>
                                <option
                                    value="<?php print_r($rowsClient[$i]['client_id'] . ' # ' . $rowsClient[$i]['last_name'] . ' ' . $rowsClient[$i]['first_name'] . ' بن ' . $rowsClient[$i]['father_name']) ?>">
                                    <?php  } ?>
                            </datalist>
                        </div>

                        <div class="col-md-2">
                            <label for="discount_percentage" class="form-label">نسبة التخفيض</label>
                            <input type="text" class="form-control" value="<?php echo $discount_percentage ?>"
                                name="discount_percentage" id="discount_percentage">
                        </div>

                        <div class="col-md-2">
                            <label for="paid_amount" class="form-label">المبلغ المدفوع</label>
                            <input type="text" class="form-control" value="<?php echo $paid_amount ?>"
                                name="paid_amount" id="paid_amount" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-md-10">
                            <button type="submit" name="editOrderInfo"
                                class="btn btn-success btn-block btn-lg rounded-pill">تعديل</button>
                        </div>
                    </div>
                </fieldset>
            </form>


            <!-- 3rd row -->
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">قائمة الكتب</legend>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label for="title" class="form-label">عنوان الكتاب</label>
                        </div>

                        <div class="col-md-2">
                            <label for="quantity">الكمية</label>
                        </div>

                        <div class="col-md-2">
                            <label for="purchase_price">سعر الشراء</label>
                        </div>

                        <div class="col-md-2">
                            <label for="sale_price">سعر البيع</label>
                        </div>
                    </div>

                    <?php
                    if (mysqli_num_rows($ordersBooksResult) > 0) {
                        while ($row = mysqli_fetch_array($ordersBooksResult)) {

                            $book_id = $row['book_id'];
                            $title = $row['title'];
                            $quantity = $row['quantity'];
                            $purchase_price = $row['purchase_price'];
                            $sale_price = $row['sale_price'];

                    ?>
                    <div class="row mt-1">
                        <div class="col-md-5">
                            <input list="books" value="<?php echo $title ?>" class="form-control" id="title" disabled>
                            <datalist id="books">
                                <?php
                                        for ($i = 0; $i <= $lastBookKey; $i++) { ?>
                                <option
                                    value="<?php print_r($rowsBooks[$i]['book_id'] . ' # ' . $rowsBooks[$i]['title']) ?>">
                                    <?php  } ?>
                            </datalist>
                        </div>

                        <div class="col-md-2">
                            <input type="number" class="form-control text-center" id="quantity"
                                value="<?php echo $quantity ?>" disabled>
                        </div>

                        <div class="col-md-2">
                            <input type="text" class="form-control" id="purchase_price"
                                value="<?php echo $purchase_price * $quantity ?>" disabled>
                        </div>

                        <div class="col-md-2">
                            <input type="text" class="form-control" id="sale_price"
                                value="<?php echo $sale_price * $quantity ?>" disabled>
                        </div>

                        <div class="col-md-1">
                            <a class="btn btn-outline-danger"
                                href="delete.php?del_order_book_id=<?php echo $order_id ?>&book_id=<?php echo $book_id ?>&title=<?php echo $title ?>"
                                onclick="return confirm('هل أنت متأكد؟')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php }
                    } ?>


                    <!-- insert book -->
                    <div class="row mt-3">
                        <div class="form-group col-md-5">
                            <input list="books" class="form-control" name="title" id="title"
                                placeholder="أدخل عنوان الكتاب" required>
                            <datalist id="books">
                                <?php
                                for ($i = 0; $i <= $lastBookKey; $i++) { ?>
                                <option
                                    value="<?php print_r($rowsBooks[$i]['book_id'] . ' # ' . $rowsBooks[$i]['title']) ?>">
                                    <?php  } ?>
                            </datalist>
                        </div>

                        <div class="form-group col-md-2">
                            <input type="number" class="form-control text-center" name="quantity" id="quantity"
                                required>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-success" name="insertOrderBook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- END insert book -->
                    <div class="row mt-3">
                        <div class="col-md-2 offset-md-5">
                            <label for="quantity_sum" class="form-label">عدد الكتب</label>
                            <input type="number" class="form-control" id="quantity_sum"
                                value="<?php echo $quantity_sum ?>" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="purchase_price_sum" class="form-label">إجمالي الشراء</label>
                            <input type="text" class="form-control" id="purchase_price_sum"
                                value="<?php echo $purchase_price_sum_discountable + $purchase_price_sum_NonDiscountable ?>.00"
                                disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="sale_price_sum" class="form-label">إجمالي البيع</label>
                            <input type="text" class="form-control" id="sale_price_sum"
                                value="<?php echo $sale_price_sum_discountable + $sale_price_sum_NonDiscountable ?>.00"
                                disabled>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-2 offset-md-9">
                            <label for="sale_price_sum_discountable" class="form-label">المبلغ بالتخفيض</label>
                            <input type="text" class="form-control" id="sale_price_sum_discountable"
                                value="<?php echo $sale_price_sum_NonDiscountable + $sale_price_sum_discountable - ($sale_price_sum_discountable * $discount_percentage / 100) ?>"
                                disabled>
                        </div>
                    </div>
                </fieldset>


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