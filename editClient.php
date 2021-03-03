<?php
include 'check.php';
include 'header.php';

// GET values from clientsList.php
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $last_name = $_GET['last_name'];
    $first_name = $_GET['first_name'];
    $father_name = $_GET['father_name'];
    $address = $_GET['address'];
    $phone1 = $_GET['phone1'];
    $phone2 = $_GET['phone2'];
    $creation_date = $_GET['creation_date'];
    $last_edit_date = $_GET['last_edit_date'];
}

if (isset($_POST['editClient'])) {
    $prev_id = $_POST['prev_id'];
    $client_id = $_POST['client_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $father_name = $_POST['father_name'];
    $address = $_POST['address'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $last_edit_date = $date;


    $editClientQry = "UPDATE a_clients set client_id = '$client_id', last_name='$last_name', first_name='$first_name', father_name='$father_name', address='$address', phone1='$phone1', phone2='$phone2', last_edit_date='$last_edit_date' WHERE client_id = '$prev_id'";

    if (mysqli_query($conn, $editClientQry) and mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('تم تعديل معلومات الزبون: $last_name $first_name بنجاح')</script>";
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
    <title>Client Edit</title>
</head>

<body class="my_bg">
    <div class="container pt-3">
        <div class="alert alert-warning text-center h4" role="alert">
            تعديل معلومات الزبون
        </div>

        <form action="editClient.php" method="post" enctype="multipart/form-data">
            <!-- 1st row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="client_id" class="form-label">رقم الزبون</label>
                    <input type="number" class="form-control text-center" value="<?php echo $client_id ?>" name="client_id" id="client_id" required>
                    <input type="number" class="form-control text-center" value="<?php echo $client_id ?>" name="prev_id" hidden>
                </div>
            </div>
            <!-- 2nd row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="last_name" class="form-label">اللقب</label>
                    <input type="text" class="form-control" value="<?php echo $last_name ?>" name="last_name" id="last_name" required>
                </div>
                <div class="col-md-3">
                    <label for="first_name" class="form-label">الإسم</label>
                    <input type="text" class="form-control" value="<?php echo $first_name ?>" name="first_name" id="first_name" required>
                </div>
                <div class="col-md-3">
                    <label for="father_name" class="form-label">اسم الأب</label>
                    <input type="text" class="form-control" value="<?php echo $father_name ?>" name="father_name" id="father_name">
                </div>
            </div>
            <!-- 3rd row -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">العنوان </label>
                    <input type="text" class="form-control" value="<?php echo $address ?>" name="address" id="address">
                </div>
            </div>

            <!-- 4th row -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="phone1" class="form-label">رقم الهاتف 1</label>
                    <input type="text" pattern="[0-9]*" class=" form-control" value="<?php echo $phone1 ?>" name="phone1" id="phone1">
                </div>

            </div>

            <!-- 5th row -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="phone2" class="form-label">رقم الهاتف 2</label>
                    <input type="text" pattern="[0-9]*" class="form-control" value="<?php echo $phone2 ?>" name="phone2" id="phone2">
                </div>
            </div>

            <div class="form-row justify-content-md-end">
                <div class="form-group my_col_btn">
                    <button type="button" class="btn btn-danger btn-block btn-lg rounded-pill" onclick="window.history.go(-1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                        </svg>
                        رجوع
                    </button>
                </div>
                <div class="form-group my_col_btn">
                    <button type="submit" name="editClient" class="btn btn-success btn-block btn-lg rounded-pill">تحديث</button>
                </div>
        </form>

    </div>
</body>

</html>