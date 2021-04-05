<?php
include 'config.php';

$d = date('Y-m-d');
$dir = 'D:/library_invoices_DB/' . $d . '/';
$path = $dir . $dbname . '.sql';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$command = "C:/xampp/mysql/bin/mysqldump.exe -u $username $dbname >" . $path;
exec($command . ' 2>&1', $output);

if (count($output) == 0) {
    echo "<script>alert('تم استخراج قاعدة البيانات بنجاح، تفقد القرص المحلي (D)');</script>";
    echo "<script> window.location.href= 'settings.php#settings'</script>";
} else {
    echo "<script>alert('حدثت مشكلة لم يتم استخراج قاعدة البيانات !');</script>";
    echo "<script> window.location.href= 'settings.php#settings'</script>";
}
//exec($command);
//exec($command . ' 2>&1', $output);
//var_dump($output);