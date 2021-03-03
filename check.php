<?php
include 'config.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['login'])) {

    $admin = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * from users where username= '$admin' and password= '$password'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) == 1) {
        //if admin
        $_SESSION['admin'] = $admin;
        header('location: insertBook.php#insertBook');
    } else {
        //if not admin
        echo 'Failed to connect to database' . mysqli_connect_error();
        echo "<script>
                alert('اسم المستخدم أو كلمة المرور غير صحيحة');
                window.location.href= 'login.php'
            </script>";
    }
}

/*** redirect to login page if session not exist ***/
if (!isset($_SESSION['admin'])) {
    echo "<script> window.location.href= 'login.php'</script>";
}

/*** redirect to login If admin inactive for more than 30 min ***/
if (!isset($_SESSION['timestamp'])) {
    $_SESSION['timestamp'] = time();
}
if (time() - $_SESSION['timestamp'] > 18000) { //subtract new timestamp from the old one
    echo "
    <script>alert('انتهت الجلسة، يرجى تسجيل الدخول مجددا !');</script>";

    session_unset(); // unset $_SESSION variable for this page
    session_destroy(); // destroy session data
    echo "<script> window.location.href= 'login.php'</script>";
    exit;
} else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}

//other sol
//<meta http-equiv="refresh" content="900;url=logout.php" />