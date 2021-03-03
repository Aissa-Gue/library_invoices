<?php
include 'check.php';
include 'header.php';

// GET values from clientsList.php
$client_id = $_GET['client_id'];
$last_name = $_GET['last_name'];
$first_name = $_GET['first_name'];
$father_name = $_GET['father_name'];
$address = $_GET['address'];
$phone1 = $_GET['phone1'];
$phone2 = $_GET['phone2'];
$creation_date = $_GET['creation_date'];
$last_edit_date = $_GET['last_edit_date'];

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Preview</title>
</head>

<body class="my_bg">
    <div class="container pt-3">
        <div class="alert alert-warning text-center h4" role="alert">
            معلومات الزبون
        </div>

        <form action="#" method="post" enctype="multipart/form-data">
            <!-- 1st row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="client_id" class="form-label">رقم الزبون</label>
                    <input type="text" class="form-control text-center" value="<?php echo $client_id ?>" id="client_id" readonly>
                </div>
            </div>
            <!-- 2nd row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="last_name" class="form-label">اللقب</label>
                    <input type="text" class="form-control" value="<?php echo $last_name ?>" id="last_name" readonly>
                </div>
                <div class="col-md-3">
                    <label for="first_name" class="form-label">الإسم</label>
                    <input type="text" class="form-control" value="<?php echo $first_name ?>" id="first_name" readonly>
                </div>
                <div class="col-md-3">
                    <label for="father_name" class="form-label">اسم الأب</label>
                    <input type="text" class="form-control" value="<?php echo $father_name ?>" id="father_name" readonly>
                </div>
            </div>
            <!-- 3rd row -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">العنوان </label>
                    <input type="text" class="form-control" value="<?php echo $address ?>" id="address" readonly>
                </div>
            </div>

            <!-- 4th row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="phone1" class="form-label">رقم الهاتف 1</label>
                    <input type="text" class="form-control" value="<?php echo $phone1 ?>" id="phone1" readonly>
                </div>
                <div class="col-md-3">
                    <label for="phone2" class="form-label">رقم الهاتف 2</label>
                    <input type="text" class="form-control" value="<?php echo $phone2 ?>" id="phone2" readonly>
                </div>
            </div>

            <!-- 5th row -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="creation_date" class="form-label">تاريخ الإنشاء</label>
                    <input type="text" class="form-control" value="<?php echo $creation_date ?>" id="creation_date" readonly>
                </div>
                <div class="col-md-3">
                    <label for="last_edit_date" class="form-label">تاريخ آخر تعديل</label>
                    <input type="text" class="form-control" value="<?php echo $last_edit_date ?>" id="last_edit_date" readonly>
                </div>
            </div>
        </form>

        <div class="form-row justify-content-end">
            <div class="form-group my_col_btn">
                <button type="button" class="btn btn-danger btn-block btn-lg rounded-pill" onclick="window.history.go(-1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                    </svg>
                    رجوع
                </button>
            </div>
        </div>
    </div>
</body>

</html>