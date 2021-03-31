<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP 4.5 / icons -->
    <link rel="stylesheet" href="bootstrap-4.5.3/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="bootstrap-4.5.3/bootstrap-icons-1.2.1/font/bootstrap-icons.css">

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

    <!-- my styles -->
    <link rel="stylesheet" href="css/style.css">

    <title><?php echo $ProjTitle ?></title>
</head>

<body>
    <div class="container-fluid background_img_login">
        <header class="text-center mb-4">
            <img class="img-fluid my_header_img" src="img/biblio_header.gif" alt="header">
        </header>
        <div class="row justify-content-md-center">
            <div class="col-md-3 p-3 my_radious my_form_bg">
                <form action="check.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <h4 class="text-center mb-5">
                            <strong>تسجيل الدخول</strong>
                        </h4>
                        <label for="username" class="form-label">اسم المستخدم</label>
                        <input type="text" name="username" class="form-control" id="username"
                            placeholder="أدخل اسم المستخدم">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="أدخل كلمة المرور">
                    </div>
                    <div class="mb-4 text-center mt-5">
                        <input type="submit" name="login" value="تسجيل الدخول" class="btn btn-danger">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="bootstrap-4.5.3/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap-4.5.3/jquery-3.3.1.js"></script>
</body>

</html>