<?php
include 'check.php';
include 'header.php';
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
                <div class="tab-pane fade mt-3" id="settings">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="nav_database-tab" data-toggle="tab" href="#nav_database"
                                role="tab" aria-selected="false">إدارة قاعدة البيانات</a>
                            <a class="nav-link" id="nav_account-tab" data-toggle="tab" href="#nav_account" role="tab"
                                aria-selected="true">إعدادات الحساب</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav_database" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h4>إدارة قاعدة بيانات البرنامج</h4>
                                    <hr>

                                    <form method="post" action="import_db.php" enctype="multipart/form-data">
                                        <div class="form-group row mb-3">
                                            <div class="input-group mb-3">
                                                <label class="col-md-3">أدخل النسخة الاحتياطية (SQL) </label>
                                                <div class="custom-file col-md-5">
                                                    <input type="file" class="form-control-file" name="db" accept=".sql"
                                                        id="db" required>
                                                    <label class="custom-file-label" for="db">اختر ملف قاعدة
                                                        البيانات</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <input type="submit" name="importDb" class="btn btn-info"
                                                        value="إدخال">
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form method="post" action="export_db.php" enctype="multipart/form-data">
                                        <!-- Third row -->
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3">استخراج قاعدة البيانات</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="submit" name="export" class="btn btn-success"
                                                        value="استخراج قاعدة البيانات">
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
                                                    <input type="submit" name="drop" class="btn btn-danger"
                                                        value="   حذف قاعدة البيانات   "
                                                        onclick="return confirm('هل أنت متأكد؟')">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Forth row -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav_account" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h4>تغيير إعدادات تسجيل الدخول</h4>
                                    <hr>
                                    <form method="post" action="editAccount.php">
                                        <!-- First row -->
                                        <div class="form-group row mb-3">
                                            <div class="input-group">
                                                <label class="col-md-2">كلمة المرور القديمة</label>
                                                <div class="col-md-4">
                                                    <input type="password" name="oldPwd" class="form-control"
                                                        placeholder="أدخل كلمة المرور القديمة" required />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END First row -->

                                        <!-- Second row -->
                                        <div class="form-group row mb-3">
                                            <div class="input-group">
                                                <label class="col-md-2">اسم المستخدم الجديد</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="newUsername" class="form-control"
                                                        placeholder="أدخل اسم المستخدم الجديد" required />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END second row -->

                                        <!-- Third row -->
                                        <div class="form-group row mb-3">
                                            <label class="col-md-2">كلمة المرور الجديدة</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="password" name="newPwd1" class="form-control"
                                                        placeholder="أدخل كلمة المرور الجديدة">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Third row -->
                                        <!-- Forth row -->
                                        <div class="form-group row mb-3">
                                            <label class="col-md-2">تأكيد كلمة المرور</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="password" name="newPwd2" class="form-control"
                                                        placeholder="أعد إدخال كلمة المرور الجديدة">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Forth row -->
                                        <div class="form-group row mb-3">
                                            <label class="col-md-2"></label>
                                            <div class="col-sm-4">
                                                <input type="submit" name="editAcc"
                                                    class="btn btn-success btn-block rounded-pill p-2"
                                                    value="تغيير الحساب">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="main.js"></script>
<script>
scrollTop();
storeSelectedTab();
</script>

</html>