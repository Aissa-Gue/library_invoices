<?php
include 'header.php';

// Select last (client_id)
$lastClientIdQry = "SELECT max(client_id) FROM `a_clients`";
$lastClientIdResult = mysqli_query($conn, $lastClientIdQry);
$rowClientId = mysqli_fetch_row($lastClientIdResult);
$lastClientIdKey = $rowClientId[0];

// Insert a client
if (isset($_POST['insertClient'])) {
    $client_id = $_POST['client_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $father_name = $_POST['father_name'];
    $address = $_POST['address'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $creation_date = $date;
    $last_edit_date = $date;

    $insertClientQry = "INSERT INTO a_clients VALUES ('$client_id', '$last_name', '$first_name', '$father_name', '$address', '$phone1', '$phone2', '$creation_date', '$last_edit_date')";

    if (mysqli_query($conn, $insertClientQry)) {
        echo "<script>alert('تم إضافة الزبون: $last_name $first_name بنجاح')</script>";
        echo '<script>window.location.href = "previewClient.php"</script>';
    } else {
        echo "<script>alert('فشلت عملية الإضافة')</script>";
        echo mysqli_error($conn);
        echo '<script>window.location.href = "insertClient.php#insertClient"</script>';
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
        <div class="row">

            <?php include "sideBar.php" ?>

            <div class="col-10 my_mr_sidebar">
                <div class="tab-content" id="tabContent">
                    <!-- Insert client -->
                    <div class="tab-pane fade mt-3" id="insertClient">

                        <div class="alert alert-primary text-center" role="alert">
                            <h4>إضافة زبون</h4>
                        </div>
                        <form action="insertClient.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="client_id">رقم الزبون</label>
                                    <input type="number" class="form-control text-center" name="client_id"
                                        id="client_id" value="<?php echo $lastClientIdKey + 1 ?>"
                                        placeholder="أدخل رقم الزبون">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="last_name">اللقب</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        placeholder="أدخل لقب الزبون">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="first_name">الاسم</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        placeholder="أدخل اسم الزبون">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="father_name">اسم الأب</label>
                                    <input type="text" class="form-control" name="father_name" id="father_name"
                                        placeholder="أدخل اسم الأب">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="phone1">رقم الهاتف 1</label>
                                    <input type="text" pattern="[0-9]*" class="form-control" name="phone1" id="phone1"
                                        placeholder="أدخل رقم هاتف الزبون">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="phone2">رقم الهاتف 2</label>
                                    <input type="text" pattern="[0-9]*" class="form-control" name="phone2" id="phone2"
                                        placeholder="أدخل رقم هاتف الزبون">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="address">العنوان</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="أدخل عنوان الزبون">
                                </div>
                            </div>

                            <div class="form-row justify-content-end">
                                <div class="form-group col-md-2">
                                    <button type="submit" name="insertClient"
                                        class="btn btn-success btn-block btn-lg rounded-pill">إضافة</button>
                                </div>
                            </div>
                        </form>
                    </div>

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