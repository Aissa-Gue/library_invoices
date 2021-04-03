<?php
include 'header.php';
include 'lists.php';

// GET values from ordersList.php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Get data from d_orders-books table
    $ordersBooksQry = "SELECT c_orders.order_id, c_orders.client_id, last_name, first_name, father_name,
    c_orders.type_id, type_name, discount_percentage, d_orders_books.book_id, title, d_orders_books.quantity, 
    d_orders_books.purchase_price, d_orders_books.sale_price, paid_amount,
    SUM(d_orders_books.quantity) as quantity_sum,
    SUM(d_orders_books.quantity * d_orders_books.purchase_price) as purchase_price_sum,
    SUM(d_orders_books.quantity * d_orders_books.sale_price) as sale_price_sum,
    sum(d_orders_books.quantity) as quantity_sum,
    c_orders.creation_date, c_orders.last_edit_date
    FROM c_orders
    INNER JOIN d_orders_books ON d_orders_books.order_id = c_orders.order_id
    INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
    INNER JOIN a_clients ON a_clients.client_id = c_orders.client_id
    INNER JOIN types ON types.type_id = c_orders.type_id
    WHERE c_orders.order_id = $order_id";

    $ordersBooksResult = mysqli_query($conn, $ordersBooksQry);
    $ordersBooksDiscountSumQry = "SELECT SUM(d_orders_books.quantity * d_orders_books.sale_price) as sale_price_sum_discounted
    FROM d_orders_books
    INNER JOIN b_books ON b_books.book_id = d_orders_books.book_id
    WHERE d_orders_books.order_id = $order_id and b_books.discount = 1";
    $ordersBooksDiscountSumResult = mysqli_query($conn, $ordersBooksDiscountSumQry);
}

