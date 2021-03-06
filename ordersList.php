<?php
include 'header.php';

// input values
if (isset($_POST['orderSearch'])) {
    $order_id = $_POST['order_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $type_id = $_POST['type_id'];
    $orderBy = $_POST['orderBy'];
} else {
    $order_id = '';
    $last_name = '';
    $first_name = '';
    $type_id = '';
    $orderBy = '';
}

// Search query
$searchQry = "SELECT c_orders.order_id, DATE(c_orders.creation_date) as creation_date,
c_orders.client_id, last_name, first_name, father_name, type_name, discount_percentage
FROM c_orders
INNER JOIN a_clients ON a_clients.client_id = c_orders.client_id
INNER JOIN types ON types.type_id = c_orders.type_id
WHERE (order_id LIKE '%$order_id' AND last_name LIKE '%$last_name%' AND first_name LIKE '%$first_name%' AND types.type_id LIKE '%$type_id')
$orderBy";

$searchResult = mysqli_query($conn, $searchQry);

// search num rows
$search_num_rows = mysqli_num_rows($searchResult);

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
                <!-- orders List -->
                <div class="tab-pane fade mt-3" id="ordersList">

                    <div class="alert alert-primary text-center" role="alert">
                        <h4>قائمة الفواتير</h4>
                    </div>

                    <form action="" method="post">
                        <div class="form-row justify-content-md-center mb-1">
                            <div class="input-group col-md-10">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">رقم الفاتورة</span>
                                </div>
                                <input type="number" name="order_id" class="form-control"
                                    placeholder="أدخل رقم الفاتورة">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">لقب الزبون</span>
                                </div>
                                <input type="text" name="last_name" class="form-control" placeholder="أدخل لقب الزبون">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">اسم الزبون</span>
                                </div>
                                <input type="text" name="first_name" class="form-control" placeholder="أدخل اسم الزبون">
                            </div>
                        </div>

                        <div class="form-row justify-content-md-center mb-1">
                            <div class="input-group col-md-10">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="type_id">نوع الفاتورة</label>
                                </div>
                                <select class="custom-select" name="type_id" id="type_id">
                                    <option value="" selected>-- اختر نوع الفاتورة --</option>
                                    <option value="1">بيع</option>
                                    <option value="2">معرض</option>
                                    <option value="3">إهداء</option>
                                </select>

                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="orderBy">ترتيب حسب</label>
                                </div>
                                <select class="custom-select" name="orderBy" id="orderBy">
                                    <option value="ORDER BY creation_date DESC">تاريخ الفاتورة</option>
                                    <option value="ORDER BY order_id ASC">رقم الفاتورة</option>
                                    <option value="ORDER BY c_orders.type_id, c_orders.order_id">نوع الفاتورة
                                    </option>
                                    <option value="ORDER BY last_name, first_name, order_id">
                                        الزبون</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-info" name="orderSearch" type="submit">بحث</button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="alert alert-warning text-center" role="alert">
                        <strong> عدد النتائج = </strong>
                        <?php echo $search_num_rows ?>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">رقم الفاتورة</th>
                                <th scope="col">تاريخ الفاتورة</th>
                                <th scope="col">الزبون</th>
                                <th scope="col" class="text-center">نوع الفاتورة</th>
                                <th scope="col" class="text-center">نسبة التخفيض</th>
                                <th scope="col" class="text-center">تفاصيل</th>
                                <th scope="col" class="text-center">تعديل</th>
                                <th scope="col" class="text-center">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($searchResult)) { ?>
                            <tr>
                                <th scope="row" class="text-center"><?php echo $row['order_id'] ?></th>
                                <td><?php echo $row['creation_date'] ?></td>
                                <td><?php echo $row['last_name'] . ' ' . $row['first_name'] . ' بن ' . $row['father_name'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $row['type_name']; ?>
                                </td>
                                <td class="text-center"><?php echo '% ' . $row['discount_percentage'] ?></td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="previewOrder.php?order_id=<?php echo $row['order_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                                        </svg>
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="editOrder.php?order_id=<?php echo $row['order_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="delete.php?del_order_id=<?php echo $row['order_id'] ?>"
                                        onclick="return confirm('هل أنت متأكد؟')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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