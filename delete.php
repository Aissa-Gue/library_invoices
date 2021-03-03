<?php
include 'check.php';
// Delete book
if (isset($_GET['del_book_id'])) {
    $book_id = $_GET['del_book_id'];
    $title = $_GET['title'];

    $deleteBookQry = "DELETE FROM b_books WHERE book_id='$book_id'";
    if (mysqli_query($conn, $deleteBookQry)) {
        echo "<script> alert('تم حذف الكتاب $title بنجاح') </script>";
        echo "<script> window.location.href= 'home.php'</script>";
    } else {
        echo "<script> alert('حدثت مشكلة: لم يتم حذف الكتاب!!') </script>";
        echo "<script> window.location.href= 'home.php'</script>";
    }
}

// Delete client
if (isset($_GET['del_client_id'])) {
    $client_id = $_GET['del_client_id'];
    $last_name = $_GET['last_name'];
    $first_name = $_GET['first_name'];

    $deleteClientQry = "DELETE FROM a_clients WHERE client_id='$client_id'";
    if (mysqli_query($conn, $deleteClientQry)) {
        echo "<script> alert('تم حذف الزبون $last_name $first_name بنجاح') </script>";
        echo "<script> window.location.href= 'home.php#clientsList'</script>";
    } else {
        echo "<script> alert('حدثت مشكلة: لم يتم حذف الزبون!!') </script>";
        echo "<script> window.location.href= 'home.php#clientsList'</script>";
    }
}

// Delete Order
if (isset($_GET['del_order_id'])) {
    $order_id = $_GET['del_order_id'];

    $deleteOrderQry = "DELETE FROM c_orders WHERE order_id='$order_id'";
    if (mysqli_query($conn, $deleteOrderQry)) {
        echo "<script> alert('تم حذف الفاتورة $order_id بنجاح') </script>";
        echo "<script> window.location.href= 'home.php#ordersList'</script>";
    } else {
        echo "<script> alert('حدثت مشكلة: لم يتم حذف الفاتورة!!') </script>";
        echo "<script> window.location.href= 'home.php#ordersList'</script>";
    }
}

// Delete book from Order
if (isset($_GET['del_order_book_id'])) {
    $order_book_id = $_GET['del_order_book_id'];
    $title = $_GET['title'];
    $order_id = $_GET['order_id'];

    $deleteOrderBookQry = "DELETE FROM d_orders_books WHERE order_id='$order_id' AND book_id = '$order_book_id'";
    if (mysqli_query($conn, $deleteOrderBookQry)) {
        echo "<script> alert('تم حذف الكتاب $title من الفاتورة بنجاح') </script>";
        //echo "<script> window.location.href= 'home.php#ordersList'</script>";
    } else {
        echo "<script> alert('حدثت مشكلة: لم يتم حذف الكتاب من الفاتورة!!') </script>";
        //echo "<script> window.location.href= 'home.php#ordersList'</script>";
    }
}