//** Edit Order **/
if (isset($_POST['editOrder'])) {
    $order_id = $_POST['order_id'];
    $type = $_POST['type'];
    $discount_percentage = $_GET['discount_percentage'];
    $paid_price = $_GET['paid_price'];
    $creation_date = $_GET['creation_date'];
    $last_edit_date = $_GET['last_edit_date'];
    $last_name = $_GET['last_name'];
    $first_name = $_GET['first_name'];
    $father_name = $_GET['father_name'];


    $editOrderQry = "UPDATE a_clients set book_id = '$book_id', title='$title', author='$author', investigator='$investigator', translator='$translator', publisher='$publisher', publication_year='$publication_year', edition='$edition', quantity=$quantity, purchase_price=$purchase_price, sale_price=$sale_price, discount=$discount, last_edit_date=$last_edit_date  WHERE book_id = '$prev_id'";

    if (mysqli_query($conn, $editOrderQry) and mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('تم تعديل معلومات الفاتورة: $title بنجاح')</script>";
    } else {
        echo "<script>alert('فشلت عملية التعديل')</script>";
        echo mysqli_error($conn);
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

            <form action="editOrder.php" method="post" enctype="multipart/form-data">

                <?php
                while ($row = mysqli_fetch_array($ordersBooksResult)) {
                    $order_id = $row['order_id'];

                    $client_id = $row['client_id'];
                    $last_name = $row['last_name'];
                    $first_name = $row['first_name'];
                    $father_name = $row['father_name'];

                    $type_id = $row['type_id'];
                    $type_name = $row['type_name'];
                    $discount_percentage = $row['discount_percentage'];
                    $book_id = $row['book_id'];
                    $title = $row['title'];
                    $quantity = $row['quantity'];
                    $purchase_price = $row['purchase_price'];
                    $sale_price = $row['sale_price'];
                    $paid_amount = $row['paid_amount'];
                    $quantity_sum = $row['quantity_sum'];
                    $purchase_price_sum = $row['purchase_price_sum'];
                    $sale_price_sum = $row['sale_price_sum'];
                    $quantity_sum = $row['quantity_sum'];

                    $creation_date = $row['creation_date'];
                    $last_edit_date = $row['last_edit_date'];

                ?>
                <!-- 1st row -->
                <div class="row mt-3">
                    <div class="col-md-2 ">
                        <label for="order_id" class="form-label">رقم الفاتورة</label>
                        <input type="number" class="form-control text-center" value="<?php echo $order_id ?>"
                            name="order_id" id="order_id">
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
                        <input type="text" class="form-control" value="<?php echo $discount_percentage ?>"
                            name="discount_percentage" id="discount_percentage">
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount" class="form-label">المبلغ المدفوع</label>
                        <input type="text" class="form-control" value="<?php echo $paid_amount ?>" name="paid_amount"
                            id="paid_amount" disabled>
                    </div>
                </div>

                <!-- 3rd row -->
                <div class="row mt-3">
                    <div class="col-md-5">
                        <label for="title" class="form-label">عنوان الكتاب</label>
                    </div>

                    <div class="col-md-2">
                        <label for="quantity">الكمية</label>
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount">السعر الإجمالي للشراء</label>
                    </div>

                    <div class="col-md-2">
                        <label for="paid_amount">السعر الإجمالي للبيع</label>
                    </div>

                    <div class="col-md-1">
                        <label for="quantity">حذف</label>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-5">
                        <input list="books" value="<?php echo $title ?>" class="form-control" name="title" id="title"
                            required>
                        <datalist id="books">
                            <?php
                                for ($i = 0; $i <= $lastBookKey; $i++) { ?>
                            <option
                                value="<?php print_r($rowsBooks[$i]['book_id'] . ' # ' . $rowsBooks[$i]['title']) ?>">
                                <?php  } ?>
                        </datalist>
                    </div>

                    <div class="col-md-2">
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            value="<?php echo $quantity ?>" required>
                    </div>

                    <div class="col-md-2">
                        <input type="text" class="form-control" name="total_purchase_price" id="total_purchase_price"
                            value="<?php echo $purchase_price * $quantity ?>" disabled>
                    </div>

                    <div class="col-md-2">
                        <input type="text" class="form-control" name="total_sale_price" id="total_sale_price"
                            value="<?php echo $sale_price * $quantity ?>" disabled>
                    </div>

                    <div class="col-md-1">
                        <a class="btn btn-outline-danger"
                            href="delete.php?del_order_book_id=<?php echo $row['order_id'] ?>&book_id=<?php echo $row['book_id'] ?>&title=<?php echo $row['title'] ?>"
                            onclick="return confirm('هل أنت متأكد؟')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2 offset-md-4">
                        <label for="quantity" class="form-label">عدد الكتب</label>
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            value="<?php echo $quantity_sum ?>" disabled>
                    </div>
                    <div class="col-md-auto">
                        <label for="purchase_price_sum" class="form-label">إجمالي الشراء</label>
                        <input type="text" class="form-control" name="purchase_price_sum" id="purchase_price_sum"
                            value="<?php echo $purchase_price_sum ?>" disabled>
                    </div>
                    <div class="col-md-auto">
                        <label for="sale_price_sum" class="form-label">إجمالي البيع</label>
                        <input type="text" class="form-control" name="sale_price_sum" id="sale_price_sum"
                            value="<?php echo $sale_price_sum ?>" disabled>
                    </div>
                </div>
                <?php } ?>
                <?php while ($row = mysqli_fetch_array($ordersBooksDiscountSumResult)) {
                    $sale_price_sum_discounted = $row['sale_price_sum_discounted'];
                ?>
                <div class="row">
                    <div class="col-md-3 offset-md-8">
                        <label for="sale_price_sum_discounted" class="form-label">المبلغ بالتخفيض</label>
                        <input type="text" class="form-control" name="sale_price_sum_discounted"
                            id="sale_price_sum_discounted"
                            value="<?php echo $sale_price_sum_discounted - ($sale_price_sum_discounted * $discount_percentage / 100) ?>"
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

                    <div class="form-group my_col_btn">
                        <button type="submit" name="editOrder"
                            class="btn btn-success btn-block btn-lg rounded-pill">تعديل</button>
                    </div>
            </form>
        </div>
    </div>
</body>

</html>