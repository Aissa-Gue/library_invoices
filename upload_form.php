<?php
include 'header.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap_v5.0.0-beta1/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Upload Database</title>
</head>

<body>
    <div class="my_background_database">
        <div class="container pt-4">
            <div class="row">
                <div class="col-md-12">
                    <h4>إدخال قاعدة بيانات التلميذات</h4>
                    <hr>
                    <form method="post" action="file_upload.php" enctype="multipart/form-data">
                        <!-- First row -->
                        <div class="form-group row mb-3">
                            <div class="input-group">
                                <label class="col-md-3">أدخل قائمة الطالبات (Excel)</label>
                                <div class="col-md-5">
                                    <input type="file" name="uploadfile" class="form-control" accept=".xlsx, .xls" required />
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" name="submit" class="btn btn-primary" value="إدخال">
                                    <a class="btn btn-secondary" href="template/ex_1.xlsx">
                                        <i class="bi bi-download"> نموذج</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END First row -->
                    </form>

                    <form method="post" action="import_db.php" enctype="multipart/form-data">
                        <!-- Second row -->
                        <div class="form-group row mb-3">
                            <div class="input-group">
                                <label class="col-md-3">أدخل النسخة الاحتياطية (SQL) </label>
                                <div class="col-md-5">
                                    <input type="file" name="db" class="form-control" accept=".sql" required />
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" name="importDb" class="btn btn-primary" value="إدخال">
                                </div>
                            </div>
                        </div>
                        <!-- END second row -->
                    </form>

                    <form method="post" action="export_db.php" enctype="multipart/form-data">
                        <!-- Third row -->
                        <div class="form-group row mb-3">
                            <label class="col-md-3">استخراج قاعدة البيانات</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="submit" name="export" class="btn btn-success" value="استخراج قاعدة البيانات">
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END Third row -->
                    <!-- Forth row -->
                    <form method="post" action="drop_db.php" enctype="multipart/form-data">
                        <div class="form-group row mb-3">
                            <label class="col-md-3">حذف قاعدة البيانات</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="submit" name="drop" class="btn btn-danger" value="   حذف قاعدة البيانات   " onclick="return confirm('هل أنت متأكد؟')">
                                </div>
                            </div>
                        </div>
                        <!-- END Forth row -->

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap_v5.0.0-beta1/js/bootstrap.bundle.min.js"></script>
</body>