<?php
include 'check.php';

//convert excel date format
function convertDate($dateValue)
{
    $unixDate = ($dateValue - 25569) * 86400;
    return gmdate("Y-m-d", $unixDate);
}

// import excel
$uploadfile = $_FILES['uploadfile']['tmp_name'];

require 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

$objExcel = PHPExcel_IOFactory::load($uploadfile);
foreach ($objExcel->getWorksheetIterator() as $worksheet) {
    $highestrow = $worksheet->getHighestRow();

    for ($row = 2; $row <= $highestrow; $row++) {
        $stud_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
        $soft_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $lname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $fname = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $father = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $grandpa = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $birthdate = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        $birthdate = convertDate($birthdate);
        $birthplace = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        $wali_lname = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
        $wali_fname = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
        $kinship = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
        $job = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
        $cultural_level = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
        $establishment = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
        $address = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
        $engagement_date = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
        $engagement_date = convertDate($engagement_date);
        $last_edit = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
        $last_edit = convertDate($last_edit);
        $phone = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
        $wali_phone = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
        $notes = $worksheet->getCellByColumnAndRow(19, $row)->getValue();


        if ($stud_id != '') {
            //students table
            $insertqry = "INSERT INTO `students` VALUES ('$stud_id', '$soft_id', '$lname', '$fname','$father', '$grandpa','$birthdate','$birthplace', '$wali_lname', '$wali_fname', '$kinship', '$job', '$cultural_level', '$establishment', '$address', '$engagement_date', '$last_edit', '$phone', '$wali_phone', '$notes')";

            if (mysqli_query($conn, $insertqry)) {
                echo "
                <script>
                    alert('تم إضافة قائمة الطالبات بنجاح');
                    window.location.href= 'search.php';
                </script>";
            } else {
                echo 'error' . mysqli_error($conn);
                echo "
                <script> 
                    alert('حدثت مشكلة ! لم يتم إضافة قائمة الطالبات');
                    window.location.href= 'upload_form.php';
                </script>";
            }
        }
    }
}
