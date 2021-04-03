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
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">معلومات الفاتورة</legend>
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
                                <div class="form-group col-md-auto">
                                    <label for="discount_percentage">نسبة التخفيض</label>
                                    <input type="number" class="form-control" name="discount_percentage"
                                        id="discount_percentage" placeholder="أدخل نسبة التخفيض">
                                </div>
                                <div class="form-group col-md-auto">
                                    <label for="paid_amount">المبلغ المدفوع</label>
                                    <input type="number" class="form-control" name="paid_amount" id="paid_amount"
                                        placeholder="أدخل المبلغ المدفوع">
                                </div>
                            </div>

                            <div class="form-row justify-content-end">
                                <div class="form-group col-md-2">
                                    <button type="submit" name="insertOrderr"
                                        class="btn btn-success btn-block btn-lg rounded-pill">إضافة</button>
                                </div>
                            </div>
                        </fieldset>
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