<?php
include 'header.php';

// input values
if (isset($_POST['clientSearch'])) {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
} else {
    $last_name = "";
    $first_name = "";
}

// Search query
$searchQry = "SELECT * FROM a_clients 
WHERE last_name LIKE '%$last_name%' AND first_name LIKE '%$first_name%'";

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
                <!-- clients list -->
                <div class="tab-pane fade mt-3" id="clientsList">

                    <div class="alert alert-primary text-center" role="alert">
                        <h4>قائمة الزبائن</h4>
                    </div>

                    <div class="row justify-content-sm-center mb-4">
                        <div class="col-sm-7">
                            <form action="" method="post">
                                <div class="form-row">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">اللقب</span>
                                            <input type="text" name="last_name" class="form-control"
                                                placeholder="أدخل اللقب">
                                        </div>

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">الاسم</span>
                                            <input type="text" name="first_name" class="form-control"
                                                placeholder="أدخل الإسم">
                                        </div>

                                        <div class="input-group-append">
                                            <button class="btn btn-primary" name="clientSearch"
                                                type="submit">بحث</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="alert alert-warning text-center" role="alert">
                        <strong> عدد النتائج = </strong>
                        <?php echo $search_num_rows ?>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">رقم الزبون</th>
                                <th scope="col">اسم الزبون</th>
                                <th scope="col">العنون</th>
                                <th scope="col" class="text-center">رقم الهاتف 1</th>
                                <th scope="col" class="text-center">رقم الهاتف 2</th>
                                <th scope="col" class="text-center">تفاصيل</th>
                                <th scope="col" class="text-center">تعديل</th>
                                <th scope="col" class="text-center">حذف</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($searchResult)) { ?>
                            <tr>
                                <th scope="row" class="text-center"><?php echo $row['client_id'] ?></th>
                                <td><?php echo $row['last_name'] . ' ' . $row['first_name'] . ' بن ' . $row['father_name'] ?>
                                </td>
                                <td><?php echo $row['address'] ?></td>
                                <td class="text-center"><?php echo $row['phone1'] ?></td>
                                <td class="text-center"><?php echo $row['phone2'] ?></td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="previewClient.php?client_id=<?php echo $row['client_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                                        </svg>
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="editClient.php?client_id=<?php echo $row['client_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a class="btn btn-outline-danger"
                                        href="delete.php?del_client_id=<?php echo $row['client_id'] ?>&last_name=<?php echo $row['last_name'] ?>&first_name=<?php echo $row['first_name'] ?>"
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