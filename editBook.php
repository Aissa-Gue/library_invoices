<?php
include 'check.php';
include 'header.php';

// GET values from booksList.php
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $title = $_GET['title'];
    $auther = $_GET['auther'];
    $investigator = $_GET['investigator'];
    $translator = $_GET['translator'];
    $publisher = $_GET['publisher'];
    $publication_year = $_GET['publication_year'];
    $edition = $_GET['edition'];
    $quantity = $_GET['quantity'];
    $purchase_price = $_GET['purchase_price'];
    $sale_price = $_GET['sale_price'];
    $discount = $_GET['discount'];
    $status = $_GET['status'];
    $creation_date = $_GET['creation_date'];
    $last_edit_date = $_GET['last_edit_date'];
}

if (isset($_POST['editBook'])) {
    $prev_id = $_POST['prev_id'];
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $auther = $_POST['auther'];
    $investigator = $_POST['investigator'];
    $translator = $_POST['translator'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $edition = $_POST['edition'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];
    $sale_price = $_POST['sale_price'];
    $discount = $_POST['discount'];
    $status = $_POST['status'];
    $last_edit_date = $date;


    $editBookQry = "UPDATE b_books set book_id = '$book_id', title='$title', auther='$auther', investigator='$investigator', translator='$translator', publisher='$publisher', publication_year='$publication_year', edition='$edition', quantity='$quantity', purchase_price='$purchase_price', sale_price='$sale_price', discount='$discount', status='$status', last_edit_date='$last_edit_date' WHERE book_id = '$prev_id'";

    if (mysqli_query($conn, $editBookQry) and mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('تم تعديل معلومات الكتاب: $title بنجاح')</script>";
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
    <title>Book Edit</title>
</head>

<body class="my_bg">
    <div class="container pt-3">
        <div class="alert alert-warning text-center h4" role="alert">
            تعديل معلومات الكتاب
        </div>

        <form action="editBook.php" method="post" enctype="multipart/form-data">
            <!-- 1st row -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="book_id" class="form-label">رقم الكتاب</label>
                    <input type="number" class="form-control text-center" value="<?php echo $book_id ?>" name="book_id" id="book_id" required>
                    <input type="number" class="form-control text-center" value="<?php echo $book_id ?>" name="prev_id" hidden>
                </div>
                <div class="col-md-6">
                    <label for="title" class="form-label">عنوان الكتاب</label>
                    <input type="text" class="form-control" value="<?php echo $title ?>" name="title" id="title" required>
                </div>
            </div>
            <!-- 2nd row -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="auther" class="form-label">المؤلف</label>
                    <input type="text" class="form-control" value="<?php echo $auther ?>" name="auther" id="auther" required>
                </div>
                <div class="col-md-4">
                    <label for="investigator" class="form-label">المحقق</label>
                    <input type="text" class="form-control" value="<?php echo $investigator ?>" name="investigator" id="investigator">
                </div>
                <div class="col-md-4">
                    <label for="translator" class="form-label">المترجم</label>
                    <input type="text" class="form-control" value="<?php echo $translator ?>" name="translator" id="translator">
                </div>
            </div>
            <!-- 3rd row -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="publisher" class="form-label">الناشر</label>
                    <input type="text" class="form-control" value="<?php echo $publisher ?>" name="publisher" id="publisher">
                </div>
                <div class="col-md-2">
                    <label for="publication_year" class="form-label">سنة النشر</label>
                    <input type="text" class="form-control" value="<?php echo $publication_year ?>" name="publication_year" id="publication_year">
                </div>
                <div class="col-md-2">
                    <label for="edition" class="form-label">الطبعة</label>
                    <input type="text" class="form-control" value="<?php echo $edition ?>" name="edition" id="edition">
                </div>
            </div>

            <!-- 4th row -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="purchase_price">سعر الشراء</label>
                    <input type="number" class="form-control" name="purchase_price" id="purchase_price" value="<?php echo $purchase_price ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="sale_price">سعر البيع</label>
                    <input type="number" class="form-control" name="sale_price" id="sale_price" value="<?php echo $sale_price ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="quantity">الكمية</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $quantity ?>" required>
                </div>
            </div>

            <!-- 5th row -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="discount">إمكانية التخفيض</label>
                    <select name="discount" id="discount" class="form-control" required>
                        <?php if ($discount == "1") { ?>
                            <option value="1" selected>نعم</option>
                            <option value="0">لا</option>
                        <?php } else { ?>
                            <option value="0" selected>لا</option>
                            <option value="1">نعم</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="status">حالة الكتاب</label>
                    <select name="status" id="status" class="form-control" required>
                        <?php if ($status == "1") { ?>
                            <option value="1" selected>متوفر</option>
                            <option value="0">غير متوفر</option>
                        <?php } else { ?>
                            <option value="0" selected>غير متوفر</option>
                            <option value="1">متوفر</option>
                        <?php } ?>
                    </select>
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
                    <button type="submit" name="editBook" class="btn btn-success btn-block btn-lg rounded-pill">تحديث</button>
                </div>
        </form>
    </div>
</body>

</html>