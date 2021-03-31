<?php
include 'header.php';

// Select last (book_id)
$lastBookIdQry = "SELECT max(book_id) FROM `b_books`";
$lastBookIdResult = mysqli_query($conn, $lastBookIdQry);
$rowBookId = mysqli_fetch_row($lastBookIdResult);
$lastBookIdKey = $rowBookId[0];

// Insert a book
if (isset($_POST['insertBook'])) {
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
    $creation_date = $date;
    $last_edit_date = $date;

    $insertBookQry = "INSERT INTO b_books VALUES ('$book_id', '$title', '$auther', '$investigator', '$translator', '$publisher', '$publication_year', '$edition', '$quantity', '$purchase_price', '$sale_price', '$discount', '$creation_date', '$last_edit_date')";

    if (mysqli_query($conn, $insertBookQry)) {
        echo "<script>alert('تم إضافة الكتاب: $title بنجاح')</script>";
        echo '<script>window.location.href = "previewBook.php?book_id="' . $book_id . '</script>';
    } else {
        echo "<script>alert('فشلت عملية الإضافة')</script>";
        echo mysqli_error($conn);
        echo '<script>window.location.href = "insertBook.php#insertBook"</script>';
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

        <?php include "sideBar.php" ?>

        <div class="col-10 my_mr_sidebar">
            <div class="tab-content" id="tabContent">
                <!-- Insert book -->
                <div class="tab-pane fade mt-3" id="insertBook">

                    <div class="alert alert-primary text-center" role="alert">
                        <h4>إضافة كتاب</h4>
                    </div>
                    <form action="insertBook.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="book_id">رقم الكتاب</label>
                                <input type="number" class="form-control text-center" name="book_id" id="book_id"
                                    value="<?php echo $lastBookIdKey + 1 ?>" placeholder="أدخل رقم الكتاب" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="title">عنوان الكتاب</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="أدخل عنوان الكتاب" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="auther">المؤلف</label>
                                <input type="text" class="form-control" name="auther" id="auther"
                                    placeholder="أدخل المؤلف">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="investigator">المحقق</label>
                                <input type="text" class="form-control" name="investigator" id="investigator"
                                    placeholder="أدخل المحقق">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="translator">المترجم</label>
                                <input type="text" class="form-control" name="translator" id="translator"
                                    placeholder="أدخل المترجم">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="publisher">الناشر</label>
                                <input type="text" class="form-control" name="publisher" id="publisher"
                                    placeholder="أدخل الناشر">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="publication_year">سنة النشر</label>
                                <input type="number" class="form-control" name="publication_year" id="publication_year"
                                    placeholder="أدخل سنة النشر">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="edition">الطبعة</label>
                                <input type="text" class="form-control" name="edition" id="edition"
                                    placeholder="أدخل الطبعة">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="purchase_price">سعر الشراء</label>
                                <input type="number" class="form-control" name="purchase_price" id="purchase_price"
                                    placeholder="أدخل سعر الشراء" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sale_price">سعر البيع</label>
                                <input type="number" class="form-control" name="sale_price" id="sale_price"
                                    placeholder="أدخل سعر البيع" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="quantity">الكمية</label>
                                <input type="number" class="form-control" name="quantity" id="quantity"
                                    placeholder="أدخل عدد الكتب" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="discount">إمكانية التخفيض</label>
                                <select name="discount" id="discount" class="form-control" required>
                                    <option value="1" selected>نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row justify-content-end">
                            <div class="form-group col-md-2">
                                <button type="submit" name="insertBook"
                                    class="btn btn-success btn-block btn-lg rounded-pill">إضافة</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- hi -->
            </div>
        </div>
    </div>
</body>

<script>
scrollTop();
storeSelectedTab();
</script>

</html>